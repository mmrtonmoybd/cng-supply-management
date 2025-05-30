<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Factory implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Factory', [
            'permission' => 'factory_crud,dispansar_crud,weightone_crud,weight_crud,cngpump_crud',
            'active' => 'backend.factory.*',
            'icon' => 'fas fa-industry',
            'order' => 120,
        ]);

        $item->add('Dispansar', [
            'permission' => 'dispansar_crud',
            'active' => 'backend.factory.dispansar.*',
            'route' => 'backend.factory.dispansar.index',
        ]);

        $item->add('Cng Pump & Weight Scale', [
            'permission' => 'weightone_crud',
            'active' => 'backend.factory.weightone.*',
            'route' => 'backend.factory.weightone.index',
        ]);

        $item->add('Weight Scale', [
            'permission' => 'weight_crud',
            'active' => 'backend.factory.weight.*',
            'route' => 'backend.factory.weight.index',
        ]);

        $item->add('Cng Pump Slip', [
            'permission' => 'cngpump_crud',
            'active' => 'backend.factory.cngpump.*',
            'route' => 'backend.factory.cngpump.index',
        ]);

        $item->add('Factory Name', [
            'permission' => 'factory_crud',
            'active' => 'backend.factory.factory.*',
            'route' => 'backend.factory.factory.index',
        ]);

        $item->add('Invoice', [
            'permission' => 'invoice_crud',
            'active' => 'backend.factory.invoice.*',
            'route' => 'backend.factory.invoice.index',
        ]);
    }
}
