<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchants extends Model
{
    use HasFactory;

    protected $table = 'merchants';
    protected $fillable = [
        'nama',
        'deskripsi',
        'image',
        'latitude',
        'longitude',
    ];
}
