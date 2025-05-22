<?php

namespace App\Datatables;

use App\Models\Boilerplate\User;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use Spatie\Activitylog\Models\Activity;

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
                ->data('created_at')
                ->filterType('daterangepicker')
                ->dateFormat('YYYY-MM-DD hh:mm:ss A'),

            Column::add(__('Module'))
                ->data('log_name')
                ->filterOptions([
                    'Factory CNG Pump Slip' => 'Factory CNG Pump Slip',
                    'Factory Dispansar' => 'Factory Dispansar',
                    'Factory names' => 'Factory names',
                    'Factory Cng Pump & Weight Scale' => 'Factory Cng Pump & Weight Scale',
                    'Factory Weight Scale' => 'Factory Weight Scale',
                    'Load' => 'Load',
                    'Pumps' => 'Pumps',
                    'Pump names' => 'Pump names',
                ])->filter(function ($query, $q) {
                    $query->where('log_name', $q);
                }),

            Column::add(__('Action'))
                ->data('event', function ($event) {
                    return $event->event === 'created' ? '<span class="badge badge-pill badge-success">Created</span>' : ($event->event === 'updated' ? '<span class="badge badge-pill badge-warning">Updated</span>' : '<span class="badge badge-pill badge-danger">Deleted</span>');
                })->filterOptions([
                    'created' => 'Created',
                    'updated' => 'Updated',
                    'deleted' => 'Deleted',
                ]),

            Column::add(__('User'))
                ->data('causer_id', function ($causer_id) {
                    $find = User::find($causer_id->causer_id);

                    return $find->first_name.' '.$find->last_name;
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
                        auth()->user()->ability(['admin'], 'activity_logs') ? Button::show('backend.activity.show', $activity) : null,
                    ]);
                }),
        ];
    }
}
