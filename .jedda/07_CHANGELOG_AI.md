# AI Changelog

Record engineering work chronologically.

## 2026-06-29 — Milestone 2.8.2 — Product Summary V2 Blueprint (Claude Code workspace)

Complete design specification. No staging changes. No code written.

### Typography System — Plus Jakarta Sans

Approved by founder. Self-hosted via plugin. 4 weights (300/400/500/600), WOFF2 only, `font-display: swap`, preload for 400+500.

Full type scale defined: 10px–20px range. Product title: PJS 600 / 20px / lh 1.25 / ls 0.02em. Price: 14px / 400. Labels (COLOR, SIZE, accordion tabs): 10px / 500 / uppercase / ls 0.10em. Body: 13px / 300 / lh 1.7. Measurements: 11px / 400.

Color tokens: `--jedda-ink` #171717, `--jedda-muted` #686868, `--jedda-ghost` #a0a0a0, `--jedda-line` #d9d7d1, `--jedda-soft` #f6f5f2, `--jedda-error` #c0392b.

Uppercase restricted to: section labels, button text, measurement headers. Never: title, body copy, price, variant values.

### Spacing System

Base unit 8px. 10 spacing tokens (--space-1 through --space-10). Full vertical rhythm defined for summary column.

### Component Specifications

All components fully specified: breadcrumb, title, price (regular + sale + range), COLOR/SIZE variant selectors, swatch states (default/selected/hover/OOS), quantity (de-emphasized), ADD TO BAG (filled/primary), BUY NOW (outline/secondary), accordion (multi-open, all closed by default, ARIA-correct).

Key changes from current:
- Accordion moved BELOW ATC buttons (hierarchy: variants → action → reference)
- Multi-open accordion (was exclusive-open)
- All panels closed by default (was Details open)
- Button label: "Add to Bag" (was "Add to cart")
- Product title: `<h1>` (was `<h2>`)
- Size Guide link next to SIZE label → opens Fit & Sizing panel
- Network error state added (currently unhandled)
- Swatch min touch target: 44px height on mobile (WCAG AA)

### Interaction States

Full state matrix documented: default/hover/focus/active/disabled/loading/error/success for every interactive element.

Animation: 120–280ms ease only. No spring, bounce, scale, rotation except accordion chevron (220ms). No page-load animations.

### Accessibility

WCAG AA throughout: contrast ratios documented, keyboard navigation order defined, full ARIA semantic map, focus-visible always visible.

### Responsive + Sticky

Desktop: `position: sticky` on summary column, top = header height + 24px.
Mobile (≤768px): normal flow, all panels closed, touch targets 44px.
Breakpoint: Foundation large (1024px+).

Sticky blocker: Foundation may use floats — requires container display audit in 2.8.3.

### CMS Data Map

Every content element mapped to architecture:
- WC native: title, price, stock, color, size, variations
- WC global attribute: material (`pa_material`)
- ACF Pro per-product: details text, care instructions, size measurements (repeater), recommended body size (repeater)
- ACF Options Page: shipping policy, returns policy, size exchange policy, pre-order policy
- Custom taxonomy `jedda_badge`: Pre-Order, New Arrival, Restocked (replaces WPCode badge snippets)

### Plugin Directory Restructure (Planned for 2.8.3)

Single-file plugin → class-based directory structure with includes/, templates/, assets/fonts/, acf-json/. Required before implementation complexity increases.

### Environment Blockers Documented

1. ACF Pro not installed (blocks 2.8.4)
2. WPCode #11836 unnamed (unknown PDP impact)
3. Sticky requires container flexbox audit
4. `<h1>` product title requires hook override

### Files Created

- `.jedda/35_PRODUCT_SUMMARY_V2_BLUEPRINT.md` — complete specification

---

## 2026-06-29 — Milestone 2.8.1 — Product Summary V2 Architecture (Claude Code workspace)

Architecture design only. No implementation. No staging changes.

### Data Architecture

