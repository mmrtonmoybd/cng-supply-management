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
            ->permissions('load_index')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()
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
                ->dateFormat(__('DD-MM-YYYY')),

            Column::add(__('Car No'))
                ->data('vehicle_reg_number'),

            Column::add(__('Pump Name'))
                ->data('pump_name')
                ->filterOptions(LoadEntry::distinct()->orderBy('pump_name', 'ASC')->pluck('pump_name', 'pump_name')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('pump_name', 'LIKE', '%'.$value.'%');
                }),

            Column::add(__('M3'))
                ->data('cng_purchase_m3'),

            Column::add(__('Rate'))
                ->data('rate'),

            Column::add(__('Purchase Taka'))
                ->data('purchase_taka'),

            Column::add(__('Factory Name'))
                ->data('factory_name'),

            Column::add(__('Status'))
                ->data('status', function ($user) {
                    return $user->status == 1 ? '<span class="badge badge-pill badge-success">Use</span>' : '<span class="badge badge-pill badge-danger">Not Use</span>';
                })->filterOptions([
                    1 => 'Use',
                    0 => 'Not Use',
                ]),

            Column::add(__('Remark'))
                ->data('remark'),

            Column::add()
                ->width('20px')
                ->actions(function (LoadEntry $loadentry) {
                    return implode([
                        auth()->user()->ability(['admin'], 'load_index') ? Button::show('backend.load.show', $loadentry) : null,
                        auth()->user()->ability(['admin'], 'load_update') ? Button::edit('backend.load.edit', $loadentry) : null,
                        auth()->user()->ability(['admin'], 'load_delete') ? Button::delete('backend.load.destroy', $loadentry) : null,
                    ]);
                }),
        ];
    }
}
