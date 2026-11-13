<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class LessonActivity extends Model {
    protected $fillable = ['lesson_id','prompt','answer','hint','sort_order','activity_type','visual_prompt'];
    protected $hidden = ['answer'];
    public function progress(): \Illuminate\Database\Eloquent\Relations\HasMany { return $this->hasMany(LearnerActivityProgress::class,'lesson_activity_id'); }
    public function lesson(): BelongsTo { return $this->belongsTo(Lesson::class); }
}
