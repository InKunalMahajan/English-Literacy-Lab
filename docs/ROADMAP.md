# ELL Development Roadmap

All stages are planning artefacts unless marked implemented.

| Stage | Scope | Status |
|---|---|---|
| 1 | Requirements and 24 modules | Draft |
| 2 | Logical database architecture | Draft; physical schema pending |
| 3 | ISL-first UI/UX and navigation | Conceptual draft |
| 4 | Laravel modular technical architecture | Design draft |
| 5 | Repository, migration and sprint planning | Draft |
| 6 | Sprint 01 environment, Laravel foundation, CI | In progress |

## Planned delivery sprints
00 Architecture readiness; 01 repository/CI; 02 identity/organisations; 03 RBAC/academic structure; 04 curriculum; 05 stories/language content; 06 ISL media; 07 assignments/reading; 08 writing/portfolio; 09 assessment; 10 instruction/progress; 11 research governance; 12 research data/reports; 13 hardening/pilot.

## Milestone gates
- Foundation: clean installation, build, tests and secret scanning.
- Institution: organisation isolation and scoped permissions.
- Learning: accessible ISL-first story and writing workflows.
- Assessment: immutable originals, versioned rubrics and audit.
- Research: approved protocols, lawful eligibility, restricted identity linkage and controlled exports.
- Release: accessibility, penetration testing, recovery and authorised sign-off.

## Immediate blocker
Confirm the XAMPP database engine/version and authenticated access before finalising MySQL configuration.

## Latest decision (13 Nov 2026)
**Stage 6 / Milestone 01:** PHP, Composer, Node/npm and Git checks passed. XAMPP MariaDB 10.4.32 authenticated successfully. Chosen direction: install independent MySQL 9.x on port 3307 while preserving MariaDB on 3306. **Pending:** select MySQL Windows ZIP and complete separate installation; Laravel foundation not yet started.

## Foundation repository implementation update
Committed application entrypoints, Laravel bootstrap and routes, Composer/NPM manifests, Tailwind/Vite, accessible landing page, test skeleton and CI workflow. These are **code committed**, not **tests passed** or **application running**. MySQL 9.x server setup remains pending.

## Stage 7 source update (13 Nov 2026)
Initial identity schema, organisation membership models, native Laravel login/logout, guest/auth route guards, login rate limiting, minimal dashboard and authentication tests committed. No administrator provisioning, full RBAC, campus hierarchy or tenant policy enforcement yet. Not verified by a green CI run. See `docs/stages/07-identity-access.md`.
