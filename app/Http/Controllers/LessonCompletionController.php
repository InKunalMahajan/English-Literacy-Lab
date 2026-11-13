<?php
namespace App\Http\Controllers;
use App\Models\Lesson;
use App\Models\LessonCompletion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class LessonCompletionController extends Controller {
    public function store(Request $request, Lesson $lesson): RedirectResponse {
        abort_unless($request->user()->is_active,403);
        abort_unless($lesson->is_published,404);
        $activityIds=$lesson->activities()->pluck('id');
        if ($activityIds->isNotEmpty()) {
            $passed=\App\Models\LearnerActivityProgress::query()
                ->where('user_id',$request->user()->id)
                ->whereIn('lesson_activity_id',$activityIds)
                ->where('is_correct',true)->count();
            if ($passed !== $activityIds->count()) {
                return back()->withErrors(['completion'=>'Complete all activities correctly before marking this lesson complete.']);
            }
        }
        LessonCompletion::firstOrCreate(
            ['user_id'=>$request->user()->id,'lesson_id'=>$lesson->id],
            ['completed_at'=>now()]
        );
        return back()->with('status','Lesson completed.');
    }
}
