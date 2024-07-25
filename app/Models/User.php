<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'client_id', 'group_id', 'username', 'score'
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'client_id' => 'array',
    ];

    /**
     * Find a user by their email or username.
     */
    public function findForUsername($username)
    {
        return $this->where('email', $username)
                    ->orWhere('username', $username)
                    ->first();
    }

    /**
     * Get the evaluations for the user.
     */
    public function evaluation()
    {
        return $this->hasMany(Evaluation::class, 'user_id');
    }

    /**
     * Get the client associated with the user.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Get the group associated with the user.
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
