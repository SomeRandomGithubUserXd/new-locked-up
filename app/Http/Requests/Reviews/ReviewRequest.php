<?php

namespace App\Http\Requests\Reviews;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'is_approved' => define_as_bool($this->is_approved),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'review_date' => ['nullable', 'date'],
            'rate' => ['required', 'integer'],
            'review' => ['required'],
            'quest_id' => ['required'],
            'phone' => ['nullable'],
            'email' => ['nullable', 'email', 'max:254'],
            'is_approved' => ['nullable', 'bool'],
            'language' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
