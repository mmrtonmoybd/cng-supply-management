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
                ->data('vehicle_type')
                ->filterOptions([
                    'truck' => __('Truck'),
                    'van' => __('Bus'),
                ]),

            Column::add(__('Driver Name'))
                ->data('driver_name'),

            Column::add(__('Registration Date'))
                ->width('180px')
                ->data('registration_date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('Maintenance Date'))
                ->data('maintenance_date', function (Vehicle $vehicle) {
                    if ($vehicle->maintenance_date) {
                        $expiry = \Carbon\Carbon::parse($vehicle->maintenance_date);
                        $now = \Carbon\Carbon::now();
                        $diffInDays = $now->diffInDays($expiry, false);
                        if ($expiry < $now) {
                            // Expired
                            return '<span class="text-danger">'.$expiry->format('d-m-Y').'</span>';
                        } elseif ($diffInDays <= 7) {
                            // Less than or equal to 10 days left
                            return '<span class="text-danger">'.$expiry->format('d-m-Y').'</span>';
                        } elseif ($diffInDays <= 20) {
                            // Less than or equal to 30 days left
                            return '<span class="text-warning">'.$expiry->format('d-m-Y').'</span>';
                        } else {
                            // More than 30 days left
                            return '<span class="text-success">'.$expiry->format('d-m-Y').'</span>';
                        }
                    } else {
                        return null;
                    }
                })->notSearchable()->notSortable(),

            Column::add(__('Documents'))
                ->data('documents', function (Vehicle $vehicle) {
                    $documents = VehicleDocument::where('vehicle_id', $vehicle->id)->get();
                    if ($documents->isEmpty()) {
                        return __('No documents available');
                    } else {
                        $output = '';
                        foreach ($documents as $document) {
                            $expiryDate = \Carbon\Carbon::parse($document->expiry_date);
                            $now = \Carbon\Carbon::now();
                            $diffInDays = $now->diffInDays($expiryDate, false);
                            if ($expiryDate < $now) {
                                $statusClass = 'text-danger';
                            } elseif ($diffInDays <= 10) {
                                $statusClass = 'text-danger';
                            } elseif ($diffInDays <= 30) {
                                $statusClass = 'text-warning';
                            } else {
                                $statusClass = 'text-success';
                            }
                            $url = asset($document->document_url);
                            $output .= '<span style="color: #222;">'.e($document->name).'</span> '
                                .'<span class="'.$statusClass.'">'.$expiryDate->format('d-m-Y').'</span> '
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
                        Button::show('backend.asset.vehicle.show', $vehicle),
                        Button::edit('backend.asset.vehicle.edit', $vehicle),
                        Button::delete('backend.asset.vehicle.destroy', $vehicle),
                    ]);
                }),
        ];
    }
}
