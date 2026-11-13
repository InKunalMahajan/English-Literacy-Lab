# English Literacy Lab (ELL)

A standalone, **Indian Sign Language (ISL)-first** English literacy learning website for Deaf learners. Built with Laravel 13, Blade, Tailwind CSS v4 and Vite.

**Status:** Active development. Not production-ready or approved for human-participant research.

## Implemented areas
- Individual login and learner dashboard.
- Published curriculum and editor-managed lessons, activities and media.
- Written English practice, lesson completion and private writing drafts.
- Untimed assessments with personal results and provisional mastery labels.
- Optional pilot research consent, withdrawal and restricted group statistics.
- Security response headers, accessibility baseline and test coverage.

ELL is independent from TEACH CMS and SignGyaan. It is not a multi-institution administration platform.

## Local setup (Windows PowerShell)
Prerequisites: compatible PHP, Composer, Node.js, npm and SQLite PHP extensions.

```powershell
composer install
npm install
Copy-Item .env.example .env
php artisan key:generate
```

Configure SQLite in `.env` (`DB_CONNECTION=sqlite`). Create `database/database.sqlite` if needed, then:

```powershell
php artisan migrate
php artisan test
npm run build
php artisan serve
```

For an existing local clone, use `git pull origin main` first. **Never overwrite an existing `.env` or regenerate a working application key without a recovery plan.**

## Release quality checks
```powershell
php artisan optimize:clear
php artisan test
npm run build
php artisan route:list
composer audit
npm audit --omit=dev --audit-level=high
```

GitHub Actions also runs automated checks. The repository currently does **not** include committed `composer.lock` or `package-lock.json`; therefore dependency resolution is not fully reproducible. Generate and review lockfiles locally before release and switch CI to `npm ci` when `package-lock.json` is committed.

## Release gates
Do not deploy for real learners until all automated tests pass, manual WCAG 2.2 AA accessibility checks and ISL content reviews are completed, production secrets/HTTPS/backups are configured, and privacy/consent governance is approved.

See [Roadmap](docs/ROADMAP.md), [Accessibility audit](docs/ACCESSIBILITY_AUDIT.md), [Phase 13 deployment checklist](docs/stages/13-accessibility-security-deployment.md), and [Phase 14 release gate](docs/stages/14-quality-release-gate.md).

Do not commit `.env`, credentials, learner records, research participant data or private ISL videos.
