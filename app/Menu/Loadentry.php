<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Loadentry implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $menu->add('Load', [
            'route' => 'backend.load.index',
            'active' => 'backend.load.*',
            'permission' => 'load_index',
            'icon' => 'fas fa-truck-loading',
            'order' => 100,
        ]);
    }
}
