<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ResearchConsent extends Model {
 public const POLICY_VERSION='pilot-v1';
 protected $fillable=['user_id','policy_version','consented_at','withdrawn_at'];
 protected function casts(): array {return ['consented_at'=>'datetime','withdrawn_at'=>'datetime'];}
 public function user(): BelongsTo {return $this->belongsTo(User::class);}
 public function isCurrent(): bool {
  return $this->policy_version===self::POLICY_VERSION && $this->consented_at!==null && $this->withdrawn_at===null;
 }
}
