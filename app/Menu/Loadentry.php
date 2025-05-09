<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Loadentry implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $menu->add('LoadEntry', [
            'route' => 'backend.load.index',
            'active' => 'backend.load.*',
            'permission' => 'backend',
            'icon' => 'square',
            'order' => 100,
        ]);
    }
}
