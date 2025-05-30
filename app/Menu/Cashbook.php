<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Cashbook implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Cashbook', [
            'permission' => 'cashbook|cashbook_entry_heading',
            'active' => 'backend.calculations.*|backend.categories.*',
            'icon' => 'fal fa-money-bill-alt',
            'order' => 200,
        ]);

        $item->add('Cashbook', [
            'permission' => 'cashbook',
            'active' => 'backend.calculations.*',
            'route' => 'backend.calculations.index',
        ]);

        $item->add('Entries heading', [
            'permission' => 'cashbook_entry_heading',
            'active' => 'backend.categories.*',
            'route' => 'backend.categories.index',
        ]);
    }
}
