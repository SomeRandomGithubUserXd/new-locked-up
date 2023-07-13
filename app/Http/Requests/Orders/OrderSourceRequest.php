<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class OrderSourceRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'is_aggregator' => define_as_bool($this->is_aggregator),
        ]);
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'is_aggregator' => ['required', 'bool'],
            'color' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
