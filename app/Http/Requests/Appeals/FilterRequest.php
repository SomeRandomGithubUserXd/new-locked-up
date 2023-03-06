<?php

namespace App\Http\Requests\Appeals;

use App\Models\Appeal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'source' => ['nullable', Rule::in(Appeal::$sources)]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
