<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
//variables we are going to pass the data to JSON File
    protected $fillable = [
        "name",
        "amount",
    ];
}
