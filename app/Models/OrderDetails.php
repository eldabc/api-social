<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'price', 'quantity', 'plan_id', 'order_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // public function getTotalPurchases()
    // {
    //    return $this->order_details()->reduce(function ($price, $item) {
    //        return $price + ($item->quantity * $item->price);
    //    }, 0);
    // }
}
