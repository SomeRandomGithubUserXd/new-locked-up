<?php

namespace App\Http\Resources;

use App\Models\Appeal;
use App\Models\Orders\OrderSource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use SebastianBergmann\CodeCoverage\Report\Xml\Source;

/** @mixin \App\Models\Appeal */
class AppealResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'comment' => $this->text,
            'status' => $this->status,
            'created_at' => $this->created_at->format('d.m.Y H:i:s'),
            'updated_at' => $this->updated_at,
            'location_id' => $this->location_id,
            'sourceUrl' => $this->source_url,
            'captcha_score' => $this->captcha_score,
            'source' => $this->source_id,
            'form' => $this->form_id,
            'admin_comment' => $this->admin_comment,
            'entity_id' => $this->entity_id,
            'hints' => [
                'backgroundColor' => 'rgba(246, 246, 246, 1)',
                'color' => 'rgba(0, 0, 0, 1)',
                'items' => [
                    [
                        'name' => 'ID',
                        'value' => $this->id
                    ],
                    [
                        'name' => 'Страница',
                        'value' => $this->source_url
                    ],
                    [
                        'name' => 'Баллы капчи',
                        'value' => '???'
                    ],
                    [
                        'name' => 'Комментарий от админа',
                        'value' => $this->admin_comment
                    ],
                ]
            ]
        ];
    }

    public static function singleItem(Appeal $appeal): array
    {
        return [
            'id' => $appeal->id,
            'name' => $appeal->name,
            'phone' => $appeal->phone,
            'email' => $appeal->email,
            'status' => $appeal->status,
            'source' => $appeal->source_id,
            'form' => $appeal->form_id,
            'comment' => $appeal->text,
        ];
    }
}
