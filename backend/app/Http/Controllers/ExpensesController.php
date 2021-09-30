<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExpensesRequest;
use App\Models\Expense;
use Log;

class ExpensesController
{
    public function index()
    {
        $expensesRecords = Expense::getExpenses();

        return view('expenses.home')->with('expenses', $expensesRecords);
    }

    public function create()
    {
        // validate if user has Balance
        if (auth()->user()->balance <= 0)
        {
            return redirect()->route('expenses.index')->with('error', 'Not enough balance.');
        }
        return view('expenses.create');
    }

    public function store(ExpensesRequest $request)
    {
        try {
            Expense::storeExpense($request->validated());

            return redirect()->route('expenses.index');
        } catch (\Exception $e) {
            Log::info($e);
            return $e;
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return view('expenses.edit')->with('expense', Expense::getById($id));
    }

    public function update(ExpensesRequest $request, $id)
    {
        try {
            Expense::updateExpense($request->validated(), $id);

            return redirect()->route('expense.index');
        } catch (\Exception $e) {
            Log::info($e);
            return $e;
        }
    }

    public function destroy($id)
    {
        try {
            Expense::RemoveExpense($id);

            return redirect()->route('expenses.index');
        } catch (\Exception $e) {
            Log::info($e);
            return $e;
        }
    }
}