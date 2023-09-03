<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'url' => 'json',
        'meta_data' => 'json'
    ];

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->returnId($value),
        );
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function returnId($value)
    {
        $urlObject = json_decode($value,true);
        return $urlObject['id'];
    }
}
