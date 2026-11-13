<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class CurriculumController extends Controller
{
    public function index(): View
    {
        $lessons = Lesson::query()->where('is_published', true)->orderBy('level')->orderBy('title')->paginate(12);

        return view('curriculum.index', compact('lessons'));
    }

    public function show(Lesson $lesson): View
    {
        abort_unless($lesson->is_published, 404);

        return view('curriculum.show', compact('lesson'));
    }
}
