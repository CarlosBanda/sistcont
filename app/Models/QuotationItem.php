<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;


class QuotationItem extends Model
{
    use HasFactory;
    protected $table = 'quotation_items';
    protected $fillable = [
        'quotation_id',
        'product_id',
        'barcode',
        'qty',
        'price',
        'discount',
        'tax',
        'total'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}

