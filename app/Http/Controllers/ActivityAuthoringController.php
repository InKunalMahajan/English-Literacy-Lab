<?php

namespace App\Http\Controllers;

use App\Models\LessonActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class ActivityAuthoringController extends Controller
{
    private function authorizeEditor(Request $request): void
    {
        abort_unless($request->user()?->is_active && $request->user()?->is_content_editor, 403);
    }

    public function edit(Request $request, LessonActivity $activity): View
    {
        $this->authorizeEditor($request);
        return view('authoring.activity-edit', compact('activity'));
    }

    public function update(Request $request, LessonActivity $activity): RedirectResponse
    {
        $this->authorizeEditor($request);
        $data = $request->validate([
            'prompt'=>'required|string|max:255',
            'answer'=>'required|string|max:255',
            'hint'=>'nullable|string|max:2000',
            'visual_prompt'=>'nullable|string|max:2000',
            'activity_type'=>'required|in:short_answer,vocabulary,grammar,sentence_order,flashcard,reading_comprehension',
            'sort_order'=>'required|integer|min:0|max:100000',
        ]);
        $activity->update($data);
        // Existing learner progress is no longer valid if the activity changes.
        $activity->progress()->delete();
        \App\Models\LessonCompletion::where('lesson_id',$activity->lesson_id)->delete();
        return redirect()->route('authoring.index')->with('status','Activity updated. Learner results for this activity and lesson completions were reset.');
    }

    public function destroy(Request $request, LessonActivity $activity): RedirectResponse
    {
        $this->authorizeEditor($request);
        $request->validate(['confirmation'=>'required|in:DELETE']);
        $lessonId=$activity->lesson_id;
        $activity->delete();
        \App\Models\LessonCompletion::where('lesson_id',$lessonId)->delete();
        return redirect()->route('authoring.index')->with('status','Activity deleted. Lesson completion records were reset.');
    }
}
