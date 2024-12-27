<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantColection extends JsonResource
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
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'image_url' => url('KlajekApi/public/images/merchants/' . $this->image),
            'location' => [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude
            ],
        ];
    }
}
