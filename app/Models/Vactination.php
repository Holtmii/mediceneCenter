<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vactination extends Model
{
    use HasFactory;
    protected $fillable = ['dose', 'date', 'user_id', 'student_id', 'vaccine_id'];
}
