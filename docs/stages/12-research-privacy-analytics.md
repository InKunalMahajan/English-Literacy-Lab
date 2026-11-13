# Phase 12 — Research, consent, privacy and analytics (pilot)

## Delivered
- Versioned, voluntary opt-in/withdrawal preference per learner.
- Participation is not required for lesson access, practice, or assessments.
- Authenticated consent page; only active users can change preferences.
- Restricted editor-only pilot analytics page with no public route or participant-level listing.
- Summary: distinct eligible participants, number of assessment attempts, mean assessment score.
- Only currently opted-in users and attempts recorded after their current consent timestamp are included.
- Minimum five eligible distinct participants required; otherwise no statistics are shown.
- Withdrawal excludes records from future live summary calculations; prior viewed/copied summaries cannot be recalled.
- No name/email, writing text, individual answer, user ID or per-learner export on the analytics page.
- Feature tests for opt-in, withdrawal, authorization and small-group suppression.

## Research ethics and deployment limitations
This is **not** a complete lawful research-consent framework, anonymisation guarantee or institutional ethics approval. The group summary is aggregated and access-controlled, not formally anonymised; small groups, repeated queries and external knowledge can still create disclosure risks.
- Obtain research ethics review, documented protocol and approved participant information before actual studies.
- Establish legal basis and privacy notice suitable for the relevant jurisdiction (including Indian DPDP obligations where applicable).
- Set retention/deletion policy, data subject rights workflow, breach procedures and research governance.
- For minors, obtain appropriate parent/guardian consent and child safeguarding protections; the pilot does not establish age or guardian identity.
- Provide ISL-accessible consent video and written equivalents reviewed by Deaf participants.
- Restrict research dashboard to separately authorized researchers before production; content-editor permission is only a pilot gate.
- Do not store or export identifiable research data or deploy with real learners until the above are completed.
- Current source assessment records remain in ordinary learning tables after research withdrawal; the live summary excludes them, but no automatic deletion is performed.
- No consent audit history, cohort filtering, downloadable datasets, differential privacy or publication workflow.

## Local verification
```powershell
git pull origin main
php artisan migrate
php artisan test --filter=ResearchPrivacyTest
php artisan test
npm run build
```
Visit /research/consent as a signed-in learner. Editors can visit /research/analytics. Keep research participation off until governance and consent materials are approved.
