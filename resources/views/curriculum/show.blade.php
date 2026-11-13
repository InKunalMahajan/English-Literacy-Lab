<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>{{ $lesson->title }} — ELL</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body><main class="mx-auto max-w-3xl px-6 py-12">
<a href="{{ route('curriculum.index') }}" class="underline">All lessons</a>
<p class="mt-8 text-sm">{{ $lesson->level }} · {{ $lesson->topic }}</p>
<h1 class="mt-2 text-3xl font-bold">{{ $lesson->title }}</h1>
<h2 class="mt-8 text-xl font-semibold">Learning outcome</h2>
<p class="mt-2">{{ $lesson->learning_outcome }}</p>
<h2 class="mt-8 text-xl font-semibold">Lesson</h2>
<div class="mt-2 whitespace-pre-line">{{ $lesson->content }}</div>
@if ($lesson->isl_guidance)
<h2 class="mt-8 text-xl font-semibold">Indian Sign Language guidance</h2>
<p class="mt-2 whitespace-pre-line">{{ $lesson->isl_guidance }}</p>
@endif
</main></body></html>
