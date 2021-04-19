<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'price', 'quantity', 'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetails::class);
    }

}
