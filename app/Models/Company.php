<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Company extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function owner(){
        return $this->belongsTo(User::class, 'user_id');
    }
    protected $fillable = [
        'name',
        'razon_social',
        'phone',
        'email',
        'address',
        'user_id',
    ];
}
