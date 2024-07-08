<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Define a relação de um para muitos (um cliente pode ter muitos questionários)
    public function questionarios()
    {
        return $this->hasMany(Questionario::class, 'clientes_id', 'id');
    }
}
