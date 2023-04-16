<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends SaleRequest
{
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'promo_code' => ['nullable', 'string'],
            'search_string' => ['nullable', 'string']
        ];
    }
}
