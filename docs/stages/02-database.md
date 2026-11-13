# Stage 2 — Database Architecture (ELL-DB-002)

**Status:** Logical design draft; not migration-ready.

## Standards
MySQL/InnoDB target; `utf8mb4`; snake_case; internal unsigned BIGINT keys; opaque public identifiers; UTC timestamps; tenant-owned records carry `organization_id`; tenant-safe composite relationships.

## Logical domains
Identity and access; institutions and enrolments; curriculum; stories and media; vocabulary and grammar; reading and activities; writing and assignments; assessment; instructional progress; research; reporting; operations and governance.

## Key entity families
- Identity: users, roles, permissions, role_assignments, account_security_events.
- Institutions: organizations, schools, classes, student_profiles, class_enrollments.
- Curriculum/content: curricula, curriculum_versions, lessons, stories, story_versions, story_sections, media_assets, vocabulary_terms.
- Learning: activities, reading_sessions, assignments, submissions, writing_revisions, portfolio_entries.
- Assessment: instruments, rubric_versions, criterion_scores, assessment_attempts, assessment_amendments.
- Research: research_studies, study_approvals, study_participants, consent_records, research_variables, research_observations, research_datasets, data_access_grants.
- Governance: audit_logs, export_requests, retention_policies, privacy_requests, legal_holds.

## Resolved architectural directions
Restrict hard deletion of evidence; enforce version references; typed research observation values; consent decision and authority history; separately permissioned participant identity linkage; approved export and retention workflows.

## Open blockers
Complete physical column specifications, nullability/defaults, exact composite foreign keys, unique indexes, cyclic FK handling, research linkage deployment and institution-approved retention schedules. No real student migrations until resolved.

**Traceability:** ILL-DB-002 → ELL-DB-002.
