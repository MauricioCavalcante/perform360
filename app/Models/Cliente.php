<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',  // Atributo para armazenar o nome do cliente
        'projeto', // Atributo para armazenar o projeto (caso aplicável)
    ];

    // Relacionamento: um cliente pode ter várias avaliações
    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'id_cliente');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_cliente', 'cliente_id', 'user_id');
    }
    
}
