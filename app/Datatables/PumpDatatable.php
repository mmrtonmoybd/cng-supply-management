<?php

namespace App\Datatables;

use App\Models\Factory;
use App\Models\Pump;
use App\Models\PumpName;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\Highlight;

class PumpDatatable extends Datatable
{
    public $slug = 'pump';

    public function datasource()
    {
        return Pump::with(['pumpname', 'factory'])->select('pumps.*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()->stateSave()
            ->setRowClass(function ($row) {
                $class = '';

                // Highlight color if set
                $highlight = Highlight::where('module_name', 'pumps')
                    ->where('module_id', $row->id)
                    ->value('color');

                if ($highlight) {
                    $class .= ' highlight-'.$highlight;
                }

                return trim($class);
            })
            ->permissions('pump_crud')
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [

            Column::add(__('Id'))
                ->data('id')
                ->name('pumps.id'),

            Column::add('________Date')
                ->data('date')
                ->dateFormat('DD-MM-YYYY')
                ->filterType('daterangepicker'),

            Column::add('Car no')
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

            Column::add('Pump type')
                ->data('pumpname.type', function ($pump) {
                    return ($pump->pumpname->type == 'Third Party') ? '<span class="badge badge-pill badge-primary">Third party</span>' : '<span class="badge badge-pill badge-warning">Main</span>';
                })
                ->filterOptions([
                    'Main' => 'Main',
                    'Third Party' => 'Third Party',
                ]),

            Column::add(__('Third party pump name'))
                ->data('third_party_pump_name'),

            Column::add('Only diesel')
                ->data('diesel_id', function ($pump) {
                    return $pump->diesel_id ? '<span class="badge badge-pill badge-success">Yes</span>' : '<span class="badge badge-pill badge-danger">No</span>';
                })->filterOptions([
                    '1' => 'Yes',
                    '0' => 'No',
                ])->filter(function ($query, $value) {
                    if ($value === '1') {
                        return $query->whereNotNull('diesel_id');
                    } elseif ($value === '0') {
                        return $query->whereNull('diesel_id');
                    }
                }),

            Column::add(__('M3'))
                ->data('cng_purchase_m3')->sum(),

            Column::add(__('Rate'))
                ->data('rate', function ($pump) {
                    return $pump->new_rate ?? $pump->rate;
                }),

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

            Column::add('Bill no')
                ->data('bill_no'),

            Column::add(__('____Payment Date'))
                ->data('payment_date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('Payment'))
                ->data('payment')->sum(),

            Column::add(__('Remarks'))
                ->data('remarks'),

            Column::add('Highlight')
                ->data('highlight', function ($row) {
                    $colors = ['none' => 'None', 'yellow' => 'Yellow', 'red' => 'Red', 'green' => 'Green', 'blue' => 'Blue'];

                    $highlight = Highlight::where('module_name', 'pumps')
                        ->where('module_id', $row->id)
                        ->first();

                    $selected = $highlight->color ?? 'none';

                    $options = '';
                    foreach ($colors as $key => $label) {
                        $sel = $key === $selected ? 'selected' : '';
                        $options .= "<option value='{$key}' {$sel}>{$label}</option>";
                    }

                    return <<<HTML
                        <select class="form-control form-control-sm highlight-select" data-id="{$row->id}" data-module="pumps">
                            {$options}
                        </select>
                    HTML;
                })->notOrderable()
                  ->filterOptions([
                    'none' => 'None', 'yellow' => 'Yellow', 'red' => 'Red', 'green' => 'Green', 'blue' => 'Blue'
                  ])
                  ->filter(function($query, $value) {
                    if ($value !== 'none') {
                        return $query->whereHas('highlight', function ($q) use ($value) {
                            $q->where('color', $value);
                        });
                    }
                  }),

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
