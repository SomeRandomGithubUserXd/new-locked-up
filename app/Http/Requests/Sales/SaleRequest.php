<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'weekdays_only' => define_as_bool($this->weekdays_only),
            'for_aggregators' => define_as_bool($this->for_aggregators),
            'for_certificates' => define_as_bool($this->for_certificates),
        ]);
    }

    public function rules(): array
    {
        return [
            'promo_code' => ['required', 'string'],
            'value' => ['nullable'],
            'type' => ['nullable', 'integer'],
            'create_date' => ['nullable', 'date'],
            'best_before' => ['nullable', 'date'],
            'activation_date' => ['nullable', 'date'],
            'weekdays_only' => ['required', 'bool'],
            'for_aggregators' => ['required', 'bool'],
            'for_certificates' => ['required', 'bool'],
            'quest_ids' => ['nullable', 'array'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
