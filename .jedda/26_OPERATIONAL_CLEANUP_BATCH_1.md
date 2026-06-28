# Batch 1 — Low-Risk Operational Cleanup

Status: Completed documentation + read-only capture; no destructive cleanup performed.
Date: 2026-06-28
Environment: Staging only, `https://beta.jeddawear.com`

## Scope

This batch executed the safest operational cleanup work before any customer-journey fixes or code refactor:

- Establish staging email safety policy.
- Verify and document WPCode / Code Snippets inventory before refactor.
- Capture baseline performance measurements before optimization.
- Identify safe cleanup paths for YaySMTP logs and Action Scheduler backlog.
- Classify runtime-unnecessary tools for later deactivation review.

No production changes were made.
No WordPress, WooCommerce, theme, or plugin updates were made.
No plugins were deactivated or removed.
No database rows were deleted.
No scheduled actions were run, cancelled, or deleted.
No real orders were created.

## Improvement 1 — Staging Email Safety Policy

### What Changed

VERIFIED: A clear staging email safety policy is now documented.

VERIFIED current risk:

- YaySMTP is active on staging.
- Mailer is configured as SMTP / Other SMTP.
- SMTP host is configured as `smtp.hostinger.com`.
- SMTP port is `465`.
- SMTP encryption is SSL.
- SMTP authentication is enabled.
- From email is a staging-domain sender.
- YaySMTP log saving is enabled.
- YaySMTP information type is full logging.
- YaySMTP retention is effectively forever.

Attempted low-risk UI change:

- Tried to change the staging SMTP host to a local fail-closed sink value (`127.0.0.1`) through the YaySMTP admin UI.
- The value appeared changed before save, but after reload it reverted to `smtp.hostinger.com`.
- Therefore, VERIFIED: the attempted setting change did not persist.
- Result: no effective email-delivery setting was changed.

### Policy

Staging must not send real customer/admin emails during checkout, order, account, password, or automation testing.

Before any full checkout/order QA:

1. Either disable outbound email delivery on staging, or route all staging email to a safe capture inbox/log-only sink.
2. Verify the policy persists after reload.
3. Verify the policy without creating a real order.
4. Document the exact rollback setting.

### Why

Earlier `.jedda` docs and this batch both confirm that staging email can behave like real SMTP delivery. Checkout/order QA is unsafe until staging email is fail-closed or safely captured.

### Expected Impact

- Prevent accidental customer/admin email during checkout QA.
- Make future cart/checkout testing safer.
- Reduce risk when testing order statuses, payment callbacks, account creation, and password flows.

### Rollback Plan

If a future staging email-safety change is applied:

- Restore previous SMTP host to `smtp.hostinger.com`.
- Restore previous port/encryption/auth settings as captured before the change.
- Do not store or commit SMTP password values in Git.
- Reload YaySMTP settings and confirm the expected values persist.

### Follow-Up Recommendation

Recommended next action: use a hosting-level mail sink, a staging-only SMTP capture service, or a plugin-supported disable-delivery option that can be verified after reload. Do not rely on the current YaySMTP UI save path until persistence is confirmed.

## Improvement 2 — Custom Code Export / Documentation Guard

### What Changed

VERIFIED: WPCode and Code Snippets inventories were re-captured before refactor.

Added repository safety guard:

- `.gitignore` now excludes `.jedda/private/`, `.jedda/exports-private/`, and common `.secret` export patterns.

This creates a safe place convention for future private raw exports while preventing accidental secret commits.

### Why

Raw snippet exports can contain credentials or external service keys. The engineering constitution says never commit secrets or credentials. Therefore:

- Commit sanitized manifests and dependency maps.
- Keep raw exports outside Git or inside ignored private export folders.
- Do not paste secret-bearing source into `.jedda` docs.

### WPCode Active Inventory

VERIFIED current active count: `22`.

