<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = ['slug', 'title', 'level', 'topic', 'learning_outcome', 'content', 'isl_guidance', 'is_published', 'curriculum_unit_id', 'isl_video_url'];

    public function media(): HasMany { return $this->hasMany(LessonMedia::class)->orderBy('sort_order')->orderBy('id'); }
    public function unit(): BelongsTo { return $this->belongsTo(CurriculumUnit::class, 'curriculum_unit_id'); }
    public function activities(): HasMany { return $this->hasMany(LessonActivity::class)->orderBy('sort_order'); }

    protected static function booted(): void
    {
        static::deleting(function (self $lesson): void {
            foreach ($lesson->media()->whereNotNull('path')->pluck('path') as $path) {
                \Illuminate\Support\Facades\Storage::disk('local')->delete($path);
            }
        });
    }

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }
}
