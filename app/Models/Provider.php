<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $table = 'providers';

    protected $fillable = [
        'company_id',
        'name_comercial',
        'rfc',
        'razon_social',
        'status',
        'cp',
        'ciudad',
        'num_ext',
        'municipio',
        'colonia',
        'address',
        'pais'
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
}
