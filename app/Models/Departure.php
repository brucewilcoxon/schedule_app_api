<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departure extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'intra_user_id',
        'start',
        'end',
        'description',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function intraUser()
    {
        return $this->belongsTo(User::class, 'intra_user_id');
    }

    public function intraClaims()
    {
        return $this->hasMany(User::class, 'intra_claim_id');
    }
}
