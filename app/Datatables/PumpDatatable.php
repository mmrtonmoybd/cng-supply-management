<?php

namespace App\Datatables;

use App\Models\Pump;
use App\Models\PumpName;
use Illuminate\Database\Eloquent\Builder;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class PumpDatatable extends Datatable
{
    public $slug = 'pump';

    public function datasource()
    {
        return Pump::with(['loada', 'loada.pumpname'])->select('*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->buttons('filters', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()
            ->permissions('pump_crud')
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [

            Column::add(__('Id'))
                ->data('id')
                ->name('pumps.id'),

            Column::add('Load date')
                ->data('loada.date')
                ->dateFormat(__('boilerplate::date.Ymd'))
                ->filterType('daterangepicker')
                ->filter(function (Builder $query, $value) {
                    $dates = explode(' - ', $value);
                    $dateRange = $dates[0];
                    [$startDate, $endDate] = explode('|', $dateRange);

                    return $query->whereHas('loada', function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('date', [$startDate, $endDate]);
                    });
                }),

            Column::add('Car no')
                ->data('loada.vehicle_reg_number'),

            Column::add('Pump Name')
                ->data('loada.pumpname.name')
                ->filterOptions(PumpName::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray())
                ->filter(function (Builder $query, $value) {
                    return $query->whereHas('loada', function ($query) use ($value) {
                        $query->where('pumpName_id', $value);
                    });
                }),

            Column::add('M3')
                ->data('loada.cng_purchase_m3'),

            Column::add('Rate')
                ->data('loada.rate'),

            Column::add('Purchase Taka')
                ->data('loada.purchase_taka'),

            Column::add(__('Payment Date'))
                ->data('payment_date')
                ->dateFormat(__('boilerplate::date.Ymd')),

            Column::add(__('Payment'))
                ->data('payment'),

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
