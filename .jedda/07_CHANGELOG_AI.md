# AI Changelog

Record engineering work chronologically.

## 2026-06-28 — Batch 1 Operational Cleanup

- Added `26_OPERATIONAL_CLEANUP_BATCH_1.md`.
- Established a documented staging email safety policy.
- Verified YaySMTP still uses real SMTP-style delivery and full forever logging.
- Attempted a low-risk YaySMTP SMTP-host sink change, but it did not persist after reload; no effective email setting change was made.
- Re-verified WPCode active snippet inventory.
- Re-verified Code Snippets active/inactive inventory.
- Captured baseline frontend/admin `domcontentloaded` performance measurements.
- Documented safe cleanup steps for YaySMTP logs and Action Scheduler backlog.
- Classified runtime-unnecessary tools for later staged deactivation review.
- Added `.gitignore` entries to prevent accidental commits of private `.jedda` exports or secret-bearing files.
