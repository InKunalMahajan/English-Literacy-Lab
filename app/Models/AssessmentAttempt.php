<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class AssessmentAttempt extends Model {
 protected $fillable=['user_id','lesson_id','total_questions','correct_answers','score_percent','mastery_status','submitted_at'];
 protected function casts(): array {return ['submitted_at'=>'datetime'];}
 public function lesson(): BelongsTo {return $this->belongsTo(Lesson::class);}
 public function user(): BelongsTo {return $this->belongsTo(User::class);}
}
