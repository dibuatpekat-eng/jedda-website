# Performance & System Health Audit

Status: Phase 4 read-only performance and system-health audit completed on 2026-06-28.

Scope: Staging website only at `https://beta.jeddawear.com`. Investigation used WordPress admin screens, WooCommerce Status, Site Health, Action Scheduler, YaySMTP admin surfaces, frontend/admin browser timing, and existing Phase 1-3 architecture documentation. No plugins, settings, database rows, code, products, orders, or deployments were changed.

## Executive Summary

The WordPress admin is measurably slower than the frontend.

VERIFIED browser wall-clock timings:

| Surface | Observed load time |
| --- | ---: |
| Static `robots.txt` | `0.64s` |
| WordPress login page | `1.38s` |
| Frontend home, warm load | `0.95s` |
| Frontend shop | `1.93s` |
| Admin dashboard | `7.48s`, `7.94s`, `9.48s` |
| Products list | `8.00s`, `8.74s` |
| Orders list | `7.35s`, processing filter `9.51s`, cancelled filter `7.71s` |
| Pages list | `6.01s`, `6.12s` |
| Plugins list | `7.02s`, `8.68s` |
| WooCommerce Status | `9.82s` |
| WooCommerce Admin home | `7.40s` |
| Action Scheduler | `5.87s`, `6.09s` |
| YaySMTP logs page | `5.80s`, `5.94s` |
| WPCode active list | `3.67s` |

Interpretation:

- VERIFIED: Static hosting latency is not the main cause. A static file loads in `0.64s`, and the frontend can load under `2s` once warm.
- VERIFIED: The admin slowdown is broad across admin pages, not limited to one screen.
- VERIFIED: The most evidence-backed root causes are database/log bloat, Action Scheduler backlog, WooCommerce admin/order data scale, high active plugin count, admin notices/widgets, and missing persistent object cache.
- VERIFIED: Autoloaded options are reported as acceptable by Site Health, so autoload is not currently a leading root cause.
- NOT VERIFIED: Exact slow SQL queries, per-plugin PHP time, PHP worker saturation, and OPcache state were not directly measurable from available read-only admin screens.

## Root Causes Ranked

### 1. YaySMTP Email Log Table Bloat

Evidence:

- VERIFIED: Total database size is `1641.15MB`.
- VERIFIED: `wp_yaysmtp_email_logs` is `1230.20MB`.
- VERIFIED: YaySMTP full logging is enabled.
- VERIFIED: Dashboard shows YaySMTP summary rows such as:
  - `Your Order is Being Processed` total `544`, sent `537`, failed `7`.
  - `Your Jedda account has been created!` total `437`, sent `386`, failed `51`.
  - `Password Reset Request for Jedda` total `196`, sent `135`, failed `61`.

Estimated contribution to admin slowness: `25-35%`.

Why:

The single YaySMTP log table accounts for roughly `75%` of total database size. Even if not every admin page queries the full log table, the dashboard and YaySMTP surfaces do read email summary/log data, and the oversized table increases backup, database scan, and admin query risk.

### 2. Action Scheduler Backlog And Failed Jobs

Evidence:

- VERIFIED: Admin notice reports `2335` past-due actions.
- VERIFIED: Action Scheduler screen reports:
  - All: `16059`
  - Complete: `4582`
  - Failed: `9103`
  - In-progress: `1`
  - Pending: `2373`
  - Past-due: `2373`
- VERIFIED: Action Scheduler notice says: `Maximum simultaneous queues already in progress (1 queue). No additional queues will begin processing until the current queues are complete.`
- VERIFIED: Failed hooks include:
  - `action_scheduler/migration_hook`
  - `woocommerce_admin/stored_state_setup_for_products/async/run_remote_notifications`
  - `shopmagic/core/queue/execute`
- VERIFIED: Several failed ShopMagic actions report order-status mismatch: `Order linked to Event has changed status again and is no longer consistent with this event`.
- VERIFIED: Action Scheduler tables total roughly `24.99MB` including data and indexes.

Estimated contribution: `20-30%`.

Why:

Action Scheduler is a core WooCommerce admin/automation dependency. A backlog this large adds recurring admin notices, scheduled event checks, queue contention, and WooCommerce Admin background-task instability.

### 3. Heavy WooCommerce Admin / Orders Data Surface

