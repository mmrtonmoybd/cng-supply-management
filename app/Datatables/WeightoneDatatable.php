<?php

namespace App\Datatables;

use App\Models\WeightOne;
use App\Models\Factory;
use App\Models\LoadEntry;
use App\Models\PumpName;
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
            ->permissions('load_index')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id')
                ->name('weight_ones.id'),

            Column::add(__('Date'))
                ->width('180px')
                ->data('date')
                ->dateFormat(__('DD-MM-YYYY')),

            Column::add(__('Car No'))
                ->data('vehicle_reg_number'),

            Column::add(__('Pump Name'))
                ->data('pumpname.name')
                ->filterOptions(PumpName::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('pumpName_id', $value);
                }),

            Column::add(__('Factory Name'))
                ->data('factory.name')
                ->filterOptions(Factory::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('factory_id', $value);
                }),

            Column::add(__('M3'))
                ->data('cng_purchase_m3'),

            Column::add(__('Load rate'))
                ->data('lrate'),

            Column::add(__('Purchase Taka'))
                ->data('purchase_taka'),

            Column::add(__('Challan No'))
                ->data('bill_no'),

            Column::add(__('Challan Date'))
                ->width('180px')
                ->data('bill_date')
                ->dateFormat(__('DD-MM-YYYY')),

            Column::add(__('F m3'))
                ->data('fm3'),

            Column::add(__('Rate'))
                ->data('rate'),

            Column::add(__('F Taka'))
                ->data('ftk'),

            Column::add(__('Difference Taka'))
                ->data('difference_taka'),

            Column::add(__('First Weight'))
                ->data('first_weight'),

            Column::add(__('Second Weight'))
                ->data('second_weight'),

            Column::add(__('Total Weight'))
                ->data('total_weight'),

            Column::add(__('Bill Amount'))
                ->data('bill_amount'),

            Column::add(__('Cash Receipt Date'))
                ->width('180px')
                ->data('cash_receipt_date')
                ->dateFormat(__('DD-MM-YYYY')),

            Column::add(__('Cash Receipt Amount'))
                ->data('cash_receipt_amount'),

            Column::add(__('Recived By'))
                ->data('recived_by'),

            Column::add(__('Remarks'))
                ->data('remarks'),

            Column::add()
                ->width('20px')
                ->actions(function (WeightOne $weightone) {
                    return implode([
                        Button::show('backend.factory.weightone.show', $weightone),
                        Button::edit('backend.factory.weightone.edit', $weightone),
                        Button::delete('backend.factory.weightone.destroy', $weightone),
                    ]);
                }),
        ];
    }
}
