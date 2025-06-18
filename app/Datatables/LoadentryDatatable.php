<?php

namespace App\Datatables;

use App\Models\Factory;
use App\Models\LoadEntry;
use App\Models\PumpName;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class LoadentryDatatable extends Datatable
{
    public $slug = 'loadentry';

    public function datasource()
    {
        return LoadEntry::with(['pumpname', 'factory'])->select('*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->permissions('load_crud')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id')
                ->name('load_entries.id'),

            Column::add(__('________Date'))
                ->data('date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('Car No'))
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
                        auth()->user()->ability(['admin'], 'load_crud') ? Button::show('backend.load.show', $loadentry) : null,
                        auth()->user()->ability(['admin'], 'load_crud') ? Button::edit('backend.load.edit', $loadentry) : null,
                        auth()->user()->ability(['admin'], 'load_crud') ? Button::delete('backend.load.destroy', $loadentry) : null,
                    ]);
                }),
        ];
    }
}
