<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Research participation — English Literacy Lab</title>@vite(['resources/css/app.css','resources/js/app.js'])</head><body>
@include('partials.site-header')
<main id="main" class="mx-auto max-w-3xl px-6 py-12"><h1 class="text-3xl font-bold">Optional research participation</h1>
<p class="mt-4">You can use all learning lessons and assessments without joining research. Your choice does not change your learning scores or access.</p>
<section class="mt-7 border p-5"><h2 class="text-xl font-semibold">What this pilot preference means</h2>
<p class="mt-3">If you opt in, assessment scores created after you opt in may contribute to group-level statistics. The pilot dashboard shows only the number of participating learners, number of assessment attempts and average score, when at least five distinct consenting learners have submitted assessments.</p>
<p class="mt-3">The dashboard does not display your name, email, writing text or individual assessment results. You can withdraw at any time. Withdrawal excludes your records from future dashboard calculations, but cannot undo any summaries already viewed or recorded elsewhere.</p>
<p class="mt-3">This is a pilot preference mechanism, not an approved research study or complete legal consent notice. Do not enrol minors or begin real human-subject research until an approved protocol, lawful basis, safeguarding, retention rules and accessible consent materials are established.</p></section>
<p class="mt-5 font-semibold">Current choice: {{ $consent?->isCurrent() ? 'Opted in' : 'Not participating' }}</p>
@if(session('research_status'))<p role="status" class="mt-4 border p-4">{{ session('research_status') }}</p>@endif
<form method="POST" action="{{ route('research.consent.update') }}" class="mt-6 flex flex-wrap gap-3">@csrf
<button name="choice" value="opt_in" class="border border-black bg-black px-5 py-3 text-white">I choose to opt in</button>
<button name="choice" value="withdraw" class="border border-black px-5 py-3">Withdraw / do not participate</button>
</form><p class="mt-5 text-sm">Consent notice version: {{ \App\Models\ResearchConsent::POLICY_VERSION }}</p></main>
@include('partials.site-footer')
</body></html>