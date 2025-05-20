<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ALaCarteService extends Model
{
    protected $table = 'a_la_carte_services';

    protected $fillable = [
        'name',
        'description',
        'is_variable',
        'price',
    ];

    public $timestamps = true;
}
