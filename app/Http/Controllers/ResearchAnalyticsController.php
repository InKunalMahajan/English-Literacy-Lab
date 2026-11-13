<?php
namespace App\Http\Controllers;
use App\Models\AssessmentAttempt;
use App\Models\ResearchConsent;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
class ResearchAnalyticsController extends Controller {
 public function index(Request $request): View {
  abort_unless($request->user()->is_active && $request->user()->is_content_editor,403);
  // Never include people who withdrew. Only attempts recorded after the current opt-in.
  $eligible=ResearchConsent::query()->where('policy_version',ResearchConsent::POLICY_VERSION)
   ->whereNotNull('consented_at')->whereNull('withdrawn_at');
  $count=(clone $eligible)->count();
  $summary=null;
  if($count>=5) {
   $attempts=AssessmentAttempt::query()->join('research_consents as rc','rc.user_id','=','assessment_attempts.user_id')
    ->where('rc.policy_version',ResearchConsent::POLICY_VERSION)
    ->whereNotNull('rc.consented_at')->whereNull('rc.withdrawn_at')
    ->whereColumn('assessment_attempts.submitted_at','>=','rc.consented_at');
   $participants=(clone $attempts)->distinct()->count('assessment_attempts.user_id');
   if($participants>=5) {
    $summary=[
     'participants'=>$participants,
     'attempts'=>(clone $attempts)->count(),
     'average_score'=>round((float)(clone $attempts)->avg('assessment_attempts.score_percent'),1),
    ];
   }
  }
  return view('research.analytics',compact('summary'));
 }
}
