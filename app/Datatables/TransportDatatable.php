<?php

namespace App\Datatables;

use App\Models\Highlight;
use App\Models\Transport;
use App\Models\Vehicle;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class TransportDatatable extends Datatable
{
    public $slug = 'transport';

    public function datasource()
    {
        return Transport::with('vehicle')
            ->select('transports.*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->permissions('transport_crud')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()->stateSave()
            ->setRowClass(function ($row) {
                $class = '';

                // ✅ Mark this row as duplicate if an older identical row already exists
                $isDuplicate = Transport::where('id', '<', $row->id) // 👈 changed this
                    ->where('vehicle_id', $row->vehicle_id)
                    ->where('date', $row->date)
                    ->where('from', $row->from)
                    ->where('to', $row->to)
                    ->where('rent', $row->rent)
                    ->where('total_cost', $row->total_cost)
                    ->exists();

                if ($isDuplicate) {
                    $class .= ' alert-danger';
                }

                // Highlight color if set
                $highlight = Highlight::where('module_name', 'transport')
                    ->where('module_id', $row->id)
                    ->value('color');

                if ($highlight) {
                    $class .= ' highlight-'.$highlight;
                }

                return trim($class);
            })
            ->setRowAttr([
                'data-toggle' => fn ($row) => Transport::where('id', '<', $row->id) // 👈 changed this
                    ->where('date', $row->date)
                    ->where('vehicle_id', $row->vehicle_id)
                    ->where('date', $row->date)
                    ->where('from', $row->from)
                    ->where('to', $row->to)
                    ->where('rent', $row->rent)
                    ->where('total_cost', $row->total_cost)
                    ->exists() ? 'tooltip' : null,

                'data-placement' => fn ($row) => 'top',

                'title' => fn ($row) => Transport::where('id', '<', $row->id) // 👈 changed this
                    ->where('vehicle_id', $row->vehicle_id)
                    ->where('date', $row->date)
                    ->where('from', $row->from)
                    ->where('to', $row->to)
                    ->where('rent', $row->rent)
                    ->where('total_cost', $row->total_cost)
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
                ->name('transports.id'),

            Column::add(__('Vehicle no'))
                ->data('vehicle.vehicle_number')
                ->filterOptions(Vehicle::where('vehicle_type', 'transport')->distinct()->orderBy('vehicle_number', 'ASC')->pluck('vehicle_number', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('vehicle_id', $value);
                }),

            Column::add(__('______Date'))
                ->data('date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('From'))
                ->data('from'),

            Column::add(__('To'))
                ->data('to'),

            Column::add(__('Rent income'))
                ->data('rent')->sum(),

            Column::add(__('Maintenance Cost'))
                ->data('maintenance_cost')->sum(),

            Column::add(__('Diesel Cost'))
                ->data('diesel_cost')->sum(),

            Column::add(__('Toll Cost'))
                ->data('toll_cost')->sum(),

            Column::add(__('Labour Cost'))
                ->data('labour_cost')->sum(),

            Column::add(__('Chada Cost'))
                ->data('chada_cost')->sum(),

            Column::add(__('Fooding Cost'))
                ->data('fooding_cost')->sum(),

            Column::add(__('Police Cost'))
                ->data('police_cost')->sum(),

            Column::add(__('Parking Cost'))
                ->data('parking_cost')->sum(),

            Column::add(__('Other Cost'))
                ->data('other_cost')->sum(),

            Column::add(__('Total Cost'))
                ->data('total_cost')->sum(),

            Column::add('Net income')
                ->data('totalincome', function (Transport $transport) {
                    return $transport->rent - $transport->total_cost;
                })->sum()->notOrderable()->notSearchable(),

            Column::add('Cash recive date')
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

                    $highlight = Highlight::where('module_name', 'transport')
                        ->where('module_id', $row->id)
                        ->first();

                    $selected = $highlight->color ?? 'none';

                    $options = '';
                    foreach ($colors as $key => $label) {
                        $sel = $key === $selected ? 'selected' : '';
                        $options .= "<option value='{$key}' {$sel}>{$label}</option>";
                    }

                    return <<<HTML
                        <select class="form-control form-control-sm highlight-select" data-id="{$row->id}" data-module="transport">
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
                ->actions(function (Transport $transport) {
                    return implode([
                        Button::show('backend.transport.show', $transport),
                        Button::edit('backend.transport.edit', $transport),
                        Button::delete('backend.transport.destroy', $transport),
                    ]);
                }),
        ];
    }
}