| ID | Name | Type | Location | Status |
| ---: | --- | --- | --- | --- |
| 13948 | Jedda Launch — Form & Token | HTML | Site Wide Footer | Active |
| 13041 | Biar muncul notif pas klik buy now yg sold out | JS | Site Wide Header | Active |
| 13040 | color and size font | CSS | Site Wide Header | Active |
| 11836 | Untitled Snippet | JS | Site Wide Header | Active |
| 5163 | Pre Order Badge Mobile | JS | Site Wide Footer | Active |
| 5152 | Posisi Badge Preorder | JS | Site Wide Footer | Active |
| 4969 | Remove Pay Button - My Account Page (Agif) | PHP | Run Everywhere | Active |
| 3653 | Spacing "Add-ons" | JS | Site Wide Footer | Active |
| 3613 | Pre-Order Badge | JS | Site Wide Header | Active |
| 2644 | Hide Order Again Button (Agif) | JS | Site Wide Footer | Active |
| 2642 | Hide Dashboard Notification (Agif) | JS | Site Wide Footer | Active |
| 2531 | Adjust YayMail Column Span | PHP | Run Everywhere | Active |
| 2395 | Custom Login Styles (Agif) | JS | Site Wide Footer | Active |
| 2393 | Disable Hover Effect on Size Options (Agif) | PHP | Run Everywhere | Active |
| 2386 | Order Page Condition Status (Agif) | PHP | Site Wide Header | Active |
| 2385 | Payment Button for Customer Order Page (Agif) | PHP | Run Everywhere | Active |
| 2384 | Product Page - Out of Stock Button (Agif) | PHP | Frontend Only | Active |
| 2378 | CSS Out of Stock (Agif) | CSS | Site Wide Header | Active |
| 2366 | Order Received Page - Styling Button Etc (Agif) | PHP | Run Everywhere | Active |
| 2217 | JS Cart and Checkout | JS | Site Wide Header | Active |
| 2193 | CSS Cart & Checkout | CSS | Site Wide Header | Active |
| 2000 | SSS Sj | HTML | Site Wide Footer | Active |

Reference: functional risk mapping remains in `13_CUSTOM_CODE_MAP.md`.

### Code Snippets Inventory

VERIFIED current count:

- All snippets: `10`.
- Active snippets: `2`.
- Inactive snippets: `8`.
- Recently active: `1`.

VERIFIED active snippets:

| ID | Name | Type | Scope | Status |
| ---: | --- | --- | --- | --- |
| 7 | sss jam conditional code for thankyou page | PHP | Front-end | Active |
| 9 | benerin ]]] | PHP | Global | Active |

VERIFIED high-risk inactive reference:

| ID | Name | Type | Status | Note |
| ---: | --- | --- | --- | --- |
| 10 | Jedda Launch — WooCommerce Hook | PHP | Inactive | High risk if reactivated; prior docs indicate external service credential and order-hook side effects. |

### Expected Impact

- Future refactors can start from a verified active-snippet list.
- Secret-bearing exports are less likely to be committed accidentally.
- WPCode / Code Snippets consolidation can proceed with clearer ownership.

### Rollback Plan

- `.gitignore` change can be reverted if needed.
- No WPCode or Code Snippets runtime behavior was changed.
- If raw exports are later created, keep them ignored/private unless secrets are removed.

### Follow-Up Recommendation

Before moving any snippet into a child theme or custom plugin:

1. Export the raw snippet privately.
2. Redact secrets.
3. Classify business logic vs presentation.
4. Move one component surface at a time.
5. Disable the matching snippet only after parity testing.

## Improvement 3 — Baseline Performance Measurements

### What Changed

VERIFIED: New baseline timings were captured before optimization.

Measurement method:

- Browser automation in a logged-in admin session.
- Timed to `domcontentloaded`.
- Full `load` was not used as the primary metric because the homepage can visually render while full page load hangs on late assets or third-party requests.
- Results are staging/admin-session indicators, not production customer RUM.

### Baseline Timings

