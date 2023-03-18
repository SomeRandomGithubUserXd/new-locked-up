<?php

namespace App\Http\Requests;

use App\Models\Appeal;
use Illuminate\Foundation\Http\FormRequest;

class AppealRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
            'source' => ['nullable', 'string'],
            'form' => ['nullable', 'string'],
            'comment' => ['nullable', 'string'],
        ];
    }

    public function getUnRefactoredValidatedData()
    {
        // TODO: Refactor when DB will be restructured
        $data = $this->validated();
        $data['status'] = array_search($data['status'], Appeal::$statuses, true);
        $data['source_id'] = array_search($data['source'], Appeal::$sources, true);
        $data['form_id'] = array_search($data['form'], Appeal::$forms, true);
        $data['text'] = $data['comment'];
        unset($data['source'], $data['form']);
        return $data;
    }

    public function authorize(): bool
    {
        return true;
    }
}
