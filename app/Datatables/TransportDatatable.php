<?php

namespace App\Datatables;

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
            ->select('*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->permissions('transport_crud')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id'),

            Column::add(__('Vehicle no'))
                ->data('vehicle.vehicle_number')
                ->filterOptions(Vehicle::distinct()->orderBy('vehicle_number', 'ASC')->pluck('vehicle_number', 'id')->toArray())
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
                ->data('balance', function (Transport $transport) {
                    return $transport->rent - $transport->total_cost;
                })->sum()->notOrderable()->notSearchable(),

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
