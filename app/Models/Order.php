<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    // protected $with = [
    //     'total_order'
    // ];

    protected $fillable = [
        'city', 'delivery_address', 'name', 'phone', 'email', 'total_order', 'status_id', 'user_id'
    ];

    public function status_order()
    {
        return $this->belongsTo(StatusOrder::class, 'status_id');
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the score associated with the user.
     */
    public function score()
    {
        return $this->hasOne(Score::class);
    }

    // public function getTotalOrderAttribute()
    // {
    //    return $this->order_details()->reduce(function ($price, $item) {
    //        return $price + ($item->quantity * $item->price);
    //    }, 0);
    // }

}
