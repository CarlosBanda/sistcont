<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'client_id',
        'user_id',
        'folio_id',
        'sale_date',
        'currency',
        'subtotal',
        'discount',
        'tax',
        'total',
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function client()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function folio()
    {
        return $this->belongsTo(Folio::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