Evaluated 6 approaches: ACF Pro, Meta Box, native WC post meta, WC attributes/taxonomies, custom post types, headless. Full comparison matrix in `.jedda/34_PRODUCT_SUMMARY_V2_ARCHITECTURE.md`.

**Recommendation: ACF Pro** as primary data layer.
- Per-product fields: details text, composition, care instructions, size measurements (repeater), recommended body size (repeater)
- Global fields: ACF Options Page "Jedda Policy" — Shipping & Returns + Pre-Order policy (edit once, reflects everywhere)
- Material composition: WC product attribute `pa_material` (categorical complement to ACF)
- `post_excerpt` freed for plain-text marketing blurb

Rejected: native meta (no editor UI), CPTs (over-engineering), headless (out of scope for this phase).

### Typography

Evaluated: Cormorant Garamond + Inter, Plus Jakarta Sans (single typeface), GT Sectra + Neue Haas Grotesk (licensed), Editorial New + Inter. Benchmarked against Toteme, SSSTEIN, The Row, Aesop, COS, A.P.C., Jacquemus, Lemaire.

**Recommendation: Cormorant Garamond 300 (display, product name) + Inter 400/500 (all UI)**
- Both free via Google Fonts, self-hostable, no GDPR/licensing concerns
- Cormorant at 22–24px: editorial serif warmth → signals craft and fashion-object quality
- Inter at 11–13px: precise, legible, industry-standard for premium digital products
- Retire Overpass (road-signage grotesque, wrong register) and Jost (implementation artifact from per-product HTML, never a deliberate brand decision)

Alternative: Plus Jakarta Sans (single typeface, Indonesian foundry — appropriate brand heritage signal for JEDDA)

### Migration Strategy

5-phase plan documented:
- Phase 1: ACF install + font infrastructure (no visual changes)
- Phase 2: Content migration for 1 product
- Phase 3: Template rendering from ACF fields
- Phase 4: Typography
- Phase 5: Full product rollout

Feature flag (`jedda_pdp_v2_enabled`) active throughout. `post_excerpt` content preserved as fallback until Phase 5.

### Blockers / Decisions Required

6 decisions documented in `.jedda/98_NEXT_ACTION.md`. Awaiting founder input before Milestone 2.8.2 begins.

Environment blocker: WPCode snippet #11836 "Untitled Snippet" — content not inspected, PDP impact unknown. Must be reviewed before V2 implementation.

### Files Created

- `.jedda/33_PRODUCT_SUMMARY_REVERSE_ENGINEERING.md` — Milestone 2.8.0 complete report
- `.jedda/34_PRODUCT_SUMMARY_V2_ARCHITECTURE.md` — Milestone 2.8.1 complete report

---

## 2026-06-29 — Gallery V2.1 — Stronger Editorial Option (Claude Code workspace)

### Changes Implemented

Option 2 (Stronger Editorial) approved and implemented via `pdp-v21.css` (new filename; `pdp-v2.css` was LiteSpeed-cached at old version).

**Four changes, all scoped to `body.single-product.jedda-pdp-v2`:**

1. **Row max-width expansion** — `#de-product-container .de-product-single__wrapper.row { max-width: 100% !important }`. Overrides `max-width: 1280px !important` in `custom.css` (which uses ID selector). Makes the product wrapper fill the full viewport at desktop. Mobile unaffected (Foundation stacks at <768px, max-width constraint has no effect below 1280px viewport).

2. **Thumbnail strip moved to right** — `float: right; margin-right: 0; margin-left: 8px`. Image now starts at the gallery column's left edge.

3. **Gallery left padding removed** — `padding-left: 0`. Image starts flush against the row's left inner boundary.

4. **Top breathing room increased** — `padding-top: clamp(48px, 5vw, 80px)` (from `clamp(8px, 1.5vw, 28px)`). At 1512px = 75.6px of deliberate editorial entry space.

