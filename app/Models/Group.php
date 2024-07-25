<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the users associated with the group.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'group_id');
    }

    /**
     * Get the evaluations associated with the group.
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'group_id');
    }
}
