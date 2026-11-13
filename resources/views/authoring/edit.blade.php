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

<section class="mt-12 border-t pt-8" aria-labelledby="media-heading"><h2 id="media-heading" class="text-2xl font-semibold">Accessible lesson media</h2>
<p class="mt-2 text-sm">Upload a JPEG, PNG or WebP image (maximum 4 MB), or add an external HTTPS ISL video link with a written transcript. Add meaningful alt text for every image. Use only media you have permission to share.</p>
<form method="POST" enctype="multipart/form-data" action="{{ route('authoring.media.store',$lesson) }}" class="mt-5 space-y-4">@csrf
<label class="block">Media type<select name="kind" class="mt-1 w-full border p-3" required><option value="image">Image</option><option value="video_link">External ISL video link</option></select></label>
<p class="text-sm">Fill in the fields for the selected media type. The server validates required accessibility fields.</p>
<label class="block">Title<input name="title" maxlength="150" required class="mt-1 w-full border p-3"></label>
<label class="block">Image file<input name="image" type="file" accept="image/jpeg,image/png,image/webp" class="mt-1 w-full border p-3"></label>
<label class="block">Image alternative text<textarea name="alt_text" maxlength="1000" class="mt-1 w-full border p-3"></textarea></label>
<label class="block">External video HTTPS URL<input name="external_url" type="url" class="mt-1 w-full border p-3" placeholder="https://"></label>
<label class="block">Video transcript / text equivalent<textarea name="transcript" rows="5" class="mt-1 w-full border p-3"></textarea></label>
<label class="block">Language code<input name="language" value="en" maxlength="20" required class="mt-1 w-full border p-3"></label>
<label class="block">Display order<input name="sort_order" type="number" min="0" max="100000" value="0" class="mt-1 w-full border p-3"></label>
<button class="bg-black px-5 py-3 text-white">Add media</button></form>
@if($lesson->media->isNotEmpty())<h3 class="mt-8 font-semibold">Existing media</h3>
<ul class="mt-3 space-y-4">@foreach($lesson->media as $media)<li class="border p-4"><p class="font-semibold">{{ $media->title }} — {{ $media->kind }}</p>
@if($media->kind==='image')<img src="{{ route('media.show',$media) }}" alt="{{ $media->alt_text }}" class="mt-3 max-h-64 w-auto object-contain">@else<p class="mt-2"><a href="{{ $media->external_url }}" class="underline" target="_blank" rel="noopener noreferrer">Open external video</a></p>@endif
<form method="POST" action="{{ route('authoring.media.destroy',$media) }}" class="mt-4 flex flex-wrap gap-3">@csrf @method('DELETE')
<label>Type DELETE to remove<input name="confirmation" required pattern="DELETE" class="ml-2 border p-2"></label><button class="border px-4 py-2">Delete media</button></form></li>@endforeach</ul>@endif
</section>
<section class="mt-12 border-t pt-8"><h2 class="text-xl font-semibold">Delete lesson</h2><p class="mt-2">This permanently removes the lesson and its activities.</p><form method="POST" action="{{ route('authoring.lessons.destroy',$lesson) }}" class="mt-4 space-y-3">@csrf @method('DELETE')
<label class="block">Type DELETE to confirm<input required name="confirmation" pattern="DELETE" class="mt-1 w-full border p-3" autocomplete="off"></label>
<button class="border border-black px-5 py-3">Permanently delete lesson</button></form></section></main></body></html>