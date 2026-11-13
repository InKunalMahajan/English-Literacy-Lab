<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard — English Literacy Lab</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<main class="mx-auto max-w-4xl px-6 py-16">
    <h1 class="text-3xl font-bold">Your learning dashboard</h1>
    <p class="mt-4">Signed in as {{ auth()->user()->name }}.</p>
    <p class="mt-4">Explore the independent English Literacy Lab curriculum.</p>
    <p class="mt-6"><a class="underline" href="{{ route('curriculum.index') }}">Browse English lessons</a></p>
    <form method="POST" action="{{ route('logout') }}" class="mt-8">
        @csrf
        <button type="submit" class="rounded border border-black px-5 py-3">Sign out</button>
    </form>
</main>
</body>
</html>
