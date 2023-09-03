<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'icon' => 'json'
    ];
    
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
