<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Diesel implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $menu->add('Diesel', [
            'route' => 'backend.diesel.index',
            'active' => 'backend.diesel.*',
            'permission' => 'diesel_crud',
            'icon' => 'fas fa-oil-can',
            'order' => 112,
        ]);
    }
}
