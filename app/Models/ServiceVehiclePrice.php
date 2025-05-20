<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceVehiclePrice extends Model
{
    protected $fillable = ['service_id', 'vehicle_type_id', 'price'];

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}