<?php

namespace App\Datatables;

use App\Models\Factory;
use App\Models\Invoice;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class InvoiceDatatable extends Datatable
{
    public $slug = 'invoice';

    public function datasource()
    {
        return Invoice::with(['factory'])->select('*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->permissions('invoice_crud')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()
            ->lengthMenu([[10, 28, 29, 30, 31, 50, 100, -1], [10, 28, 29, 30, 31, 50, 100, 'All']])
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Invoice no'))
                ->data('id'),

            Column::add(__('Invoice date'))
                ->width('180px')
                ->data('date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('Factory Type'))
                ->data('factory_type', function ($invoice) {
                    if ($invoice->factory_type === 'dispansar') {
                        return '<span class="badge badge-pill badge-success">Dispansar</span';
                    } elseif ($invoice->factory_type === 'cngpump') {
                        return '<span class="badge badge-pill badge-info">CNG Pump Slip</span>';
                    } elseif ($invoice->factory_type === 'weight') {
                        return '<span class="badge badge-pill badge-primary">Weight Scale</span>';
                    } elseif ($invoice->factory_type === 'weightone') {
                        return '<span class="badge badge-pill badge-secondary">Cng Pump & Weight Scale</span>';
                    }
                })->filterOptions(
                    [
                        'dispansar' => __('Dispansar'),
                        'cngpump' => __('CNG Pump Slip'),
                        'weight' => __('Weight Scale'),
                        'weightone' => __('Cng Pump & Weight Scale'),
                    ]),

            Column::add(__('Factory Name'))
                ->data('factory.name')
                ->filterOptions(Factory::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('factory_id', $value);
                }),

            Column::add(__('Invoice amount'))
                ->data('total')->sum(),

            Column::add()
                ->width('20px')
                ->actions(function (Invoice $invoice) {
                    return implode([
                        Button::show('backend.factory.invoice.show', $invoice),
                        Button::add()
                            ->attributes(['data-action' => 'dt-edit-element'])
                            ->link(route('backend.factory.invoice.edit', $invoice->id).'?factory='.$invoice->factory_type)
                            ->color('primary')
                            ->icon('pencil-alt')
                            ->make(),
                        Button::delete('backend.factory.invoice.destroy', $invoice),
                    ]);
                }),
        ];
    }
}
