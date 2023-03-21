<?php

namespace App\Http\Resources;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Location */
class LocationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'email' => $this->email,
            'name_ru' => $this->name_ru,
            'address_ru' => $this->address_ru,
        ];
    }

    public static function singleItem(Location $location)
    {
        return [
            'id' => $location->id,
            'phone' => $location->phone,
            'email' => $location->email,
            'maps' => $location->maps,
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
            'additional_email' => $location->additional_email,
            'isDeleted' => $location->isDeleted,
            'name_ru' => $location->name_ru,
            'name_en' => $location->name_en,
            'address_ru' => $location->address_ru,
            'address_en' => $location->address_en,
            'show_on_child' => $location->show_on_child,
            'show_on_corporate' => $location->show_on_corporate,
        ];
    }
}
