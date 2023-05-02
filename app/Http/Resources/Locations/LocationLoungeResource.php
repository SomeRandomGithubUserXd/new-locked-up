<?php

namespace App\Http\Resources\Locations;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Locations\LocationLounge */
class LocationLoungeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name_ru' => $this->name_ru,
            'name_en' => $this->name_en,
            'description_ru' => $this->description_ru,
            'description_en' => $this->description_en,
            'gallery_id' => $this->gallery_id,

            'location_id' => $this->location_id,

            'location' => new LocationResource($this->whenLoaded('location')),
        ];
    }
}
