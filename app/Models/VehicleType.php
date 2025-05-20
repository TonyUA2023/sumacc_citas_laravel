<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $fillable = ['name', 'icon'];

    public function serviceVehiclePrices()
    {
        return $this->hasMany(ServiceVehiclePrice::class);
    }
}