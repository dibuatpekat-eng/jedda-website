# AI Changelog

Record engineering work chronologically.

## 2026-06-29 — Sprint 2 Product Page Excellence Recovery Checkpoint

- Added `27_PRODUCT_PAGE_EXCELLENCE_SPRINT_2.md`.
- Documented the Sprint 2 PDP snippet incident and manual rollback.
- Confirmed the failed Sprint 2 active snippet markers were no longer present in served PDP HTML.
- Recorded the likely observer-loop failure mode.
- Established a safer event-based implementation path for the next PDP invalid-variant guard.
- Added a kill-switch requirement for future staging frontend snippets before activation.
- No website code, repository code, payment settings, checkout logic, products, orders, plugins, or database rows were changed.

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
