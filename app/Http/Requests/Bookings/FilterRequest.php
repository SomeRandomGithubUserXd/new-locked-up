<?php

namespace App\Http\Requests\Bookings;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['nullable', 'date']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
