<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Lesson authoring — ELL</title>@vite(['resources/css/app.css','resources/js/app.js'])</head>
<body><main class="mx-auto max-w-5xl px-5 py-10">
<a class="underline" href="{{ route('dashboard') }}">Dashboard</a><h1 class="mt-6 text-3xl font-bold">Curriculum authoring</h1>
<p class="mt-2 text-neutral-600">Editor-only workspace. New lessons are saved as drafts.</p>
@if(session('status'))<p role="status" class="my-4 border p-3">{{ session('status') }}</p>@endif
@if($errors->any())<div role="alert" class="my-4 border p-3"><strong>Check your entries:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="mt-8 grid gap-8 md:grid-cols-2">
<section class="border p-5"><h2 class="text-xl font-semibold">1. Create module</h2><form class="mt-4 space-y-3" method="POST" action="{{ route('authoring.modules.store') }}">@csrf
<label class="block">Module title<input required maxlength="150" name="title" class="mt-1 w-full border p-2" value="{{ old('title') }}"></label>
<label class="block">Description<textarea name="description" class="mt-1 w-full border p-2"></textarea></label>
<button class="border border-black px-4 py-2">Create module</button></form></section>
<section class="border p-5"><h2 class="text-xl font-semibold">2. Create unit</h2><form class="mt-4 space-y-3" method="POST" action="{{ route('authoring.units.store') }}">@csrf
<label class="block">Module<select required name="curriculum_module_id" class="mt-1 w-full border p-2"><option value="">Select module</option>@foreach($modules as $module)<option value="{{ $module->id }}">{{ $module->title }}</option>@endforeach</select></label>
<label class="block">Unit title<input required maxlength="150" name="title" class="mt-1 w-full border p-2"></label>
<button class="border border-black px-4 py-2">Create unit</button></form></section>
</div>
<section class="mt-8 border p-5"><h2 class="text-xl font-semibold">3. Create lesson</h2>
<form class="mt-4 grid gap-4 md:grid-cols-2" method="POST" action="{{ route('authoring.lessons.store') }}">@csrf
<label class="block">Unit<select required name="curriculum_unit_id" class="mt-1 w-full border p-2"><option value="">Select unit</option>@foreach($units as $unit)<option value="{{ $unit->id }}">{{ $unit->module->title }} / {{ $unit->title }}</option>@endforeach</select></label>
<label class="block">Lesson title<input required name="title" maxlength="150" class="mt-1 w-full border p-2"></label>
<label class="block">Level<input required name="level" maxlength="32" placeholder="Foundation" class="mt-1 w-full border p-2"></label>
<label class="block">Topic<input required name="topic" maxlength="80" placeholder="Vocabulary" class="mt-1 w-full border p-2"></label>
<label class="block md:col-span-2">Measurable learning outcome<textarea required name="learning_outcome" class="mt-1 w-full border p-2"></textarea></label>
<label class="block md:col-span-2">Lesson content<textarea required name="content" rows="6" class="mt-1 w-full border p-2"></textarea></label>
<label class="block md:col-span-2">ISL performance guidance<textarea name="isl_guidance" rows="3" class="mt-1 w-full border p-2"></textarea></label>
<label class="block md:col-span-2">ISL video HTTPS URL (optional)<input name="isl_video_url" type="url" placeholder="https://..." class="mt-1 w-full border p-2"></label>
<button class="border border-black px-4 py-2 md:col-span-2">Save lesson as draft</button></form></section>
<section class="mt-8"><h2 class="text-xl font-semibold">4. Manage lessons and activities</h2><div class="mt-4 space-y-6">
@forelse($lessons as $lesson)<article class="border p-5"><h3 class="font-semibold">{{ $lesson->title }} <span class="text-sm font-normal">({{ $lesson->is_published ? 'Published' : 'Draft' }})</span></h3>
<p class="mt-3"><a class="underline" href="{{ route('authoring.lessons.edit',$lesson) }}">Edit or delete lesson</a></p>
<form class="mt-3" method="POST" action="{{ route('authoring.lessons.publish',$lesson) }}">@csrf<button class="border px-3 py-2">{{ $lesson->is_published ? 'Unpublish' : 'Publish' }}</button></form>
@if($lesson->activities->isNotEmpty())
<div class="mt-4 border-t pt-4"><h4 class="font-semibold">Existing activities</h4><ul class="mt-2 space-y-2">@foreach($lesson->activities as $activity)<li class="flex flex-wrap items-center justify-between gap-3 border p-3"><span>{{ $activity->prompt }} ({{ str_replace('_',' ',$activity->activity_type) }})</span><a class="underline" href="{{ route('authoring.activities.edit',$activity) }}">Edit or delete</a></li>@endforeach</ul></div>
@endif
<form class="mt-4 grid gap-3 md:grid-cols-2" method="POST" action="{{ route('authoring.activities.store',$lesson) }}">@csrf
<label>Activity type<select name="activity_type" required class="mt-1 w-full border p-2"><option value="short_answer">Short answer</option><option value="vocabulary">Vocabulary</option><option value="grammar">Grammar</option><option value="sentence_order">Sentence ordering</option><option value="flashcard">Vocabulary flashcard</option><option value="reading_comprehension">Reading comprehension</option></select></label>
<label>Activity question<input required name="prompt" maxlength="255" class="mt-1 w-full border p-2"></label>
<label>Expected answer (for sentence ordering, write the correct sentence)<input required name="answer" maxlength="255" class="mt-1 w-full border p-2"></label>
<label class="md:col-span-2">Visual description (optional)<textarea name="visual_prompt" class="mt-1 w-full border p-2" placeholder="Describe a scene, object or visual example"></textarea></label>
<label class="md:col-span-2">Optional visual/ISL hint<input name="hint" class="mt-1 w-full border p-2"></label>
<button class="border px-3 py-2 md:col-span-2">Add learning activity</button></form></article>
@empty<p>No lessons yet.</p>@endforelse</div><div class="mt-6">{{ $lessons->links() }}</div></section>
</main></body></html>
