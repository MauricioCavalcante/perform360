<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'question_text',
        'question_order',
        'version_date',
    ];

    /**
     * Get the question that owns the version.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
