<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class CurriculumController extends Controller
{
    public function index(): View
    {
        $modules = \App\Models\CurriculumModule::with(['units.lessons' => fn ($q) => $q->where('is_published', true)])->orderBy('sort_order')->get();
        $lessons = Lesson::query()->where('is_published', true)->orderBy('level')->orderBy('title')->paginate(12);

        return view('curriculum.index', compact('lessons', 'modules'));
    }

    public function show(Lesson $lesson): View
    {
        abort_unless($lesson->is_published, 404);

        $lesson->load('activities', 'unit.module');
        return view('curriculum.show', compact('lesson'));
    }
}
