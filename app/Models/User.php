<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Mood;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'birthdate',
        'profile_picture', // Menambahkan kolom baru untuk foto profil
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function moods()
{
    return $this->hasMany(Mood::class);
}

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

        public function todos()
    {
        return $this->hasMany(Todo::class);
    }


    /**
     * Mendapatkan URL untuk gambar profil
     */
    public function getProfilePictureAttribute($value)
    {
        return asset('storage/' . $value); // Menghasilkan URL lengkap ke gambar yang disimpan di storage
    }
}

