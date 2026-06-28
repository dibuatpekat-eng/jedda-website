# Engineering Cleanup Roadmap

Status: Phase 5 planning-only roadmap completed on 2026-06-28.

Scope: This roadmap converts Phase 1-4 audit findings into a safe improvement sequence. No WordPress settings, plugins, code, database rows, products, orders, payments, emails, or deployment state were changed.

## Executive Direction

The cleanup should start with low-risk operational safety and admin performance work before custom-code refactoring or new features.

Recommended first batch: Batch 1 - Low-risk operational cleanup.

Why:

- It reduces risk before any deeper work.
- It prepares safe checkout testing by addressing staging email risk.
- It targets high-impact issues already proven by evidence: YaySMTP logs, Action Scheduler backlog, staging email, and admin-only tooling.
- It does not require redesigning the site or changing customer-facing commerce logic.

## Roadmap Principles

- Work on staging first.
- Backup before every cleanup batch.
- Prefer reversible changes.
- Measure before and after each batch.
- Do not update WooCommerce, plugins, or theme until compatibility risks are mapped.
- Do not remove a plugin unless its dependency is documented or tested.
- Keep production untouched until explicitly approved.

## Immediate Quick Wins

These are the lowest-risk, highest-impact actions to test on staging first.

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Create a verified staging backup and restore point. | High | Low | Small | Hosting or backup tool access. | Yes |
| 2 | Set staging email safety policy before checkout/order testing. | High | Low-Medium | Small | YaySMTP or hosting SMTP settings; decision on disable vs capture/redirect. | Yes |
| 3 | Export/document YaySMTP current settings and log-retention state. | Medium | Low | Small | WP admin read-only/settings access. | Yes if settings are changed |
| 4 | Prune/archive YaySMTP logs on staging after backup. | High | Medium | Small-Medium | Backup; confirmation that logs are not needed for disputes/audit. | Yes |
| 5 | Review Action Scheduler failed/past-due actions and classify safe cleanup candidates. | High | Low | Medium | Read-only Action Scheduler review first. | Yes before deleting/running actions |
| 6 | Dismiss non-critical admin notices only after documenting them. | Low-Medium | Low | Small | Screenshots/notes of current notices. | Yes |
| 7 | Identify admin-only plugins safe to deactivate on staging. | Medium | Low-Medium | Medium | Plugin dependency list and rollback plan. | Yes before deactivation |

## Performance Fix Plan

### YaySMTP Logs

Evidence:

- VERIFIED: `wp_yaysmtp_email_logs` is `1230.20MB`.
- VERIFIED: Total database size is `1641.15MB`.
- VERIFIED: YaySMTP full logging is enabled.

Plan:

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Confirm whether logs are needed for business/legal/customer-service purposes. | High | Low | Small | Founder/business decision. | Yes |
| 2 | Backup database before touching logs. | High | Low | Small-Medium | Hosting/backup access. | Yes |
| 3 | Configure staging email safety and log-retention policy. | High | Low-Medium | Small | YaySMTP settings. | Yes |
| 4 | Archive/export logs if needed, then prune logs on staging. | High | Medium | Medium | Backup and export path. | Yes |
| 5 | Re-measure admin dashboard, YaySMTP logs page, Woo Status, and database size. | High | Low | Small | Browser/admin access. | No if read-only |

Recommended order: complete this before Action Scheduler cleanup because it directly addresses the largest table and staging email risk.

### Action Scheduler Backlog

Evidence:

- VERIFIED: `16059` actions total.
- VERIFIED: `9103` failed.
- VERIFIED: `2373` pending/past-due.
- VERIFIED: Failed hooks include WooCommerce Admin, Action Scheduler migration, and ShopMagic.

Plan:

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Export/screenshot Action Scheduler status counts and top failed hooks. | Medium | Low | Small | WP admin. | No |
| 2 | Identify stale failed actions older than launch-critical windows. | High | Low | Medium | Action Scheduler review. | No if read-only |
| 3 | Investigate ShopMagic dependency before cleanup. | High | Low | Medium | ShopMagic screen/logs. | No if read-only |
| 4 | Delete stale failed actions on staging only. | High | Medium | Medium | Backup; approval. | Yes |
| 5 | Run or allow pending actions only if hook owners are known. | High | Medium-High | Medium | Plugin dependency review. | Yes |
| 6 | Re-measure admin pages and scheduled-action notice state. | High | Low | Small | Browser/admin access. | No if read-only |

