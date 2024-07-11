<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'ramal',
        'score',
        'grupo_id',
        'cliente_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function findForUsername($username)
    {
        return $this->where('email', $username)
                    ->orWhere('username', $username)
                    ->first();
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'id_user');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'user_cliente', 'user_id', 'cliente_id');
    }
    
}
