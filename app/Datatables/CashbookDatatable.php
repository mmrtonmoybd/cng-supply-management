<?php

namespace App\Datatables;

use App\Models\Calculation;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class CashbookDatatable extends Datatable
{
    public $slug = 'cashbook';

    public function datasource()
    {
        return Calculation::with(['incomeEntries', 'expenseEntries'])->select('*');
    }

    public function setUp()
    {
        $this->order('id', 'desc')
            ->buttons('filters', 'csv', 'excel', 'print', 'copy', 'refresh')
            ->condensed()
            ->permissions('cashbook_crud')
            ->setRowId('id');
    }

    public function columns(): array
    {
        return [

            Column::add(__('Date'))
                ->width('180px')
                ->data('date')
                ->dateFormat('DD-MM-YYYY'),

            Column::add('Income')
                ->data('incomeEntries.amount', function ($calculation) {
                    return $calculation->incomeEntries->sum('amount');
                })->notSortable()->notSearchable()->notOrderable(),

            Column::add('Expense')
                ->data('expenseEntries.amount', function ($calculation) {
                    return $calculation->expenseEntries->sum('amount');
                })->notSortable()->notSearchable()->notOrderable(),

            Column::add('Net cash flow')
                ->data('net_cash_flow', function ($calculation) {
                    return $calculation->incomeEntries->sum('amount') - $calculation->expenseEntries->sum('amount');
                })->notSortable()->notSearchable()->notOrderable(),

            Column::add(__('Previous Balance'))
                ->data('previous_balance')->notSortable()->notSearchable()->notOrderable(),

            Column::add(__('Net Balance'))
                ->data('balance', function ($calculation) {
                    return $calculation->previous_balance + ($calculation->incomeEntries->sum('amount') - $calculation->expenseEntries->sum('amount'));

                })->notSortable()->notSearchable()->notOrderable(),

            Column::add()
                ->width('20px')
                ->actions(function (Calculation $calculation) {
                    return implode([
                        Button::show('backend.calculations.show', $calculation),
                        Button::edit('backend.calculations.edit', $calculation),
                        Button::delete('backend.calculations.destroy', $calculation),
                    ]);
                }),
        ];
    }
}
