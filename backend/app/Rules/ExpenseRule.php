<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ExpenseRule implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value): bool
    {
        return !($value > auth()->user()->balance);
    }

    public function message(): string
    {
        return 'Your expenses are more than your balance.';
    }
}