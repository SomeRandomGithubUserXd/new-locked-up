<?php

namespace App\Http\Requests\Schedules;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string'],
            'schedule_items' => ['nullable']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
