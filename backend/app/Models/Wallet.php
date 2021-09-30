<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Balance;
use App\Models\Expense;

class Wallet extends Model
{
    protected $fillable = [
        'user_id'
    ];

    public function balances()
    {
        return $this->hasMany(Balance::class, 'wallet_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'wallet_id');
    }
}