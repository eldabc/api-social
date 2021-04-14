<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResaleData extends Model
{
    use HasFactory;
    protected $fillable = [
        'stock', 'shipping_value', 'delivery_time', 'status', 'unitary_price', 'product_id', 'user_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
