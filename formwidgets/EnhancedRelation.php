<?php

namespace Hounddd\EnhancedRelationFormWidget\FormWidgets;

use Db;
use Lang;
use Backend\Classes\FormField;
use Backend\Classes\FormWidgetBase;
use Illuminate\Database\Eloquent\Relations\Relation as RelationBase;
use Winter\Storm\Exception\SystemException;

/**
 * EnhancedRelation Form Widget
 */
class EnhancedRelation extends \Backend\FormWidgets\Relation
{

    /**
     * @var bool Define if the widget must be rendered has a displayTree.
     */
    public $displayTree;

    //
    // Object properties
    //

    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'enhanced-relation';


    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->fillFromConfig([
            'nameFrom',
            'emptyOption',
            'scope',
            'order',
            'displayTree',
        ]);

        if (isset($this->config->select)) {
            $this->sqlSelect = $this->config->select;
        }
    }

    /**
     * @inheritDoc
     */
    protected function loadAssets()
    {
        $this->addCss('css/enhancedrelation.css', 'Hounddd.EnhancedRelationFormWidget');
        $this->addJs('js/enhancedrelation.js', 'Hounddd.EnhancedRelationFormWidget');
    }

    /**
     * Makes the form object used for rendering a simple field type
     * @throws SystemException if an unsupported relation type is used.
     */
    protected function makeRenderFormField()
    {
        return $this->renderFormField = RelationBase::noConstraints(function () {

            $field = clone $this->formField;
            $relationObject = $this->getRelationObject();
            $query = $relationObject->newQuery();

            list($model, $attribute) = $this->resolveModelAttribute($this->valueFrom);
            $relationType = $model->getRelationType($attribute);
            $relationModel = $model->makeRelation($attribute);

            if (in_array($relationType, ['belongsToMany', 'morphToMany', 'morphedByMany', 'hasMany'])) {
                $field->type = 'checkboxlist';
            } elseif (in_array($relationType, ['belongsTo', 'hasOne'])) {
                $field->type = 'dropdown';
            } else {
                throw new SystemException(
                    Lang::get('backend::lang.relation.relationwidget_unsupported_type', [
                        'type' => $relationType
                    ])
                );
            }

            // Order query by the configured option.
            if ($this->order) {
                // Using "raw" to allow authors to use a string to define the order clause.
                $query->orderByRaw($this->order);
            }

            // It is safe to assume that if the model and related model are of
            // the exact same class, then it cannot be related to itself
            if ($model->exists && (get_class($model) == get_class($relationModel))) {
                $query->where($relationModel->getKeyName(), '<>', $model->getKey());
            }

            // Even though "no constraints" is applied, belongsToMany constrains the query
            // by joining its pivot table. Remove all joins from the query.
            $query->getQuery()->getQuery()->joins = [];

            if ($scopeMethod = $this->scope) {
                $query->$scopeMethod($model);
            }

            // Determine if the model uses a tree trait
            $treeTraits = ['Winter\Storm\Database\Traits\NestedTree', 'Winter\Storm\Database\Traits\SimpleTree'];
            $usesTree = count(array_intersect($treeTraits, class_uses($relationModel))) > 0;

            // The "sqlSelect" config takes precedence over "nameFrom".
            // A virtual column called "selection" will contain the result.
            // Tree models must select all columns to return parent columns, etc.
            if ($this->sqlSelect) {
                $nameFrom = 'selection';
                $selectColumn = $usesTree ? '*' : $relationModel->getKeyName();
                $result = $query->select($selectColumn, Db::raw($this->sqlSelect . ' AS ' . $nameFrom));
            }
            else {
                $nameFrom = $this->nameFrom;
                $result = $query->getQuery()->get();
            }

            // Some simpler relations can specify a custom local or foreign "other" key,
            // which can be detected and implemented here automagically.
            $primaryKeyName = in_array($relationType, ['hasMany', 'belongsTo', 'hasOne'])
                ? $relationObject->getOtherKey()
                : $relationModel->getKeyName();

            $field->options = $usesTree
                ? $result->listsNested($nameFrom, $primaryKeyName)
                : $result->lists($nameFrom, $primaryKeyName);

            if ($usesTree) {
                if ($this->displayTree) {
                    /*
                     * Recursive helper function
                     */
                    $buildCollection = function ($items) use (&$buildCollection) {
                        $result = [];

                        foreach ($items as $item) {
                            $result[$item->id] = [
                                'name' => $item->name
                            ];

                            /*
                             * Add the children
                             */
                            $childItems = $item->getChildren();
                            if ($childItems->count() > 0) {
                                $result[$item->id]['children'] = $buildCollection($childItems);
                            } else {
                                $result[$item->id]['children'] = [];
                            }
                        }

                        return $result;
                    };

                    $field->options = $buildCollection($result->toNested());
                } else {
                    $field->options = $result->listsNested($nameFrom, $primaryKeyName);
                }
            } else {
                $field->options = $result->lists($nameFrom, $primaryKeyName);
            }

            return $field;
        });
    }
}
