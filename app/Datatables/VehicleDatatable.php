<?php

namespace App\Datatables;

use App\Models\Vehicle;
use App\Models\VehicleDocument;
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
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()
            ->permissions('vehicle_crud')
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id'),

            Column::add(__('Vehicle Number'))
                ->data('vehicle_number')
                ->width('12%')
                ->class('text-nowrap'),

            Column::add(__('Vehicle Type'))
                ->data('vehicle_type')
                ->filterOptions([
                    'truck' => __('Truck'),
                    'van' => __('Van'),
                    'car' => 'Car',
                ]),

            Column::add(__('Type'))
                ->data('type')
                ->filterOptions([
                    'own' => __('Own'),
                    'rent' => __('Rent'),
                ]),

            Column::add(__('Driver Name'))
                ->data('driver_name')
                ->width('12%')
                ->class('text-nowrap'),

            Column::add(__('Registration Date'))
                ->width('180px')
                ->data('registration_date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('Maintenance Date'))
                ->data('maintenance_date')->dateFormat('DD-MM-YYYY'),

            Column::add(__('Documents'))
                ->data('documents', function (Vehicle $vehicle) {
                    $documents = VehicleDocument::where('vehicle_id', $vehicle->id)->get();
                    if ($documents->isEmpty()) {
                        return __('No documents available');
                    } else {
                        $output = '';
                        
                      foreach ($documents as $document) {
    if (!empty($document->expiry_date)) {
        $expiryDate = \Carbon\Carbon::parse($document->expiry_date);
        $now = \Carbon\Carbon::now();
        $diffInDays = $now->diffInDays($expiryDate, false);

        if ($expiryDate < $now) {
            $statusClass = 'text-danger';
        } elseif ($diffInDays <= 30) {
            $statusClass = 'text-danger';
        } elseif ($diffInDays <= 40) {
            $statusClass = 'text-warning';
        } else {
            $statusClass = 'text-success';
        }

        $expireHtml = '<span class="'.$statusClass.'">'.$expiryDate->format('d-m-Y').'</span> ';
    } else {
        $expireHtml = '';
    }

    $url = asset($document->document_url);
    $output .= '<span style="color: #222;">'.e($document->name).'</span> '
        .$expireHtml
        .'<a href="'.$url.'" target="_blank" style="color:#007bff;font-weight:bold;">'.__('View').'</a><br>';
}


                        return $output;
                    }
                })->notOrderable()->notSearchable()->notSortable(),

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
                    return implode([
                        Button::show('backend.vehicle.vehicle.show', $vehicle),
                        Button::edit('backend.vehicle.vehicle.edit', $vehicle),
                        Button::delete('backend.vehicle.vehicle.destroy', $vehicle),
                    ]);
                }),
        ];
    }
}
