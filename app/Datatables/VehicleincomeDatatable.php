<?php

namespace App\Datatables;

use App\Models\Factory;
use App\Models\PumpName;
use App\Models\VehicleIncome;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class VehicleincomeDatatable extends Datatable
{
    public $slug = 'vehicleincome';

    public function datasource()
    {
        return VehicleIncome::with(['pumpname', 'factory'])->select('*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->permissions('vehicle_income_crud')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()->stateSave()
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id'),

            Column::add(__('______Date'))
                ->width('180px')
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

            Column::add(__('Factory Name'))
                ->data('factory.name')
                ->filterOptions(Factory::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray())
                ->width('12%')
                ->class('text-nowrap')
                ->filter(function ($query, $value) {
                    return $query->where('factory_id', $value);
                }),

            Column::add(__('M3'))
                ->data('cng_purchase_m3')->sum(),

            Column::add(__('Load rate'))
                ->data('lrate'),

            Column::add(__('Purchase Taka'))
                ->data('purchase_taka')->sum(),

            Column::add(__('______F date'))
                ->width('180px')
                ->data('bill_date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('Fm3'))
                ->data('fm3')->sum(),

            Column::add(__('Rate'))
                ->data('rate'),

            Column::add(__('Ftk'))
                ->data('ftk')->sum(),

            Column::add(__('Difference'))
                ->data('difference')->sum(),

            Column::add(__('Rent'))
                ->data('rent')->sum(),

            Column::add(__('Driver Fooding'))
                ->data('driver_fooding')->sum(),

            Column::add(__('Maintenance'))
                ->data('maintenance')->sum(),

            Column::add(__('Other'))
                ->data('other')->sum(),

            Column::add()
                ->width('20px')
                ->actions(function (VehicleIncome $vehicleincome) {
                    return implode([
                        Button::show('backend.vehicleIncome.show', $vehicleincome),
                        Button::edit('backend.vehicleIncome.edit', $vehicleincome),
                    ]);
                }),
        ];
    }
}
