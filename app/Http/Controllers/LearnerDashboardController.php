<?php
namespace App\Http\Controllers;
use App\Models\Lesson;
use App\Models\LessonCompletion;
use App\Models\LearnerActivityProgress;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
class LearnerDashboardController extends Controller {
    public function index(Request $request): View {
        $user=$request->user();
        $completed=LessonCompletion::with('lesson')->where('user_id',$user->id)
            ->whereHas('lesson',fn($q)=>$q->where('is_published',true))
            ->orderByDesc('completed_at')->get();
        $completedIds=$completed->pluck('lesson_id');
        $progress=LearnerActivityProgress::where('user_id',$user->id)->get();
        return view('dashboard',[
            'assessmentAttempts'=>\App\Models\AssessmentAttempt::with('lesson')->where('user_id',$user->id)->whereHas('lesson',fn($q)=>$q->where('is_published',true))->latest('id')->limit(10)->get(),
            'writingDrafts'=>\App\Models\WritingPractice::with('lesson')->where('user_id',$user->id)->whereHas('lesson',fn($q)=>$q->where('is_published',true))->orderByDesc('updated_at')->limit(10)->get(),
            'completed'=>$completed,
            'completedCount'=>$completed->count(),
            'availableCount'=>Lesson::where('is_published',true)->count(),
            'attemptCount'=>$progress->sum('attempts'),
            'correctCount'=>$progress->where('is_correct',true)->count(),
            'nextLessons'=>Lesson::where('is_published',true)->whereNotIn('id',$completedIds)->orderBy('title')->limit(5)->get(),
        ]);
    }
}
