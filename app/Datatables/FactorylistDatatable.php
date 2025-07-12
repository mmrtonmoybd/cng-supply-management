<?php

namespace App\Datatables;

use App\Models\Factory;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class FactorylistDatatable extends Datatable
{
    public $slug = 'factorylist';

    public function datasource()
    {
        return Factory::query();
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->permissions('factory_crud')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()->stateSave()
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id'),

            Column::add(__('Name'))
                ->data('name')
                ->width('12%')
                ->class('text-nowrap'),

            Column::add(__('Type'))
                ->data('type'),

            Column::add(__('Address'))
                ->data('address'),

            Column::add(__('Email'))
                ->data('email'),

            Column::add(__('Phone'))
                ->data('phone'),

            Column::add()
                ->width('20px')
                ->actions(function (Factory $factory) {
                    return implode([
                        auth()->user()->ability(['admin'], 'factory_crud') ? Button::show('backend.factory.factory.show', $factory) : null,
                        auth()->user()->ability(['admin'], 'factory_crud') ? Button::edit('backend.factory.factory.edit', $factory) : null,
                        auth()->user()->ability(['admin'], 'factory_crud') ? Button::delete('backend.factory.factory.destroy', $factory) : null,
                    ]);
                }),
        ];
    }
}