Evidence:

- VERIFIED: WooCommerce orders menu badge shows `543`.
- VERIFIED: Site Health reports `6867` users.
- VERIFIED: WooCommerce product count is `88`, variations `244`.
- VERIFIED: Woo order/customer tables are material:
  - `wp_wc_orders_meta`: `34.56MB` data + `72.59MB` index.
  - `wp_woocommerce_order_itemmeta`: `14.55MB` data + `17.03MB` index.
  - `wp_comments`: `19.55MB` data + `24.13MB` index.
  - `wp_usermeta`: `29.56MB` data + `31.11MB` index.
- VERIFIED: Orders list consistently loads around `7-10s`.

Estimated contribution: `15-25%`.

Why:

Admin list tables for orders/products/customers invoke WooCommerce, HPOS, order meta, shipment tracking, payment data, and plugin columns. Orders are slower than frontend because they need authenticated admin bootstrap plus data-rich list-table queries.

### 4. High Active Plugin Count And Admin-Side Plugin Overhead

Evidence:

- VERIFIED: `40` active plugins.
- VERIFIED: `8` inactive plugins.
- VERIFIED: Many active plugins are not required for normal runtime: migration/import/demo tools, WPIDE, rollback/downgrade tools, Customizer Export/Import, Widget Importer/Exporter.
- VERIFIED: Plugins list itself loads around `7-9s`.
- VERIFIED: Admin pages repeatedly render plugin/theme notices from WPIDE, Action Scheduler, CTX Feed, YayMail, theme dependencies, WPBakery, and beta prompts.
- VERIFIED: Site Health recommends removing inactive plugins.

Estimated contribution: `15-20%`.

Why:

Active plugins load admin hooks, notices, scripts, update checks, menu registrations, list-table columns, and background checks. The admin pages show the same notice cluster repeatedly, which indicates broad admin-hook overhead.

### 5. Missing Persistent Object Cache / WP_CACHE Disabled

Evidence:

- VERIFIED: WooCommerce Status reports `External object cache: -`.
- VERIFIED: Site Health recommends: `You should use a persistent object cache`.
- VERIFIED: WordPress constants report `WP_CACHE: Disabled`.

Estimated contribution: `10-15%`.

Why:

Without persistent object cache, repeated admin requests must rebuild expensive option, user, product/order, plugin, and WooCommerce state from database. This matters more in admin than frontend because admin pages are less cacheable and more query-heavy.

### 6. WooCommerce Admin Background Features And Remote Notifications

Evidence:

- VERIFIED: WooCommerce Status lists many enabled WooCommerce Admin features including analytics, activity panels, homescreen, marketing, remote inbox notifications, remote free extensions, payment gateway suggestions, store alerts, and onboarding features.
- VERIFIED: Action Scheduler failed hook includes `woocommerce_admin/stored_state_setup_for_products/async/run_remote_notifications`.
- VERIFIED: WooCommerce Admin home loads around `7.40s`.

Estimated contribution: `5-10%`.

Why:

WooCommerce Admin adds React screens, background data stores, remote notifications, analytics state, and scheduled tasks. The failed remote-notification action suggests WooCommerce Admin background state is not fully healthy.

### 7. Development / Migration / Rollback Tooling Active In Runtime

Evidence:

- VERIFIED active runtime tools include WPIDE, WP Downgrade, WP Rollback, All-in-One WP Migration, One Click Demo Import, Widget Importer & Exporter, WordPress Importer edited version, and Customizer Export/Import.
- VERIFIED: WPIDE notice appears repeatedly on admin pages.

Estimated contribution: `5-8%`.

Why:

These plugins may not dominate database time, but they add admin menus, notices, update checks, security surface, and cognitive/admin overhead. They are low-value during normal admin use.

### 8. WPCode / Code Snippets Customization Layer

Evidence:

- VERIFIED: WPCode has `22` active snippets.
- VERIFIED: Code Snippets has `2` active snippets.
- VERIFIED: WPCode active list loads faster than most admin pages at `3.67s`.
- VERIFIED: Many WPCode snippets are frontend/site-wide; the heaviest launch snippet is injected site-wide footer, but not all snippets affect admin list tables.

Estimated contribution to admin slowness: `3-7%`.

Why:

