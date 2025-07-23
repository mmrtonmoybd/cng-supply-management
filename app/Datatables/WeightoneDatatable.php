<?php

namespace App\Datatables;

use App\Models\Factory;
use App\Models\Highlight;
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
        return WeightOne::with(['pumpname', 'factory'])->select('weight_ones.*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->permissions('weightone_crud')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()->stateSave()
            ->setRowClass(function ($row) {
                $class = '';

                // ✅ Mark this row as duplicate if an older identical row already exists
                $isDuplicate = WeightOne::where('id', '<', $row->id) // 👈 changed this
                    ->where('date', $row->date)
                    ->where('vehicle_reg_number', $row->vehicle_reg_number)
                    ->where('factory_id', $row->factory_id)
                    ->where('pumpName_id', $row->pumpName_id)
                    ->where('cng_purchase_m3', $row->cng_purchase_m3)
                    ->where('lrate', $row->lrate)
                    ->where('purchase_taka', $row->purchase_taka)
                    ->where('bill_no', $row->bill_no)
                    ->where('bill_date', $row->bill_date)
                    ->where('fm3', $row->fm3)
                    ->where('ftk', $row->ftk)
                    ->where('rate', $row->rate)
                    ->exists();

                if ($isDuplicate) {
                    $class .= ' alert-danger';
                }

                // Highlight color if set
                $highlight = Highlight::where('module_name', 'weight_ones')
                    ->where('module_id', $row->id)
                    ->value('color');

                if ($highlight) {
                    $class .= ' highlight-'.$highlight;
                }

                return trim($class);
            })
            ->setRowAttr([
                'data-toggle' => fn ($row) => WeightOne::where('id', '<', $row->id) // 👈 changed this
                    ->where('date', $row->date)
                    ->where('vehicle_reg_number', $row->vehicle_reg_number)
                    ->where('factory_id', $row->factory_id)
                    ->where('pumpName_id', $row->pumpName_id)
                    ->where('cng_purchase_m3', $row->cng_purchase_m3)
                    ->where('lrate', $row->lrate)
                    ->where('purchase_taka', $row->purchase_taka)
                    ->where('bill_no', $row->bill_no)
                    ->where('bill_date', $row->bill_date)
                    ->where('fm3', $row->fm3)
                    ->where('ftk', $row->ftk)
                    ->where('rate', $row->rate)
                    ->exists() ? 'tooltip' : null,

                'data-placement' => fn ($row) => 'top',

                'title' => fn ($row) => WeightOne::where('id', '<', $row->id) // 👈 changed this
                    ->where('date', $row->date)
                    ->where('vehicle_reg_number', $row->vehicle_reg_number)
                    ->where('factory_id', $row->factory_id)
                    ->where('pumpName_id', $row->pumpName_id)
                    ->where('cng_purchase_m3', $row->cng_purchase_m3)
                    ->where('lrate', $row->lrate)
                    ->where('purchase_taka', $row->purchase_taka)
                    ->where('bill_no', $row->bill_no)
                    ->where('bill_date', $row->bill_date)
                    ->where('fm3', $row->fm3)
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
                ->data('bill_no', function ($billno) {
                    return $billno->invoice_id ? '<a style="color:#007bff;font-weight:bold;">'.$billno->bill_no.'</a>' : $billno->bill_no;
                }),

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
                    $invoice = \App\Models\Invoice::find($invoiceId->invoice_id);

                    return $invoiceId->invoice_id ? '<a href="'.route('backend.factory.invoice.show', $invoiceId->invoice_id).'" target="_blank" style="color:#007bff;font-weight:bold;">'.$invoice->invoice_number.'</a>' : null;
                })->notOrderable()->notSearchable(),

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

            Column::add('Highlight')
                ->data('highlight', function ($row) {
                    $colors = ['none' => 'None', 'yellow' => 'Yellow', 'red' => 'Red', 'green' => 'Green', 'blue' => 'Blue'];

                    $highlight = Highlight::where('module_name', 'weight_ones')
                        ->where('module_id', $row->id)
                        ->first();

                    $selected = $highlight->color ?? 'none';

                    $options = '';
                    foreach ($colors as $key => $label) {
                        $sel = $key === $selected ? 'selected' : '';
                        $options .= "<option value='{$key}' {$sel}>{$label}</option>";
                    }

                    return <<<HTML
                        <select class="form-control form-control-sm highlight-select" data-id="{$row->id}" data-module="weight_ones">
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