| Surface | DOMContentLoaded |
| --- | ---: |
| Frontend home | `1.353s` |
| Shop | `1.573s` |
| PDP Kiro Vest | `2.001s` |
| Cart | `1.447s` |
| Checkout view only | `1.022s` |
| Admin dashboard | `10.293s` |
| Products list | `9.056s` |
| Orders list | `6.839s` |
| Plugins list | `9.126s` |
| WooCommerce Status | `8.882s` |
| Action Scheduler | `6.024s` |
| YaySMTP settings/log shell | `6.092s` |
| WPCode active list | `3.005s` |
| Code Snippets active list | `5.433s` |

### Supporting Observations

- VERIFIED: Frontend pages are much faster than admin pages in the logged-in session.
- VERIFIED: Admin dashboard, products, plugins, Woo Status, Action Scheduler, YaySMTP, and Code Snippets remain slow enough to interrupt admin work.
- VERIFIED: Plugins page had very high notice/update noise in the captured DOM.
- VERIFIED: Admin pages repeatedly show Action Scheduler past-due notices and plugin/theme notices.

### Expected Impact

- Future cleanup work can be measured against a concrete baseline.
- We can separate frontend customer performance from admin operational performance.
- Optimizations can target the largest verified admin bottlenecks first.

### Rollback Plan

No runtime change was made.

### Follow-Up Recommendation

After each cleanup batch, re-measure the same surfaces using the same `domcontentloaded` method and note whether admin performance improved.

## Improvement 4 — YaySMTP Log Cleanup Plan

### What Changed

VERIFIED: Exact safe cleanup path is documented.

Current state:

- YaySMTP log saving is enabled.
- Full information logging is enabled.
- Retention value is `0`, interpreted by the UI as `Forever`.
- Prior docs verify `wp_yaysmtp_email_logs` is approximately `1230.20MB`, around 75% of total database size.

No logs were deleted in this batch.

### Recommended Cleanup Steps

1. Confirm a staging database backup exists.
2. Decide whether any historical email logs must be retained for business/customer-service reasons.
3. Export/archive logs only if needed.
4. Make staging email delivery safe first.
5. Change future logging from full to basic, if supported and verified after reload.
6. Set future retention to a limited window, if approved.
7. Prune old logs on staging only.
8. Re-measure database size and admin timing.

### What Requires Approval

- Any bulk delete/prune of YaySMTP logs.
- Any retention setting that may automatically delete logs.
- Any direct database operation.

### Expected Impact

High, because the YaySMTP log table is the largest known database bloat source.

### Rollback Plan

- Take database backup before pruning.
- If cleanup causes unexpected issues, restore the staging database backup.
- Keep an exported archive only if business/legal support requires it.

## Improvement 5 — Action Scheduler Cleanup Plan

### What Changed

VERIFIED: Action Scheduler cleanup candidates were classified read-only.

Current visible notice:

- `2354` past-due actions found.

Previously verified counts:

- All: `16059`.
- Complete: `4582`.
- Failed: `9103`.
- Pending: `2373`.
- Past-due: `2373`.

Observed failed-action groups:

- `woocommerce_admin/stored_state_setup_for_products/async/run_remote_notifications`
- `action_scheduler/migration_hook`
- `shopmagic/core/queue/execute`

Observed pending/past-due groups:

- `wc-admin_import_orders`
- `wc_admin_daily_wrapper`
- `woocommerce_cleanup_personal_data`
- `woocommerce_tracker_send_event_wrapper`
- `action_scheduler_run_recurring_actions_schedule_hook`

No actions were run, cancelled, or deleted in this batch.

### Recommended Cleanup Steps

1. Confirm staging backup exists.
2. Export/screenshot Action Scheduler counts and top failed hooks.
3. Treat old non-repeating failed actions with no registered callbacks as likely safe delete candidates after approval.
4. Investigate ShopMagic automation `id 2221` before deleting ShopMagic-related failures.
5. Do not run pending `wc-admin_import_orders` in bulk until Woo Admin import impact is understood.
6. Do not cancel recurring Woo hooks unless a plugin owner is known and the effect is understood.
7. Delete stale failed actions in one small group first.
8. Re-measure admin dashboard, Woo Status, and Action Scheduler.

