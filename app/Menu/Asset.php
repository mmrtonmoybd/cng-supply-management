<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Asset implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Assets', [
            'permission' => 'asset_crud,vehicle_crud',
            'active' => 'backend.asset.*',
            'icon' => 'fa-balance-scale',
            'order' => 130,
        ]);

        $item->add('Asset', [
            'permission' => 'asset_crud',
            'active' => 'backend.asset.asset.*',
            'route' => 'backend.asset.asset.index',
        ]);

        $item->add('Asset document', [
            'permission' => 'asset_crud',
            'active' => 'backend.asset.assetdocument.*',
            'route' => 'backend.asset.assetdocument.index',
        ]);

        $item->add('Vehicle', [
            'permission' => 'vehicle_crud',
            'active' => 'backend.asset.vehicle.*',
            'route' => 'backend.asset.vehicle.index',
        ]);

        $item->add('Vehicle document', [
            'permission' => 'vehicle_crud',
            'active' => 'backend.asset.vehicledocument.*',
            'route' => 'backend.asset.vehicledocument.index',
        ]);
    }
}
