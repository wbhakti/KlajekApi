<?php

namespace App\Models;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menus extends Model
{
    use HasFactory;

    protected $table = 'menus';
    protected $fillable = [
        'sku',
        'nama',
        'harga',
        'image',
        'kategori',
        'merchant_id',
    ];
}
