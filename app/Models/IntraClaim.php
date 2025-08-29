<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntraClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'intra_user_id',
        'user_id',
        'departure_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function intraUser()
    {
        return $this->belongsTo(User::class, 'intra_user_id');
    }

    public function departure()
    {
        return $this->belongsTo(Departure::class, 'departure_id');
    }
}
