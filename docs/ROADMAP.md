# English Literacy Lab — Independent Platform Roadmap

## Product boundary
ELL is a standalone English literacy, ISL-first learning and educational research website. It is independent from TEACH CMS and SignGyaan. No institution administration, campus management, multi-tenancy or cross-project integration.

## Delivery
| Stage | Scope | Status |
|---|---|---|
| 1–5 | Initial planning documents | Historical drafts; superseded where organisation-scoped |
| 6 | Laravel foundation, authentication, tests | Implemented locally; user confirmed tests passing |
| 7 | Individual account authentication | Initial implementation |
| 7.2 | Organisation access | Retired; legacy tables removed by forward migration |
| 8 | Curriculum catalogue, module/unit structure, editor lesson/activity CRUD, visual-text activities, individual practice progress and lesson completion | Implemented; local verification required for final activity-management update |
| 9 | Private lesson image uploads, alt text, HTTPS ISL video references, text equivalents, draft access protection and accessible media displays | Implemented in code; local verification pending |
| 10 | Reading comprehension questions, existing vocabulary exercises, private writing practice with revisions and learner dashboard drafts | Implemented in code; local verification pending |
| 11 | Untimed written lesson assessments, percentage scores, provisional mastery bands and private attempt history | Implemented in code; local verification pending |
| 12 | Versioned optional consent and withdrawal; restricted, small-group-suppressed descriptive assessment analytics | Pilot code implemented; local verification and ethics review pending |
| 13 | Baseline keyboard/reduced-motion CSS, security headers, automated checks and deployment checklist | Implemented in code; manual accessibility and deployment verification pending |
| 14 | Quality assurance CI, current setup documentation and release gates | Implemented in code; CI, lockfiles and manual checks pending |
| 15 | Production environment template, Nginx example, secure deployment runbook and launch gates | Preparation committed; hosting, domain and staging not configured |
| 15.1 | Free Windows local readiness script and SQLite backup guidance | Committed; user local verification pending |

## Architecture
Laravel 13, Blade, Tailwind CSS v4, Vite, SQLite for local development. Individual user accounts, publicly browsable published lessons, curriculum levels and learning outcomes. Do not put learner-sensitive or research data in public lesson content.

## Database change safety
The original organisation-creation migration remains in Git history for compatibility with existing local databases. A new forward migration drops its tables. This permanently deletes any organisation/member records in those tables: back up data before running migrations if any real data was entered.

## Verification
Run `php artisan migrate`, `php artisan test`, `npm run build`. Do not claim CI green until confirmed.
