<?php

namespace App\Datatables;

use App\Models\Dispansar;
use App\Models\Factory;
use App\Models\PumpName;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class DispansarDatatable extends Datatable
{
    public $slug = 'dispansar';

    public function datasource()
    {
        return Dispansar::with(['pumpname', 'factory'])->select('*');
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

            Column::add(__('Pump Name'))
                ->data('pumpname.name')
                ->filterOptions(PumpName::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('pumpName_id', $value);
                }),

            Column::add('M3')
                ->data('cng_purchase_m3'),

            Column::add('Rate')
                ->data('rate'),

            Column::add('Purchase Taka')
                ->data('purchase_taka'),

            Column::add(__('Factory Name'))
                ->data('factory.name')
                ->filterOptions(Factory::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('factory_id', $value);
                }),

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

            Column::add(__('Recived By'))
                ->data('recived_by'),

            Column::add(__('Remarks'))
                ->data('remarks'),

            Column::add()
                ->width('20px')
                ->actions(function (Dispansar $dispansar) {
                    return implode([
                        auth()->user()->ability(['admin'], 'dispansar_crud') ? Button::show('backend.factory.dispansar.show', $dispansar) : null,
                        auth()->user()->ability(['admin'], 'dispansar_crud') ? Button::edit('backend.factory.dispansar.edit', $dispansar) : null,
                        auth()->user()->ability(['admin'], 'dispansar_crud') ? Button::delete('backend.factory.dispansar.destroy', $dispansar) : null,
                    ]);
                }),
        ];
    }
}
