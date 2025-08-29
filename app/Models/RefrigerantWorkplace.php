<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefrigerantWorkplace extends Model
{
    use HasFactory;

    protected $fillable = [
        'business',
        'residence',
        'vehicle_registration_number',
        'serial_number',
        'machine_type',
        'gas_type',
        'initial_fill_amount',
        'is_selected',
    ];

    protected $casts = [
        'initial_fill_amount' => 'decimal:2',
        'is_selected' => 'boolean',
    ];
}
