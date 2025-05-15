<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    use HasFactory;

     protected $fillable = ['mood_id', 'entry'];

    // Relasi dengan Mood
    public function mood()
    {
        return $this->belongsTo(Mood::class);
    }
}
