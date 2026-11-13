<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Organisations — ELL</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body><main class="mx-auto max-w-3xl px-6 py-12">
<a href="{{ route('dashboard') }}" class="underline">Dashboard</a>
<h1 class="mt-6 text-3xl font-bold">Your organisations</h1>
<ul class="mt-8 space-y-4">
@forelse ($organizations as $organization)
<li><a class="underline" href="{{ route('organizations.show', $organization) }}">{{ $organization->name }}</a></li>
@empty
<li>No active organisation memberships are assigned to your account.</li>
@endforelse
</ul>
</main></body></html>
