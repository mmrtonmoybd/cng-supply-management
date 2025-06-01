<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Transport implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $menu->add('Transport', [
            'route' => 'backend.transport.index',
            'active' => 'backend.transport.*',
            'permission' => 'backend',
            'icon' => 'fas fa-shuttle-van',
            'order' => 128,
        ]);
    }
}