WPCode/Code Snippets are a major maintainability risk, but current evidence suggests they are not the top admin performance bottleneck. Their direct admin load contribution appears lower than database bloat, Action Scheduler, WooCommerce orders, and plugin stack.

### 9. Parent Theme / WPBakery / Slider Revolution

Evidence:

- VERIFIED: Active theme is Upscale parent theme with no child theme.
- VERIFIED: WPBakery Page Builder and Slider Revolution are active.
- VERIFIED: WPBakery pages list integrations appear on pages.
- VERIFIED: WPBakery Custom CSS is large, but WPBakery Custom JS is empty.
- VERIFIED: Page list loads around `6s`, slower than frontend but not the worst admin screen.

Estimated contribution: `3-7%`.

Why:

Theme/page-builder stack likely contributes to admin menus, editor hooks, frontend rendering, and page editor weight. Based on measured screens, it is not as directly implicated as database/log/Action Scheduler/WooCommerce admin issues.

### 10. Hosting / PHP Workers / OPcache

Evidence:

- VERIFIED: Server is LiteSpeed, PHP SAPI `litespeed`, PHP `8.2.31`, MariaDB `11.8.8` on `127.0.0.1`.
- VERIFIED: Static `robots.txt` loads in `0.64s`.
- VERIFIED: Frontend warm home loads in `0.95s`.
- VERIFIED: Site Health says HTTP requests work and SQL server is up to date.
- NOT VERIFIED: PHP worker count, current PHP worker saturation, OPcache enabled/disabled state, or slow query log.

Estimated contribution: `0-10%`.

Why:

The server can serve static and frontend pages reasonably quickly. This does not rule out PHP worker contention under load, but the available evidence points more strongly to WordPress admin workload and database/plugin overhead than raw hosting latency.

## Non-Root Causes / Lower Priority Findings

- VERIFIED: Autoloaded options are reported as acceptable by Site Health.
- VERIFIED: `wp_options` is `7.42MB` data + `3.97MB` index, not unusually dominant compared with YaySMTP logs/order/user meta.
- VERIFIED: WooCommerce sessions table is `14.52MB` data + `0.50MB` index. Worth cleaning later, but not the largest bottleneck.
- NOT VERIFIED: Slow SQL query list. Requires Query Monitor, server slow-query logs, New Relic/Blackfire, or host-level profiling.
- NOT VERIFIED: Admin hook timing by plugin. Requires profiling or controlled staging plugin toggles.
- NOT VERIFIED: OPcache status. Not exposed in the read-only admin screens inspected.

## Quick Wins

Do not execute without approval:

1. Prune or archive YaySMTP logs.
   - Expected impact: high.
   - Reason: largest database table at `1230.20MB`.

2. Add/enable staging-safe email policy and reduce YaySMTP logging retention.
   - Expected impact: high for safety, medium for performance.
   - Reason: prevents log table from immediately regrowing and prevents accidental staging email.

3. Resolve Action Scheduler backlog.
   - Expected impact: high.
   - Reason: `2373` pending/past-due and `9103` failed actions are verified.

4. Disable or remove admin-only runtime utilities after backup and approval.
   - Expected impact: medium.
   - Candidates: WPIDE, WP Downgrade, WP Rollback, One Click Demo Import, Widget Importer & Exporter, WordPress Importer edited version, Customizer Export/Import, All-in-One WP Migration outside migration windows.

5. Remove inactive plugins and unused inactive themes after backup.
   - Expected impact: low-medium.
   - Reason: Site Health recommends it; reduces update checks/security surface.

6. Reduce repeated admin notices where plugin settings allow dismissing safely.
   - Expected impact: low-medium.
   - Reason: repeated notice rendering is visible across admin pages.

## Medium-Term Improvements

1. Add persistent object cache if Hostinger plan supports Redis/Memcached/LiteSpeed object cache.
   - Expected impact: medium-high for admin.

2. Standardize email/log architecture.
   - Keep YayMail if needed.
   - Keep one SMTP/logging path.
   - Define retention.
   - Disable delivery or sink emails on staging.

3. Audit ShopMagic.
   - It contributes failed Action Scheduler actions and database tables despite visible automations previously showing no data.

4. Consolidate invoice/PDF/shipping-label plugins.
   - Multiple active document plugins overlap and add Woo admin/order hooks.

