<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    protected $table = 'customers';

    public $timestamps = false; // Desactiva updated_at y created_at automáticos

    protected $fillable = ['name', 'phone_number', 'email', 'address', 'created_at'];
}