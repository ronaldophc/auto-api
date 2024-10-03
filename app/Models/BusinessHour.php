<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessHour extends Model
{
    use HasFactory;

    protected $fillable = ['store_id', 'hours'];

    protected $casts = [
        'hours' => 'array', // Cast para a coluna JSON
    ];
}
