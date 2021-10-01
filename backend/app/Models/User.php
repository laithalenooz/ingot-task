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
        'image',
        'birthdate',
        'phone',
        'role'
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

    protected $appends = ['balance', 'walletId', 'expenses', 'income'];

    public function getBalanceAttribute()
    {
        $total = $this->wallet->balances->sum('amount');
        $expenses = $this->wallet->expenses->sum('amount');
        return $total - $expenses;
    }

    public function getExpensesAttribute()
    {
        return $this->wallet->expenses->sum('amount');
    }

    public function getIncomeAttribute()
    {
        return $this->wallet->balances->sum('amount');
    }

    public function getWalletIdAttribute()
    {
        return $this->wallet->id;
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id');
    }
}
