<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Dashboard — English Literacy Lab</title>@vite(['resources/css/app.css','resources/js/app.js'])</head><body>
<a class="sr-only focus:not-sr-only" href="#main">Skip to content</a>
<header class="border-b px-6 py-5"><nav class="mx-auto flex max-w-4xl justify-between"><a class="font-bold" href="{{ route('home') }}">English Literacy Lab</a><a class="underline" href="{{ route('curriculum.index') }}">Curriculum</a></nav></header>
<main id="main" class="mx-auto max-w-4xl px-6 py-12"><h1 class="text-3xl font-bold">Your learning dashboard</h1><p class="mt-3">Welcome, {{ auth()->user()->name }}.</p>
<section class="mt-8 grid gap-4 sm:grid-cols-3" aria-label="Your learning statistics">
<div class="border p-5"><p class="text-sm">Lessons completed</p><p class="mt-2 text-3xl font-bold">{{ $completedCount }} / {{ $availableCount }}</p></div>
<div class="border p-5"><p class="text-sm">Activity attempts</p><p class="mt-2 text-3xl font-bold">{{ $attemptCount }}</p></div>
<div class="border p-5"><p class="text-sm">Activities answered correctly</p><p class="mt-2 text-3xl font-bold">{{ $correctCount }}</p></div></section>
<section class="mt-10"><h2 class="text-2xl font-semibold">Continue learning</h2>
@if($nextLessons->isEmpty())<p class="mt-3">No more published lessons to complete right now.</p>
@else<ul class="mt-4 space-y-3">@foreach($nextLessons as $lesson)<li class="border p-4"><a class="font-semibold underline" href="{{ route('curriculum.show',$lesson) }}">{{ $lesson->title }}</a><p class="mt-1 text-sm">{{ $lesson->level }} · {{ $lesson->topic }}</p></li>@endforeach</ul>@endif</section>
<section class="mt-10"><h2 class="text-2xl font-semibold">Completed lessons</h2>
@if($completed->isEmpty())<p class="mt-3">Your completed lessons will appear here.</p>
@else<ul class="mt-4 space-y-3">@foreach($completed as $item)<li class="border p-4"><a class="underline" href="{{ route('curriculum.show',$item->lesson) }}">{{ $item->lesson->title }}</a><span class="ml-2 text-sm">Completed {{ $item->completed_at->format('d M Y') }}</span></li>@endforeach</ul>@endif</section>
<section class="mt-10"><h2 class="text-2xl font-semibold">Your assessment results</h2>
@if($assessmentAttempts->isEmpty())<p class="mt-3">No assessments submitted yet.</p>
@else<ul class="mt-4 space-y-3">@foreach($assessmentAttempts as $attempt)<li class="border p-4"><a class="underline" href="{{ route('assessments.show',$attempt->lesson) }}">{{ $attempt->lesson->title }}</a><p class="mt-1 text-sm">{{ $attempt->score_percent }}% · {{ str_replace('_',' ',$attempt->mastery_status) }} · {{ $attempt->submitted_at->format('d M Y') }}</p></li>@endforeach</ul>@endif</section>
<section class="mt-10"><h2 class="text-2xl font-semibold">Your writing practice</h2>
@if($writingDrafts->isEmpty())<p class="mt-3">No writing drafts saved yet.</p>
@else<ul class="mt-4 space-y-3">@foreach($writingDrafts as $draft)<li class="border p-4"><a class="underline" href="{{ route('curriculum.show',$draft->lesson) }}">{{ $draft->lesson->title }}</a><p class="mt-1 text-sm">Last edited {{ $draft->updated_at->format('d M Y') }} · Approximately {{ $draft->word_count }} words</p></li>@endforeach</ul>@endif</section>
@if(auth()->user()->is_content_editor)<p class="mt-8"><a class="underline" href="{{ route('authoring.index') }}">Open lesson authoring</a></p>@endif
<section class="mt-10 border-t pt-6"><h2 class="text-xl font-semibold">Research privacy</h2><p class="mt-2">Research participation is optional and separate from learning.</p><p class="mt-3"><a class="underline" href="{{ route('research.consent') }}">Manage research participation</a></p>
@if(auth()->user()->is_content_editor)<p class="mt-3"><a class="underline" href="{{ route('research.analytics') }}">View restricted research pilot summary</a></p>@endif</section>
<form method="POST" action="{{ route('logout') }}" class="mt-10">@csrf<button class="border border-black px-5 py-3">Sign out</button></form></main></body></html>