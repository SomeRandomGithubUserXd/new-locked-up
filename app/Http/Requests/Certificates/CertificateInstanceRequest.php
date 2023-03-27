<?php

namespace App\Http\Requests\Certificates;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CertificateInstanceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'number' => ['required', $this->getRuleUnique()],
            'price' => ['nullable', 'integer'],
            'status' => ['nullable', 'integer'],
        ];
    }

    public function getRuleUnique()
    {
        $rule = Rule::unique('certificates_data');
        if ($id = $this->route()->parameter('certificate_instance')?->id) {
            $rule->whereNot('id', $id);
        }
        return $rule;
    }

    public function authorize(): bool
    {
        return true;
    }
}
