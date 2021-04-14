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

    public function distribuitor()
    {
        return $this->belongsTo(User::class, 'distr_id')->withDefault([
            'id' => null,
            'name' => null,
            'phone' => null,
            'email' => null,
            'email_verified_at' => null,
            'delivery_address' => null,
            'city' => null,
            'total_transactions' => null,
            'created_at' => null,
            'updated_at' => null,
        ]);
    }
}
