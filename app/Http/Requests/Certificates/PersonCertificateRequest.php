<?php

namespace App\Http\Requests\Certificates;

use Illuminate\Foundation\Http\FormRequest;

class PersonCertificateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string'],
            'customer_phone' => ['required', 'string'],
            'customer_email' => ['required', 'email'],
            'certificate_id' => ['required', 'int', 'exists:certificates,id'],
            'customer_address' => ['required', 'string'],
            'price' => ['required', 'int'],
            'delivery_cost' => ['required', 'int'],
            'paid_cash' => ['required', 'int'],
            'paid_card' => ['required', 'int'],
            'paid_online' => ['required', 'int'],
            'expires_at' => ['nullable', 'date'],
            'payment_link' => ['nullable', 'string'],
            'status' => ['required', 'int'],
            'comment' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
