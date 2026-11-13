<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>{{ $organization->name }} — ELL</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body><main class="mx-auto max-w-3xl px-6 py-12">
<a class="underline" href="{{ route('organizations.index') }}">Your organisations</a>
<h1 class="mt-6 text-3xl font-bold">{{ $organization->name }}</h1>
<p class="mt-4 text-neutral-700">Organisation workspace. Learner records and research data are not available in this development stage.</p>
</main></body></html>
