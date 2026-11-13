<?php
namespace App\Http\Controllers;
use App\Models\ResearchConsent;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
class ResearchConsentController extends Controller {
 public function show(Request $request): View {
  return view('research.consent',['consent'=>ResearchConsent::where('user_id',$request->user()->id)->first()]);
 }
 public function update(Request $request): RedirectResponse {
  abort_unless($request->user()->is_active,403);
  $data=$request->validate(['choice'=>'required|in:opt_in,withdraw']);
  $optIn=$data['choice']==='opt_in';
  ResearchConsent::updateOrCreate(['user_id'=>$request->user()->id],[
   'policy_version'=>ResearchConsent::POLICY_VERSION,
   'consented_at'=>$optIn?now():null,
   'withdrawn_at'=>$optIn?null:now(),
  ]);
  return back()->with('research_status',$optIn?'Your optional research preference is on.':'Your optional research preference is off. You can continue learning.');
 }
}
