<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Store extends Model
{
    use HasFactory, Notifiable;

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'logo',
        'address',
        'phone',
        'whatsapp',
        'instagram',
        'tiktok',
        'facebook',
        'google_maps',
        'email',
        'hours',
    ];
}
