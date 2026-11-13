<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class CurriculumUnit extends Model {
    protected $fillable = ['curriculum_module_id','title','slug','sort_order'];
    public function module(): BelongsTo { return $this->belongsTo(CurriculumModule::class,'curriculum_module_id'); }
    public function lessons(): HasMany { return $this->hasMany(Lesson::class); }
}
