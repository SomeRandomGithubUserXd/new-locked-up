<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class ActionWithManyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ids' => ['required', 'array']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
