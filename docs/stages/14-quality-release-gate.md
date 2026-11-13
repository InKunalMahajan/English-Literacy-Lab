# Phase 14 — Quality assurance and release gate

## Changes delivered
- CI explicitly uses an in-memory SQLite test database and isolated test session/cache settings.
- PHP manifest validation, PHP syntax checks, Composer security audit, full PHPUnit tests, production npm dependency audit and Vite build.
- README now reflects the actual standalone application, not retired multi-institution planning.

## Outstanding release blockers
1. `composer.lock` and `package-lock.json` are missing from the repository. Generate them in a trusted local environment, review changes, commit both and use `npm ci` in CI.
2. Confirm all GitHub Actions jobs pass on the current branch; no successful run is claimed here.
3. Complete manual accessibility testing with keyboard, NVDA, VoiceOver, zoom, captions and ISL comprehension.
4. Perform security authorization testing on inactive users, guest users, editors and learners, including research routes and private media.
5. Complete privacy, child safeguarding, ethics, ISL consent and retention governance before inviting real research participants.
6. Validate a staging deployment using HTTPS, production configuration, persistent private media, backup/restore drills and rollback.
7. Check test fixture dependencies and validate the PHP environment for image processing; GD may be absent.

## Local verification (Windows PowerShell)
```powershell
git pull origin main
php artisan optimize:clear
php artisan test
npm run build
composer audit
npm audit --omit=dev --audit-level=high
```

If these commands fail, fix failures before considering a release. Do not commit `.env`, secret keys, actual student data or private media.

## Decision
**Release status: NOT APPROVED.** Phase 14 adds quality gates, but production readiness depends on passing CI, manual accessibility testing, privacy governance and staging verification.
