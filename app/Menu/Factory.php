<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Factory implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Factory', [
            'permission' => 'backend',
            'active' => 'backend.factory.*',
            'icon' => 'fas fa-industry',
            'order' => 120,
        ]);

        $item->add('Dispansar', [
            'permission' => 'backend',
            'active' => 'backend.factory.dispansar.*',
            'route' => 'backend.factory.dispansar.index',
        ]);
    }
}