**Arrow visibility fix also confirmed** — `display: none !important` working (was blocked by LiteSpeed CSS optimization serving stale bundle).

### Verified Measurements (1512px viewport)

| Metric | V2.0 | V2.1 | Target (Toteme) |
|---|---|---|---|
| Image width | 672px | 817px | ~840px |
| Image % of viewport | 44.5% | 54.0% | 54-62% |
| Wrapper width | 1280px | 1512px (full) | full |
| Top breathing room | 8-28px | 48-80px | ~60-80px |
| Arrows | hidden | hidden | none |
| Thumbnail position | left | right | right or none |

### LiteSpeed CSS Optimization Investigation + Fix

LiteSpeed CSS optimization bundled our plugin CSS into a server-level cache. The cached bundle contained the very first (failed) version of `pdp-v2.css` from before Gallery V2. Several purge attempts via `LiteSpeed_Cache_API::purge_all()` did not clear the CSS optimization bundle.

**Resolution:**
- Added `litespeed_optimize_css_excludes` filter to plugin PHP to exclude the file from future bundling.
- Renamed CSS file to `pdp-v21.css` (new filename = no cached response exists). PHP updated to reference `pdp-v21.css`.
- Discovered theme rule `#de-product-container .de-product-single__wrapper { max-width: 1280px !important }` — ID selector + `!important` — which was blocking our max-width override. Fixed by matching the ID in our selector and adding `!important`.

### Full PDP Visual Check

- Gallery: dominant, clean, no arrows, no chrome ✓
- Product summary column (right): title, price, accordions, color, size, ATC, BUY NOW — all intact ✓
- Below gallery: expected white space (gallery taller than summary — to be addressed in Product Summary V2)
- Related Products: full-width, unaffected by wrapper change ✓
- Mobile: Foundation stacks both columns to full-width (small-12). max-width change has zero effect below 1280px viewport ✓

### Files Changed

- `assets/css/pdp-v21.css` — new file (Gallery V2.1 implementation, replaces `pdp-v2.css` as active file)
- `assets/css/pdp-v2.css` — contains V2.1 CSS but no longer the active file (PHP references `pdp-v21.css`)
- `jedda-commerce-ui.php` — references `pdp-v21.css`; added `litespeed_optimize_css_excludes` filter

## 2026-06-29 — Gallery V2 Design Review + V2.1 Plan (Claude Code workspace)

- Conducted full design review of Gallery V2 against Toteme / SSSTEIN references.
- Honest verdict: directionally correct, not yet close enough to approved design language.
- Completed reverse engineering of arrow CSS cascade: base `display: flex` (dahz-framework-blog.css:28136), hover `opacity: 1` (line 27227). No JS manipulation in df-commerce.js.
- Confirmed layout constraint: `.row` has `max-width: 1280px`, creates 116px side margins at 1512px viewport. This is the ceiling for image width without HTML changes.
- Arrow visibility on normal page loads is a LiteSpeed cache deployment issue, not a CSS logic issue. `display: none !important` rule is correct.
- Arrow fix committed (9a7e22d) and pushed. Only visible after LiteSpeed cache refresh.
- Identified three V2.1 refinements: thumbnail strip to right, gallery left padding removal, increased top breathing room.
- Documentation updated. Awaiting founder approval to proceed with V2.1.

## 2026-06-29 — Gallery V2 Implementation (Claude Code workspace)

