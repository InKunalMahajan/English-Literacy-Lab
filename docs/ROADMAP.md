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
| 9 | ISL media management, image assets, accessibility enhancements and richer interactive activities | Planned |
| 10 | Reading, writing and vocabulary practice | Planned |
| 11 | Formal assessments, scoring, mastery and research-ready learning metrics (separate from Stage 8 practice tracking) | Planned |
| 12 | Research ethics, consent and anonymised analytics | Planned |
| 13 | Accessibility review, hardening and deployment | Planned |

## Architecture
Laravel 13, Blade, Tailwind CSS v4, Vite, SQLite for local development. Individual user accounts, publicly browsable published lessons, curriculum levels and learning outcomes. Do not put learner-sensitive or research data in public lesson content.

## Database change safety
The original organisation-creation migration remains in Git history for compatibility with existing local databases. A new forward migration drops its tables. This permanently deletes any organisation/member records in those tables: back up data before running migrations if any real data was entered.

## Verification
Run `php artisan migrate`, `php artisan test`, `npm run build`. Do not claim CI green until confirmed.
