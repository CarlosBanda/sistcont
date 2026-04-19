<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $table = 'quotations';
    protected $fillable = [
        'serie',
        'user_id',
        'client_id',
        'contact_name',
        'folio',
        'quotation_date',
        'currency'
    ];
}
