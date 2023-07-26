<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'time' => $this->time['time'],
            'schedule_item_id' => $this->time['id'],
        ]);
    }

    public function rules(): array
    {
        return [
            'quest_id' => ['required', 'int', 'exists:quests,id'],
            'date' => ['required', 'date'],
            'time' => ['required', 'string'],
            'customer_name' => ['required', 'string'],
            'customer_email' => ['nullable', 'email'],
            'customer_phone' => ['required', 'string'],
            'order_source_id' => ['required', 'exists:order_sources,id'],
            'option' => ['nullable', 'string'],
            'promo_code' => ['nullable', 'exists:sales,promo_code'],
            'certificate_id' => ['nullable', 'int', 'exists:certificates,id'],
            'comment' => ['nullable', 'string'],
            'additional_players_count' => ['nullable', 'int'],
            'options' => ['nullable', 'array'],
            'pre_paid' => ['nullable', 'int'],
            'postpaid' => ['nullable', 'int'],
            'paid_through_acquiring' => ['nullable', 'int'],
            'paid_through_aggregator' => ['nullable', 'int'],
            'price' => ['required', 'int'],
            'additional_players_cost' => ['required', 'int'],
            'additional_options_cost' => ['required', 'int'],
            'price_to_pay' => ['required', 'int'],
            'paid_total' => ['required', 'int'],
            'price_total' => ['required', 'int'],
            'postpaid_type' => ['nullable', 'int'],
            'pre_paid_type' => ['nullable', 'int'],
            'status' => ['required', 'int'],
            'schedule_item_id' => ['nullable', 'int', 'exists:schedule_items,id'],
            'lounge_id' => ['nullable', 'int', 'exists:lounges,id'],
            'lounge_schedule_item_id' => ['nullable', 'int', 'exists:lounge_schedule_items,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
