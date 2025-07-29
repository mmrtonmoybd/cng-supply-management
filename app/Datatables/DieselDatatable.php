<?php

namespace App\Datatables;

use App\Models\Diesel;
use App\Models\Highlight;
use App\Models\PumpName;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class DieselDatatable extends Datatable
{
    public $slug = 'diesel';

    public function datasource()
    {
        return Diesel::with(['pumpname'])->select('diesels.*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()->stateSave()
            ->setRowClass(function ($row) {
                $class = '';

                // âœ… Mark this row as duplicate if an older identical row already exists
                $isDuplicate = Diesel::where('id', '<', $row->id) // ðŸ‘ˆ changed this
                    ->where('d_date', $row->d_date)
                    // ->where('d_time', $row->d_time)
                    ->where('slip_no', $row->slip_no)
                    ->where('pumpName_id', $row->pumpName_id)
                    ->where('vehicle_reg_number', $row->vehicle_reg_number)
                    ->where('diesel_purchase_litre', $row->diesel_purchase_litre)
                    ->where('taka', $row->taka)
                    ->exists();

                if ($isDuplicate) {
                    $class .= ' alert-danger';
                }

                // Highlight color if set
                $highlight = Highlight::where('module_name', 'diesel')
                    ->where('module_id', $row->id)
                    ->value('color');

                if ($highlight) {
                    $class .= ' highlight-'.$highlight;
                }

                return trim($class);
            })
            ->setRowAttr([
                'data-toggle' => fn ($row) => Diesel::where('id', '<', $row->id) // ðŸ‘ˆ changed this
                    ->where('d_date', $row->d_date)
                    // ->where('d_time', $row->d_time)
                    ->where('slip_no', $row->slip_no)
                    ->where('pumpName_id', $row->pumpName_id)
                    ->where('vehicle_reg_number', $row->vehicle_reg_number)
                    //->where('diesel_purchase_litre', $row->diesel_purchase_litre)
                    ->where('taka', $row->taka)
                    ->exists() ? 'tooltip' : null,

                'data-placement' => fn ($row) => 'top',

                'title' => fn ($row) => Diesel::where('id', '<', $row->id) // ðŸ‘ˆ changed this
                    ->where('d_date', $row->d_date)
                    // ->where('d_time', $row->d_time)
                    ->where('slip_no', $row->slip_no)
                    ->where('pumpName_id', $row->pumpName_id)
                    ->where('vehicle_reg_number', $row->vehicle_reg_number)
                    ->where('diesel_purchase_litre', $row->diesel_purchase_litre)
                    ->where('taka', $row->taka)
                    ->exists()
                        ? 'ðŸš¨ This row appears to be a duplicate of a previous row with identical data. Please double-check before proceeding.'
                        : null,
            ])
            ->permissions('diesel_crud')
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id'),

            Column::add(__('___Load Date'))
                ->data('d_date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('Load Time'))
                ->data('d_time', function ($diesel) {
                    return date('h:i A', strtotime($diesel->d_time));
                })->notOrderable()->notSearchable(),

            Column::add(__('Slip No'))
                ->data('slip_no'),

            Column::add(__('Pump Name'))
                ->data('pumpname.name')
                ->width('12%')
                ->class('text-nowrap')
                ->filterOptions(PumpName::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('pumpName_id', $value);
                }),

            Column::add(__('Vehicle Number'))
                ->data('vehicle_reg_number')
                ->width('12%')
                ->class('text-nowrap'),

            Column::add(__('Litre'))
                ->data('diesel_purchase_litre')->sum(),

            Column::add(__('Taka'))
                ->data('taka')->sum(),

            Column::add(__('___Use Date'))
                ->data('date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('____Time'))
                ->data('time', function ($diesel) {
                    return $diesel->time ? date('h:i A', strtotime($diesel->time)) : '';

                })->notOrderable()->notSearchable(),

            Column::add(__('Distance'))
                ->data('distance')->sum(),

            Column::add(__('Use Litre'))
                ->data('use_litre')->sum(),

            Column::add(__('Use Balance'))
                ->data('use_balance')->sum(),

            Column::add(__('Remark'))
                ->data('remark'),

            Column::add('Highlight')
                ->data('highlight', function ($row) {
                    $colors = ['none' => 'None', 'yellow' => 'Yellow', 'red' => 'Red', 'green' => 'Green', 'blue' => 'Blue'];

                    $highlight = Highlight::where('module_name', 'diesel')
                        ->where('module_id', $row->id)
                        ->first();

                    $selected = $highlight->color ?? 'none';

                    $options = '';
                    foreach ($colors as $key => $label) {
                        $sel = $key === $selected ? 'selected' : '';
                        $options .= "<option value='{$key}' {$sel}>{$label}</option>";
                    }

                    return <<<HTML
                        <select class="form-control form-control-sm highlight-select" data-id="{$row->id}" data-module="diesel">
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
                ->actions(function (Diesel $diesel) {
                    return implode([
                        Button::show('backend.diesel.show', $diesel),
                        Button::edit('backend.diesel.edit', $diesel),
                        Button::delete('backend.diesel.destroy', $diesel),
                    ]);
                }),
        ];
    }
}
