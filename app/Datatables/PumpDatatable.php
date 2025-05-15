<?php

namespace App\Datatables;

use App\Models\LoadEntry;
use App\Models\Pump;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use Illuminate\Database\Eloquent\Builder;

class PumpDatatable extends Datatable
{
    public $slug = 'pump';

    public function datasource()
    {
        return Pump::with('loada')->select('*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->permissions('load_index')
            ->buttons('filters', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()
            ->permissions('pump_index')
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [

            Column::add(__('Id'))
                ->data('id')
                ->name('pumps.id'),
            
            Column::add('Load date')
                ->data('loada.date')
                ->dateFormat(__('boilerplate::date.Ymd'))
                ->filterType('daterangepicker')
                ->filter(function (Builder $query, $value) {
                    $dates = explode(' - ', $value);
                    $dateRange = $dates[0];
                    [$startDate, $endDate] = explode('|', $dateRange);
                    
                    return $query->whereHas('loada', function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('date', [$startDate, $endDate]);
                    });
                }),

            Column::add('Car no')
                ->data('loada.vehicle_reg_number'),

            Column::add('Pump Name')
                ->data('loada.pump_name')
                ->filterOptions(LoadEntry::distinct()->orderBy('pump_name', 'ASC')->pluck('pump_name', 'pump_name')->toArray())
                ->filter(function ($query, $value) {
                    //return $query->where('pump_name', 'LIKE', '%' . $value. '%');
                    return $query->whereHas('loada', function ($query) use ($value) {
                        $query->where('pump_name', 'LIKE', '%' . $value . '%');
                    });
                }),

            Column::add('M3')
                ->data('loada.cng_purchase_m3'),

            Column::add('Rate')
                ->data('loada.rate'),

            Column::add('Purchase Taka')
                ->data('loada.purchase_taka'),

            Column::add(__('Payment Date'))
                ->data('payment_date')
                ->dateFormat(__('boilerplate::date.Ymd')),

            Column::add(__('Payment'))
                ->data('payment'),

            Column::add(__('Balance'))
                ->data('balance'),

            Column::add('Banlance type')
                ->data('balance_type', function ($balance) {
                    if (is_null($balance->balance)) {
                        return '<span class="badge badge-secondary">N/A</span>';
                    } elseif ($balance->balance == 0) {
                        return '<span class="badge badge-success">Paid</span>';
                    } elseif ($balance->balance < 0) {
                        return '<span class="badge badge-warning">Advance</span>';
                    } else {
                        return '<span class="badge badge-danger">Due</span>';
                    }
                })->filterOptions([
                    'paid' => 'Paid',
                    'advance' => 'Advance',
                    'due' => 'Due',
                ])->filter(function ($query, $value) {
                    if ($value == 'paid') {
                        return $query->where('balance', 0);
                    } elseif ($value == 'advance') {
                        return $query->where('balance', '<', 0);
                    } elseif ($value == 'due') {
                        return $query->where('balance', '>', 0);
                    }
                }),

            Column::add(__('Remarks'))
                ->data('remarks'),

            Column::add()
                ->width('20px')
                ->actions(function ($pump) {
                    return implode([
                        auth()->user()->ability(['admin'], 'pump_index') ? Button::show('backend.pump.show', $pump->id) : null,
                        auth()->user()->ability(['admin'], 'pump_update') ? Button::edit('backend.pump.edit', $pump->id) : null,
                        // Button::delete('pump.destroy', $pump),
                    ]);
                }),
        ];
    }
}