5. Replace admin-side snippets that affect business logic with a custom plugin.
   - Especially order/payment/checkout/launch logic.

6. Review WooCommerce Admin feature flags and remote-notification failures.
   - Goal: reduce failed actions and admin background work.

7. Plan WooCommerce update only after template/snippet compatibility is controlled.

## Long-Term Architectural Improvements

1. Create a site-specific custom plugin for business logic.
   - Move launch/waitlist, order status copy, payment action rules, checkout account behavior, and YayMail filters out of WPCode/Code Snippets.

2. Create a child theme for presentation.
   - Move CSS/JS/template overrides out of WPCode, WPBakery Custom CSS, and parent theme files.

3. Replace broad admin mutability with Git-based workflow.
   - Remove WPIDE and reduce code editing from WordPress admin.

4. Build a performance observability workflow.
   - Use Query Monitor on staging, server slow-query logs, Action Scheduler monitoring, database table-size tracking, and synthetic page timing.

5. Establish routine database maintenance.
   - Email logs, Action Scheduler logs/actions, sessions, transients, orphaned postmeta/usermeta, and stale plugin tables.

6. Reduce plugin surface.
   - Keep only plugins with active business value.
   - Convert simple display rules to child theme/custom plugin code.

## Plugins That Should Become Custom Code

Candidates for custom plugin:

- WPCode snippets controlling launch/waitlist behavior.
- WPCode snippets controlling payment action visibility and order status messaging.
- Code Snippets thank-you message logic.
- YayMail column-span filter.
- Checkout account creation rule if it remains a business requirement.

Candidates for child theme:

- Product variation/swatches styling.
- Product badge placement/copy.
- Cart/checkout/account/order CSS.
- Login form styling.
- Product quantity buttons/search UI if still needed.

Candidates for removal or inactive-only use:

- WPIDE.
- WP Downgrade.
- WP Rollback outside maintenance windows.
- One Click Demo Import.
- Widget Importer & Exporter.
- WordPress Importer edited version.
- Customizer Export/Import outside migration windows.
- All-in-One WP Migration outside migration windows.
- Duplicate invoice/PDF/shipping-label plugins after selecting one system.

## Duplicate Functionality

- VERIFIED: WPCode and Code Snippets both run custom code.
- VERIFIED: Multiple PDF/invoice/shipping-label plugins are active.
- VERIFIED: Multiple migration/import utilities are active.
- VERIFIED: Multiple rollback/downgrade/development utilities are active.
- VERIFIED: Inactive marketing tools overlap: Mailchimp for WooCommerce, MC4WP, MailPoet, MailPoet Premium.
- VERIFIED: Product badge functionality overlaps between inactive Advanced Woo Labels and active snippets referencing Advanced Woo Labels markup.

## Updated Scores

Architecture Score: `44 / 100`.

- Previous Phase 2 score was `46 / 100`.
- Reduced because Phase 4 verified large operational-health problems: database/log bloat, Action Scheduler backlog, missing persistent object cache, and repeated admin plugin notices.

Maintainability Score: `36 / 100`.

- Previous Phase 3 score was `38 / 100`.
- Reduced because performance investigation confirms operational debt is not just structural; it is actively affecting admin usability.

Performance Score: `42 / 100`.

- Frontend warm path can be acceptable, but admin is consistently slow across dashboard/products/orders/plugins/WooCommerce.
- Database/log/queue health materially lowers the score.

Overall Engineering Health Score: `40 / 100`.

- The store is operational and recoverable, but admin performance, queue health, database maintenance, plugin sprawl, and customization architecture need cleanup before major engineering changes.

## Evidence Gaps

The following require additional tools or approved changes:

- Exact slow SQL queries.
- Per-plugin PHP/admin-hook timing.
- PHP worker saturation.
- OPcache status and hit rate.
- Redis/Memcached availability from hosting panel.
- Database row counts for autoloaded options and individual log tables.
- Controlled before/after plugin overhead measurement.

Preferred next profiling tool if approved later: Query Monitor on staging, used briefly and removed/disabled after collecting query/hook timing.

## Conversation Recommendation

Recommendation: Continue in this conversation.

Reason: The thread remains coherent, the core architecture/performance context is now captured in `.jedda`, and the next likely step is a targeted safety/performance plan. A new conversation is not necessary yet unless the next objective becomes an implementation phase.

