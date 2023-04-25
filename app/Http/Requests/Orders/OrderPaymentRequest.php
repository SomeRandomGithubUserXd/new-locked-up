<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class OrderPaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sum' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
