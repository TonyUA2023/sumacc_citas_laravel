<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentExtra extends Model
{
    protected $fillable = ['appointment_id', 'a_la_carte_service_id', 'quantity'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function aLaCarteService()
    {
        return $this->belongsTo(ALaCarteService::class, 'a_la_carte_service_id');
    }
}