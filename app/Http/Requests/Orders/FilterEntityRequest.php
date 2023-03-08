<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterEntityRequest extends FilterRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                $this->getRuleUnique()
            ],
            ...parent::rules()
        ];
    }

    public function getRuleUnique()
    {
        $rule = Rule::unique('order_filters');
        if ($id = $this->route()->parameter('order_filter')?->id) {
            $rule->whereNot('id', $id);
        }
    }

    public function authorize(): bool
    {
        return true;
    }
}
