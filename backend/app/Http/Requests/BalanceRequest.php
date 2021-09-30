<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BalanceRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->income_type === "Other")
        {
            return [
                'income_type' => ['required'],
                'income_type_new' => ['required'],
                'amount'      => ['required', 'numeric']
            ];
        }
        return [
            'income_type' => ['required'],
            'amount'      => ['required', 'numeric']
        ];
    }
}