<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use Sebastienheyd\Boilerplate\Models\User;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Builder;

class ActivitylogDatatable extends Datatable
{
    public $slug = 'activitylog';

    public function datasource()
    {
        return Activity::query();
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->buttons('filters', 'colvis', 'refresh')
            ->permissions('activity_logs')
            ->condensed()
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id'),

            Column::add(__('Date'))
                ->width('180px')
                ->data('created_at', function($data) {
                    return $data->created_at->format('d-m-Y h:i A');
                })->filterType('daterangepicker')->filter(function (Builder $query, $value) {
                    $dates = explode(' - ', $value);

                    try {
                        $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[0]));
                        $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[1]));

                        $query->whereBetween('created_at', [$startDate, $endDate]);
                    } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                        // Log the error and skip filtering if the format is invalid
                        \Log::error('Invalid date format in ActivitylogDatatable filter: ' . $e->getMessage());
                    }
                }),
            
            Column::add(__('Module'))
                ->data('log_name'),

            Column::add(__('Action'))
                ->data('event', function ($event) {
                    return $event->event === 'created' ? '<span class="badge badge-pill badge-success">Created</span>' : ($event->event === 'updated' ? '<span class="badge badge-pill badge-warning">Updated</span>' : '<span class="badge badge-pill badge-danger">Deleted</span>');
                })->filterOptions([
                    'created' => 'Created',
                    'updated' => 'Updated',
                    'deleted' => 'Deleted',
                ]),

            Column::add(__('User'))
                ->data('causer_id', function ($causer_id ) {
                      $find = User::find($causer_id->causer_id);
                      return $find->first_name . ' ' . $find->last_name;
                })->filterOptions(function () {
                    return User::all()->pluck('name', 'id')->toArray();
                })->filter(function ($query, $q) {
                    $query->where('causer_id', $q);
                }),

            Column::add(__('Activity description'))
                ->data('properties', function ($property) {
                    $decoded = json_decode($property->properties, true);
                    $output = '';

                    if (isset($decoded['attributes']) && isset($decoded['old'])) {
                        foreach ($decoded['attributes'] as $key => $newValue) {
                            $oldValue = $decoded['old'][$key] ?? 'N/A';
                            $output .= "New $key = $newValue<br>Old $key = $oldValue<br>";
                        }
                    } elseif (isset($decoded['attributes'])) {
                        foreach ($decoded['attributes'] as $key => $newValue) {
                            $output .= "New $key = $newValue<br>";
                        }
                    } elseif (isset($decoded['old'])) {
                        foreach ($decoded['old'] as $key => $oldValue) {
                            $output .= "Old $key = $oldValue<br>";
                        }
                    }

                    return $output;
                }),

                Column::add()
                ->width('20px')
                ->actions(function (Activity $activity) {
                    return implode([
                        Button::show('backend.activity.show', $activity),
                    ]);
                }),
        ];
    }
}
