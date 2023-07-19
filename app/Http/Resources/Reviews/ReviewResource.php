<?php

namespace App\Http\Resources\Reviews;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Review */
class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'rate' => $this->rate,
            'review' => $this->review,
            'quest' => $this->quest->name_ru,
            'is_approved' => $this->is_approved ? 'Да' : 'Нет',
        ];
    }

    public static function singleItem(Review $review): array
    {
        return [
            'id' => $review->id,
            'review_date' => $review->review_date?->format('Y-m-d'),
            'name' => $review->name,
            'rate' => $review->rate,
            'review' => $review->review,
            'quest_id' => $review->quest->id,
            'is_approved' => $review->is_approved,
            'language' => $review->language
        ];
    }
}
