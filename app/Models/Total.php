<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Total extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_purchases', 'total_sales', 'user_id'
    ];

    /**
     * Get the user that owns the totals.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
