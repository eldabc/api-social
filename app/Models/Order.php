<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'city', 'delivery_address', 'name', 'phone', 'email', 'total_sale', 'status_id', 'user_id'
    ];

    public function StatusOrder()
    {
        return $this->belongsTo(StatusOrder::class);
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetails::class);
    }
}
