<?php

namespace App\Datatables;

use App\Models\PumpName;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class PumpnameDatatable extends Datatable
{
    public $slug = 'pumpname';

    public function datasource()
    {
        return PumpName::query();
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->permissions('load_index')
            ->buttons('filters', 'colvis', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id'),

            Column::add(__('Name'))
                ->data('name'),

            Column::add(__('Type'))
                ->data('type')
                ->filterOptions([
                    'Main' => 'Main',
                    'Third Party' => 'Third Party',
                ])
                ->filter(function ($query, $value) {
                    return $query->where('type', $value);
                }),

            Column::add(__('Address'))
                ->data('address'),

            Column::add(__('Email'))
                ->data('email'),

            Column::add(__('Phone'))
                ->data('phone'),

            Column::add()
                ->width('20px')
                ->actions(function (PumpName $pumpname) {
                    return implode([
                        Button::show('backend.pumpname.show', $pumpname),
                        Button::edit('backend.pumpname.edit', $pumpname),
                        Button::delete('backend.pumpname.destroy', $pumpname),
                    ]);
                }),
        ];
    }
}
