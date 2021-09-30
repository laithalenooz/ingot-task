<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balance;
use App\Http\Requests\BalanceRequest;
use App\Rules\BalanceRule;
use Illuminate\Support\Facades\Validator;
use Log;

class BalancesController
{
    public function index()
    {

        $balanceRecords = Balance::getBalance();

        return view('wallet.home')->with('balance', $balanceRecords);
    }

    public function create()
    {
        return view('wallet.create');
    }

    public function store(BalanceRequest $request)
    {
        try {
            $wallet = Balance::storeBalance($request->validated());

            return redirect()->route('wallet.index');
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
        return view('wallet.edit')->with('balance', Balance::getById($id));
    }

    public function update(BalanceRequest $request, $id)
    {
        try {
            Balance::updateBalance($request->validated(), $id);

            return redirect()->route('wallet.index');
        } catch (\Exception $e) {
            Log::info($e);
            return $e;
        }
    }

    public function destroy($id)
    {
        try {
            // validate if after removing balance the expenses will be more
            $validateBalance = Balance::checkBalance($id);
            if ($validateBalance)
            {
                return redirect()->route('wallet.index')->with('error', 'Your expenses will be above your balance.');
            }

            Balance::RemoveBalance($id);

            return redirect()->route('wallet.index');
        } catch (\Exception $e) {
            Log::info($e);
            return $e;
        }
    }
}