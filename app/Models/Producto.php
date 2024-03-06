<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    public $guarded = [];
}
