<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'company_id',
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

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
