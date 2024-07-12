<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;

class Avaliacao extends Model
{
    protected $table = 'avaliacoes';

    protected $fillable = [
        'id_user', 'id_cliente', 'num_chamado', 'usuario', 'audio', 'transcricao', 'modified_at', 'avaliacao', 'feedback'
    ];

    protected $casts = [
        'avaliacao' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
