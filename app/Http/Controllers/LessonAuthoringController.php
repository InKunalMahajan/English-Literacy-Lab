<?php

namespace App\Http\Controllers;

use App\Models\CurriculumModule;
use App\Models\CurriculumUnit;
use App\Models\Lesson;
use App\Models\LessonActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LessonAuthoringController extends Controller
{
    private function authorizeEditor(Request $request): void
    {
        abort_unless($request->user()?->is_active && $request->user()?->is_content_editor, 403);
    }

    public function index(Request $request): View
    {
        $this->authorizeEditor($request);
        return view('authoring.index', [
            'modules' => CurriculumModule::with('units')->orderBy('sort_order')->get(),
            'lessons' => Lesson::orderByDesc('updated_at')->paginate(20),
            'units' => CurriculumUnit::with('module')->orderBy('title')->get(),
        ]);
    }

    public function module(Request $request): RedirectResponse
    {
        $this->authorizeEditor($request);
        $data = $request->validate(['title'=>'required|string|max:150','description'=>'nullable|string|max:1000']);
        $slug = Str::slug($data['title']);
        if (CurriculumModule::where('slug', $slug)->exists()) {
            return back()->withErrors(['title'=>'A module with this name already exists.'])->withInput();
        }
        CurriculumModule::create(['title'=>$data['title'],'slug'=>$slug,'description'=>$data['description'] ?? null]);
        return redirect()->route('authoring.index')->with('status','Module created.');
    }

    public function unit(Request $request): RedirectResponse
    {
        $this->authorizeEditor($request);
        $data = $request->validate([
            'curriculum_module_id'=>'required|exists:curriculum_modules,id',
            'title'=>'required|string|max:150',
        ]);
        $slug = Str::slug($data['title']);
        if (CurriculumUnit::where('curriculum_module_id', $data['curriculum_module_id'])->where('slug', $slug)->exists()) {
            return back()->withErrors(['title'=>'A unit with this name already exists in this module.'])->withInput();
        }
        CurriculumUnit::create($data + ['slug'=>$slug]);
        return redirect()->route('authoring.index')->with('status','Unit created.');
    }

    public function lesson(Request $request): RedirectResponse
    {
        $this->authorizeEditor($request);
        $data = $request->validate([
            'curriculum_unit_id'=>'required|exists:curriculum_units,id',
            'title'=>'required|string|max:150',
            'level'=>'required|string|max:32','topic'=>'required|string|max:80',
            'learning_outcome'=>'required|string|max:2000','content'=>'required|string|max:20000',
            'isl_guidance'=>'nullable|string|max:5000',
            'isl_video_url'=>'nullable|url|starts_with:https://|max:2048',
            'is_published'=>'sometimes|boolean',
        ]);
        $slug = Str::slug($data['title']);
        if (Lesson::where('slug',$slug)->exists()) {
            return back()->withErrors(['title'=>'A lesson with this title already exists.'])->withInput();
        }
        unset($data['is_published']);
        Lesson::create($data + ['slug'=>$slug,'is_published'=>false]);
        return redirect()->route('authoring.index')->with('status','Lesson saved as draft.');
    }

    public function publish(Request $request, Lesson $lesson): RedirectResponse
    {
        $this->authorizeEditor($request);
        $lesson->update(['is_published'=>!$lesson->is_published]);
        return redirect()->route('authoring.index')->with('status','Publication status updated.');
    }

    public function activity(Request $request, Lesson $lesson): RedirectResponse
    {
        $this->authorizeEditor($request);
        $data = $request->validate(['prompt'=>'required|string|max:255','answer'=>'required|string|max:255','hint'=>'nullable|string|max:2000']);
        $lesson->activities()->create($data);
        return redirect()->route('authoring.index')->with('status','Activity added.');
    }
}
