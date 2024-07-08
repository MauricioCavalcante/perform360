<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionario extends Model
{
    use HasFactory;

    // Define quais atributos podem ser atribuídos em massa
    protected $fillable = ['pergunta', 'nota', 'clientes_id'];

    // Define a relação de muitos para um (um questionário pertence a um cliente)
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'clientes_id', 'id');
    }
}
