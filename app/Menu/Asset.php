<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Asset implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $menu->add('Asset', [
            'permission' => 'asset_crud',
            'active' => 'backend.asset.asset.*',
            'route' => 'backend.asset.asset.index',
            'icon' => 'fa-balance-scale',
            'order' => 130,
        ]);
    }
}
