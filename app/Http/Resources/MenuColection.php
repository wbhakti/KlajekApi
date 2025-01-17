<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;

class MenuColection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $mimage = 'images/menus/' . $this->image;

        if(!File::exists(public_path($mimage))){
            $mimage = 'KlajekApi/public/images/default-img.jpeg';
        } else {
            $mimage = 'KlajekApi/public/images/menus/' . $this->image;
        }

        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'nama' => $this->nama,
            'harga' => $this->harga,
            'image_url' => url($mimage),
            'kategori' => [
                'id' => $this->id_kategori,
                'kategori' => $this->kategori
            ],
        ];
    }
}
