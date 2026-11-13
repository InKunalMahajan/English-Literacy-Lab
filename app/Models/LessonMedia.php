<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class LessonMedia extends Model {
 protected $table='lesson_media';
 protected $fillable=['lesson_id','kind','path','external_url','title','alt_text','transcript','language','sort_order'];
 public function lesson(): BelongsTo {return $this->belongsTo(Lesson::class);}
}
