<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['task', 'date', 'completed', 'is_completed', 'user_id'];

    // Tambahkan relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
