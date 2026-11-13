<?php
namespace Tests\Feature;
use App\Models\AssessmentAttempt;
use App\Models\ResearchConsent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class ResearchPrivacyTest extends TestCase {
 use RefreshDatabase;
 private function user(int $n,bool $editor=false): User {
  $user=User::create(['name'=>'Learner','email'=>"person{$n}@example.test",'password'=>'password','is_active'=>true]);
  $user->forceFill(['is_content_editor'=>$editor])->save();
  return $user;
 }
 public function test_consent_is_optional_and_withdrawable(): void {
  $user=$this->user(1);
  $this->actingAs($user)->get('/research/consent')->assertOk()->assertSee('Not participating');
  $this->post('/research/consent',['choice'=>'opt_in'])->assertRedirect();
  $this->assertTrue(ResearchConsent::where('user_id',$user->id)->firstOrFail()->isCurrent());
  $this->post('/research/consent',['choice'=>'withdraw'])->assertRedirect();
  $this->assertFalse(ResearchConsent::where('user_id',$user->id)->firstOrFail()->isCurrent());
  $this->get('/dashboard')->assertOk();
 }
 public function test_analytics_are_editor_only_and_suppressed_for_small_groups(): void {
  $this->get('/research/analytics')->assertRedirect('/login');
  $this->actingAs($this->user(1))->get('/research/analytics')->assertForbidden();
  $this->actingAs($this->user(2,true))->get('/research/analytics')->assertOk()->assertSee('statistics are hidden');
 }
 public function test_five_opted_in_participants_enable_group_summary_and_withdrawal_hides_it(): void {
  $editor=$this->user(99,true);
  $lesson=\App\Models\Lesson::create(['slug'=>'research-test','title'=>'Research','level'=>'Foundation','topic'=>'English','learning_outcome'=>'Learn','content'=>'Read','is_published'=>true]);
  $participants=[];
  for($n=1;$n<=5;$n++){
   $user=$this->user($n);$participants[]=$user;
   ResearchConsent::create(['user_id'=>$user->id,'policy_version'=>ResearchConsent::POLICY_VERSION,'consented_at'=>now()->subDay()]);
   AssessmentAttempt::create(['user_id'=>$user->id,'lesson_id'=>$lesson->id,'total_questions'=>1,'correct_answers'=>1,'score_percent'=>100,'mastery_status'=>'mastered','submitted_at'=>now()]);
  }
  $this->actingAs($editor)->get('/research/analytics')->assertOk()->assertSee('100.0%');
  ResearchConsent::where('user_id',$participants[0]->id)->update(['withdrawn_at'=>now()]);
  $this->get('/research/analytics')->assertOk()->assertSee('statistics are hidden')->assertDontSee('100.0%');
 }
}
