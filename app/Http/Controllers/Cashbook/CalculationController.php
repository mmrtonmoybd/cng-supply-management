<?php

namespace App\Http\Controllers\Cashbook;

use App\Http\Controllers\Controller;
use App\Models\Calculation;
use App\Models\Category;
use App\Models\ExpenseEntry;
use App\Models\IncomeEntry;
use Illuminate\Http\Request;

class CalculationController extends Controller
{
    public function index()
    {
        // Check if the user has permission to view calculations
        $this->authorize('cashbook_crud');

        return view('backend.cashbook.list');
        /*
        // Get all calculations in DESC order with pagination (e.g., 10 per page)
        $calculations = Calculation::with(['incomeEntries', 'expenseEntries'])
            ->orderBy('created_at', 'DESC')
            ->paginate(31);

        // Process each calculation to compute total income, total expense, and net balance
        $calculationsData = $calculations->map(function ($calculation) {
            $totalIncome = $calculation->incomeEntries->sum('amount');
            $totalExpense = $calculation->expenseEntries->sum('amount');
            $netChange = $totalIncome - $totalExpense;
            $netBalance = $calculation->previous_balance + $netChange;

            return [
                'id' => $calculation->id,
                'name' => $calculation->name,
                'date' => \Illuminate\Support\Carbon::parse($calculation->date)->format('d/m/Y'),
                'totalIncome' => $totalIncome,
                'totalExpense' => $totalExpense,
                'netBalance' => $netBalance,
                'created_at' => $calculation->created_at,
            ];
        });

        return view('backend.cashbook.index', compact('calculationsData', 'calculations'));

        */
    }

