# Phase 8 — Curriculum and learning foundation

## Scope
Standalone English Literacy Lab. No TEACH CMS, SignGyaan, campus administration or multi-tenant functionality.

## Delivered
- Black-and-white responsive homepage, curriculum catalogue and published lesson pages.
- Module > unit > lesson structure with editor-only authoring and draft/publish controls.
- Lesson create/edit/delete, with confirmation for permanent deletion.
- Activity create/edit/delete/reorder (sort_order), with confirmation for deletion.
- Short-answer, vocabulary, grammar, sentence-ordering and reveal-flashcard activities.
- Written visual scenes and ISL guidance; optional external HTTPS ISL video links.
- Guest practice without persistence; authenticated per-user attempts and correctness.
- Lesson completion requires all current activities answered correctly; per-user dashboard shows statistics, next lessons and completed lessons.
- Editing an activity resets its saved results and affected lesson completions. Deleting an activity resets affected lesson completions.
- Feature tests cover editor permissions, draft visibility, activity answers, learner isolation and completion.

## Boundaries
- Flashcards use a text reveal, not uploaded images. Sentence ordering uses typed responses, not draggable tiles.
- No local media upload, video hosting, captions validation, formal assessment scoring, research analytics or consent system.
- This is a curriculum/practice foundation; the later roadmap stages address media, richer exercises, assessments and research.
- Existing user accounts and local SQLite data remain; do not commit .env or learner records.

## Verify on Windows
```powershell
git pull origin main
php artisan migrate
php artisan test
npm run build
php artisan serve
```
Open /authoring to manage activities, /curriculum for public learning and /dashboard for signed-in progress.
Do not mark this final update verified until local tests/build pass.
