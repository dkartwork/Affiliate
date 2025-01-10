<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'iduser',
        'idproduct',
        'price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'id');
    }
}
