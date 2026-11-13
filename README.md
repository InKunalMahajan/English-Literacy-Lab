# English Literacy Lab (ELL)

**Status:** Architecture and implementation planning; Laravel application not yet installed.

English Literacy Lab is an independent, multi-institution, **Indian Sign Language (ISL)-first** English literacy learning and educational research platform for Deaf learners. Written English learning, accessible ISL video, teacher assessment, student evidence and governed research are separate but connected capabilities.

## Planned technology
Laravel 13 (subject to environment verification), PHP 8.4, Blade, Tailwind CSS v4, MySQL/InnoDB (database engine to be confirmed), Redis queues, private object storage, PHPUnit/Pest, GitHub Actions.

## Project stages
| Stage | Document | Status |
|---|---|---|
| 1 | [Software Requirements](docs/stages/01-srs.md) | Drafted; not formally approved |
| 2 | [Database Architecture](docs/stages/02-database.md) | Drafted; physical schema pending |
| 3 | [UI/UX & Information Architecture](docs/stages/03-ux.md) | Conceptual draft |
| 4 | [Technical Architecture](docs/stages/04-technical.md) | Design draft |
| 5 | [Implementation Readiness](docs/stages/05-readiness.md) | Planning draft |
| 6 | [Sprint 01 Development](docs/stages/06-sprint-01.md) | In progress; environment verification |

**Important:** Stage documentation describes proposed design, not deployed features. Do not upload student records, research participant data, consent evidence, or private ISL videos to this public repository.

## Next actions
1. Confirm the database engine and version using the XAMPP MySQL client.
2. Verify repository working-tree status before installing Laravel in the existing clone.
3. Initialise Laravel without a starter kit.
4. Implement modular structure, configuration, CI and tests.
5. Finalise physical schema before real educational or research migrations.

See [Development Roadmap](docs/ROADMAP.md).

## Database setup decision (13 Nov 2026)
Existing XAMPP database was verified as **MariaDB 10.4.32**, accepting authenticated connections on port 3306. The selected approach is to install a **separate MySQL 9.x Community Server** for ELL on port 3307, with a separate data directory and Windows service (planned name `MySQL9ELL`). **Installation has not started; version and ZIP package still need confirmation.** XAMPP must remain unchanged.

## Implemented repository foundation (13 Nov 2026)
Added a Laravel 13-oriented application skeleton, Blade/Tailwind landing page, module-boundary development guide, PHPUnit feature tests and GitHub Actions CI workflow. **Not yet installed or verified:** Composer/NPM dependencies, lockfiles, database server, test execution or deployment. See [Development guide](docs/DEVELOPMENT.md).
