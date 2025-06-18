<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Pumps implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Pumps', [
            'active' => 'backend.pump.*|backend.pumpname.*',
            'permission' => 'pump_crud,pump_name_crud',
            'icon' => 'fas fa-gas-pump',
            'order' => 110,
        ]);

        $item->add('Pumps', [
            'route' => 'backend.pump.index',
            'active' => 'backend.pump.*',
            'permission' => 'pump_crud',
        ]);

        $item->add('Pump Name', [
            'route' => 'backend.pumpname.index',
            'active' => 'backend.pumpname.*',
            'permission' => 'pump_name_crud',
        ]);

        $item->add('Pump summary', [
            'route' => 'backend.pumpsum.filter',
            'active' => 'backend.pumpsum.*',
            'permission' => 'pump_name_crud',
        ]);
    }
}
