<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

class MerchantColection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $mimage = 'images/merchants/' . $this->image;

        if(!File::exists(public_path($mimage))){
            $mimage = 'KlajekApi/public/images/default-img.jpeg';
        } else {
            $mimage = 'KlajekApi/public/images/merchants/' . $this->image;
        }

        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'image_url' => url($mimage),
            'location' => [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude
            ],
        ];
    }
}
