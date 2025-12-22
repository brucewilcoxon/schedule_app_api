<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start',
        'end',
        'vehicle_info',
        'repair_type',
        'work_type',
        'workers',
        'status',
        'description',
        'is_delayed',
        'images',
    ];

    protected $casts = [
        'start' => 'date:Y-m-d',
        'end' => 'date:Y-m-d',
        'is_delayed' => 'boolean',
        'images' => 'array',
    ];

    /**
     * Get the repair_type attribute with proper JSON encoding for Japanese characters.
     */
    public function getRepairTypeAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true);
        }

        return $value;
    }

    /**
     * Set the repair_type attribute with proper JSON encoding for Japanese characters.
     */
    public function setRepairTypeAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['repair_type'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        } else {
            $this->attributes['repair_type'] = $value;
        }
    }

    /**
     * Get the workers attribute with proper JSON decoding for Japanese characters.
     */
    public function getWorkersAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true);
        }

        return $value;
    }

    /**
     * Set the workers attribute with proper JSON encoding for Japanese characters.
     */
    public function setWorkersAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['workers'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        } else {
            $this->attributes['workers'] = $value;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
