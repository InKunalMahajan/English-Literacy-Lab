# Stage 7 — Identity and Access (implementation in progress)

## Implemented in source
- Native Laravel session authentication: GET/POST /login and POST /logout.
- Regenerate session after successful login; invalidate session and rotate CSRF token at logout.
- No public registration, password reset emails or initial admin creation workflow.
- Account active flag checked on login.
- Initial users, organizations, organization_memberships, password_reset_tokens and sessions tables.
- Guest-only login page; authenticated dashboard with no student or research data.
- Authentication feature tests.

## Not implemented
- Role authorisation middleware, scoped tenant policies, campus hierarchy, invitation and provisioning workflows, verified email requirements, MFA, account lockouts, consent governance, full role taxonomy, password recovery, research access and admin CRUD.
- Existing authenticated sessions are not yet automatically revoked on account deactivation.
- Migrations and tests have not been executed in the owner's environment by this change.

## Deployment guardrails
- Never expose a public registration route or create default credentials.
- Do not store student or research records until tenant-scoped access control is implemented and tested.
- Before enabling real users, verify the configured login rate limiting, add administrator provisioning, deactivation session revocation and security review.
- Run `php artisan migrate:status`, `php artisan migrate`, `php artisan test` against an isolated development database.
