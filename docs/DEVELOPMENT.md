# Development foundation — Sprint 01

This repository now contains an **authored Laravel application foundation**, not a fully installed or verified Laravel project. Composer dependencies, frontend dependencies and the application have not been executed on the owner's Windows machine. CI is configured but has not yet been confirmed green.

## Windows local setup (after Git pull)
1. Ensure PHP 8.4, Composer 2.11 and Node 24 are available.
2. Run `composer install` (creates composer.lock if absent), then `npm install` (creates package-lock.json if absent).
3. Create required directories if missing: `storage/framework/cache`, `storage/framework/sessions`, `storage/framework/views`, `storage/logs`, `bootstrap/cache`.
4. Copy `.env.example` to `.env` and run `php artisan key:generate`.
5. Configure dedicated MySQL **only after** verifying installation and credentials; intended port 3307. Do not use XAMPP MariaDB data files or service.
6. Run `npm run build`, `php artisan test`, `php artisan serve`.
7. Commit both generated lock files after verifying successful installs.

## Modular architecture
The intended domain boundaries are Identity, Institutions, Curriculum, Content, Learning, Assessment, Instruction, Research, Reporting, Operations and Privacy. Do not add production student or research data until tenant policies, schema, consent controls and retention are implemented and tested.

## Known limitations
No database migrations, authentication, tenancy, RBAC, student content, ISL video, research capture or deployment are implemented yet. Test suite currently covers the landing page and health endpoint only. CI uses SQLite in memory to avoid reliance on a secret database server; MySQL integration tests are a future gate.
