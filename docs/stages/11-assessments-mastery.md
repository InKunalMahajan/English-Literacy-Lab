# Phase 11 — Assessments, scoring and provisional mastery

## Implemented
- Signed-in, active learners can open an untimed assessment for any published lesson.
- Questions reuse lesson activities except flashcards; no answer keys appear in assessment HTML.
- Submitted answers are compared using the existing whitespace/case-insensitive exact-answer rule.
- Score = rounded percentage of correctly answered questions; all questions count equally.
- Provisional status bands: mastered >=80%, developing >=50%, needs_practice <50%.
- Each submission creates an immutable score summary (not individual answer text) tied to the current learner.
- Personal attempt history appears on the assessment page and dashboard, with draft access blocked.
- Rate limit: five assessment submissions per minute per configured Laravel throttle.
- Automated tests cover scoring, access control, account isolation and exclusion of flashcards.

## Important limitations
- This is a simple auto-scored practice assessment, **not** a validated formal exam, psychometric mastery system, or research-ready analytics.
- Exact-answer checking can reject valid synonyms, alternate phrasing and punctuation. Writing journals are not auto-scored.
- No timer, negative marking, randomization, rubric-based marking, question versioning or proctoring.
- Previous assessment summaries remain historical when lesson activities are edited; results are not recalculated. Avoid comparing scores across changed question sets.
- Only last ten attempts display on the dashboard and lesson page; database retains older records.
- No research data export or consent workflow. Do not use real sensitive learner data until privacy safeguards are implemented.

## Verify
```powershell
git pull origin main
php artisan migrate
php artisan test
npm run build
php artisan serve
```
Publish a lesson with at least one non-flashcard activity, sign in, open the lesson, choose Open lesson assessment, submit answers, and inspect /dashboard.
