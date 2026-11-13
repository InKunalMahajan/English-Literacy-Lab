<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Edit lesson — ELL</title>@vite(['resources/css/app.css','resources/js/app.js'])</head><body><main class="mx-auto max-w-3xl px-6 py-12"><a class="underline" href="{{ route('authoring.index') }}">Back to authoring</a><h1 class="mt-6 text-3xl font-bold">Edit lesson</h1>
@if($errors->any())<div role="alert" class="mt-5 border p-4">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
<form method="POST" action="{{ route('authoring.lessons.update',$lesson) }}" class="mt-8 space-y-5">@csrf @method('PUT')
<label class="block">Unit<select name="curriculum_unit_id" required class="mt-1 w-full border p-3">@foreach($units as $unit)<option value="{{ $unit->id }}" @selected(old('curriculum_unit_id',$lesson->curriculum_unit_id)==$unit->id)>{{ $unit->module->title }} / {{ $unit->title }}</option>@endforeach</select></label>
<label class="block">Title<input required maxlength="150" name="title" value="{{ old('title',$lesson->title) }}" class="mt-1 w-full border p-3"></label>
<label class="block">Level<input required maxlength="32" name="level" value="{{ old('level',$lesson->level) }}" class="mt-1 w-full border p-3"></label>
<label class="block">Topic<input required maxlength="80" name="topic" value="{{ old('topic',$lesson->topic) }}" class="mt-1 w-full border p-3"></label>
<label class="block">Learning outcome<textarea required name="learning_outcome" class="mt-1 w-full border p-3">{{ old('learning_outcome',$lesson->learning_outcome) }}</textarea></label>
<label class="block">Lesson content<textarea required name="content" rows="8" class="mt-1 w-full border p-3">{{ old('content',$lesson->content) }}</textarea></label>
<label class="block">ISL guidance<textarea name="isl_guidance" rows="4" class="mt-1 w-full border p-3">{{ old('isl_guidance',$lesson->isl_guidance) }}</textarea></label>
<label class="block">ISL video HTTPS URL<input type="url" name="isl_video_url" value="{{ old('isl_video_url',$lesson->isl_video_url) }}" class="mt-1 w-full border p-3"></label>
<button class="bg-black px-5 py-3 font-semibold text-white">Save changes</button></form>
<section class="mt-12 border-t pt-8"><h2 class="text-xl font-semibold">Delete lesson</h2><p class="mt-2">This permanently removes the lesson and its activities.</p><form method="POST" action="{{ route('authoring.lessons.destroy',$lesson) }}" class="mt-4 space-y-3">@csrf @method('DELETE')
<label class="block">Type DELETE to confirm<input required name="confirmation" pattern="DELETE" class="mt-1 w-full border p-3" autocomplete="off"></label>
<button class="border border-black px-5 py-3">Permanently delete lesson</button></form></section></main></body></html>