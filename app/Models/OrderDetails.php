<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'price', 'quantity', 'plan_id', 'order_id', 'distr_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
