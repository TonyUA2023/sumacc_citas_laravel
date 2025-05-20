<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'customer_id', 'appointment_date', 'status', 'total_price',
        'service_vehicle_price_id', 'admin_user_id'
    ];

    protected $dates = ['appointment_date'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class);
    }

    public function serviceVehiclePrice()
    {
        return $this->belongsTo(ServiceVehiclePrice::class);
    }

    public function appointmentExtras()
    {
        return $this->hasMany(AppointmentExtra::class);
    }
}