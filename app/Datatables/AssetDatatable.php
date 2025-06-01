<?php

namespace App\Datatables;

use App\Models\Asset;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\Vehicle;

class AssetDatatable extends Datatable
{
    public $slug = 'asset';

    public function datasource()
    {
        return Asset::with('vehicle')->select('*');
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

            Column::add(__('Asset name'))
                ->data('name'),

            Column::add(__('Asset type'))
                ->data('type')
                ->filterOptions(Asset::distinct()->pluck('type', 'type')->toArray()),

            Column::add(__('Vehicle'))
                ->data('vehicle.vehicle_number')
                ->filterOptions(Vehicle::distinct()->orderBy('vehicle_number', 'ASC')->pluck('vehicle_number', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('vehicle_id', $value);
                }),

            Column::add()
                ->width('20px')
                ->actions(function (Asset $asset) {
                    return join([
                         Button::show('backend.asset.asset.show', $asset),
                         Button::edit('backend.asset.asset.edit', $asset),
                         Button::delete('backend.asset.asset.destroy', $asset),
                    ]);
                }),
        ];
    }
}
