<?php

namespace App\Datatables;

use App\Models\Factory;
use App\Models\PumpName;
use App\Models\Weight;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\Highlight;

class WeightDatatable extends Datatable
{
    public $slug = 'weight';

    public function datasource()
    {
        return Weight::with(['pumpname', 'factory'])->select('weights.*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->permissions('weight_crud')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()->stateSave()
            ->setRowClass(function ($row) {
                $class = '';

                // ✅ Mark this row as duplicate if an older identical row already exists
                $isDuplicate = Weight::where('id', '<', $row->id) // 👈 changed this
                    ->where('date', $row->date)
                    ->where('vehicle_reg_number', $row->vehicle_reg_number)
                    ->where('factory_id', $row->factory_id)
                    ->where('pumpName_id', $row->pumpName_id)
                    ->where('cng_purchase_m3', $row->cng_purchase_m3)
                    ->where('lrate', $row->lrate)
                    ->where('purchase_taka', $row->purchase_taka)
                    ->where('bill_no', $row->bill_no)
                    ->where('bill_date', $row->bill_date)
                    ->where('receive_m3', $row->receive_m3)
                    ->where('ftk', $row->ftk)
                    ->where('rate', $row->rate)
                    ->exists();

                if ($isDuplicate) {
                    $class .= ' alert-danger';
                }

                // Highlight color if set
                $highlight = Highlight::where('module_name', 'weight')
                    ->where('module_id', $row->id)
                    ->value('color');

                if ($highlight) {
                    $class .= ' highlight-'.$highlight;
                }

                return trim($class);
            })
            ->setRowAttr([
                'data-toggle' => fn ($row) => Weight::where('id', '<', $row->id) // 👈 changed this
                    ->where('date', $row->date)
                    ->where('vehicle_reg_number', $row->vehicle_reg_number)
                    ->where('factory_id', $row->factory_id)
                    ->where('pumpName_id', $row->pumpName_id)
                    ->where('cng_purchase_m3', $row->cng_purchase_m3)
                    ->where('lrate', $row->lrate)
                    ->where('purchase_taka', $row->purchase_taka)
                    ->where('bill_no', $row->bill_no)
                    ->where('bill_date', $row->bill_date)
                    ->where('receive_m3', $row->receive_m3)
                    ->where('ftk', $row->ftk)
                    ->where('rate', $row->rate)
                    ->exists() ? 'tooltip' : null,

                'data-placement' => fn ($row) => 'top',

                'title' => fn ($row) => Weight::where('id', '<', $row->id) // 👈 changed this
                    ->where('date', $row->date)
                    ->where('vehicle_reg_number', $row->vehicle_reg_number)
                    ->where('factory_id', $row->factory_id)
                    ->where('pumpName_id', $row->pumpName_id)
                    ->where('cng_purchase_m3', $row->cng_purchase_m3)
                    ->where('lrate', $row->lrate)
                    ->where('purchase_taka', $row->purchase_taka)
                    ->where('bill_no', $row->bill_no)
                    ->where('bill_date', $row->bill_date)
                    ->where('receive_m3', $row->receive_m3)
                    ->where('ftk', $row->ftk)
                    ->where('rate', $row->rate)
                    ->exists()
                        ? '🚨 This row appears to be a duplicate of a previous row with identical data. Please double-check before proceeding.'
                        : null,
            ])
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id')
                ->name('weights.id'),

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

            Column::add(__('Bill No'))
                ->data('bill_no', function ($billno) {
                    return $billno->invoice_id ? '<a style="color:#007bff;font-weight:bold;">'.$billno->bill_no.'</a>' : $billno->bill_no;
                }),

            Column::add(__('____Bill Date'))
                ->data('bill_date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('First Weight'))
                ->data('first_weight')->sum(),

            Column::add(__('Second Weight'))
                ->data('second_weight')->sum(),

            Column::add(__('Net Weight'))
                ->data('total_weight')->sum(),

            Column::add(__('Fact'))
                ->data('fact'),

            Column::add(__('Receive M3'))
                ->data('receive_m3')->sum(),

            Column::add(__('Rate'))
                ->data('rate'),

            Column::add(__('Factory taka'))
                ->data('ftk')->sum(),

            Column::add(__('Difference Taka'))
                ->data('difference_taka')->sum(),

            Column::add(__('Difference M3'))
                ->data('difference_m3')->sum(),

            Column::add(__('In'))
                ->data('in')->sum(),

            Column::add(__('Out'))
                ->data('out')->sum(),

            Column::add('Invoice')
                ->data('invoice_id', function ($invoiceId) {
                    $invoice = \App\Models\Invoice::find($invoiceId->invoice_id);

                    return $invoiceId->invoice_id ? '<a href="'.route('backend.factory.invoice.show', $invoiceId->invoice_id).'" target="_blank" style="color:#007bff;font-weight:bold;">'.$invoice->invoice_number.'</a>' : null;
                })->notOrderable()->notSearchable(),

            Column::add(__('___Invoice Date'))
                ->data('invoice_date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('Cash Receipt Date'))
                ->data('cash_receipt_date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('Cash Receipt Amount'))
                ->data('cash_receipt_amount')->sum(),

            Column::add(__('Recived By'))
                ->data('recived_by'),

            Column::add(__('Remarks'))
                ->data('remarks'),

            Column::add('Highlight')
                ->data('highlight', function ($row) {
                    $colors = ['none' => 'None', 'yellow' => 'Yellow', 'red' => 'Red', 'green' => 'Green', 'blue' => 'Blue'];

                    $highlight = Highlight::where('module_name', 'weight')
                        ->where('module_id', $row->id)
                        ->first();

                    $selected = $highlight->color ?? 'none';

                    $options = '';
                    foreach ($colors as $key => $label) {
                        $sel = $key === $selected ? 'selected' : '';
                        $options .= "<option value='{$key}' {$sel}>{$label}</option>";
                    }

                    return <<<HTML
                        <select class="form-control form-control-sm highlight-select" data-id="{$row->id}" data-module="weight">
                            {$options}
                        </select>
                    HTML;
                })->notOrderable()
                ->filterOptions([
                    'none' => 'None', 'yellow' => 'Yellow', 'red' => 'Red', 'green' => 'Green', 'blue' => 'Blue',
                ])
                ->filter(function ($query, $value) {
                    if ($value !== 'none') {
                        return $query->whereHas('highlight', function ($q) use ($value) {
                            $q->where('color', $value);
                        });
                    }
                }),

            Column::add()
                ->width('20px')
                ->actions(function (Weight $weight) {
                    return implode([
                        auth()->user()->ability(['admin'], 'weight_crud') ? Button::show('backend.factory.weight.show', $weight) : null,
                        auth()->user()->ability(['admin'], 'weight_crud') ? Button::edit('backend.factory.weight.edit', $weight) : null,
                        auth()->user()->ability(['admin'], 'weight_crud') ? Button::delete('backend.factory.weight.destroy', $weight) : null,
                    ]);
                }),
        ];
    }
}
