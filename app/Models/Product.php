<?php

namespace App\Models;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'presentation', 'stock', 'img', 'status'
    ];

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function resaleData()
    {
        return $this->hasMany(ResaleData::class);
    }
}
