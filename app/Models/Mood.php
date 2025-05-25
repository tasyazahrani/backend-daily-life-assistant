<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mood extends Model
{
    protected $fillable = ['user_id', 'mood', 'emoji', 'diary_text'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}