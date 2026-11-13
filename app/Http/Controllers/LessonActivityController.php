<?php
namespace App\Http\Controllers;
use App\Models\LessonActivity;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
class LessonActivityController extends Controller {
    public function check(Request $request, LessonActivity $activity): RedirectResponse {
        abort_unless($activity->lesson()->where('is_published',true)->exists(),404);
        $data=$request->validate(['answer'=>'required|string|max:255']);
        $correct=mb_strtolower(trim($data['answer']))===mb_strtolower(trim($activity->answer));
        return redirect()->route('curriculum.show',$activity->lesson_id)
            ->with('activity_feedback',[$activity->id=>$correct ? 'Correct! Well done.' : 'Try again.']);
    }
}
