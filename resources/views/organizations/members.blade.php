<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Members — {{ $organization->name }}</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body><main class="mx-auto max-w-3xl px-6 py-12">
<a class="underline" href="{{ route('organizations.show', $organization) }}">Organisation</a>
<h1 class="mt-6 text-3xl font-bold">Members — {{ $organization->name }}</h1>
<table class="mt-8 w-full border-collapse text-left">
<thead><tr><th scope="col" class="border-b p-3">Name</th><th scope="col" class="border-b p-3">Role</th></tr></thead>
<tbody>@foreach ($memberships as $membership)<tr><td class="border-b p-3">{{ $membership->user->name }}</td><td class="border-b p-3">{{ str_replace('_', ' ', $membership->role) }}</td></tr>@endforeach</tbody>
</table>
</main></body></html>