Recommended order: do not bulk-delete until ShopMagic and WooCommerce Admin hook ownership is understood.

### WooCommerce Admin Performance

Evidence:

- VERIFIED: WooCommerce Admin home loads around `7.40s`.
- VERIFIED: Orders list loads around `7-10s`.
- VERIFIED: Woo order/user/meta tables are material.

Plan:

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Establish baseline timing for Dashboard, Orders, Products, Pages, Plugins, Woo Status. | High | Low | Small | Browser/admin access. | No |
| 2 | Reduce log/queue bloat first. | High | Medium | Medium | YaySMTP and Action Scheduler cleanup. | Yes |
| 3 | Audit WooCommerce Admin notices/background features after backlog cleanup. | Medium | Low | Medium | Woo Status and Action Scheduler. | No if read-only |
| 4 | Use Query Monitor briefly on staging to identify slow queries/hooks. | High | Medium | Medium | Plugin install/activation approval; staging only. | Yes |
| 5 | Consider WooCommerce updates only after template/snippet risks are addressed. | High | High | Large | Backup, compatibility plan, custom-code mapping. | Yes |

Recommended order: measure, clean logs/queues, then profile. Profiling before cleanup may over-index on noise.

### Object Cache

Evidence:

- VERIFIED: External object cache is absent.
- VERIFIED: `WP_CACHE` is disabled.
- VERIFIED: Site Health recommends persistent object cache.

Plan:

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Verify Hostinger plan support for Redis/Memcached/LiteSpeed object cache. | Medium | Low | Small | Hosting panel access. | No if read-only |
| 2 | Test object cache on staging only. | High | Medium | Medium | Backup; host support; cache plugin/config. | Yes |
| 3 | Re-measure admin pages after enabling. | High | Low | Small | Browser/admin access. | No |
| 4 | Document cache purge/disable rollback process. | High | Low | Small | Hosting/cache settings. | Yes if config changes |

Recommended order: after log/Action Scheduler cleanup, so object-cache impact can be measured cleanly.

### Unnecessary Admin / Runtime Tools

Evidence:

- VERIFIED active admin/runtime tools include WPIDE, WP Downgrade, WP Rollback, All-in-One WP Migration, One Click Demo Import, Widget Importer & Exporter, WordPress Importer edited version, and Customizer Export/Import.

Plan:

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Classify each tool as required, migration-only, maintenance-only, or remove. | Medium | Low | Small | Plugin inventory. | No |
| 2 | Confirm no current migration/import/editor task depends on each tool. | Medium | Low | Small | Founder/developer confirmation. | Yes |
| 3 | Deactivate one low-risk utility at a time on staging. | Medium | Low-Medium | Medium | Backup; rollback plan. | Yes |
| 4 | Re-measure admin pages after each small group. | Medium | Low | Small | Browser/admin access. | No |
| 5 | Remove only after a stable observation window. | Medium | Medium | Medium | Staging validation. | Yes |

Recommended order: deactivate before deleting; group tools by role, not all at once.

## Plugin Cleanup Plan

### Essential Plugins

Keep until a replacement plan exists.

| Plugin | Reason | Risk | Future direction |
| --- | --- | --- | --- |
| WooCommerce | Commerce core. | High if updated casually. | Keep; update through staged compatibility plan. |
| Midtrans - WooCommerce Payment Gateway | Payment gateway. | High. | Keep; verify sandbox/live separation. |
| Epeken All Kurir - Full Version | Shipping rates/couriers. | High. | Keep; audit detailed config. |
| WPBakery Page Builder | Page content/layout dependency. | Medium. | Keep until redesign/rebuild. |
| Dahz Commerce Extender / Shortcode | Upscale theme dependency. | Medium. | Keep while Upscale is active. |
| Variation Swatches for WooCommerce | Product color/size UX. | Medium. | Keep short term; styling moves to child theme. |
| WooCommerce Price Based on Country | Regional pricing. | Medium. | Keep if international pricing remains. |
| YayMail | Email templates. | Medium. | Keep short term; export templates. |
| YaySMTP | SMTP delivery/logging. | High on staging. | Keep only with safe staging policy and retention. |

### Optional Plugins

Keep only if active business use is confirmed.

