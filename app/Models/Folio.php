<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folio extends Model
{
    use HasFactory;
    protected $fillable = [
        'folio',
        'folio_type',
        'user_id',
        'company_id'
    ];
}
