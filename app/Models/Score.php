<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment', 'score', 'user_id'
    ];

      /**
     * Get the user that owns the score.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
