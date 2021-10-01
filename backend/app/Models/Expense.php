<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Wallet;
use Cache;
use DB;

class Expense extends Model
{
    protected $fillable = [
        'wallet_id',
        'category',
        'amount',
        'note'
    ];

    protected $casts = [
        'amount' => 'integer'
    ];

    // put the wallet relation
    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    // Prepare get by id function to not repeat my code
    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    // check if expenses exist in cache, if not then query it then cache it
    public static function getExpenses()
    {
        if (Cache::has('expenses_' . auth()->id())) {
            $expenseRecords = Cache::get('expenses_' . auth()->id());
        } else {
            $expenseRecords = self::where('wallet_id', auth()->user()->wallet->id)->get();
            self::cacheAllExpenses($expenseRecords);
        }
        return $expenseRecords;
    }

    public static function storeExpense($data)
    {
        if ($data['category'] === "Other") {
            $wallet = self::create([
                'wallet_id' => auth()->user()->walletId,
                'amount' => $data['amount'],
                'category' => $data['category_new']
            ]);

            self::clearCacheAllExpenses();
            self::cacheExpense($wallet);
            return $wallet;
        }
        $wallet = self::create([
            'wallet_id' => auth()->user()->walletId,
            'amount' => $data['amount'],
            'category' => $data['category']
        ]);

        self::clearCacheAllExpenses();
        self::cacheExpense($wallet);

        return $wallet;
    }

    public static function updateExpense($data, $id)
    {
        if ($data['category'] === "Other") {
            $wallet = self::where('id', $id)->update([
                'amount' => $data['amount'],
                'category' => $data['category_new']
            ]);
        } else {
            $wallet = self::where('id', $id)->update([
                'amount' => $data['amount'],
                'category' => $data['category']
            ]);
        }

        self::cacheExpense($wallet);
        self::clearCacheAllExpenses();

        return $wallet;
    }

    public static function getExpenseChart(): array
    {

        $currentYear = date('Y');
        $data = [];
        for ($i = 1; $i <= 12; ++$i) {
            $amountMounth = DB::table('expenses')
                ->where('wallet_id', auth()->user()->walletId)
                ->select('amount')
                ->whereMonth('created_at', $i)
                ->whereYear('created_at', $currentYear)
                ->sum('amount');
            $data[] = $amountMounth;
        }

        return $data;
    }

    public static function RemoveExpense($id)
    {
        self::clearCacheAllExpenses();
        self::clearCacheExpense();
        return self::where('id', $id)->delete();
    }

    public static function cacheExpense($wallet): void
    {
        Cache::forever('expense_' . auth()->id(), $wallet);
    }

    public static function clearCacheExpense(): void
    {
        if (Cache::has('expense_' . auth()->id())) {
            Cache::forget('expense_' . auth()->id());
        }
    }

    public static function cacheAllExpenses($wallets): void
    {
        Cache::forever('expenses_' . auth()->id(), $wallets);
    }

    public static function clearCacheAllExpenses(): void
    {
        if (Cache::has('expenses_' . auth()->id())) {
            Cache::forget('expenses_' . auth()->id());
        }
    }
}