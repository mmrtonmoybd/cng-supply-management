<?php

namespace App\Datatables;

use App\Models\Factory;
use App\Models\PumpName;
use App\Models\Weight;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class WeightDatatable extends Datatable
{
    public $slug = 'weight';

    public function datasource()
    {
        return Weight::with(['pumpname', 'factory'])->select('*');
    }

    public function setUp()
    {
        $this->order('id', 'desc');
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

            Column::add(__('Bill No'))
                ->data('bill_no'),

            Column::add(__('Bill Date'))
                ->width('180px')
                ->data('bill_date')
                ->dateFormat(__('DD-MM-YYYY')),

            Column::add(__('First Weight'))
                ->data('first_weight'),

            Column::add(__('Second Weight'))
                ->data('second_weight'),

            Column::add(__('Net Weight'))
                ->data('total_weight'),

            Column::add(__('Fact'))
                ->data('fact'),

            Column::add(__('Receive M3'))
                ->data('receive_m3'),

            Column::add(__('Rate'))
                ->data('rate'),

            Column::add(__('Factory taka'))
                ->data('ftk'),

            Column::add(__('Total Bill No'))
                ->data('total_bill_no'),

            Column::add(__('Total Bill Taka'))
                ->data('total_bill_taka'),

            Column::add(__('Difference Taka'))
                ->data('difference_taka'),

            Column::add(__('Difference M3'))
                ->data('difference_m3'),

            Column::add(__('In'))
                ->data('in'),

            Column::add(__('Out'))
                ->data('out'),

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
                ->actions(function (Weight $weight) {
                    return implode([
                        Button::show('backend.factory.weight.show', $weight),
                        Button::edit('backend.factory.weight.edit', $weight),
                        Button::delete('backend.factory.weight.destroy', $weight),
                    ]);
                }),
        ];
    }
}
