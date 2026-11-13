<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class WritingPractice extends Model {
 protected $table='writing_practice';
 protected $fillable=['user_id','lesson_id','response','word_count'];
 public function lesson(): BelongsTo {return $this->belongsTo(Lesson::class);}
 public function user(): BelongsTo {return $this->belongsTo(User::class);}
}
