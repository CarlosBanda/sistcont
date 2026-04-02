<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [
        'name',
        'category',
        'code',
        'price',
        'barcode',
        'description',
        'sat_key',
        'sat_unit',
        'stock',
        'user_id'
    ];
}
