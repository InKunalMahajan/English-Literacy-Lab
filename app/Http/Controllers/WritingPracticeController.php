<?php
namespace App\Http\Controllers;
use App\Models\Lesson;
use App\Models\WritingPractice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class WritingPracticeController extends Controller {
 public function store(Request $request,Lesson $lesson): RedirectResponse {
  abort_unless($request->user()->is_active,403);
  abort_unless($lesson->is_published,404);
  $data=$request->validate(['response'=>'required|string|min:1|max:10000']);
  $response=trim($data['response']);
  if($response==='') return back()->withErrors(['response'=>'Write at least one word.']);
  $count=str_word_count($response);
  WritingPractice::updateOrCreate(
   ['user_id'=>$request->user()->id,'lesson_id'=>$lesson->id],
   ['response'=>$response,'word_count'=>$count]
  );
  return back()->with('writing_status','Your private writing practice was saved. This is not an assessment.');
 }
}
