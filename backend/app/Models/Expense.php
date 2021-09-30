<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Wallet;
use Cache;

class Expense extends Model
{
    protected $fillable = [
        'wallet_id',
        'category',
        'amount',
        'note'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getExpenses()
    {
        if (Cache::has('expenses_'.auth()->id()))
        {
            $expenseRecords = Cache::get('expenses_'.auth()->id());
        } else {
            $expenseRecords = self::where('wallet_id', auth()->user()->wallet->id)->get();
            self::cacheAllExpenses($expenseRecords);
        }
        return $expenseRecords;
    }

    public static function storeExpense($data)
    {
        if ($data['category'] === "Other")
        {
            $wallet =  self::create([
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
        if ($data['category'] === "Other")
        {
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

    public static function RemoveExpense($id)
    {
        self::clearCacheAllExpenses();
        self::clearCacheExpense();
        return self::where('id', $id)->delete();
    }



    public static function cacheExpense($wallet)
    {
        Cache::forever('expense_'.auth()->id(), $wallet);
    }

    public static function clearCacheExpense()
    {
        if (Cache::has('expense_'.auth()->id())) {
            Cache::forget('expense_'.auth()->id());
        }
    }

    public static function cacheAllExpenses($wallets)
    {
        Cache::forever('expenses_'.auth()->id(), $wallets);
    }

    public static function clearCacheAllExpenses()
    {
        if (Cache::has('expenses_'.auth()->id())) {
            Cache::forget('expenses_'.auth()->id());
        }
    }
}