### What Requires Approval

- Deleting failed actions.
- Cancelling pending actions.
- Running pending actions.
- Disabling ShopMagic.

### Expected Impact

Medium-high to high. The backlog creates admin notices, recurring checks, and operational noise.

### Rollback Plan

- Take database backup before any delete/cancel/run operation.
- Restore staging database backup if cleanup causes unexpected WooCommerce/Admin behavior.

## Improvement 6 — Runtime-Unnecessary Tool Classification

### What Changed

VERIFIED plugin state was re-captured:

- All plugins: `48`.
- Active: `40`.
- Inactive: `8`.
- Update available: `31`.

No plugins were disabled or removed.

### Later Deactivation Candidates

These appear unnecessary for normal storefront runtime and should be reviewed for staged deactivation later:

| Plugin / Tool | Current role | Risk if active | Later action |
| --- | --- | --- | --- |
| WPIDE | Admin file manager/code editor | Bypasses Git workflow and adds admin surface. | Deactivate on staging after confirming no active file-edit task. |
| WP Downgrade | Core version manipulation | High operational risk if misused. | Deactivate after update/rollback policy is documented. |
| WP Rollback | Plugin/theme rollback utility | Useful during maintenance, unnecessary always-on. | Keep only during controlled maintenance windows. |
| All-in-One WP Migration | Migration/export/import | Not needed for normal runtime. | Deactivate outside migration windows after backup policy is confirmed. |
| One Click Demo Import | Demo import | Not runtime needed. | Deactivate after confirming no demo import work is active. |
| Widget Importer & Exporter | Widget migration | Not runtime needed. | Deactivate outside migration windows. |
| WordPress Importer edited version | Edited content import plugin | Edited import-only plugin adds risk. | Deactivate after confirming theme demo import is not needed. |
| Customizer Export/Import | Theme option migration | Not runtime needed. | Keep only for theme-option export windows. |
| Hostinger Easy Onboarding | Host onboarding checklist | Not storefront runtime. | Deactivate if Hostinger does not require it. |
| Hostinger AI | Admin content helper | Not storefront runtime. | Deactivate if unused. |

### What Requires Approval

- Any plugin deactivation.
- Any plugin removal.
- Any plugin update.

### Expected Impact

Medium. Deactivation will reduce admin notices, update checks, menu clutter, and some admin-hook overhead, but it should happen one small group at a time.

### Rollback Plan

- Deactivate only on staging.
- Record exact plugin names and versions.
- Re-activate the plugin if any admin/frontend dependency breaks.
- Re-measure the same baseline pages.

## Batch 1 Result

Completed safely:

- Staging email safety policy established.
- YaySMTP current risk documented.
- Email setting change attempted but correctly not counted as complete because it did not persist after reload.
- WPCode active inventory re-verified.
- Code Snippets active/inactive inventory re-verified.
- Private export paths are now ignored by Git.
- Baseline performance measurements captured.
- YaySMTP log cleanup plan created.
- Action Scheduler cleanup plan created.
- Runtime-unnecessary tools classified for later review.

Blocked / requires follow-up:

- Actual staging email fail-closed setting still needs a verified save path or hosting-level mail sink.
- YaySMTP log pruning requires backup and explicit destructive-operation approval.
- Action Scheduler deletion/cancel/run requires backup and explicit destructive-operation approval.
- Plugin deactivation requires approval per plugin/group.

## Recommended Next Batch

Batch 2 should focus on making staging email truly safe through a verified method:

1. Use hosting-level mail sink or SMTP capture if available.
2. If not available, use a WordPress-supported disable-delivery mechanism that can be verified after reload.
3. Only after email safety is verified, run a safe checkout validation pass without placing real orders.

After that, proceed to YaySMTP log pruning and Action Scheduler stale-failed cleanup with backup in place.
