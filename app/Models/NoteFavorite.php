<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteFavorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'note_id',
        'user_id'
    ];

    public function note()
    {
        return $this->belongsTo(WindNote::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
