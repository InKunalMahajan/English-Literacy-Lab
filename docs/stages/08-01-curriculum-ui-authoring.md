# Stage 8.1 — Curriculum structure, authoring, activities and UI

Standalone English Literacy Lab. No TEACH CMS or SignGyaan integration.

## Implemented
- Responsive black-and-white homepage, accessible navigation, public curriculum catalogue and lesson pages.
- Modules > Units > Lessons, with draft/published visibility.
- Editor-only module, unit, lesson and short-answer activity creation.
- Optional external HTTPS ISL video resource links, written ISL performance notes, hints and feedback.
- Editor access provisioned via local CLI, not public registration.
- Tests for authoring access, publication and activity visibility.

## Local setup
```powershell
git pull origin main
php artisan migrate
php artisan test
npm run build
```
To grant an **existing active user** editing rights, run `php artisan ell:grant-editor your-email@example.com` and confirm the prompt. Revoke with `php artisan ell:revoke-editor your-email@example.com`.

## Known limitations
- No editor UI for updating/deleting existing content, no ISL video upload/streaming, no progress persistence, no assessment scoring, no student data analytics, no research consent workflow.
- Short-answer matching trims whitespace and ignores case, but does not support synonyms, punctuation variation or linguistic evaluation.
- ISL media are external links only; independently verify captions, access rights, and quality.
- The authoring UI is a development MVP, not a complete editorial workflow.
- User self-registration and editor invitation are not provided. Existing users must be provisioned through a separate trusted process.
- Editor grants are manual CLI operations; use only with trusted administrators.
- Migration adds editor flag and curriculum tables; does not modify existing learner records.
- Do not use real student/research data until privacy and consent features are implemented.

## Verification
Tests/build are committed but not executed on the user's Windows environment. Run the commands above and share failures.
