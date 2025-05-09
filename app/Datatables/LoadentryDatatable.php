<?php

namespace App\Datatables;

use App\Models\LoadEntry;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class LoadentryDatatable extends Datatable
{
    public $slug = 'loadentry';

    public function datasource()
    {
        return LoadEntry::query();
    }

    public function setUp()
    {
        $this->order('id', 'desc')
             ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
             ->condensed()
             ->stateSave()
             ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id'),

            Column::add(__('Date'))
                ->width('180px')
                ->data('date')
                ->dateFormat(__("D MMMM YYYY")),

            Column::add(__('Car No'))
                ->data('vehicle_reg_number'),

            Column::add(__('Pump Name'))
                ->data('pump_name'),

            Column::add(__('M3'))
                ->data('cng_purchase_m3'),

            Column::add(__('Rate'))
                ->data('rate'),

            Column::add(__('Purchase Taka'))
                ->data('purchase_taka'),

            Column::add(__('Fuel Cost'))
                ->data('fuel_cost'),

            Column::add(__('Fuel Pump'))
                ->data('fuel_pump'),

            Column::add(__('Factory Name'))
                ->data('factory_name'),

            Column::add(__('Status'))
                ->data('status'),

            Column::add(__('Remark'))
                ->data('remark'),

            Column::add(__('Diesel Litter'))
                ->data('diesel_litter'),

            Column::add(__('Diesel Rate'))
                ->data('diesel_rate'),

            Column::add(__('Created At'))
                ->data('created_at'),

            Column::add(__('Updated At'))
                ->data('updated_at'),

            Column::add()
                ->width('20px')
                ->actions(function (LoadEntry $loadentry) {
                    return join([
                        Button::show('backend.load.show', $loadentry),
                        Button::edit('backend.load.edit', $loadentry),
                        Button::delete('backend.load.destroy', $loadentry),
                    ]);
                }),
        ];
    }
}
