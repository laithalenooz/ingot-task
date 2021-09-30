<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BalanceRule implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value): bool
    {
        return !((auth()->user()->balance - $value) < auth()->user()->expenses);
    }

    public function message(): string
    {
        return 'Your expenses will be above your balance.';
    }
}