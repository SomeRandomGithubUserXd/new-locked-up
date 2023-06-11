<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'weekdays_only' => define_as_bool($this->weekdays_only),
            'for_aggregators' => define_as_bool($this->for_aggregators),
            'for_certificate' => define_as_bool($this->for_certificate),
        ]);
    }

    public function rules(): array
    {
        return [
            'promo_code' => ['required', 'string'],
            'value' => ['nullable'],
            'type' => ['nullable', 'integer'],
            'create_date' => ['nullable', 'date'],
            'best_before' => ['nullable', 'date'],
            'start_date' => ['nullable', 'date'],
            'weekdays_only' => ['required', 'bool'],
            'for_aggregators' => ['required', 'bool'],
            'for_certificate' => ['required', 'bool'],
            'quest_ids' => ['nullable', 'array'],
        ];
    }

    public function getUnRefactoredValidatedData()
    {
        // TODO: Refactor when DB will be restructured
        $data = $this->validated();
        $data['promocode'] = $data['promo_code'];
        $data['weekday_only'] = $data['weekdays_only'];
        unset($data['promo_code']);
        return $data;
    }

    public function authorize(): bool
    {
        return true;
    }
}
