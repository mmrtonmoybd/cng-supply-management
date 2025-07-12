<?php

namespace App\Datatables;

use App\Models\Factory;
use App\Models\PumpName;
use App\Models\WeightOne;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class WeightoneDatatable extends Datatable
{
    public $slug = 'weightone';

    public function datasource()
    {
        return WeightOne::with(['pumpname', 'factory'])->select('*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->permissions('weightone_crud')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()->stateSave()
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id')
                ->name('weight_ones.id'),

            Column::add(__('______Date'))
                ->width('180px')
                ->data('date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('___Car No'))
                ->data('vehicle_reg_number'),

            Column::add(__('Pump Name'))
                ->data('pumpname.name')
                ->width('12%')
                ->class('text-nowrap')
                ->filterOptions(PumpName::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('pumpName_id', $value);
                }),

            Column::add(__('Factory Name'))
                ->data('factory.name')
                ->width('12%')
                ->class('text-nowrap')
                ->filterOptions(Factory::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('factory_id', $value);
                }),

            Column::add(__('M3'))
                ->data('cng_purchase_m3')->sum(),

            Column::add(__('Load rate'))
                ->data('lrate'),

            Column::add(__('Purchase Taka'))
                ->data('purchase_taka')->sum(),

            Column::add(__('Challan No'))
                ->data('bill_no'),

            Column::add(__('__Challan Date'))
                ->width('180px')
                ->data('bill_date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('F m3'))
                ->data('fm3')->sum(),

            Column::add(__('Rate'))
                ->data('rate'),

            Column::add(__('F Taka'))
                ->data('ftk')->sum(),

            Column::add(__('Difference Taka'))
                ->data('difference_taka')->sum(),

            Column::add(__('First Weight'))
                ->data('first_weight')->sum(),

            Column::add(__('Second Weight'))
                ->data('second_weight')->sum(),

            Column::add(__('Total Weight'))
                ->data('total_weight')->sum(),

            Column::add('Invoice')
                ->data('invoice_id', function ($invoiceId) {
                    return $invoiceId->invoice_id ? '<a href="'.route('backend.factory.invoice.show', $invoiceId->invoice_id).'" target="_blank" style="color:#007bff;font-weight:bold;">Invoice('.$invoiceId->invoice_id.')</a>' : null;
                })->notOrderable(),

            Column::add(__('___Invoice Date'))
                ->data('invoice_date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('Cash Receipt Date'))
                ->width('180px')
                ->data('cash_receipt_date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('Cash Receipt Amount'))
                ->data('cash_receipt_amount')->sum(),

            Column::add(__('Recived By'))
                ->data('recived_by'),

            Column::add(__('Remarks'))
                ->data('remarks'),

            Column::add()
                ->width('20px')
                ->actions(function (WeightOne $weightone) {
                    return implode([
                        auth()->user()->ability(['admin'], 'weightone_crud') ? Button::show('backend.factory.weightone.show', $weightone) : null,
                        auth()->user()->ability(['admin'], 'weightone_crud') ? Button::edit('backend.factory.weightone.edit', $weightone) : null,
                        auth()->user()->ability(['admin'], 'weightone_crud') ? Button::delete('backend.factory.weightone.destroy', $weightone) : null,
                    ]);
                }),
        ];
    }
}
