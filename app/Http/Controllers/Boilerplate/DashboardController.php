<?php

namespace App\Http\Controllers\Boilerplate;

use App\Models\Calculation;
use App\Models\CngPump;
use App\Models\Diesel;
use App\Models\Dispansar;
use App\Models\IncomeEntry;
use App\Models\Invoice;
use App\Models\LoadEntry;
use App\Models\Transport;
use App\Models\Weight;
use App\Models\WeightOne;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Sebastienheyd\Boilerplate\Dashboard\DashboardWidgetsRepository;
use App\Http\Controllers\Controller;
use App\Models\Pump;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    private $registry;

    /**
     * Show the application dashboard.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $start_date = $request->input('daterange.start') ? $request->input('daterange.start') : Carbon::now();
        $end_date = $request->input('daterange.end') ? $request->input('daterange.end') : Carbon::now();

        $con_start = Carbon::parse($start_date)->format('Y-m-d');
        $con_end = Carbon::parse($end_date)->format('Y-m-d');

        // profit 
        $profit_pump = Pump::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('purchase_taka');
        $profit_diesel = Diesel::whereBetween('d_date', [
            $con_start,
            $con_end
        ])->sum('taka');
        $profit_transport = Transport::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('total_cost');

        $profit_transport_rent = Transport::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('rent');

        $profit_dispansar = Dispansar::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('bill_amount');
        $profit_weightone = WeightOne::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('ftk');
        $profit_weight = Weight::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('ftk');
        $profit_cngpump = CngPump::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('ftk');

        $profit = ($profit_dispansar + $profit_weightone + $profit_weight + $profit_cngpump  + $profit_transport_rent) - ($profit_pump + $profit_diesel + $profit_transport);

        // Load
          $load = Pump::whereBetween('date', [
            $con_start,
            $con_end
          ]);
          $load_count = $load->count('id');
          $load_m3 = $load->sum('cng_purchase_m3');

          // Diesel cost
          $diesel_cost = Diesel::whereBetween('date', [
            $con_start,
            $con_end
          ])->sum('taka');

          // Total pay 
           $pay_pump = Pump::whereBetween('payment_date', [
            $con_start,
            $con_end
        ])->sum('payment');

        // due / advance
        $due_pump = Pump::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('payment');
           $due_pump = Pump::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('purchase_taka');
           $due_diesel = Diesel::whereBetween('d_date', [
            $con_start,
            $con_end
        ])->sum('taka');

        $total_due = $due_pump - ($due_pump + $due_diesel);
        if ($total_due > 0) {
            $total_due_type = 'Advance';
        } elseif ($total_due > 0) {
            $total_due_type = 'Paid';
        } else {
            $total_due_type = 'Due';
        }

        // Use Diesel 
        $use_liter_diesel = Diesel::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('diesel_purchase_litre');
        $use_liter_diesel_2 = Diesel::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('use_litre');

        $use_liter = $use_liter_diesel - $use_liter_diesel_2; 
        if ($use_liter < 0) {
            $use_liter_type = 'Due';
        } else {
            $use_liter_type = 'Advance';
        }

        $use_bal_diesel = Diesel::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('use_balance');

        $use_balance = $diesel_cost - $use_bal_diesel;

        if ($use_balance < 0) {
            $use_balance_type = 'Due';
        } else {
            $use_balance_type = 'Advance';
        }


        // Dispansar

        $dispansar_cashrec = Dispansar::whereBetween('cash_receipt_date', [
            $con_start,
            $con_end
        ])->sum('cash_receipt_amount');

        $dispansar_balance = Dispansar::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('cash_receipt_amount');

        $dispansar_balance_t = $dispansar_balance - $profit_dispansar;

        if ($dispansar_balance_t > 0) {
                                $dispansar_balance_t_type = 'Advance';
                            } elseif ($dispansar_balance_t == 0) {
                                $dispansar_balance_t_type = 'Paid';
                            } else {
                                $dispansar_balance_t_type = 'Due';
                            }


        // Weightone 

        $weightone_cashrec = WeightOne::whereBetween('cash_receipt_date', [
            $con_start,
            $con_end
        ])->sum('cash_receipt_amount');

        $weightone_balance = WeightOne::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('cash_receipt_amount');

        $weightone_balance_t = $weightone_balance - $profit_weightone;

        if ($weightone_balance_t > 0) {
                                $weightone_balance_t_type = 'Advance';
                            } elseif ($weightone_balance_t == 0) {
                                $weightone_balance_t_type = 'Paid';
                            } else {
                                $weightone_balance_t_type = 'Due';
                            }


        // Weight 

        $weight_cashrec = Weight::whereBetween('cash_receipt_date', [
            $con_start,
            $con_end
        ])->sum('cash_receipt_amount');

        //dd($weight_cashrec);

        $weight_balance = Weight::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('cash_receipt_amount');

        $weight_balance_t = $weight_balance - $profit_weight;

        if ($weight_balance_t > 0) {
                                $weight_balance_t_type = 'Advance';
                            } elseif ($weight_balance_t == 0) {
                                $weight_balance_t_type = 'Paid';
                            } else {
                                $weight_balance_t_type = 'Due';
                            }

        // Cng pump slip 

        $cngpump_cashrec = CngPump::whereBetween('cash_receipt_date', [
            $con_start,
            $con_end
        ])->sum('cash_receipt_amount');

        //dd($cngpump_cashrec);

        $cngpump_balance = CngPump::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('cash_receipt_amount');

        $cngpump_balance_t = $cngpump_balance - $profit_cngpump;

        if ($cngpump_balance_t > 0) {
                                $cngpump_balance_t_type = 'Advance';
                            } elseif ($cngpump_balance_t == 0) {
                                $cngpump_balance_t_type = 'Paid';
                            } else {
                                $cngpump_balance_t_type = 'Due';
                            }

        // Invoice 
        $invoice = Invoice::whereBetween('date', [
            $con_start,
            $con_end
        ])->sum('total');

        // cashbook
        $cashbook = Calculation::whereBetween('date', [
            $con_start,
            $con_end
        ])->latest('id')->first();

        $cashbook2 = Calculation::whereDate('date', '<=', $con_end)->latest('id')->first();

        $handcash = $cashbook ? $cashbook : $cashbook2;

        // Income 
        $income = $handcash->incomeEntries->sum('amount');

        // Expense
        $expense = $handcash->expenseEntries->sum('amount');

        // Transport
        $transport_income = $profit_transport_rent - $profit_transport;
        
        return view('backend.dashboard', compact(['profit', 'load_count', 'load_m3', 'diesel_cost',
            'pay_pump', 'total_due', 'total_due_type', 'use_liter', 'use_liter_type', 'use_balance', 'use_balance_type',
        'profit_dispansar', 'dispansar_cashrec', 'dispansar_balance_t', 'dispansar_balance_t_type',
        'profit_weightone', 'weightone_cashrec', 'weightone_balance_t', 'weightone_balance_t_type',
        'profit_weight', 'weight_cashrec', 'weight_balance_t', 'weight_balance_t_type',
        'profit_cngpump', 'cngpump_cashrec', 'cngpump_balance_t', 'cngpump_balance_t_type', 'invoice', 'handcash', 'income', 'expense', 'transport_income']));
    }

}
