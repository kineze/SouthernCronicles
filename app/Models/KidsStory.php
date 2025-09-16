<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KidsStory extends Model
{
    protected $fillable = [
        'first_name','age','location','guardian_name','guardian_email',
        'title','genres','genre_other','main_characters',
        'story_html','story','drawing_path',
        'guardian_signature','consent_date',
        'status',
    ];

    protected $casts = [
        'genres' => 'array',
        'consent_date' => 'date',
    ];
}
