<?php

namespace App\Http\Requests\Certificates;

use Illuminate\Foundation\Http\FormRequest;

class CertificateUploadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => ['required', 'file']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
