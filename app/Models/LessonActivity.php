<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class LessonActivity extends Model {
    protected $fillable = ['lesson_id','prompt','answer','hint','sort_order'];
    protected $hidden = ['answer'];
    public function lesson(): BelongsTo { return $this->belongsTo(Lesson::class); }
}
