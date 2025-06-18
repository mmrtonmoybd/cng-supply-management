<?php

namespace App\Datatables;

use App\Models\Vehicle;
use App\Models\VehicleDocument;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class VehicledocumentDatatable extends Datatable
{
    public $slug = 'vehicledocument';

    public function datasource()
    {
        return VehicleDocument::with('vehicle')->select('*');
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
                ->name('vehicle_documents.id'),

            Column::add(__('Vehicle Number'))
                ->data('vehicle.vehicle_number')
                ->name('vehicles.vehicle_number')
                ->width('12%')
                ->class('text-nowrap')
                ->filterOptions(Vehicle::distinct()->orderBy('vehicle_number', 'ASC')->pluck('vehicle_number', 'id')->toArray())
                ->filter(function ($query, $value) {
                    return $query->where('vehicle_id', $value);
                }),

            Column::add(__('Name'))
                ->data('name'),

            Column::add(__('Issued Date'))
                ->data('issued_date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add(__('Expiry Date'))
                ->data('expiry_date', function (VehicleDocument $vehicledocument) {
                    if ($vehicledocument->expiry_date) {
                        $expiry = \Carbon\Carbon::parse($vehicledocument->expiry_date);
                        $now = \Carbon\Carbon::now();
                        $diffInDays = $now->diffInDays($expiry, false);
                        if ($expiry < $now) {
                            // Expired
                            return '<span class="text-danger">'.$expiry->format('d-m-Y').'</span>';
                        } elseif ($diffInDays <= 30) {
                            // Less than or equal to 10 days left
                            return '<span class="text-danger">'.$expiry->format('d-m-Y').'</span>';
                        } elseif ($diffInDays <= 40) {
                            // Less than or equal to 30 days left
                            return '<span class="text-warning">'.$expiry->format('d-m-Y').'</span>';
                        } else {
                            // More than 30 days left
                            return '<span class="text-success">'.$expiry->format('d-m-Y').'</span>';
                        }
                    } else {
                        return __('Not Applicable');
                    }
                })->filterType('daterangepicker'),

            Column::add(__('Document url'))
                ->data('path', function (VehicleDocument $vehicledocument) {
                    return '<a href="'.asset($vehicledocument->document_url).'" target="_blank" style="color:#007bff;font-weight:bold;">'.__('View').'</a>';
                }),

            Column::add()
                ->width('20px')
                ->actions(function (VehicleDocument $vehicledocument) {
                    return implode([
                        Button::edit('backend.vehicle.vehicledocument.edit', $vehicledocument),
                        Button::delete('backend.vehicle.vehicledocument.destroy', $vehicledocument),
                    ]);
                }),
        ];
    }
}
