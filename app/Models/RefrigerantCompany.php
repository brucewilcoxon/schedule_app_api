<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefrigerantCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'item',
        'process_type',
        'delivery_date',
        'is_selected',
        'owner',
        'manager_id',
        'residence',
    ];

    protected $casts = [
        'delivery_date' => 'date',
        'is_selected' => 'boolean',
    ];

    /**
     * Get the process type options
     */
    public static function getProcessTypeOptions(): array
    {
        return [
            'collection' => '回収',
            'filling' => '充填',
            'collection_filling' => '回収充填',
        ];
    }

    /**
     * Get the process type label
     */
    public function getProcessTypeLabelAttribute(): string
    {
        return self::getProcessTypeOptions()[$this->process_type] ?? $this->process_type;
    }

    /**
     * Get the manager relationship
     */
    public function manager()
    {
        return $this->belongsTo(UserProfile::class, 'manager_id');
    }
} 