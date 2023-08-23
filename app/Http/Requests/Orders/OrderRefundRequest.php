<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class OrderRefundRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sum' => ['required', 'numeric']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
