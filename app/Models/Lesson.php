<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['slug', 'title', 'level', 'topic', 'learning_outcome', 'content', 'isl_guidance', 'is_published'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }
}
