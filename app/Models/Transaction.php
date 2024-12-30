<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $fillable = [
        'customer_id',
        'merchant_id',
        'total',
        'ongkir',
        'fee',
        'details'
    ];

    public function details(): HasMany
    {
        return $this->hasMany(DetailTransaction::class, 'transaction_id', 'id');
    }
}
