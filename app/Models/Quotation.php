<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Folio;
use App\Models\QuotationItem;

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
        'currency',
        'subtotal',
        'discount',
        'tax',
        'total'
    ];

    public function client(){
        return $this->belongsTo(Cliente::class);
    }

    public function folio(){
        return $this->belongsTo(Folio::class);
    }

    public function items(){
        return $this->hasMany(QuotationItem::class);
    }

    public function user(){
        return $this->belongsTo(User::Class);
    }
}
