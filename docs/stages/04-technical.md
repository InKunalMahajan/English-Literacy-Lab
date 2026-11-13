# Stage 4 — Technical Architecture (ELL-TECH-004)

**Status:** Architecture design draft.

## Core decisions
Modular Laravel monolith; Blade and Tailwind CSS v4; MySQL/InnoDB; scoped RBAC plus resource policies; private media storage; Redis-backed jobs; controlled analytics and research processing.

## Domain packages
Identity, Institutions, Curriculum, Content, Learning, Assessment, Instruction, Research, Reporting, Operations, Privacy.

## Layers
Presentation → HTTP/validation/policies → Application use cases → Domain services → Infrastructure persistence/storage/queues.

## Cross-cutting safeguards
Tenant-aware queries and composite FKs; immutable evidence; transaction boundaries; idempotent writes; private ISL media; audit logs; restricted research identity linkage; permission checks on export execution; versioned datasets and manifests.

## Delivery
Separate local, CI, staging and production environments. CI must include formatting, static analysis, unit, feature, integration, tenant-isolation, security and accessibility checks. Deployment requires backup/recovery and governance gates.

## Architecture dependencies
Physical schema, exact package compatibility, research approvals and approved retention policies remain prerequisites to sensitive implementation.

**Traceability:** ILL-TECH-004 → ELL-TECH-004.

## Database deployment clarification (13 Nov 2026)
Existing Windows XAMPP runs MariaDB 10.4.32 on port 3306. For ELL, the owner selected a separate MySQL 9.x server, planned port 3307 and dedicated data directory/service. This is a **planned environment change**, not an implemented database deployment. Avoid XAMPP data-directory reuse, service conflicts and committing local credentials.
