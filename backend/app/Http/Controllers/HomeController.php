<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Expense;

class HomeController
{
    public function index()
    {
        // Get chart data for dashboard
        $balancesChart = Balance::getBalanceChart();
        $expensesChart = Expense::getExpenseChart();

        return view('dashboard', compact('balancesChart', 'expensesChart'));

    }
}