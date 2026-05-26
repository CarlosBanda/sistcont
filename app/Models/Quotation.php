<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Folio;

class Quotation extends Model
{
    use HasFactory;
    protected $table = 'quotations';
    protected $fillable = [
        'company_id',
        'client_id',
        'contact_name',
        'quotation_date',
        'folio_id',
        'currency'
    ];

    public function client(){
        return $this->belongsTo(Cliente::class);
    }

    public function folio(){
        return $this->belongsTo(Folio::class);
    }
}
