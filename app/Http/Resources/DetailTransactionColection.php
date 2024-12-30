<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailTransactionColection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_transaction' => $this->id,
            'note' => $this->note,
            'menu' => [
                'id' => $this->menu_id,
                'sku' => $this->sku,
                'nama' => $this->nama,
                'harga' => $this->harga,
                'image_url' => url('KlajekApi/public/images/menus/' . $this->merchant_id . '/' . $this->image),
                'kategori' => $this->kategori,
            ]
        ];
    }
}
