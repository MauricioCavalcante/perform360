<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'question',
        'score',
        'client_id', 
        'version',
    ];

    // Adiciona o suporte a soft deletes
    protected $dates = ['deleted_at'];

    protected $casts = [
        'client_id' => 'array',
    ];

    /**
     * Get the client that owns the question.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Get the versions for the question.
     */
    public function versions()
    {
        return $this->hasMany(QuestionVersion::class);
    }
}