    public function create()
    {
        $this->authorize('cashbook_crud');
        $categories = Category::all();

        return view('backend.cashbook.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('cashbook_crud');
        // Normalize date to Y-m-d for unique validation
        $date = $request->date ? date('Y-m-d', strtotime($request->date)) : null;
        $request->merge(['date' => $date]);

        $request->validate([
            'date' => 'required|date|unique:calculations,date',
        ], [
            'date.required' => 'The date field is required.',
            'date.date' => 'The date must be a valid date.',
            'date.unique' => 'A Cashbook for this date already exists update those or make another date cashbook.',
        ]);
        $previousCalculation = Calculation::latest()->first();
        $previousBalance = $previousCalculation ? $previousCalculation->balance : 0;

        $calculation = Calculation::create([
            'name' => $request->name ?? $date, // fallback to date if name is missing
            'date' => $date,
            'previous_balance' => $previousBalance,
            'balance' => $previousBalance,
        ]);

        // Save income entries if any
        if (is_array($request->income)) {
            foreach ($request->income as $income) {
                if (empty($income['amount'])) {
                    continue;
                } // skip empty
                IncomeEntry::create([
                    'calculation_id' => $calculation->id,
                    'description' => $income['description'] ?? '',
                    'amount' => convertBengaliToEnglish($income['amount']),
                    'category_id' => $income['category_id'] ?? null,
                    'date' => $date, // Ensure date is set for income entries
                ]);
                $calculation->balance += convertBengaliToEnglish($income['amount']);
            }
        }

        // Save expense entries if any
        if (is_array($request->expense)) {
            foreach ($request->expense as $expense) {
                if (empty($expense['amount'])) {
                    continue;
                } // skip empty
                ExpenseEntry::create([
                    'calculation_id' => $calculation->id,
                    'description' => $expense['description'] ?? '',
                    'amount' => convertBengaliToEnglish($expense['amount']),
                    'category_id' => $expense['category_id'] ?? null,
                    'date' => $date, // Ensure date is set for expense entries
                ]);
                $calculation->balance -= convertBengaliToEnglish($expense['amount']);
            }
        }

        $calculation->save();

        return redirect()->route('backend.calculations.index');
    }

    public function edit(Calculation $calculation)
    {

        $this->authorize('cashbook_crud');
        $categories = Category::all();

        return view('backend.cashbook.edit', compact('calculation', 'categories'));
    }

    public function update(Request $request, Calculation $calculation)
    {
        $this->authorize('cashbook_crud');
        // Normalize date to Y-m-d for unique validation
        $date = $request->date ? date('Y-m-d', strtotime($request->date)) : null;
        $request->merge(['date' => $date]);

        $request->validate([
            'date' => 'required|date|unique:calculations,date,'.$calculation->id,
        ], [
            'date.required' => 'The date field is required.',
            'date.date' => 'The date must be a valid date.',
            'date.unique' => 'A Cashbook for this date already exists update those or make another date cashbook.', ]);

        $calculation->name = $request->name ?? $date;
        $calculation->date = $date;
        $calculation->balance = $calculation->previous_balance;

        // Update income entries
        $calculation->incomeEntries()->delete();
        if (is_array($request->income)) {
            foreach ($request->income as $income) {
                if (empty($income['amount'])) {
                    continue;
                } // skip empty
                IncomeEntry::create([
                    'calculation_id' => $calculation->id,
                    'description' => $income['description'] ?? '',
                    'amount' => convertBengaliToEnglish($income['amount']),
                    'category_id' => $income['category_id'] ?? null,
                    'date' => $date, // Ensure date is set for income entries
                ]);
                $calculation->balance += convertBengaliToEnglish($income['amount']);
            }
        }

        // Update expense entries
        $calculation->expenseEntries()->delete();
        if (is_array($request->expense)) {
            foreach ($request->expense as $expense) {
                if (empty($expense['amount'])) {
                    continue;
                } // skip empty
                ExpenseEntry::create([
                    'calculation_id' => $calculation->id,
                    'description' => $expense['description'] ?? '',
                    'amount' => convertBengaliToEnglish($expense['amount']),
                    'category_id' => $expense['category_id'] ?? null,
                    'date' => $date, // Ensure date is set for expense entries
                ]);
                $calculation->balance -= convertBengaliToEnglish($expense['amount']);
            }
        }

        $calculation->save();

        $nextcalculation = Calculation::where('id', '>', $calculation->id)->count();

        if ($nextcalculation > 0) {

            $previousBalance = $calculation->balance;

            // Fetch all subsequent calculations that need recalculation
            $subsequentCalculations = Calculation::where('id', '>', $calculation->id)->orderBy('id', 'asc')->get();

            // Recalculate balances for subsequent calculations
            foreach ($subsequentCalculations as $subsequentCalculation) {
                // Fetch income and expense totals for this calculation
                $totalIncome = $subsequentCalculation->incomeEntries->sum('amount');
                $totalExpense = $subsequentCalculation->expenseEntries->sum('amount');

                // Calculate the net balance (Income - Expense)
                $netBalance = $totalIncome - $totalExpense;

                // Calculate the current balance for this calculation
                $currentBalance = $previousBalance + $netBalance;

                // Update the subsequent calculation balance with recalculated data
                /*
                $subsequentCalculation->update([
                     'previous_balance' => $previousBalance, // You should not have to create a new column; this is conceptual for recalculation
                     'balance' => $currentBalance,   // Update the current balance for the record
                 ]);
                 */

                $upcal = Calculation::find($subsequentCalculation->id);
                $upcal->previous_balance = $previousBalance;
                $upcal->balance = $currentBalance;
                $upcal->save();

                $previousBalance = $currentBalance;

                // dd($previousBalance);

                // Set the previous balance for the next iteration

            }

        }

        return redirect()->route('backend.calculations.index');
    }

    public function show(Calculation $calculation, Request $request)
    {
        $this->authorize('cashbook_crud');
        // Get the start and end dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // If dates are provided, filter the income and expense entries
        $incomeEntries = $calculation->incomeEntries();
        $expenseEntries = $calculation->expenseEntries();

        // Step 1: Calculate the previous balance before the start date
        $previousBalance = $calculation->previous_balance;

        if ($startDate) {

            // Check if there is no entry is smaller then start date

            $rowcheck = Calculation::where('date', '<=', $startDate)->count();
            if ($rowcheck > 1) {
                // Get all calculations before the start date to adjust the previous balance
                $previousIncome = Calculation::with('incomeEntries')->where('date', '<', $startDate)->get()->pluck('incomeEntries')->collapse()->sum('amount');
                $previousExpense = Calculation::with('expenseEntries')->where('date', '<', $startDate)->get()->pluck('expenseEntries')->collapse()->sum('amount');
                $previousNet = $previousIncome - $previousExpense;

                // Adjust previous balance
                $previousBalance += $previousNet;
            } else {
                $previousBalance = 0; // There is no calculation before start date, so we set the previous balance to 0
            }

        }

        if ($startDate && $endDate) {
            $cal = Calculation::whereBetween('date', [$startDate, $endDate])->pluck('id')->toArray();
            $incomeEntries = IncomeEntry::whereIn('calculation_id', $cal);
            $expenseEntries = ExpenseEntry::whereIn('calculation_id', $cal);
            // $incomeEntries->whereBetween('date', [$startDate, $endDate]);
            // $expenseEntries->whereBetween('date', [$startDate, $endDate]);
        }

        // Get the filtered entries
        $incomeEntries = $incomeEntries->get();
        $expenseEntries = $expenseEntries->get();

        // dd($incomeEntries);

        // Calculate total income, total expense, and net balance
        $totalIncome = $incomeEntries->sum('amount');
        $totalExpense = $expenseEntries->sum('amount');
        $netChange = $totalIncome - $totalExpense;
        $netBalance = $previousBalance + $netChange;

        return view('backend.cashbook.show', compact('calculation', 'incomeEntries', 'expenseEntries', 'totalIncome', 'totalExpense', 'netBalance', 'previousBalance', 'startDate', 'endDate'));
    }

    public function export(Calculation $calculation, Request $request)
    {
        $this->authorize('cashbook_crud');
        // Get the start and end dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // If dates are provided, filter the income and expense entries
        $incomeEntries = $calculation->incomeEntries();
        $expenseEntries = $calculation->expenseEntries();

        // Step 1: Calculate the previous balance before the start date
        $previousBalance = $calculation->previous_balance;
        $range = '';

        if ($startDate) {

            // Check if there is no entry is smaller then start date

            $rowcheck = Calculation::where('date', '<=', $startDate)->count();
            if ($rowcheck > 1) {
                // Get all calculations before the start date to adjust the previous balance
                $previousIncome = Calculation::with('incomeEntries')->where('date', '<', $startDate)->get()->pluck('incomeEntries')->collapse()->sum('amount');
                $previousExpense = Calculation::with('expenseEntries')->where('date', '<', $startDate)->get()->pluck('expenseEntries')->collapse()->sum('amount');
                $previousNet = $previousIncome - $previousExpense;

                // Adjust previous balance
                $previousBalance += $previousNet;
            } else {
                $previousBalance = 0; // There is no calculation before start date, so we set the previous balance to 0
            }

        }

        if ($startDate && $endDate) {
            $cal = Calculation::whereBetween('date', [$startDate, $endDate])->pluck('id')->toArray();
            $incomeEntries = IncomeEntry::whereIn('calculation_id', $cal);
            $expenseEntries = ExpenseEntry::whereIn('calculation_id', $cal);
            // $incomeEntries->whereBetween('date', [$startDate, $endDate]);
            // $expenseEntries->whereBetween('date', [$startDate, $endDate]);

            $sdate = date_create($startDate);
            $sv = date_format($sdate, 'd/m/Y');
            $edate = date_create($endDate);
            $ev = date_format($edate, 'd/m/Y');
            $range = (string) $sv.'--'.(string) $ev;
        }

        // Get the filtered entries
        $incomeEntries = $incomeEntries->get();
        $expenseEntries = $expenseEntries->get();

        // dd($incomeEntries);

        // Calculate total income, total expense, and net balance
        $totalIncome = $incomeEntries->sum('amount');
        $totalExpense = $expenseEntries->sum('amount');
        $netChange = $totalIncome - $totalExpense;
        $netBalance = $previousBalance + $netChange;

        return view('backend.cashbook.export', compact('calculation', 'incomeEntries', 'expenseEntries', 'totalIncome', 'totalExpense', 'netBalance', 'previousBalance', 'startDate', 'endDate', 'range'));
    }

    public function destroy($id)
    {
        $this->authorize('cashbook_crud');
        // Find the calculation to delete
        $calculationToDelete = Calculation::findOrFail($id);

        // Delete the calculation
        $calculationToDelete->delete();

        // Fetch the previous calculation (before the deleted one)
        $previousCalculation = Calculation::where('id', '<', $id)->orderBy('id', 'desc')->first();

        // Determine the starting balance (from the previous calculation if it exists)
        $previousBalance = $previousCalculation ? $previousCalculation->getCurrentBalance() : 0;

        // Fetch all subsequent calculations that need recalculation
        $subsequentCalculations = Calculation::where('id', '>', $id)->orderBy('id', 'asc')->get();

        // Recalculate balances for subsequent calculations
        foreach ($subsequentCalculations as $subsequentCalculation) {
            // Fetch income and expense totals for this calculation
            $totalIncome = $subsequentCalculation->incomeEntries->sum('amount');
            $totalExpense = $subsequentCalculation->expenseEntries->sum('amount');

            // Calculate the net balance (Income - Expense)
            $netBalance = $totalIncome - $totalExpense;

            // Calculate the current balance for this calculation
            $currentBalance = $previousBalance + $netBalance;

            // Update the subsequent calculation balance with recalculated data
            $subsequentCalculation->update([
                'previous_balance' => $previousBalance, // You should not have to create a new column; this is conceptual for recalculation
                'balance' => $currentBalance,   // Update the current balance for the record
            ]);

            // Set the previous balance for the next iteration
            $previousBalance = $currentBalance;
        }

        // Redirect back with a success message
        return response()->json(['success' => $calculationToDelete->delete() ?? true]);
    }

    public function filter(Request $request)
    {
        $this->authorize('cashbook_crud');
        $dateRange = $request->input('date_range');
        $startDate = null;
        $endDate = null;
        if ($dateRange && strpos($dateRange, ' - ') !== false) {
            [$startDate, $endDate] = array_map('trim', explode(' - ', $dateRange));
        }
        $incomeEntries = collect();
        $expenseEntries = collect();
        $previousBalance = 0;
        $totalIncome = 0;
        $totalExpense = 0;
        $netChange = 0;
        $netBalance = 0;
        $calculation = null;

        if ($startDate && $endDate) {
            $calIds = Calculation::whereBetween('date', [$startDate, $endDate])->pluck('id')->toArray();
            $incomeEntries = IncomeEntry::whereIn('calculation_id', $calIds);
            $expenseEntries = ExpenseEntry::whereIn('calculation_id', $calIds);
            $previousIncome = Calculation::with('incomeEntries')->where('date', '<', $startDate)->get()->pluck('incomeEntries')->collapse()->sum('amount');
            $previousExpense = Calculation::with('expenseEntries')->where('date', '<', $startDate)->get()->pluck('expenseEntries')->collapse()->sum('amount');
            $previousBalance = $previousIncome - $previousExpense;
            $incomeEntries = $incomeEntries->get();
            $expenseEntries = $expenseEntries->get();
            $totalIncome = $incomeEntries->sum('amount');
            $totalExpense = $expenseEntries->sum('amount');
            $netChange = $totalIncome - $totalExpense;
            $netBalance = $previousBalance + $netChange;
        }

        return view('backend.cashbook.show', compact('calculation', 'incomeEntries', 'expenseEntries', 'totalIncome', 'totalExpense', 'netBalance', 'previousBalance', 'startDate', 'endDate', 'netChange', 'dateRange'));
    }

    public function filterExport(Request $request)
    {
        $this->authorize('cashbook_crud');
        $dateRange = $request->input('date_range');
        $startDate = null;
        $endDate = null;
        if ($dateRange && strpos($dateRange, ' - ') !== false) {
            [$startDate, $endDate] = array_map('trim', explode(' - ', $dateRange));
        }
        $incomeEntries = collect();
        $expenseEntries = collect();
        $previousBalance = 0;
        $totalIncome = 0;
        $totalExpense = 0;
        $netChange = 0;
        $netBalance = 0;
        $range = '';
        $calculation = null;

        if ($startDate && $endDate) {
            $calIds = Calculation::whereBetween('date', [$startDate, $endDate])->pluck('id')->toArray();
            $incomeEntries = IncomeEntry::whereIn('calculation_id', $calIds);
            $expenseEntries = ExpenseEntry::whereIn('calculation_id', $calIds);
            $previousIncome = Calculation::with('incomeEntries')->where('date', '<', $startDate)->get()->pluck('incomeEntries')->collapse()->sum('amount');
            $previousExpense = Calculation::with('expenseEntries')->where('date', '<', $startDate)->get()->pluck('expenseEntries')->collapse()->sum('amount');
            $previousBalance = $previousIncome - $previousExpense;
            $incomeEntries = $incomeEntries->get();
            $expenseEntries = $expenseEntries->get();
            $totalIncome = $incomeEntries->sum('amount');
            $totalExpense = $expenseEntries->sum('amount');
            $netChange = $totalIncome - $totalExpense;
            $netBalance = $previousBalance + $netChange;
            $range = $dateRange;
        }

        return view('backend.cashbook.export', compact('calculation', 'incomeEntries', 'expenseEntries', 'totalIncome', 'totalExpense', 'netBalance', 'previousBalance', 'startDate', 'endDate', 'range', 'dateRange'));
    }
}
