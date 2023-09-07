<?php

namespace App\Http\Requests\Bookings;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['nullable', 'date'],
            'ids' => ['nullable', 'array'],
            'quest_id' => ['nullable', 'int']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
