<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_date',
        'time_in',
        'time_out',
        'venue',
        'name',
        'event_type',
        'description',
        'moderator_id',
        'book_signing',
    ];

    // No longer cast or store `speaker_ids` directly
    protected $casts = [
        'book_signing' => 'boolean',
        'event_date' => 'date',
        'time_in' => 'datetime:H:i',
        'time_out' => 'datetime:H:i',
    ];

    public function moderator()
    {
        return $this->belongsTo(Speaker::class, 'moderator_id');
    }

    public function speakers()
    {
        return $this->belongsToMany(Speaker::class, 'event_speaker', 'event_id', 'speaker_id');
    }


}
