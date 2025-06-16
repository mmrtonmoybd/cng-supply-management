<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Vehicle implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $menu->add('Vehicle', [
            'route' => 'backend.vehicle.vehicle.index',
            'active' => 'backend.vehicle.*',
            'permission' => 'vehicle_crud',
            'icon' => 'fas fa-truck',
            'order' => 129,
        ]);
    }
}
