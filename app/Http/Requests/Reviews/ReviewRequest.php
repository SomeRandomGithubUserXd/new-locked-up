<?php

namespace App\Http\Requests\Reviews;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'approved' => define_as_bool($this->approved),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable'],
            'review_date' => ['nullable', 'date'],
            'rate' => ['required', 'integer'],
            'review' => ['required'],
            'quest_id' => ['nullable'],
            'phone' => ['nullable'],
            'email' => ['nullable', 'email', 'max:254'],
            'approved' => ['nullable', 'bool'],
            'language' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
