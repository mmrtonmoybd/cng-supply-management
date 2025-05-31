<?php

namespace App\Datatables;

use App\Models\Vehicle;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class VehicleDatatable extends Datatable
{
    public $slug = 'vehicle';

    public function datasource()
    {
        return Vehicle::query();
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->buttons('filters', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()
            ->permissions('cngpump_crud')
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id'),

            Column::add(__('Vehicle Number'))
                ->data('vehicle_number'),

            Column::add(__('Vehicle Type'))
                ->data('vehicle_type'),

            Column::add(__('Driver Name'))
                ->data('driver_name'),

            Column::add(__('Driver Phone'))
                ->data('driver_phone'),

            Column::add(__('Registration Date'))
                ->width('180px')
                ->data('registration_date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('Status'))
                ->data('status', function ($vehicle) {
                    return $vehicle->status ? __('Active') : __('Inactive');
                })->filterOptions([
                    0 => __('Inactive'),
                    1 => __('Active'),
                ]),

            Column::add()
                ->width('20px')
                ->actions(function (Vehicle $vehicle) {
                    return join([
                         Button::show('backend.asset.vehicle.show', $vehicle),
                         Button::edit('backend.asset.vehicle.edit', $vehicle),
                         Button::delete('backend.asset.vehicle.destroy', $vehicle),
                    ]);
                }),
        ];
    }
}
