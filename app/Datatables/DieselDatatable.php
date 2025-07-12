<?php

namespace App\Datatables;

use App\Models\Diesel;
use App\Models\PumpName;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class DieselDatatable extends Datatable
{
    public $slug = 'diesel';

    public function datasource()
    {
        return Diesel::with(['pumpname'])->select('*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()->stateSave()
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
