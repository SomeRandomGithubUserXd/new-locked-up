<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'with_options_only' => $this->with_options_only === 'true' || $this->with_options_only === true
        ]);
    }

    public function rules(): array
    {
        return [
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date'],
            'quest_ids' => ['nullable', 'array'],
            'order_id' => ['nullable', 'exists:orders,id'],
            'source_ids' => ['nullable', 'array'],
            'statuses' => ['nullable', 'array'],
            'promo_code_ids' => ['nullable', 'array'],
            'order_by' => ['nullable', 'string', 'regex:/^([a-z]+_[a-z]+)*$/'],
            'with_options_only' => ['nullable', 'bool'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
