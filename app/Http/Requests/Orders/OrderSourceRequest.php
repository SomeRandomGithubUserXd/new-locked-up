<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class OrderSourceRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'aggregator' => define_as_bool($this->aggregator),
        ]);
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'aggregator' => ['required', 'bool'],
            'color' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
