<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Pumps implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $menu->add('Pumps', [
            'route' => 'backend.pump.index',
            'active' => 'backend.pump.*',
            'permission' => 'pump_index',
            'icon' => 'fas fa-gas-pump',
            'order' => 110,
        ]);
    }
}
