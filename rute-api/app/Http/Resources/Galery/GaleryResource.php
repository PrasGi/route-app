<?php

namespace App\Http\Resources\Galery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GaleryResource extends JsonResource
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
            'route_id' => $this->route_id,
            'image' => env('APP_URL') . '/storage/' . $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
