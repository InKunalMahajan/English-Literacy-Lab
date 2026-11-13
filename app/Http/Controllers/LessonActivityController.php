<?php

namespace App\Http\Controllers;

use App\Models\LearnerActivityProgress;
use App\Models\LessonActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LessonActivityController extends Controller
{
    public function check(Request $request, LessonActivity $activity): RedirectResponse
    {
        abort_unless($activity->lesson()->where('is_published', true)->exists(), 404);
        $data = $request->validate(['answer' => 'required|string|max:255']);
        $normalize = static fn (string $value): string => mb_strtolower(trim($value));
        $correct = $normalize($data['answer']) === $normalize($activity->answer);

        if ($request->user() && $request->user()->is_active) {
            $progress = LearnerActivityProgress::firstOrCreate([
                'user_id' => $request->user()->id,
                'lesson_activity_id' => $activity->id,
            ]);
            $progress->attempts += 1;
            $progress->is_correct = $progress->is_correct || $correct;
            $progress->last_attempted_at = now();
            $progress->save();
        }

        return redirect()->route('curriculum.show', $activity->lesson_id)
            ->with('activity_feedback', [$activity->id => $correct ? 'Correct! Well done.' : 'Try again.']);
    }
}
