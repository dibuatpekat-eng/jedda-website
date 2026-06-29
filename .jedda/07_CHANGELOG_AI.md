# AI Changelog

Record engineering work chronologically.

## 2026-06-29 — Sprint 2 Product Page Excellence Recovery Checkpoint

- Added `27_PRODUCT_PAGE_EXCELLENCE_SPRINT_2.md`.
- Added Component Reverse Engineering as a permanent rule in `01_ENGINEERING_CONSTITUTION.md`.
- Added an initial Product Page Reverse Engineering map before any further PDP implementation.
- Documented the Sprint 2 PDP snippet incident and manual rollback.
- Confirmed the failed Sprint 2 active snippet markers were no longer present in served PDP HTML.
- Rechecked the logged-in browser/admin channel before reactivation; it still timed out before any snippet activation.
- Re-established stability through the upgraded extension-backed Chrome environment.
- Activated Code Snippets ID `13`: `JEDDA PDP Variant Validation - Sprint 2.1`.
- Tested PDP invalid add-to-cart with no variant selected; inline color/size guidance appeared, no loading state stuck, and cart stayed `0`.
- Pushed existing commits to `origin/main` before starting Milestone 2.2.
- Activated Code Snippets ID `18`: `JEDDA PDP Loading Feedback - Sprint 2.2 Active`.
- Deactivated superseded loading-feedback attempts in Code Snippets IDs `14`, `15`, `16`, and `17`.
- Tested invalid variant flow after 2.2; validation still owned the missing-variant state and no loading feedback appeared.
- Tested valid add-to-cart flow after 2.2; button changed to `Adding...` with `aria-busy="true"` and recovered after cart update.
- Activated Code Snippets ID `19`: `JEDDA PDP Success Feedback - Sprint 2.3 Active`.
- Evaluated success-feedback alternatives and selected subtle inline confirmation as the best fit for JEDDA's premium product-page experience.
- Owner manually verified staging PDP access, invalid/valid add-to-cart behavior, success feedback, and Code Snippets admin responsiveness in Chrome.
- Recorded the remaining Codex browser/CDP timeout as a tooling issue rather than a website issue.
- Recorded the likely observer-loop failure mode.
- Established a safer event-based implementation path for the next PDP invalid-variant guard.
- Added a kill-switch requirement for future staging frontend snippets before activation.
- No repository website code, payment settings, checkout logic, products, orders, plugins, or database rows were changed.

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
