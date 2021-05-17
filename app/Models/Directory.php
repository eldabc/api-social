<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directory extends Model
{
    use HasFactory;
    protected $table = "directories";

    protected $fillable = [
        'name', 'address', 'description', 'img', 'user_id'
    ];
}
