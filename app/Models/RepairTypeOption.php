<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairTypeOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get all repair type options ordered by order field
     */
    public static function getOrderedOptions(): array
    {
        return self::orderBy('order')->orderBy('name')->pluck('name')->toArray();
    }
}

