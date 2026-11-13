<?php
namespace App\Http\Controllers;
use App\Models\AssessmentAttempt;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
class LessonAssessmentController extends Controller {
 private function published(Lesson $lesson): void {abort_unless($lesson->is_published,404);}
 public function show(Request $request,Lesson $lesson): View {
  abort_unless($request->user()->is_active,403);
  $this->published($lesson);
  $questions=$lesson->activities()->where('activity_type','!=','flashcard')->get();
  $history=AssessmentAttempt::where('user_id',$request->user()->id)->where('lesson_id',$lesson->id)->latest('id')->limit(10)->get();
  return view('assessments.show',compact('lesson','questions','history'));
 }
 public function submit(Request $request,Lesson $lesson): RedirectResponse {
  abort_unless($request->user()->is_active,403);
  $this->published($lesson);
  $questions=$lesson->activities()->where('activity_type','!=','flashcard')->get();
  abort_if($questions->isEmpty(),422,'This lesson has no assessment questions.');
  $data=$request->validate(['answers'=>'required|array','answers.*'=>'nullable|string|max:255']);
  $answers=$data['answers'];
  $normalize=static fn(string $s): string=>mb_strtolower(preg_replace('/\\s+/u',' ',trim($s)));
  $correct=0;
  foreach($questions as $question) {
   $value=$answers[$question->id]??'';
   if(is_string($value) && $normalize($value)===$normalize($question->answer)) $correct++;
  }
  $score=(int)round(100*$correct/$questions->count());
  $status=$score>=80?'mastered':($score>=50?'developing':'needs_practice');
  AssessmentAttempt::create([
   'user_id'=>$request->user()->id,'lesson_id'=>$lesson->id,
   'total_questions'=>$questions->count(),'correct_answers'=>$correct,
   'score_percent'=>$score,'mastery_status'=>$status,'submitted_at'=>now(),
  ]);
  return redirect()->route('assessments.show',$lesson)->with('assessment_result',"Assessment submitted. Score: {$score}%. Status: ".str_replace('_',' ',$status).'.');
 }
}
