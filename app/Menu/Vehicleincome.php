<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Vehicleincome implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $menu->add('Vehicle Income', [
            'route' => 'backend.vehicleIncome.index',
            'active' => 'backend.vehicleIncome.*',
            'permission' => 'vehicle_income_crud',
            'icon' => 'fas fa-car',
            'order' => 113,
        ]);
    }
}
