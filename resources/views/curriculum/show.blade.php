<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>{{ $lesson->title }} — English Literacy Lab</title>@vite(['resources/css/app.css','resources/js/app.js'])</head><body>
<a href="#main" class="sr-only focus:not-sr-only">Skip to content</a><header class="border-b px-6 py-5"><nav class="mx-auto flex max-w-4xl justify-between"><a class="font-bold" href="{{ route('home') }}">English Literacy Lab</a><a class="underline" href="{{ route('curriculum.index') }}">All lessons</a></nav></header>
<main id="main" class="mx-auto max-w-4xl px-6 py-12"><p class="text-sm text-neutral-600">{{ $lesson->level }} · {{ $lesson->topic }}</p><h1 class="mt-3 text-4xl font-bold">{{ $lesson->title }}</h1>
@if($lesson->unit)<p class="mt-3 text-neutral-600">{{ $lesson->unit->module->title }} / {{ $lesson->unit->title }}</p>@endif
<section class="mt-10 border-l-4 border-black pl-5"><h2 class="text-xl font-semibold">Learning outcome</h2><p class="mt-2">{{ $lesson->learning_outcome }}</p></section>
<section class="mt-10"><h2 class="text-2xl font-semibold">Learn</h2><div class="mt-4 whitespace-pre-line leading-loose">{{ $lesson->content }}</div></section>

@if($lesson->media->isNotEmpty())
<section class="mt-10" aria-labelledby="visual-resources-heading"><h2 id="visual-resources-heading" class="text-2xl font-semibold">Visual and ISL learning resources</h2>
<div class="mt-5 space-y-6">@foreach($lesson->media as $media)
<figure class="border p-5">
@if($media->kind==='image')
<img src="{{ route('media.show',$media) }}" alt="{{ $media->alt_text }}" loading="lazy" class="max-h-96 w-full object-contain">
@else
<p><a href="{{ $media->external_url }}" target="_blank" rel="noopener noreferrer" class="underline">Open {{ $media->title }} (external video, new tab)</a></p>
@if($media->transcript)<details class="mt-4 border p-4"><summary class="cursor-pointer font-semibold">Read the video transcript / text equivalent</summary><p class="mt-3 whitespace-pre-line">{{ $media->transcript }}</p></details>@endif
@endif
<figcaption class="mt-3 text-sm">{{ $media->title }} · Language: {{ $media->language }}</figcaption>
</figure>
@endforeach</div></section>
@endif
@if($lesson->isl_video_url)<section class="mt-10"><h2 class="text-2xl font-semibold">ISL video resource</h2><p class="mt-3"><a class="underline" href="{{ $lesson->isl_video_url }}" target="_blank" rel="noopener noreferrer">Open ISL video in a new tab</a></p><p class="mt-2 text-sm text-neutral-600">External video resource. Captions and accessibility depend on the provider.</p></section>@endif
@if($lesson->isl_guidance)<section class="mt-10 border p-5"><h2 class="text-2xl font-semibold">ISL-first guidance</h2><p class="mt-3 whitespace-pre-line">{{ $lesson->isl_guidance }}</p></section>@endif
@if($lesson->activities->isNotEmpty())<section class="mt-12"><h2 class="text-2xl font-semibold">Practise your English</h2><p class="mt-2 text-neutral-700">Type your answer and check your understanding.</p>
@foreach($lesson->activities as $activity)<article class="mt-5 border p-5"><p class="text-xs font-semibold uppercase tracking-wider text-neutral-600">{{ str_replace('_',' ',$activity->activity_type) }}</p><h3 class="mt-2 font-semibold">{{ $loop->iteration }}. {{ $activity->prompt }}</h3>
@if($activity->visual_prompt)<div class="mt-3 border-l-4 border-black bg-neutral-50 p-4"><p class="text-sm font-semibold">Visual learning scene</p><p class="mt-2 whitespace-pre-line">{{ $activity->visual_prompt }}</p></div>@endif
@auth
@if(isset($learnerProgress[$activity->id]))
<p class="mt-2 text-sm">Your progress: {{ $learnerProgress[$activity->id]->attempts }} attempt(s) · {{ $learnerProgress[$activity->id]->is_correct ? 'Completed' : 'Practising' }}</p>
@endif
@endauth
@if($activity->activity_type === 'flashcard')
<details class="mt-4 border p-4"><summary class="cursor-pointer font-semibold">Reveal vocabulary card</summary><p class="mt-3 whitespace-pre-line">{{ $activity->answer }}</p><p class="mt-2 text-sm">Read the word, then practise writing it below.</p></details>
@elseif($activity->activity_type === 'sentence_order')
<p class="mt-3 text-sm">Put the words in the correct order. Type the complete sentence in the answer field. Use the punctuation shown in the question.</p>
@endif
@if($activity->hint)<p class="mt-2 text-sm text-neutral-700">Hint: {{ $activity->hint }}</p>@endif
@if(session('activity_feedback') && isset(session('activity_feedback')[$activity->id]))<p role="status" class="mt-3 font-semibold">{{ session('activity_feedback')[$activity->id] }}</p>@endif
<form method="POST" action="{{ route('activities.check',$activity) }}" class="mt-4 flex flex-wrap gap-3">@csrf<label class="flex-1">Your answer<input required maxlength="255" name="answer" class="mt-1 block w-full border p-3"></label><button class="self-end border border-black px-5 py-3">Check answer</button></form></article>@endforeach</section>@endif

<section class="mt-12 border-t pt-8" aria-labelledby="completion-heading"><h2 id="completion-heading" class="text-2xl font-semibold">Lesson completion</h2>
@auth
@if($isCompleted)<p class="mt-3 font-semibold" role="status">Completed — well done!</p>
@elseif($canComplete)
<form method="POST" action="{{ route('curriculum.complete',$lesson) }}" class="mt-4">@csrf<button class="border border-black bg-black px-5 py-3 text-white">Mark lesson complete</button></form>
@else<p class="mt-3">Answer every activity correctly to unlock lesson completion.</p>@endif
@else<p class="mt-3"><a class="underline" href="{{ route('login') }}">Sign in</a> to save lesson completion.</p>@endauth
@if($errors->has('completion'))<p role="alert" class="mt-3">{{ $errors->first('completion') }}</p>@endif
@if(session('status'))<p role="status" class="mt-3">{{ session('status') }}</p>@endif
</section>
</main></body></html>
