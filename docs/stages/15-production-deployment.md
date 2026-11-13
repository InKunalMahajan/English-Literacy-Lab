# Phase 15 — Production deployment and website launch preparation

**Status: Preparation only. No host, domain, DNS, certificates or production data were modified.**

## Deployment architecture
- Linux VPS or managed Laravel host with supported PHP-FPM, Composer, Node build environment and HTTPS.
- Nginx document root points **only** to Laravel's `public/` directory.
- Private database, restricted application account and persistent storage for lesson images.
- Production secrets stored outside Git. Never copy local `.env` to public source control.
- Backups encrypted, stored off-host and regularly restore-tested.

## Preflight gates
1. Confirm domain, hosting provider, supported PHP version/extensions, database, file persistence and cost.
2. Commit reviewed `composer.lock` and `package-lock.json` from the trusted local development environment; verify CI.
3. Complete Phase 13 manual accessibility and ISL content audit.
4. Complete privacy/consent governance before using real learner or research records.
5. Run full tests, security audits, migrations on staging, browser smoke tests and backup/restore rehearsal.
6. Verify no debug pages, development server, exposed dotfiles, public database or local private media.

## Production environment
Use `.env.production.example` as a **template**, not a real secret file. Generate a unique `APP_KEY` once per environment and store it securely. Never regenerate the production key casually: encrypted data and sessions can become unreadable.
Use `APP_ENV=production`, `APP_DEBUG=false`, correct HTTPS `APP_URL`, `SESSION_SECURE_COOKIE=true`, and restricted DB credentials.
The template chooses MySQL for production; local SQLite can remain unchanged.

## Example manual release sequence (staging first)
From a reviewed, tested release checkout on the server:
```bash
composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
Before migration, take a verified database backup and plan rollback; **database migrations are not automatically reversible**. Ensure the `storage/` and `bootstrap/cache/` directories are writable by the application user but not publicly exposed. If using symlink-based releases, preserve the private storage and production `.env` across releases. Never run `php artisan key:generate` on an established production environment.

## Nginx and HTTPS
The sample `deploy/nginx/ell.conf.example` requires adaptation to actual domain, certificate path, PHP-FPM socket and deployment directory. Obtain and validate TLS before enabling the HTTPS block. Test with `nginx -t` and use a controlled reload. Check secure session cookies, HSTS behavior, redirects, private media authorization and health endpoint. Review any reverse proxy or CDN caching of private responses.

## Smoke tests after staging deployment
- Homepage, curriculum, login, dashboard and published lesson.
- Guest cannot access private dashboard, writing drafts, research consent or unpublished media.
- Editor-only authoring and analytics remain restricted.
- Lesson image upload and private retrieval persist after restart.
- Research opt-out removes learner from live pilot summary.
- Responsive layout, keyboard navigation, screen reader, written equivalents and ISL videos.
- Restore rehearsal succeeds and monitoring reports application errors.

## Rollback and incident response
- Keep previous tested release artifact and deploy revision.
- Restore application code first if safe; database rollback requires a separate tested restoration strategy.
- Maintain off-host encrypted backups and a recovery point/recovery time objective.
- Configure alerting, access/error logs without sensitive learner answers, incident contacts and secret rotation.

## Launch decision
**NOT READY FOR PUBLIC LAUNCH** until domain/hosting are selected, dependency lockfiles are committed, CI and staging pass, and accessibility/privacy reviews are completed.
