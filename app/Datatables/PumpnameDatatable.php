<?php

namespace App\Datatables;

use App\Models\PumpName;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\Highlight;

class PumpnameDatatable extends Datatable
{
    public $slug = 'pumpname';

    public function datasource()
    {
        return PumpName::query();
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->permissions('pump_name_crud')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()->stateSave()
            ->setRowClass(function ($row) {
                $class = '';

                // Highlight color if set
                $highlight = Highlight::where('module_name', 'pumpname')
                    ->where('module_id', $row->id)
                    ->value('color');

                if ($highlight) {
                    $class .= ' highlight-'.$highlight;
                }

                return trim($class);
            })
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id'),

            Column::add(__('Name'))
                ->data('name')
                ->width('12%')
                ->class('text-nowrap'),

            Column::add(__('Type'))
                ->data('type')
                ->filterOptions([
                    'Main' => 'Main',
                    'Third Party' => 'Third Party',
                ])
                ->filter(function ($query, $value) {
                    return $query->where('type', $value);
                }),

            Column::add(__('Is Diesel'))
                ->data('is_diesel', function ($model) {
                    return $model->is_diesel ? 'Yes' : 'No';
                })->notSearchable()->notSortable(),

            Column::add(__('Address'))
                ->data('address'),

            Column::add(__('Email'))
                ->data('email'),

            Column::add(__('Phone'))
                ->data('phone'),

            Column::add('Highlight')
                ->data('highlight', function ($row) {
                    $colors = ['none' => 'None', 'yellow' => 'Yellow', 'red' => 'Red', 'green' => 'Green', 'blue' => 'Blue'];

                    $highlight = Highlight::where('module_name', 'pumpname')
                        ->where('module_id', $row->id)
                        ->first();

                    $selected = $highlight->color ?? 'none';

                    $options = '';
                    foreach ($colors as $key => $label) {
                        $sel = $key === $selected ? 'selected' : '';
                        $options .= "<option value='{$key}' {$sel}>{$label}</option>";
                    }

                    return <<<HTML
                        <select class="form-control form-control-sm highlight-select" data-id="{$row->id}" data-module="pumpname">
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
                ->actions(function (PumpName $pumpname) {
                    return implode([
                        auth()->user()->ability(['admin'], 'pump_name_crud') ? Button::show('backend.pumpname.show', $pumpname) : null,
                        auth()->user()->ability(['admin'], 'pump_name_crud') ? Button::edit('backend.pumpname.edit', $pumpname) : null,
                        auth()->user()->ability(['admin'], 'pump_name_crud') ? Button::delete('backend.pumpname.destroy', $pumpname) : null,
                    ]);
                }),
        ];
    }
}
