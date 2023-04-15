<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\CityResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'district_id'=>$this->id,
            'district_name'=>$this->name,
            'city'=> new CityResource($this->city),
        ];
    }
}
