<?php

namespace App\Http\Resources\Route;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouteResource extends JsonResource
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
            'description' => $this->description,
            'height_start' => $this->height_start,
            'height_end' => $this->height_end,
            'galeries' => $this->galeries->map(function ($galery) {
                return [
                    'id' => $galery->id,
                    'image' => env('APP_URL') . '/storage/' . $galery->image,
                ];
            })
        ];
    }
}