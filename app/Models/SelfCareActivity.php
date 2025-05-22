<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfCareActivity extends Model
{
    use HasFactory;
    
    protected $table = 'selfcare_activities';
    protected $fillable = [
        'user_id', 'name', 'description', 'is_checked', 'is_custom', 'date'
    ];

    protected $casts = [
        'is_checked' => 'boolean',
        'is_custom' => 'boolean',
        'date' => 'date',
    ];
}