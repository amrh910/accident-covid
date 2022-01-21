<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pref extends Model
{
    use HasFactory;
    protected $table = 'preferences';
    protected $guarded = ['id'];
}
