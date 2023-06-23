<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestRequest extends OrderRequest
{
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'date' => ['required', 'date', 'after_or_equal:' . date('Y-m-d')],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
