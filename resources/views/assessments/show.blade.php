<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Assessment — {{ $lesson->title }}</title>@vite(['resources/css/app.css','resources/js/app.js'])</head><body>
@include('partials.site-header')
<main id="main" class="mx-auto max-w-3xl px-6 py-12"><h1 class="text-3xl font-bold">Assessment: {{ $lesson->title }}</h1>
<p class="mt-3">Answer each question in written English. No timer or audio is required. This assessment uses exact-answer matching after ignoring capitalization and extra spaces; it does not evaluate the meaning of alternative answers.</p>
@if(session('assessment_result'))<p role="status" class="mt-5 border p-4 font-semibold">{{ session('assessment_result') }}</p>@endif
@if($errors->any())<div role="alert" class="mt-5 border p-4">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
@if($questions->isEmpty())<p class="mt-8">This lesson has no assessment questions yet.</p>
@else<form method="POST" action="{{ route('assessments.submit',$lesson) }}" class="mt-8 space-y-6">@csrf
@foreach($questions as $question)<fieldset class="border p-5"><legend class="px-2 font-semibold">Question {{ $loop->iteration }}</legend><p class="mt-2">{{ $question->prompt }}</p>
@if($question->visual_prompt)<p class="mt-3 whitespace-pre-line border-l-4 border-black p-3">{{ $question->visual_prompt }}</p>@endif
<label class="mt-4 block" for="answer-{{ $question->id }}">Your answer</label>
<input id="answer-{{ $question->id }}" name="answers[{{ $question->id }}]" maxlength="255" class="mt-1 w-full border p-3" value="{{ old('answers.'.$question->id) }}"></fieldset>@endforeach
<button class="bg-black px-6 py-3 font-semibold text-white">Submit assessment</button></form>@endif
<section class="mt-12 border-t pt-8"><h2 class="text-2xl font-semibold">Your previous results</h2>
@if($history->isEmpty())<p class="mt-3">No assessment attempts yet.</p>
@else<table class="mt-4 w-full border-collapse text-left"><thead><tr><th class="border-b p-2">Date</th><th class="border-b p-2">Score</th><th class="border-b p-2">Status</th></tr></thead><tbody>@foreach($history as $attempt)<tr><td class="border-b p-2">{{ $attempt->submitted_at->format('d M Y') }}</td><td class="border-b p-2">{{ $attempt->score_percent }}%</td><td class="border-b p-2">{{ str_replace('_',' ',$attempt->mastery_status) }}</td></tr>@endforeach</tbody></table>@endif
<p class="mt-4 text-sm">Mastered: 80–100%. Developing: 50–79%. Needs practice: below 50%. These are provisional practice thresholds, not validated academic proficiency levels.</p></section></main>
@include('partials.site-footer')
</body></html>