| Plugin | Decision needed | Recommended order |
| --- | --- | ---: |
| Slider Revolution | Confirm active modules/pages. | 3 |
| Dahz Portfolio | Confirm portfolio use. | 3 |
| Contact Form 7 | Confirm active forms. | 2 |
| CTX Feed | Confirm product feed owners/endpoints. | 3 |
| GTM4WP | Confirm tracking container ownership and staging policy. | 2 |
| Advanced Shipment Tracking | Confirm operations uses tracking. | 3 |
| Checkout Field Editor | Export and verify field map. | 2 |
| Maximum Products per User free/pro | Verify active limits and launch dependency. | 3 |
| ShopMagic | Verify hidden/legacy automation dependency. | 1 |

### Replaceable Plugins

Good candidates for future custom code or consolidation.

| Plugin | Replace with | Impact | Risk | Approval needed |
| --- | --- | --- | --- | --- |
| WPCode Lite | Custom site plugin + child theme. | High maintainability. | High if rushed. | Yes |
| Code Snippets | Custom site plugin + child theme. | High maintainability. | Medium-High. | Yes |
| Maximum Products per User | Custom plugin rules if limits are simple. | Medium. | Medium. | Yes |
| Checkout Field Editor | Custom plugin checkout fields if critical. | Medium. | Medium. | Yes |
| Product badge snippets / Advanced Woo Labels | Child theme or one plugin strategy. | Medium. | Medium. | Yes |

### Risky Plugins

| Plugin | Risk | Recommended order |
| --- | --- | ---: |
| WPIDE | Admin-side file edits bypass Git. | 1 |
| WP Downgrade | Core version manipulation risk. | 1 |
| WP Rollback | Useful during maintenance but risky always-on. | 1 |
| WordPress Importer edited version | Edited plugin, import-only role. | 1 |
| ShopMagic | Failed scheduled actions and unclear active use. | 1 |
| YaySMTP | Huge logs and staging email risk. | 1 |

### Plugins To Eventually Remove Or Consolidate

| Group | Plugins | Recommended path |
| --- | --- | --- |
| Migration/import tools | All-in-One WP Migration, One Click Demo Import, Widget Importer & Exporter, WordPress Importer edited version, Customizer Export/Import | Keep only during migration windows; deactivate first, remove later. |
| Rollback/development tools | WPIDE, WP Downgrade, WP Rollback | Disable after backup/export and admin workflow migration to Git. |
| PDF/invoice/labels | WebToffee PDF/labels, PDF Invoices & Packing Slips, Customizer for WooCommerce PDF Invoices, WooCommerce Shipping Labels/Dispatch Labels Pro | Choose one operational document stack. |
| Marketing/email candidates | Mailchimp for WooCommerce, MC4WP, MailPoet, MailPoet Premium, ShopMagic | Choose one marketing automation direction. |
| Launch/waiting room | Queue-Fair inactive, custom Supabase launch flow | Avoid running both; decide architecture before launch feature work. |

## Custom Code Refactor Plan

### WPCode

Current state:

- VERIFIED: `22` active snippets.
- VERIFIED: Snippets affect launch/waitlist, checkout, cart, order received, payment links, My Account, product availability, badges, email layout, login styling, and product/search UI.

Plan:

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Export every WPCode snippet into version-controlled reference files. | High | Low | Medium | WP admin read-only/export. | Yes if export action required |
| 2 | Classify snippets as business logic, presentation, obsolete, or temporary. | High | Low | Medium | Existing custom code map. | No |
| 3 | Move presentation CSS/JS to child theme in small groups. | High | Medium | Large | Child theme. | Yes |
| 4 | Move business rules to custom site plugin. | High | Medium-High | Large | Custom plugin scaffold/tests. | Yes |
| 5 | Disable matching WPCode snippets only after parity testing. | High | Medium | Large | Staging validation. | Yes |

Recommended order: export first, then classify, then migrate one surface at a time.

### Code Snippets

Current state:

- VERIFIED: `2` active snippets.
- VERIFIED: One controls thank-you order text.
- VERIFIED: One globally removes direct body text nodes.

Plan:

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Export active snippets and relevant inactive launch hook. | High | Low | Small | WP admin. | Yes if export action required |
| 2 | Replace thank-you status text with custom plugin filter. | Medium | Medium | Small-Medium | Custom plugin. | Yes |
| 3 | Investigate original reason for `benerin ]]]`. | High | Low | Small | Visual/content inspection. | No if read-only |
| 4 | Remove or replace global body text-node removal narrowly. | High | Medium | Small-Medium | Staging visual QA. | Yes |

### Parent Theme Overrides

Current state:

