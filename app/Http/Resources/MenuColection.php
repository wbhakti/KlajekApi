<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class MenuColection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'nama' => $this->nama,
            'harga' => $this->harga,
            'image_url' => url('KlajekApi/public/images/menus/' . $this->merchant_id . '/' . $this->image),
            'kategori' => [
                'id' => $this->id_kategori,
                'kategori' => $this->kategori
            ],
        ];
    }
}
