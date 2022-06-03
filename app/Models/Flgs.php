<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flgs extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_at',
        'result',
        'user_id',
        'student_id',
    ];
}
