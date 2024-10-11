<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vehicle extends Model
{
    use HasFactory, Notifiable;

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'manufacturer',
        'manufacture_year',
        'model',
        'model_year',
        'fuel_type',
        'steering_type',
        'transmission',
        'doors',
        'license_plate',
        'color',
        'price',
        'description',
        'current_km',
        'is_new',
        'is_featured',
        'renavam',
        'store_id',
    ];

    protected $casts = [
        'is_new' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function coverPhoto()
    {
        return $this->hasOne(VehicleImage::class);
    }
}
