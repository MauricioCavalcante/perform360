<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'protocol',
        'username',
        'audio',
        'referent',
        'transcription',
        'modified_at',
        'score',
        'feedback',
    ];

    /**
     * Get the user that owns the evaluation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the client that owns the evaluation.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the question versions associated with the evaluation.
     */
    public function questionVersions()
    {
        return $this->belongsToMany(QuestionVersion::class, 'evaluation_question_versions');
    }

    /**
     * Get the notifications for the evaluation.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'evaluation_id')->onDelete('cascade');
    }

        /**
     * Get the URL of the audio file.
     */
    public function getAudioUrlAttribute()
    {
        return asset('storage/upload/' . $this->audio);
    }

    /**
     * Get the formatted modified_at attribute.
     */
    public function getFormattedModifiedAtAttribute()
    {
        return $this->modified_at ? $this->modified_at->format('d/m/Y H:i:s') : 'N/A';
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
