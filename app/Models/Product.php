<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'price', 'description', 'phone', 'phone_ws', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assets()
    {
        //esta será la relación a los assets
        // return $this->hasMany(Asset::class); 
    }
}
