<?php

namespace App\Datatables;

use App\Models\Factory;
use App\Models\Pump;
use App\Models\PumpName;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class PumpDatatable extends Datatable
{
    public $slug = 'pump';

    public function datasource()
    {
        return Pump::with(['pumpname', 'factory'])->select('*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()
            ->permissions('pump_crud')
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [

            Column::add(__('Id'))
                ->data('id'),

            Column::add('________Date')
                ->data('date')
                ->dateFormat('DD-MM-YYYY')
                ->filterType('daterangepicker'),

            Column::add('Car no')
                ->data('vehicle_reg_number')
                ->width('12%')
                ->class('text-nowrap'),

            Column::add(__('Pump Name'))
                ->data('pumpname.name')
                ->width('12%')
                ->class('text-nowrap')
                ->filterOptions(PumpName::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('pumpName_id', $value);
                }),

            Column::add('Pump type')
                ->data('type', function ($pump) {
                    return (! $pump->load_entry_id) ? '<span class="badge badge-pill badge-primary">Third party</span>' : '<span class="badge badge-pill badge-warning">Main</span>';
                })
                ->filterOptions([
                    '1' => 'Main',
                    '0' => 'Third Party',
                ])
                ->filter(function ($query, $value) {
                    if ($value === 1) {
                        $query->where('load_entry_id', '!=', null);
                    } else {
                        $query->where('load_entry_id', '=', null);
                    }
                }),

            Column::add(__('M3'))
                ->data('cng_purchase_m3')->sum(),

            Column::add(__('Rate'))
                ->data('rate'),

            Column::add(__('Purchase Taka'))
                ->data('purchase_taka')->sum(),

            Column::add(__('Factory Name'))
                ->data('factory.name')
                ->width('12%')
                ->class('text-nowrap')
                ->filterOptions(Factory::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('factory_id', $value);
                }),

            Column::add(__('____Payment Date'))
                ->data('payment_date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('Payment'))
                ->data('payment')->sum(),

            Column::add(__('Remarks'))
                ->data('remarks'),

            Column::add()
                ->width('20px')
                ->actions(function ($pump) {
                    return implode([
                        auth()->user()->ability(['admin'], 'pump_crud') ? Button::show('backend.pump.show', $pump->id) : null,
                        auth()->user()->ability(['admin'], 'pump_crud') ? Button::edit('backend.pump.edit', $pump->id) : null,
                        // Button::delete('pump.destroy', $pump),
                    ]);
                }),
        ];
    }
}
