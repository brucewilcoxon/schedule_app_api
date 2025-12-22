<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gas extends Model
{
    use HasFactory;

    protected $table = 'gas';

    protected $fillable = [
        'gas_type',
        'quantity',
        'date',
        'prefecture',
        'process',
    ];

    protected $casts = [
        'date' => 'date',
        'quantity' => 'decimal:2',
    ];

    /**
     * Get the process label in Japanese
     */
    public function getProcessLabelAttribute(): string
    {
        return match ($this->process) {
            'recovery' => '回収',
            'filling' => '充填',
            'refilling' => '再充填',
            'recovery_refilling' => '回収/再充填',
            'recovery_disposal' => '回収/廃棄',
            'recovery_impossible' => '回収不可',
            default => $this->process,
        };
    }

    /**
     * Scope for filtering by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        if ($startDate) {
            $query->where('date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('date', '<=', $endDate);
        }

        return $query;
    }

    /**
     * Scope for filtering by gas type
     */
    public function scopeGasType($query, $gasType)
    {
        if ($gasType && $gasType !== 'all') {
            $query->where('gas_type', $gasType);
        }

        return $query;
    }

    /**
     * Scope for filtering by prefecture
     */
    public function scopePrefecture($query, $prefecture)
    {
        if ($prefecture && $prefecture !== 'all') {
            $query->where('prefecture', $prefecture);
        }

        return $query;
    }

    /**
     * Scope for filtering by process
     */
    public function scopeProcess($query, $process)
    {
        if ($process && $process !== 'all') {
            $query->where('process', $process);
        }

        return $query;
    }
}
