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

        $item->add('Cng Pump & Weight Scale', [
            'permission' => 'backend',
            'active' => 'backend.factory.weightone.*',
            'route' => 'backend.factory.weightone.index',
        ]);

        $item->add('Weight Scale', [
            'permission' => 'backend',
            'active' => 'backend.factory.weight.*',
            'route' => 'backend.factory.weight.index',
        ]);

        $item->add('Factory', [
            'permission' => 'backend',
            'active' => 'backend.factory.factory.*',
            'route' => 'backend.factory.factory.index',
        ]);
    }
}
