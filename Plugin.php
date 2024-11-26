<?php

namespace Hounddd\EnhancedRelation;

use Backend;
use Backend\Models\UserRole;
use System\Classes\PluginBase;

/**
 * EnhancedRelation Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     */
    public function pluginDetails(): array
    {
        return [
            'name'        => 'hounddd.enhancedrelation::lang.plugin.name',
            'description' => 'hounddd.enhancedrelation::lang.plugin.description',
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
            'Hounddd\EnhancedRelation\FormWidgets\EnhancedRelation' => 'enhanced-relation'
        ];
    }
}
