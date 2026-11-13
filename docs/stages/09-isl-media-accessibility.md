# Phase 9 — ISL media and visual accessibility

## Delivered
- Editor-only JPEG, PNG and WebP uploads, maximum 4 MB, stored on the local Laravel disk (not the public disk).
- Required descriptive alt text for images.
- External HTTPS ISL video resources with required written transcript/text equivalent; no untrusted video embed.
- Editor media creation and deletion; permanent deletion requires DELETE confirmation.
- Public media access only for published lessons; authorized editors can preview draft media.
- Media ordering, titles and language codes.
- Responsive, keyboard-accessible learner display with image alt text and expandable video text equivalents.
- Tests for editor permissions, draft media isolation, required transcripts, upload and deletion.

## Media accessibility checklist
- Use images you own or are licensed to publish. Avoid personal or identifiable student images without appropriate permissions.
- Alt text describes the learning information in the image, not just "picture".
- Video links should be checked for captions, visual clarity, stable access and permission to share.
- Transcript or text equivalent should accurately represent the signing, including important visual details.
- Provide accessible alternatives for every meaningful media resource. No automatic transcription is claimed.
- Uploaded files are not scanned for malware; production deployment needs file scanning, limits, monitoring and backup policy.
- Local storage must be persistent and backed up in production. External videos are linked, not hosted.

## Limits
- No local video hosting or transcoding, no subtitle-file upload, no drag-and-drop exercise engine.
- No claims of certified WCAG compliance. Formal accessibility audit, manual keyboard testing and Deaf user review are still needed.
- Phase 9 focuses on visual media and text equivalents. Formal assessments and research features remain future phases.

## Windows verification
```powershell
git pull origin main
php artisan migrate
php artisan test
npm run build
php artisan serve
```
As an authorized editor, open /authoring, choose a lesson's Edit or delete link, and add media. Publish the lesson to test public visibility. Uploaded images do not require php artisan storage:link.
