# Phase 13 — Accessibility, security and deployment readiness

## Implemented in code
- Web middleware adds `X-Content-Type-Options: nosniff`, `X-Frame-Options: DENY`, `Referrer-Policy: strict-origin-when-cross-origin` and a restrictive camera/microphone/geolocation Permissions Policy.
- Sensitive dashboard, research, assessment and authoring responses use `Cache-Control: private, no-store`.
- Production HTTPS responses set a one-year HSTS policy. Do not add `includeSubDomains` until all subdomains are HTTPS.
- Explicit keyboard focus outline and reduced-motion CSS.
- Automated feature tests for security headers and sensitive route caching.

## Manual accessibility audit checklist — not yet verified
Use keyboard-only navigation at 200% and 400% zoom on mobile and desktop.
1. Tab through homepage, curriculum, lesson, assessment, writing, research consent and editor workflows; visible focus and logical order.
2. Verify skip links, heading hierarchy, landmarks, field labels, instructions, validation errors and live status messages.
3. Check screen reader output using NVDA on Windows and VoiceOver on iOS/macOS.
4. Check 4.5:1 contrast for normal text and 3:1 for large text and meaningful non-text UI; inspect every hover, focus, disabled and error state.
5. Check no horizontal scrolling at 320 CSS px where reflow is required; verify large text and input spacing.
6. Verify every uploaded lesson image has meaningful alt text; decorative images should be treated appropriately.
7. Review every ISL video for accurate, synchronized captions, accessible written equivalent, player keyboard operation and clear signing visibility.
8. Test that instructions never rely only on sound, color, motion or time pressure.
9. Conduct usability sessions with Deaf learners, ISL users and other assistive-technology users.
10. Record each issue, severity, reproduction steps, owner and retest result. Target WCAG 2.2 AA; do not claim conformance until audited.

## Security review — still required
- Audit authorization on every write endpoint, especially editor content and media access; repeat tests with guests, inactive accounts and different users.
- Review CSRF, login throttling, session fixation protection, secure cookie settings and password reset/account recovery.
- Scan Composer and npm dependencies for known vulnerabilities; patch before release.
- Check user-generated external URLs for allowed protocols and phishing risks.
- Validate uploaded files by content and size; consider image re-encoding and malware scanning where operationally justified.
- Configure a carefully tested Content Security Policy compatible with Vite, external video links and any future media providers; CSP is not yet implemented.
- Review privacy obligations, consent materials, data deletion/export procedures and access logs.
- Do not expose SQLite database, `.env`, storage, logs, backup files or Git internals to the public web.
- Set up backups, restore drills, monitoring, audit logging, rate limits and incident response.
- Keep real learner data out of development, CI and demos.

## Production deployment checklist
1. Use a maintained PHP release compatible with Laravel 13 and install required extensions; check actual platform requirements.
2. Set `APP_ENV=production`, `APP_DEBUG=false`, a unique secret `APP_KEY`, correct `APP_URL`, and HTTPS-only cookies where appropriate. Never commit secrets.
3. Point the web server document root **only** at `public/`; deny dotfiles and configure HTTPS.
4. Choose a supported production database and persistent private media storage. SQLite requires careful backup and concurrency planning; use a server database if scale demands.
5. Install locked dependencies using `composer install --no-dev --optimize-autoloader` and `npm ci`; run `npm run build`.
6. Back up the database and storage; run `php artisan migrate --force` after reviewing migrations and deployment impact.
7. Run `php artisan config:cache`, `php artisan route:cache`, `php artisan view:cache`; ensure storage and bootstrap cache directories are writable by the application user only.
8. Configure trusted reverse proxy, session/cookie policy, logging, health checks, monitoring, rollback and restore procedures.
9. Run tests and accessibility checks in staging; verify image upload, private drafts, authentication, research consent withdrawal and access restrictions.
10. Review privacy/legal readiness before inviting real participants; Stage 12 is a pilot, not approved research governance.

## Local verification
```powershell
git pull origin main
php artisan test --filter=SecurityHeadersTest
php artisan test
npm run build
php artisan route:list
```

No production deployment was performed in this phase.
