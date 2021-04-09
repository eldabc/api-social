<?php

namespace App\Models;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'presentation', 'stock', 'img', 'status', 'shipping_value', 'delivery_time'
    ];

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
}