- VERIFIED: No active child theme.
- VERIFIED: Parent theme `functions.php` has custom additions.
- VERIFIED: Parent theme WooCommerce override `archive-product.php` is outdated.

Plan:

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Export/read parent theme customizations into repository references. | High | Low | Medium | Theme file access. | No if read-only |
| 2 | Create child theme on staging. | High | Medium | Medium | Backup; theme plan. | Yes |
| 3 | Move JEDDA-specific `functions.php` additions to child theme or plugin. | High | Medium | Medium | Child theme/custom plugin. | Yes |
| 4 | Rebase WooCommerce overrides against current Woo templates. | High | High | Large | WooCommerce compatibility plan. | Yes |

### Child Theme Strategy

Use the child theme for:

- Product visual behavior.
- Product badges and swatches styling.
- Cart, checkout, account, order-received CSS.
- Login form styling.
- Template overrides after rebasing.

Do not use child theme for:

- Payment state changes.
- Launch token validation.
- Order status business rules.
- External API integrations.

### Custom Site Plugin Strategy

Use a custom site plugin for:

- Launch/waitlist server-side logic.
- Supabase integration and secrets handling.
- WooCommerce order meta and order-status hooks.
- Payment action rules.
- Checkout account creation rules.
- Order/customer status messaging.
- Email-related filters that affect business communication.

Recommended first custom-plugin milestone:

1. Scaffold plugin with no behavior.
2. Add one low-risk filter, such as thank-you status text.
3. Test parity.
4. Migrate more risky rules only after the pattern is proven.

## Staging Safety Plan

### Email Safety

Current state:

- VERIFIED: WooCommerce emails are enabled.
- VERIFIED: YaySMTP `Disable delivery` is unchecked.
- VERIFIED: YaySMTP logs include successful WooCommerce emails.

Plan:

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Decide staging email policy: disable delivery, capture, or redirect all. | High | Low | Small | Founder decision. | Yes |
| 2 | Apply policy on staging. | High | Medium | Small | YaySMTP/hosting settings. | Yes |
| 3 | Verify no real customer/admin emails can send. | High | Low | Small | Safe test email method. | Yes before sending test |
| 4 | Document policy in `.jedda/05_DEPLOYMENT.md`. | Medium | Low | Small | Verification. | Yes |

### Indexing

Current state:

- VERIFIED: `robots.txt` blocks crawlers with `Disallow: /`.
- VERIFIED: WordPress discourage indexing setting is unchecked.
- VERIFIED: User reported saving that setting errors.

Plan:

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Keep existing robots block until better protection is verified. | High | Low | None | Current state. | No |
| 2 | Investigate Reading Settings save error from logs. | Medium | Low | Medium | Hosting/PHP logs. | No if read-only |
| 3 | Prefer hosting/server password protection for staging. | High | Medium | Small-Medium | Hosting access. | Yes |
| 4 | Re-test unauthenticated public access. | High | Low | Small | Browser. | No |

### Payment Sandbox

Current state:

- VERIFIED: Midtrans sandbox is enabled.
- VERIFIED: Main Midtrans gateway is enabled.

Plan:

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Preserve Midtrans sandbox on staging. | High | Low | None | Current state. | No |
| 2 | Verify Midtrans dashboard URLs later if dashboard access is available. | High | Low | Small | Midtrans access. | No if read-only |
| 3 | Use safe sandbox VA/bank-transfer checkout test first. | High | Medium | Medium | Email safety, shipping readiness, test product. | Yes |

### Checkout Test Readiness

Do not run full checkout tests until:

- Staging email safety is active.
- Midtrans sandbox is verified.
- Shipping/Epeken settings are read and documented.
- Test product/order plan is approved.
- Expected order status behavior is documented.
- Any real customer notification risk is removed.

## Suggested Fix Batches

### Batch 1: Low-Risk Operational Cleanup

Goal: Make staging safer and prepare the site for cleanup work.

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Verify backup and restore path. | High | Low | Small-Medium | Hosting/backup access. | Yes |
| 2 | Apply staging email safety policy. | High | Medium | Small | YaySMTP/hosting access. | Yes |
| 3 | Document current admin notices and plugin update pressure. | Medium | Low | Small | Admin access. | No |
| 4 | Export current WPCode/Code Snippets as references. | High | Low | Medium | WP admin. | Yes if export action required |
| 5 | Establish timing baseline before fixes. | Medium | Low | Small | Browser/admin. | No |

Recommended order: execute first.

