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
        'city', 'delivery_address', 'name', 'phone', 'email', 'total_order', 'status_id', 'user_id', 'distr_id'
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

    public static function getTotalByUser($user_id)
    {
        return Total::where('user_id', $user_id)->first();
    }

    public static function updateOrCreateTotalByUser($user_id, $total_to_update, $old_total, $total_order)
    {
        return Total::updateOrCreate(
            [ 'user_id' => $user_id ],
            [ $total_to_update =>  $old_total + $total_order ]
        );
    }

    public static function totalDistr($distr_id, $total_order)
    {
        $distr = Order::getTotalByUser($distr_id);
        Order::updateOrCreateTotalByUser($distr->user_id, $total_to_update = 'total_sales', $distr->total_sales, $total_order);
    }

    // public function getTotalOrderAttribute()
    // {
    //    return $this->order_details()->reduce(function ($price, $item) {
    //        return $price + ($item->quantity * $item->price);
    //    }, 0);
    // }

}
