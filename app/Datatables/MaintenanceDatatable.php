<?php

namespace App\Datatables;

use App\Models\Vehicle;
use App\Models\VehicleMaintenance;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class MaintenanceDatatable extends Datatable
{
    public $slug = 'maintenance';

    public function datasource()
    {
        return VehicleMaintenance::with('vehicle')->select('*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()
            ->permissions('vehicle_crud')
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id')
                ->name('vehicle_maintenances.id'),

            Column::add(__('Vehicle Number'))
                ->data('vehicle.vehicle_number')
                ->name('vehicles.vehicle_number')
                ->filterOptions(Vehicle::distinct()->orderBy('vehicle_number', 'ASC')->pluck('vehicle_number', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('vehicle_id', $value);
                }),

            Column::add(__('Maintenance Cost'))
                ->data('maintenance_cost')->sum(),

            Column::add(__('Details'))
                ->data('details')
                ->width('30%')
                ->class('text-nowrap'),

            Column::add(__('Maintenance Date'))
                ->width('180px')
                ->data('maintenance_date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add()
                ->width('20px')
                ->actions(function (VehicleMaintenance $vehiclemaintenance) {
                    return implode([
                        // Button::show('vehiclemaintenance.show', $vehiclemaintenance),
                        Button::edit('backend.vehicle.vehiclemaintenance.edit', $vehiclemaintenance),
                        Button::delete('backend.vehicle.vehiclemaintenance.destroy', $vehiclemaintenance),
                    ]);
                }),
        ];
    }
}
