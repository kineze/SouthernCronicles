<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MemorySubmission extends Model
{
    
    protected $fillable = [
        'given_name',
        'family_name',
        'country',
        'submission',
        'is_copyright',
        'copyright_holder',
        'copyright_contact',
        'file_path',
    ];

    protected $casts = [
        'is_copyright' => 'boolean',
    ];

    public function getFileUrlAttribute()
    {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }

}
