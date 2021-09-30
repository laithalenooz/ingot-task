<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Wallet;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['balance', 'walletId', 'expenses'];

    public function getBalanceAttribute()
    {
        $total = auth()->user()->wallet->balances->sum('amount');
        $expenses = auth()->user()->wallet->expenses->sum('amount');
        return $total - $expenses;
    }

    public function getExpensesAttribute()
    {
        return auth()->user()->wallet->expenses->sum('amount');
    }

    public function getWalletIdAttribute()
    {
        return auth()->user()->wallet->id;
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id');
    }
}
