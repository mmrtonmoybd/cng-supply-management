<?php

namespace App\Datatables;

use App\Models\Category;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class CategoryentryDatatable extends Datatable
{
    public $slug = 'categoryentry';

    public function datasource()
    {
        return Category::query();
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->buttons('filters', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()->stateSave()
            ->permissions('cashbook_crud')
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Id'))
                ->data('id'),

            Column::add(__('Name'))
                ->data('name'),

            Column::add()
                ->width('20px')
                ->actions(function (Category $category) {
                    return implode([
                        // Button::show('category.show', $category),
                        Button::edit('backend.categories.edit', $category),
                        Button::delete('backend.categories.destroy', $category),
                    ]);
                }),
        ];
    }
}
