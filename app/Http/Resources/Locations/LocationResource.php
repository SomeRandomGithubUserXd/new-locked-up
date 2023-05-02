<?php

namespace App\Http\Resources\Locations;

use App\Models\Locations\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Locations\Location */
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
            'show_at_kids_page' => (bool) $location->show_on_child,
            'show_at_corporate_parties_page' => (bool) $location->show_on_corporate,
            'lounges' => LocationLoungeResource::collection($location->locationLounges),
        ];
    }
}
