<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    protected $table = 'user_progress';
    
    protected $fillable = [
        'user_id',
        'story_id',
        'chapter_id',
        'history',
        'choices_made'
    ];

    protected $casts = [
        'history' => 'array',
        'choices_made' => 'array'
    ];
}