<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExpenseRule;

class ExpensesRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->category === "Other")
        {
            return [
                'category' => ['required'],
                'category_new' => ['required'],
                'amount'      => ['required', 'numeric', new ExpenseRule()]
            ];
        }
        return [
            'category' => ['required'],
            'amount'      => ['required', 'numeric', new ExpenseRule()]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}