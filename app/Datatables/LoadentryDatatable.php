<?php

namespace App\Datatables;

use App\Models\Factory;
use App\Models\LoadEntry;
use App\Models\PumpName;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\Highlight;

class LoadentryDatatable extends Datatable
{
    public $slug = 'loadentry';

    public function datasource()
    {
        return LoadEntry::with(['pumpname', 'factory'])->select('load_entries.*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->permissions('load_crud')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()->stateSave()
            ->setRowClass(function ($row) {
    $class = '';

    // ✅ Mark this row as duplicate if an older identical row already exists
    $isDuplicate = LoadEntry::where('id', '<', $row->id) // 👈 changed this
        ->where('vehicle_reg_number', $row->vehicle_reg_number)
        ->where('pumpName_id', $row->pumpName_id)
        ->where('cng_purchase_m3', $row->cng_purchase_m3)
        ->where('rate', $row->rate)
        ->where('purchase_taka', $row->purchase_taka)
        ->where('factory_id', $row->factory_id)
        ->whereDate('date', $row->date)
        ->exists();

    if ($isDuplicate) {
        $class .= ' alert-danger';
    }

    // Highlight color if set
    $highlight = Highlight::where('module_name', 'loadEntry')
        ->where('module_id', $row->id)
        ->value('color');

    if ($highlight) {
        $class .= ' highlight-' . $highlight;
    }

    return trim($class);
})

->setRowAttr([
    'data-toggle' => fn($row) => LoadEntry::where('id', '<', $row->id)
        ->where('vehicle_reg_number', $row->vehicle_reg_number)
        ->where('pumpName_id', $row->pumpName_id)
        ->where('cng_purchase_m3', $row->cng_purchase_m3)
        ->where('rate', $row->rate)
        ->where('purchase_taka', $row->purchase_taka)
        ->where('factory_id', $row->factory_id)
        ->whereDate('date', $row->date)
        ->exists() ? 'tooltip' : null,

    'data-placement' => fn($row) => 'top',

    'title' => fn($row) => LoadEntry::where('id', '<', $row->id)
        ->where('vehicle_reg_number', $row->vehicle_reg_number)
        ->where('pumpName_id', $row->pumpName_id)
        ->where('cng_purchase_m3', $row->cng_purchase_m3)
        ->where('rate', $row->rate)
        ->where('purchase_taka', $row->purchase_taka)
        ->where('factory_id', $row->factory_id)
        ->whereDate('date', $row->date)
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
                ->name('load_entries.id'),

            Column::add(__('________Date'))
                ->data('date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('Car No'))
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

            Column::add(__('M3'))
                ->data('cng_purchase_m3')->sum(),

            Column::add(__('Rate'))
                ->data('rate'),

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

            Column::add('Highlight')
                ->data('highlight', function($row) {
                    $colors = ['none' => 'None', 'yellow' => 'Yellow', 'red' => 'Red', 'green' => 'Green', 'blue' => 'Blue'];

                    $highlight = Highlight::where('module_name', 'loadEntry')
                                        ->where('module_id', $row->id)
                                        ->first();

                    $selected = $highlight->color ?? 'none';

                    $options = '';
                    foreach ($colors as $key => $label) {
                        $sel = $key === $selected ? 'selected' : '';
                        $options .= "<option value='{$key}' {$sel}>{$label}</option>";
                    }

                    return <<<HTML
                        <select class="form-control form-control-sm highlight-select" data-id="{$row->id}" data-module="loadEntry">
                            {$options}
                        </select>
                    HTML;
                })->notOrderable()->notSearchable(),

            Column::add(__('Status'))
                ->data('status', function ($user) {
                    return $user->status == 1 ? '<span class="badge badge-pill badge-success">Use</span>' : '<span class="badge badge-pill badge-danger">Not Use</span>';
                })->filterOptions([
                    1 => 'Use',
                    0 => 'Not Use',
                ]),

            Column::add(__('Remark'))
                ->data('remark'),

            Column::add()
                ->width('20px')
                ->actions(function (LoadEntry $loadentry) {
                    return implode([
                        auth()->user()->ability(['admin'], 'load_crud') ? Button::show('backend.load.show', $loadentry) : null,
                        auth()->user()->ability(['admin'], 'load_crud') ? Button::edit('backend.load.edit', $loadentry) : null,
                        auth()->user()->ability(['admin'], 'load_crud') ? Button::delete('backend.load.destroy', $loadentry) : null,
                    ]);
                }),
        ];
    }
}
