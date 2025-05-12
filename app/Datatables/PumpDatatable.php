<?php

namespace App\Datatables;

use App\Models\Pump;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class PumpDatatable extends Datatable
{
    public $slug = 'pump';

    public function datasource()
    {
        return Pump::with('loada')->select('*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->permissions('load_index')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()
            ->permissions('pump_index')
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add('id')
                ->data('id')
                ->width('20px'),
            Column::add('Load date')
                ->data('loada.date')
                ->dateFormat(__('boilerplate::date.Ymd')),

            Column::add('Car no')
                ->data('loada.vehicle_reg_number'),

            Column::add('Pump Name')
                ->data('loada.pump_name'),
            Column::add('M3')
                ->data('loada.cng_purchase_m3'),

            Column::add('Rate')
                ->data('loada.rate'),

            Column::add('Purchase Taka')
                ->data('loada.purchase_taka'),

            Column::add('Diesel Litter')
                ->data('loada.diesel_litter'),

            Column::add('Diesel Rate')
                ->data('loada.diesel_rate'),

            Column::add(__('Payment Date'))
                ->data('payment_date')
                ->dateFormat(__('boilerplate::date.Ymd')),

            Column::add(__('Payment'))
                ->data('payment'),

            Column::add(__('Balance'))
                ->data('balance'),

            Column::add(__('Remarks'))
                ->data('remarks'),

            Column::add(__('Load Entry Id'))
                ->data('load_entry_id'),

            Column::add(__('Created At'))
                ->data('created_at'),

            Column::add(__('Updated At'))
                ->data('updated_at'),

            Column::add()
                ->width('20px')
                ->actions(function (Pump $pump) {
                    return implode([
                        auth()->user()->ability(['admin'], 'pump_index') ? Button::show('backend.pump.show', $pump->id) : null,
                        auth()->user()->ability(['admin'], 'pump_update') ? Button::edit('backend.pump.edit', $pump->id) : null,
                        // Button::delete('pump.destroy', $pump),
                    ]);
                }),
        ];
    }
}
