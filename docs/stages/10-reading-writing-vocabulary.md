# Phase 10 — Reading, writing and vocabulary practice

## Delivered
- Reading-comprehension activity type, using the lesson text as the reading passage and an editor-authored question/expected answer.
- Existing vocabulary, grammar, flashcard and sentence-order exercises remain available.
- Private, authenticated writing practice per learner and lesson, with editable saved response.
- Maximum 10,000 characters, server-side validation and per-account isolation.
- Writing draft history in the learner dashboard.
- Draft/unpublished lesson gate and no guest writing persistence.
- Automated feature tests for writing privacy, editing, and authorization.

## Boundaries
- Reading answers are compared using the existing case-insensitive matching; no semantic understanding or AI grading.
- Writing is a practice journal, not a scored exam or reviewed submission.
- Word count uses PHP str_word_count and is approximate for multilingual input.
- No automatic spelling feedback, teacher feedback, writing history versions, export, plagiarism checks or formal assessments.
- No real student or research data should be used without the later privacy and consent work.

## Verify
```powershell
git pull origin main
php artisan migrate
php artisan test
npm run build
php artisan serve
```
Create a published lesson with a reading passage, add a reading-comprehension activity in /authoring, and save writing from its public lesson page after signing in.
