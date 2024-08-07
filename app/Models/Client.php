<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'codigo',
    ];

    /**
     * Get the users associated with the client.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'client_id');
    }

    /**
     * Get the evaluations associated with the client.
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'client_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
