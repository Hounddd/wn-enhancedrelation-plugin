<?php

namespace Hounddd\EnhancedRelationFormWidget;

use Backend;
use Backend\Models\UserRole;
use System\Classes\PluginBase;

/**
 * EnhancedRelationFormWidget Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     */
    public function pluginDetails(): array
    {
        return [
            'name'        => 'hounddd.enhancedrelationformwidget::lang.plugin.name',
            'description' => 'hounddd.enhancedrelationformwidget::lang.plugin.description',
            'author'      => 'Hounddd',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register formwidgets
     *
     * @return array
     */
    public function registerFormWidgets()
    {
        return [
            'Hounddd\EnhancedRelationFormWidget\FormWidgets\EnhancedRelation' => 'enhanced-relation'
        ];
    }
}
