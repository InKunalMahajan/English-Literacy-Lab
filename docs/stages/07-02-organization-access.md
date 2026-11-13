# Stage 7.2 — Organisation-scoped access foundation

Implemented: read-only organisation list, organisation workspace and admin-only membership directory; permission mapping with role allowlists; denial of access for inactive users, memberships and organisations; cross-organisation access returns 404; automated isolation tests.

Roles in this initial policy: organization_admin, teacher, learner, curriculum_developer, researcher. These are **provisional** and not a complete production RBAC model. Membership roles are not yet constrained by the database; management UI and assignment permissions are not implemented.

Security limitations: No campus hierarchy, no audit logging, no invitation workflow, no multi-role membership, no enforced composite tenant foreign keys on future student records, no research consent enforcement. Never store sensitive student data until these are implemented and independently tested.

Local verification: run `php artisan test` after `git pull origin main`. No new migration is required for this change.
