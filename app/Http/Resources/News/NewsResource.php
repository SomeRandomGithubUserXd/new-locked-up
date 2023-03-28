<?php

namespace App\Http\Resources\News;

use App\Models\News\News;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\News\News */
class NewsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'header' => $this->h1_ru,
            'alias' => $this->alias,
            'is_published' => $this->published ? 'Да' : 'Нет',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public static function singleItem(News $news): array
    {
        return [
            'id' => $news->id,
            'header' => $news->h1_ru,
            'alias' => $news->alias,
            'is_published' => $news->published ? 'Да' : 'Нет',
            'created_at' => $news->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
