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
            'certificate_instance_id' => ['required', 'int', 'exists:certificates,id'],
            'address' => ['required', 'string'],
            'price' => ['required', 'int'],
            'delivery_price' => ['required', 'int'],
            'payed_cash' => ['required', 'int'],
            'payed_card' => ['required', 'int'],
            'payed_online' => ['required', 'int'],
            'expires_at' => ['nullable', 'date'],
            'payment_link' => ['nullable', 'string'],
            'status' => ['nullable', 'int'],
            'comment' => ['nullable', 'string'],
        ];
    }

    public function getUnRefactoredValidatedData()
    {
        // TODO: Refactor when DB will be restructured
        $data = $this->validated();
        $data['number'] = $data['certificate_instance_id'];
        $data['expired'] = $data['expires_at'];
        unset($data['certificate_instance_id'], $data['expires_at']);
        return $data;
    }

    public function authorize(): bool
    {
        return true;
    }
}
