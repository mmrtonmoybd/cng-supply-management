<?php

namespace App\Datatables;

use App\Models\Dispansar;
use App\Models\LoadEntry;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class DispansarDatatable extends Datatable
{
    public $slug = 'dispansar';

    public function datasource()
    {
        return Dispansar::query();
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->buttons('filters', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()
            ->permissions('pump_index')
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id')
                ->name('dispansars.id'),

            Column::add('Date')
                ->data('date')
                ->dateFormat(__('boilerplate::date.Ymd'))
                ->filterType('daterangepicker'),
                /*
                ->filter(function (Builder $query, $value) {
                    $dates = explode(' - ', $value);
                    $dateRange = $dates[0];
                    [$startDate, $endDate] = explode('|', $dateRange);

                    return $query->whereHas('loada', function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('date', [$startDate, $endDate]);
                    });
                }), 
                */

            Column::add('Car no')
                ->data('vehicle_reg_number'),

            Column::add('Pump Name')
                ->data('pump_name')
                ->filterOptions(LoadEntry::distinct()->orderBy('pump_name', 'ASC')->pluck('pump_name', 'pump_name')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('pump_name', 'LIKE', '%'.$value.'%');
                }),

            Column::add('M3')
                ->data('cng_purchase_m3'),

            Column::add('Rate')
                ->data('rate'),

            Column::add('Purchase Taka')
                ->data('purchase_taka'),

            Column::add(__('Bill No'))
                ->data('bill_no'),

            Column::add(__('Bill Date'))
                ->width('180px')
                ->data('bill_date')
                ->dateFormat(__('boilerplate::date.Ymd')),

            Column::add(__('Opening Reading'))
                ->data('opening_reading'),

            Column::add(__('Closing Reading'))
                ->data('closing_reading'),

            Column::add(__('Total Reading'))
                ->data('total_reading'),

            Column::add(__('Rate'))
                ->data('rate'),

            Column::add(__('Bill Amount'))
                ->data('bill_amount'),

            Column::add(__('Difference M3'))
                ->data('difference_m3'),

            Column::add(__('Difference Taka'))
                ->data('difference_taka'),

            Column::add(__('In'))
                ->data('in'),

            Column::add(__('Out'))
                ->data('out'),

            Column::add(__('Cash Receipt Date'))
                ->width('180px')
                ->data('cash_receipt_date')
                ->dateFormat(__('boilerplate::date.Ymd')),

            Column::add(__('Cash Receipt Amount'))
                ->data('cash_receipt_amount'),

            Column::add(__('Balance'))
                ->data('balance'),

            Column::add(__('Recived By'))
                ->data('recived_by'),

            Column::add(__('Remarks'))
                ->data('remarks'),

            Column::add()
                ->width('20px')
                ->actions(function (Dispansar $dispansar) {
                    return implode([
                        Button::show('backend.factory.dispansar.show', $dispansar),
                        Button::edit('backend.factory.dispansar.edit', $dispansar),
                        Button::delete('backend.factory.dispansar.destroy', $dispansar),
                    ]);
                }),
        ];
    }
}
