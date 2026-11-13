<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>English Curriculum — ELL</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body><main class="mx-auto max-w-3xl px-6 py-12">
<a href="{{ route('home') }}" class="underline">Home</a>
<h1 class="mt-6 text-3xl font-bold">English literacy lessons</h1>
<p class="mt-3">Accessible English learning with Indian Sign Language guidance.</p>
<ul class="mt-8 space-y-5">
@forelse ($lessons as $lesson)
<li class="border-b pb-4">
<p class="text-sm">{{ $lesson->level }} · {{ $lesson->topic }}</p>
<h2 class="mt-1 text-xl font-semibold"><a class="underline" href="{{ route('curriculum.show', $lesson) }}">{{ $lesson->title }}</a></h2>
<p class="mt-2">{{ $lesson->learning_outcome }}</p>
</li>
@empty
<li>No published lessons yet.</li>
@endforelse
</ul>
<div class="mt-8">{{ $lessons->links() }}</div>
</main></body></html>
