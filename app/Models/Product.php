<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'modelo',
        'nombre',
        'unidad_medida_id',
        'user_id'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}