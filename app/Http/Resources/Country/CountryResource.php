<?php

namespace App\Http\Resources\Country;

use App\Http\Resources\Zone\ZoneResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'abbreviation' => $this->abbreviation,
            'code' => $this->code,
            'iso' => $this->iso,
            'zone' => new ZoneResource($this->zone),
        ];
    }
}
