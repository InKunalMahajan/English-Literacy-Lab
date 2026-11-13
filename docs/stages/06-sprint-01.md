# Stage 6 — Sprint 01 Foundation (ELL-IMP-006)

**Status:** In progress. No Laravel application code committed yet.

## Milestones
1. Environment compatibility verification
2. Existing repository and Laravel 13 installation without starter kit
3. Modular domain folder scaffolding
4. MySQL, Blade, Tailwind CSS v4 and environment configuration
5. CI, automated tests, security checks
6. Sprint acceptance

## Observed local Windows environment (user-reported, 13 Nov 2026)
PHP 8.4.25; Composer 2.11.2; Node.js 24.19.0; npm 12.0.2; Git 2.55.0. PHP extensions include pdo_mysql, mysqli, mbstring, openssl, fileinfo, xml, curl and zip. Composer diagnose and global audit report no advisories after Composer update.

XAMPP client exists at `C:\xampp\mysql\bin\mysql.exe`; port 3306 accepts TCP connections. **Database engine/version and successful authenticated connection are not yet verified.** Do not assume this is MySQL 9.x; XAMPP may provide MariaDB.

## Next verification commands (PowerShell)
```powershell
& "C:\xampp\mysql\bin\mysql.exe" --version
& "C:\xampp\mysql\bin\mysql.exe" -u root -p
```
Then within the database client:
```sql
SELECT VERSION();
SELECT @@version_comment;
SHOW DATABASES;
```

Never commit `.env`, credentials, student records or research data. Verify existing working-tree changes before project creation.

## Sprint 01 acceptance
Clean installation; reproducible frontend build; passing automated tests; safe configuration; CI pipeline; documented module boundaries; no unresolved critical security findings.

## Database verification and decision — 13 Nov 2026
- Verified client: `C:\\xampp\\mysql\\bin\\mysql.exe`, MariaDB 10.4.32 (Win64).
- Verified authenticated server query: `10.4.32-MariaDB`, `mariadb.org binary distribution`.
- XAMPP MariaDB is reachable on `127.0.0.1:3306`.
- Decision: retain XAMPP unchanged; deploy MySQL 9.x separately for ELL on port `3307`, with its own binaries, data directory and planned service `MySQL9ELL`.
- Current step: select and verify an official Windows x64 MySQL Community Server ZIP archive. **No download, extraction, installation, service registration, schema creation or Laravel installation has been confirmed.**
- Next: user provides exact archive version/filename; verify compatibility, then extract and configure in small, reviewable steps.
- Do not commit credentials or `.env`.

## Repository implementation update (13 Nov 2026)
Committed 20 foundation files directly to GitHub: Laravel 13-oriented Composer manifest and bootstrap, artisan/public entrypoints, Blade landing page, Tailwind CSS v4/Vite, .env.example/.gitignore, initial PHPUnit tests, GitHub Actions workflow and development instructions. **Verification outstanding:** dependency installation, generated lockfiles, green CI, actual Windows runtime and MySQL 9.x. No feature modules or student/research database have been implemented. See `docs/DEVELOPMENT.md`.
