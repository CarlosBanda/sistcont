<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clients';

    protected $fillable = [
        'company_id',
        'name',
        'rfc',
        'email',
        'phone',
        'tax_regime',
        'cfdi_use',
        'zip_code',
        'address',
        'number_ext',
        'number_int',
        'colony',
        'city',
        'state',
        'country',
    ];
}
