<?php

namespace App\Datatables;

use App\Models\Diesel;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\PumpName;
use App\Models\Vehicle;

class DieselDatatable extends Datatable
{
    public $slug = 'diesel';

    public function datasource()
    {
        return Diesel::with(['pumpname', 'vehicle'])->select('*');
    }

    public function setUp()
    {
        $this->order('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id'),

            Column::add(__('D Date'))
                ->data('d_date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('D Time'))
                ->data('d_time')->dateFormat('HH:mm A')->notOrderable()->notSearchable(),

            Column::add(__('Slip No'))
                ->data('slip_no'),

            Column::add(__('Pump Name'))
                ->data('pumpname.name')
                ->filterOptions(PumpName::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('pumpName_id', $value);
                }),

            Column::add(__('Vehicle Number'))
                ->data('vehicle.vehicle_number')
                ->name('vehicles.vehicle_number')
                ->filterOptions(Vehicle::distinct()->orderBy('vehicle_number', 'ASC')->pluck('vehicle_number', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('vehicle_id', $value);
                }),

            Column::add(__('Purchase Litre'))
                ->data('diesel_purchase_litre'),

            Column::add(__('Taka'))
                ->data('taka'),

            Column::add(__('Date'))
                ->data('date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('Time'))
                ->data('time')->dateFormat('HH:mm A')->notOrderable()->notSearchable(),

            Column::add(__('Distance'))
                ->data('distance'),

            Column::add(__('Use Litre'))
                ->data('use_litre'),

            Column::add(__('Use Balance'))
                ->data('use_balance'),

            Column::add(__('Remark'))
                ->data('remark'),

            Column::add()
                ->width('20px')
                ->actions(function (Diesel $diesel) {
                    return join([
                         Button::show('backend.diesel.show', $diesel),
                         Button::edit('backend.diesel.edit', $diesel),
                         Button::delete('backend.diesel.destroy', $diesel),
                    ]);
                }),
        ];
    }
}
