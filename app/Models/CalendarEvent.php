<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start',
        'end',
        'vehicle_info',
        'repair_type',
        'workers',
        'status',
        'description',
        'is_delayed'
    ];

    protected $casts = [
        'start' => 'date:Y-m-d',
        'end' => 'date:Y-m-d',
        'workers' => 'array',
        'is_delayed' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
