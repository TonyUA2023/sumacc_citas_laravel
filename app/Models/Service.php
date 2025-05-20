<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'description', 'recommended_frequency', 'tagline',
        'base_duration_minutes', 'category_id', 'starting_price',
        'price_label', 'exterior_description', 'interior_description'
    ];

    public function serviceVehiclePrices()
    {
        return $this->hasMany(ServiceVehiclePrice::class, 'service_id');
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

}