<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Activity implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $menu->add('Activity', [
            'route' => 'backend.activity.index',
            'active' => 'backend.activity.*',
            'permission' => 'activity_logs',
            'icon' => 'fas fa-skull-crossbones',
            'order' => 10000,
        ]);
    }
}
