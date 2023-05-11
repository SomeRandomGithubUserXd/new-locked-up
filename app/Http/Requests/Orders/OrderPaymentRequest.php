<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class OrderPaymentRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'sum' => ['required', 'numeric', 'min:0.1'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