- Completed full Gallery V2 reverse engineering from live staging DOM inspection.
- Mapped complete Upscale Philo gallery structure: `.de-product-single__images-left-philo`, `.de-product-single__images-container--philo`, `.de-product-single__thumbnail--philo`, `.de-product-single__images--philo`, `.de-product-single__images--philo-inner`.
- Confirmed CSS ownership: `dahz-framework-blog.css` (primary), `custom.css` (thumbnail gap + mobile hide).
- Confirmed JS ownership: `dahz-framework-themes.js` and `df-commerce.js` init both Slick sliders.
- Confirmed Slick config: main slider (horizontal, 1 slide, lazyLoad ondemand, asNavFor thumbnail), thumbnail slider (vertical, 3 slides, focusOnSelect, asNavFor main).
- Confirmed image dimensions: 1032×1548px natural (2:3 portrait), displayed at 524×786px.
- Identified 5 UX issues: insufficient image scale, disproportionate thumbnail gap, always-visible arrows, weak active state, no mobile navigation affordance.
- Replaced failed full-page `pdp-v2.css` (which used wrong generic WooCommerce selectors) with gallery-only CSS targeting real Upscale selectors.
- Replaced `pdp-v2.js` with gallery-only counter implementation.
- Gallery V2 changes:
  - Thumbnail rail reduced to 12px indicator strip (from 100px) — main image gains ~128px width.
  - Thumbnail images hidden; replaced by 2px left-border active indicator strip.
  - Inactive thumbnails show muted `--jedda-line` mark; active shows `--jedda-ink`; hover shows `--jedda-muted`.
  - Gallery arrows hidden entirely — navigation belongs to thumbnails and swipe.
  - Crosshair cursor removed from main image hover.
  - Breathing room added to gallery column via `padding-top: clamp(8px, 1.5vw, 28px)`.
  - Mobile image counter (`1 / 6`) injected via event-based JS below gallery column.
- Verified JS syntax with `node --check`: passed.
- Created `32_GALLERY_V2_MILESTONE.md` with complete analysis and decision log.
- Updated `98_NEXT_ACTION.md` and `99_CURRENT_STATE.md`.
- Committed and pushed to `origin/main`.
- PDP V2 remains disabled by default. Staging activation requires explicit feature flag.
- No payment, checkout, cart, summary, variants, add-to-cart, orders, or stock was touched.

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
- Added `28_PRODUCT_PAGE_V2_PLAN.md` to define the approved Product Page V2 design direction before coding visual changes.
- Added `29_PRODUCT_PAGE_V2_IMPLEMENTATION_STRATEGY.md` and selected a small custom site plugin as the safest PDP V2 implementation path.
- Added `30_PRODUCT_PAGE_V2_MILESTONE_2_6.md`.
- Created the first Git-owned custom plugin module: `wp-content/plugins/jedda-commerce-ui`.
- Added product-page-only PDP V2 asset loading, feature flags, and kill switches.
- Added the first scoped PDP V2 presentation layer for layout rhythm, typography, image/gallery treatment, variant section, add-to-cart styling, and Sprint feedback styling.
- Verified the PDP V2 JavaScript syntax with `node --check`; PHP lint was not available locally.
- Deactivated `JEDDA Commerce UI` on staging after visual QA showed the first PDP V2 CSS attempt compressed/broke the product page.
- Reclassified the first PDP V2 visual attempt as failed, not successful.
- Updated the plugin so PDP V2 is disabled by default and no longer auto-enables on `beta.jeddawear.com`.
- Added `31_PRODUCT_PAGE_V2_VISUAL_RECOVERY.md` with recovery status, failure analysis, and the real Upscale PDP DOM selector map.
- Added long-term project continuity documentation: root `README.md`, `96_ENGINEERING_INDEX.md`, `97_PROJECT_IDENTITY.md`, `98_NEXT_ACTION.md`, and `99_CURRENT_STATE.md`.
- Added the New Conversation Startup Procedure for future AI engineers.
- Updated PDP V2 workflow: all future Product Page V2 work must be component-by-component, starting with Gallery V2 only.
- Added AI handoff summary covering completed work, failed work, architecture, current risks, current sprint status, immediate next milestone, and expected next output.
- Recorded the likely observer-loop failure mode.
- Established a safer event-based implementation path for the next PDP invalid-variant guard.
- Added a kill-switch requirement for future staging frontend snippets before activation.
- No payment settings, checkout logic, cart logic, products, orders, customer data, plugin settings, or database rows were changed.

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
