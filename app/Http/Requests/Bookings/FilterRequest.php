<?php

namespace App\Http\Requests\Bookings;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['nullable', 'date'],
            'location_id' => ['nullable', 'exists:locations,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
