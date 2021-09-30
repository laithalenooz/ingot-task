<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Wallet;
use Cache;

class Balance extends Model
{
    use \App\Http\Traits\UsesUuid;

    protected $fillable = [
        'id',
        'wallet_id',
        'income_type',
        'amount'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getBalance()
    {
        if (Cache::has('wallets_'.auth()->id()))
        {
            $balanceRecords = Cache::get('wallets_'.auth()->id());
        } else {
            $balanceRecords = self::where('wallet_id', auth()->user()->wallet->id)->get();
            self::cacheAllWallets($balanceRecords);
        }
        return $balanceRecords;
    }

    public static function checkBalance($id): bool
    {

        $balance = self::getById($id);
        $totalBalance = self::getBalance()->sum('amount');

        return ($totalBalance - $balance->amount) < auth()->user()->expenses;
    }

    public static function storeBalance($data)
    {
        if ($data['income_type'] === "Other")
        {
            $wallet =  self::create([
                'wallet_id' => auth()->user()->walletId,
                'amount' => $data['amount'],
                'income_type' => $data['income_type_new']
            ]);

            self::clearCacheAllWallets();
            self::cacheWallet($wallet);
            return $wallet;
        }
        $wallet = self::create([
            'wallet_id' => auth()->user()->walletId,
            'amount' => $data['amount'],
            'income_type' => $data['income_type']
        ]);

        self::clearCacheAllWallets();
        self::cacheWallet($wallet);

        return $wallet;
    }

    public static function updateBalance($data, $id)
    {
        if ($data['income_type'] === "Other")
        {
            $wallet = self::where('id', $id)->update([
                'amount' => $data['amount'],
                'income_type' => $data['income_type_new']
            ]);
        } else {
            $wallet = self::where('id', $id)->update([
                'amount' => $data['amount'],
                'income_type' => $data['income_type']
            ]);
        }

        self::cacheWallet($wallet);
        self::clearCacheAllWallets();

        return $wallet;
    }

    public static function RemoveBalance($id)
    {
        self::clearCacheAllWallets();
        self::clearCacheWallet();
        return self::where('id', $id)->delete();
    }



    public static function cacheWallet($wallet)
    {
        Cache::forever('wallet_'.auth()->id(), $wallet);
    }

    public static function clearCacheWallet()
    {
        if (Cache::has('wallet_'.auth()->id())) {
            Cache::forget('wallet_'.auth()->id());
        }
    }

    public static function cacheAllWallets($wallets)
    {
        Cache::forever('wallets_'.auth()->id(), $wallets);
    }

    public static function clearCacheAllWallets()
    {
        if (Cache::has('wallets_'.auth()->id())) {
            Cache::forget('wallets_'.auth()->id());
        }
    }
}