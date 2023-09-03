<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'thumbnail' => 'json',
        'banner_image' => 'json',
        'course_offerings' => 'json',
        'course_outcomes' => 'json',
        'teachers' => 'json',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function sections():HasMany
    {
        return $this->hasMany(Section::class);
    }
}
