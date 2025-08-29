<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WindNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'date',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function noteFavorites()
    {
        return $this->hasMany(NoteFavorite::class, 'note_id');
    }
}
