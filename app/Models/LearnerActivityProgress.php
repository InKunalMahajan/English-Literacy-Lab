<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LearnerActivityProgress extends Model
{
    protected $table = 'learner_activity_progress';
    protected $fillable = ['user_id','lesson_activity_id','attempts','is_correct','last_attempted_at'];
    protected function casts(): array
    {
        return ['is_correct'=>'boolean','last_attempted_at'=>'datetime'];
    }
    public function activity(): BelongsTo { return $this->belongsTo(LessonActivity::class,'lesson_activity_id'); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
