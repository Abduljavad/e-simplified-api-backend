<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['image' => 'json', 'icon' => 'json'];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->with('children');
    }

    public function parent()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id')->with('parent');
    }
}
