<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; 

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'skills',
        'is_admin',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'skills' => 'array',
        'is_admin' => 'boolean',
    ];

    

    
    public function cvs()
    {
        return $this->hasMany(UserCV::class);
    }

    /**
     * Get all candidatures for the user.
     */
    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }

    /**
     * Get all job offers that the user has applied to.
     */
    public function offres()
    {
        return $this->belongsToMany(Offre::class, 'candidatures'); 
    }
}