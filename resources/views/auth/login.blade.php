<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in — English Literacy Lab</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main class="mx-auto max-w-md px-6 py-16">
        <a class="underline" href="{{ route('home') }}">English Literacy Lab</a>
        <h1 class="mt-8 text-3xl font-bold">Sign in</h1>
        <p class="mt-3 text-neutral-700">Accounts are created by an authorised administrator.</p>
        <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5">
            @csrf
            <div>
                <label for="email" class="block font-semibold">Email</label>
                <input id="email" name="email" type="email" autocomplete="username" required value="{{ old('email') }}" class="mt-2 w-full rounded border border-neutral-600 p-3">
                @error('email') <p role="alert" class="mt-2 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password" class="block font-semibold">Password</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required class="mt-2 w-full rounded border border-neutral-600 p-3">
                @error('password') <p role="alert" class="mt-2 text-sm">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="rounded bg-black px-6 py-3 font-semibold text-white">Sign in</button>
        </form>
    </main>
</body>
</html>