### Batch 2: Admin Performance Cleanup

Goal: Reduce proven admin bottlenecks without changing customer-facing behavior.

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Archive/prune YaySMTP logs on staging. | High | Medium | Medium | Batch 1 backup/email policy. | Yes |
| 2 | Configure log retention. | High | Low-Medium | Small | YaySMTP settings. | Yes |
| 3 | Classify Action Scheduler failed/past-due actions. | High | Low | Medium | Action Scheduler review. | No if read-only |
| 4 | Clean stale failed actions on staging. | High | Medium | Medium | Classification and backup. | Yes |
| 5 | Re-measure admin pages. | High | Low | Small | Browser/admin. | No |
| 6 | Test object cache on staging if hosting supports it. | Medium-High | Medium | Medium | Hosting/cache access. | Yes |

### Batch 3: Plugin Rationalization

Goal: Reduce plugin surface safely.

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Audit ShopMagic dependency and failed actions. | High | Low-Medium | Medium | Admin read-only. | No if read-only |
| 2 | Deactivate admin-only utilities one group at a time on staging. | Medium | Medium | Medium | Backup; rollback plan. | Yes |
| 3 | Choose one invoice/PDF/shipping-label stack. | Medium | Medium | Medium | Operations decision. | Yes |
| 4 | Choose one marketing/email stack. | Medium | Medium | Medium | Business decision. | Yes |
| 5 | Remove unused inactive plugins/themes only after stable observation. | Low-Medium | Medium | Small-Medium | Staging validation. | Yes |

### Batch 4: Custom Code Architecture

Goal: Move durable logic out of admin snippets and parent theme.

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Scaffold child theme on staging. | High | Medium | Medium | Backup. | Yes |
| 2 | Scaffold custom site plugin with no behavior. | High | Low-Medium | Small-Medium | Repo/code deployment path. | Yes |
| 3 | Migrate low-risk snippet first. | Medium | Medium | Medium | Plugin scaffold. | Yes |
| 4 | Move CSS/JS presentation code by surface. | High | Medium | Large | Child theme. | Yes |
| 5 | Move payment/order/checkout rules to custom plugin. | High | High | Large | Tests and rollback. | Yes |
| 6 | Rebase WooCommerce template overrides. | High | High | Large | Child theme and Woo update plan. | Yes |

### Batch 5: Customer Journey / Visual Refinement

Goal: Improve premium UX after safety/performance architecture is stable.

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Audit product detail, cart, checkout, account, order received with real staging cart. | High | Low-Medium | Medium | Email/payment safety. | Yes before checkout flow |
| 2 | Fix typography/spacing/readability issues from design-language doc. | Medium-High | Medium | Medium-Large | Child theme strategy. | Yes |
| 3 | Improve out-of-stock and preorder communication. | High | Medium | Medium | Product/business rules. | Yes |
| 4 | Refine checkout payment/shipping clarity. | High | Medium-High | Medium-Large | Safe checkout testing. | Yes |

### Batch 6: New Features Such As Waitlist

Goal: Build new launch/waitlist functionality only after core stability.

| Order | Item | Impact | Risk | Effort | Dependencies | Approval needed |
| ---: | --- | --- | --- | --- | --- | --- |
| 1 | Decide waitlist business rules. | High | Low | Medium | Founder decision. | Yes |
| 2 | Design server-side token lifecycle. | High | Medium | Medium | Custom plugin strategy. | Yes |
| 3 | Move Supabase secrets server-side. | Critical | Medium | Medium | Hosting/env config. | Yes |
| 4 | Build waitlist UI in child theme or page template. | High | Medium | Medium-Large | Design direction. | Yes |
| 5 | Test end-to-end with sandbox checkout and email safety. | Critical | High | Large | Batches 1-5. | Yes |

## Recommended First Batch

Execute Batch 1 first: Low-Risk Operational Cleanup.

Reason:

- It creates the backup and safety layer required before any real cleanup.
- It addresses staging email risk before checkout/order testing.
- It preserves the current custom code by exporting snippets before refactoring.
- It gives us a clean performance baseline before changing logs, queues, plugins, or cache.
- It has the best ratio of impact to risk.

Do not start Batch 2 until Batch 1 is complete and documented.

## Conversation Recommendation

Recommendation: Continue in this conversation.

Reason: The `.jedda` documentation now contains the full Phase 1-5 context, and the next likely step is approval to execute Batch 1. A new conversation is not necessary unless the next objective becomes a long implementation run.

