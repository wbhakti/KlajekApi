<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionColection extends JsonResource
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
            'total' => $this->total,
            'ongkir' => $this->ongkir,
            'fee' => $this->fee,
            'customer' => [
                'id' => $this->customer_id,
                'full_name' => $this->full_name,
                'phone_number' => $this->phone_number,
                'address' => $this->address
            ],
            'merchant' => [
                'id' => $this->merchant_id,
                'name' => $this->merchant_name
            ]
        ];
    }
}
