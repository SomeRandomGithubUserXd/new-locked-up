<?php

namespace App\Http\Requests\Orders;

use App\Models\Sale;
use Carbon\Carbon;
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
            'time' => ['nullable', 'string'],
            'customer_name' => ['required', 'string'],
            'customer_email' => ['required', 'email'],
            'customer_phone' => ['required', 'string'],
            'source' => ['required', 'exists:order_sources,id'],
            'option' => ['required', 'string'],
            'promo_code_id' => ['nullable', 'int', 'exists:sales,id'],
            'certificate_id' => ['nullable', 'int', 'exists:certificates_data,id'],
            'comment' => ['nullable', 'string'],
            'players_count' => ['nullable', 'int'],
            'options' => ['nullable', 'array'],
            'fact_payment' => ['nullable', 'int'],
            'pre_payed' => ['nullable', 'int'],
            'online_payment' => ['nullable', 'int'],
            'payed_aggregator' => ['nullable', 'int'],
            'price_total' => ['required', 'int'],
            'fact_payment_type' => ['nullable', 'int'],
            'pre_payed_type' => ['nullable', 'int'],
            'status' => ['required', 'int'],
            'additional_players' => ['nullable', 'int'],
            'schedule_item_id' => ['nullable', 'int', 'exists:shedule_item,id'],
        ];
    }

    public function getUnRefactoredValidatedData()
    {
        // TODO: Refactor when DB will be restructured
        $data = $this->validated();
        $data['date'] .= ' ' . $data['time'];
        $data['promo'] = $this->promo_code['promocode'] ?? null;
        $data['certificate_data_id'] = $data['certificate_id'] ?? null;
        $data['prepayed'] = $data['pre_payed'] ?? null;
        $data['package'] = $data['option'] ?? null;
        $data['payed_online'] = $data['online_payment'] ?? null;
        $data['countPlayers'] = $data['players_count'] ?? null;
        $data['prepayed_type'] = $data['pre_payed_type'];
        unset($data['promo_code_id'], $data['players_count'], $data['pre_payed'], $data['certificate_id'], $data['pre_payed_type']);
        return $data;
    }

    public function authorize(): bool
    {
        return true;
    }
}
