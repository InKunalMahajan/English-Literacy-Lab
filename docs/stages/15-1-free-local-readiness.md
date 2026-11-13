# Phase 15.1 — Free local development and readiness

**Status:** Local workflow committed. No hosting purchase or deployment.

## Windows PowerShell workflow
From `C:\Users\LENOVO\Documents\GitHub\English-Literacy-Lab`:
```powershell
git pull origin main
powershell -ExecutionPolicy Bypass -File .\scripts\check-local.ps1
php artisan serve
```
The script checks local dependencies, PHP, Composer manifest, tests, Vite build and routes. It **does not** alter your database, run migrations or change `.env`. The bypass applies to this process invocation; review the script before executing it.

## Local SQLite
In your existing `.env`, keep `APP_ENV=local`, `APP_DEBUG=true`, `DB_CONNECTION=sqlite`, and a valid local `DB_DATABASE` path or Laravel default. Do not overwrite an existing `.env` or regenerate its `APP_KEY`.

### Safe backup checklist
1. Stop `php artisan serve`, queue workers and all application writers before taking a file-level backup.
2. Identify the **actual** SQLite database path from your `.env` / Laravel configuration. Do not assume it is `database/database.sqlite`.
3. Use a SQLite-aware backup method (SQLite CLI `.backup` or an application-consistent database backup). Avoid blindly copying an active database because SQLite WAL sidecar files may contain uncheckpointed changes.
4. Store backups outside the repository, encrypted if they contain personal data. Never commit databases or backups to GitHub.
5. Restore a copy to a separate temporary database and verify its tables/data. Never overwrite your live local database as a test.
6. Keep your original application key securely; it may be required to read encrypted application data.

Example with SQLite CLI **only if installed** and after confirming the database path:
```powershell
sqlite3 "database/database.sqlite" ".backup 'C:/ELL-Backups/ell-backup.sqlite'"
```
Create the destination directory first. Replace both paths as needed. Do not use this command if your actual database path differs.

## Manual review (not automated)
- Keyboard-only navigation and visible focus on all pages
- ISL video transcript and written equivalents
- Text contrast, 200% zoom, responsive mobile layout and screen reader labels
- Learner drafts and private media inaccessible to other users
- Research consent/withdrawal and minimum-group privacy rules
- Verify GitHub Actions CI independently and commit reviewed dependency lockfiles

## Current release gate
**Not public-launch ready.** Hostinger hosting is not purchased, no staging deployment has occurred, and manual accessibility/privacy reviews and dependency lockfiles remain outstanding.
