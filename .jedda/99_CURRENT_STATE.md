# Current State

Status: Handoff source of truth.
Last updated: 2026-06-29.

## Repository

- Local path (Claude Code workspace): `/Users/maverick/Documents/JEDDA WEBSITE - Claude Code`
- Local path (previous engineer workspace): `/Users/maverick/Documents/JEDDA WEBSITE`
- Remote: `git@github.com:dibuatpekat-eng/jedda-website.git`
- Branch: `main`
- Both workspaces share the same remote. Commits from either workspace go to `main`.

## Staging State

- Staging URL: `https://beta.jeddawear.com`
- Public unauthenticated response may show Hostinger coming-soon gate.
- Logged-in WordPress admin/browser required for accurate storefront review.
- `JEDDA Commerce UI` plugin files are installed on staging but the plugin is deactivated.
- PDP V2 is disabled by default. `jedda_pdp_v2_enabled` option is `0` or unset.
- WordPress admin Codex account: accessible via browser automation.

## Completed Work

Design and documentation:
- Phase 6 design research completed.
- Digital design principles completed.
- Component direction completed.
- Customer journey audit completed.
- Visual gap analysis completed.
- PDP V2 design plan completed.
- PDP V2 implementation strategy completed.

Sprint 2 PDP interactions (active on staging):
- Milestone 2.1: PDP variant validation — Code Snippets ID `13`.
- Milestone 2.2: PDP loading feedback — Code Snippets ID `18`.
- Milestone 2.3: PDP success feedback — Code Snippets ID `19`.

Custom plugin:
- `wp-content/plugins/jedda-commerce-ui` installed on staging, currently deactivated.
- `pdp-v2.css` — Gallery V2 implementation (gallery-only, Upscale selectors).
- `pdp-v2.js` — Mobile image counter (event-based, Slick afterChange).
- PDP V2 disabled by default. Feature flag required to activate.

## Gallery V2.1 — Implemented, QA Complete, Awaiting Founder Approval

Gallery V2.1 implemented on 2026-06-29. Stronger Editorial option.

Active file: `assets/css/pdp-v21.css` (renamed from `pdp-v2.css` to bust LiteSpeed CSS optimization cache).

### Verified Measurements (1512px viewport, staging)

| Metric | V2.0 | V2.1 | Target (Toteme) |
|---|---|---|---|
| Wrapper max-width | 1280px | 100% (1512px) | full |
| Gallery column width | 712px | 847px | ~840px |
| Image width | 672px | 817px | ~840px |
| Image % of viewport | 44.5% | 54.0% | 54-62% |
| Top breathing room | 8-28px | 48-80px (75.6px at 1512px) | ~60-80px |
| Arrows | hidden | hidden | none |
| Thumbnail position | left | right | right or none |
| Mobile | unaffected | unaffected | n/a |

### What Changed V2.0 → V2.1

1. Row expanded: `#de-product-container .de-product-single__wrapper.row { max-width: 100% !important }`. Theme had `max-width: 1280px !important` with ID selector — matched specificity with same ID in our selector.
2. Thumbnail moved to right: `float: right; margin-right: 0; margin-left: 8px`
3. Gallery left padding removed: `padding-left: 0`
4. Top breathing room: `clamp(48px, 5vw, 80px)` (was `clamp(8px, 1.5vw, 28px)`)

### Full PDP Check

- Gallery: dominant, clean, no arrows ✓
- Related Products section: full-width, unaffected by wrapper change ✓
- Product info (right column): all elements intact, wider column ✓
- White space below BUY NOW: expected — gallery is taller than summary. Addressed in Product Summary V2.
- Mobile: Foundation `small-12` stacks both columns. Max-width change inactive below 1280px ✓

### LiteSpeed CSS Optimization — Resolved

LiteSpeed was bundling plugin CSS into a server-level cache. Old content was served despite new files being deployed.

Fix:
- `litespeed_optimize_css_excludes` filter added to `jedda-commerce-ui.php`
- CSS renamed to `pdp-v21.css` (new filename = no existing cache entry)
- Rule: when deploying a new milestone CSS, rename the file (pdp-v22.css, etc.)

### CSS Cascade for Key Rules

Arrows: `dahz-framework-blog.css:28136` sets `display: flex`. Our `display: none !important` wins.
Wrapper max-width: `custom.css` sets `max-width: 1280px !important` via `#de-product-container`. Our selector `body.single-product.jedda-pdp-v2 #de-product-container .de-product-single__wrapper.row` matches with `max-width: 100% !important`.

`df-commerce.js` confirmed: zero gallery arrow manipulation. Safe.

## Failed Work (Do Not Repeat)

- Do not apply full-page CSS to generic WooCommerce selectors.
- Do not use `div.product`, `.summary`, or `.woocommerce-product-gallery` as Upscale layout targets.
- Do not redesign multiple PDP components in one milestone.
- Do not equate minimalism with compression.

## Current Architecture

- WooCommerce is the commerce engine.
- Midtrans handles payment.
- Epeken handles shipping/rates.
- Upscale theme is the functional base.
- `jedda-commerce-ui` is the Git-owned presentation layer — installed but inactive.
- Sprint 2 snippets still own temporary PDP interaction behavior.
- Code Snippets/WPCode still contain other business and presentation logic.

## Current Implementation Strategy

PDP V2 component-by-component through `jedda-commerce-ui`:

1. Gallery ← DONE, awaiting founder approval
2. Product Summary ← next after Gallery approval
3. Title & Price
4. Variant Selector
5. Add-to-Cart
6. Product Details / Accordion
7. Recommendations
8. Mobile

Each component requires: reverse engineering → implementation → screenshots → approval before next.

## Product Summary — Reverse Engineering + Architecture (Complete, Awaiting Approval)

Milestones 2.8.0 and 2.8.1 complete. Full docs: `.jedda/33_PRODUCT_SUMMARY_REVERSE_ENGINEERING.md` and `.jedda/34_PRODUCT_SUMMARY_V2_ARCHITECTURE.md`.

### Key Reverse Engineering Findings (2.8.0)

- Summary column: `.de-product-single__summary--philo.large-5` (605px @ 1512px viewport)
- Title: `h2.product_title` — Overpass 16px/400 — data: `wp_posts.post_title`
- Price: inside `h4` (semantically incorrect) — Overpass 12px — WC `_price` meta. Schema.org tags hidden inside (must preserve)
- Accordion: CSS (35 rules) + HTML (4 items) + JS (`jdToggle()`) all hardcoded in `post_excerpt`. Not CMS-friendly. Non-technical editors cannot update without HTML knowledge.
- Variation form: WooCommerce core + woo-variation-swatches plugin. Labels styled by WPCode #13040 (Jost 11px)
- Two typefaces on one panel: Overpass (title/price) vs Jost (accordion/labels) — never a deliberate decision
- WPCode #11836 "Untitled Snippet" runs `site_wide_header` — PDP impact unknown. Must review before V2
- Sprint 2 snippets (#13, #18, #19) active — must be preserved through V2
- Buy Now: Upscale `.de-single-direct-checkout`, WPCode #13041 adds sold-out guard

### Architecture Recommendation (2.8.1)

**Data layer:** ACF Pro
- Per-product structured fields: details text, composition, care, size measurements (repeater), recommended body size (repeater)
- Global policy: ACF Options Page "Jedda Policy" — Shipping & Returns, Pre-Order, Returns — edit once, reflect on all products
- Material composition: WC attribute `pa_material` (categorical, filterable)
- `post_excerpt` freed for plain-text marketing blurb

**Typography:** Cormorant Garamond (display) + Inter (UI) — both free, self-hosted
- Cormorant Garamond 300 → product name 22–24px (editorial serif)
- Inter 400/500 → price, labels, measurements, accordion body
- Retire Overpass and Jost entirely

**Migration:** 5 phases — Foundation → Content Migration (1 product) → Template → Typography → Rollout. Feature flag active throughout. `post_excerpt` not deleted until Phase 5 approved.

### Architecture Decisions — Status

| # | Decision | Status |
|---|---|---|
| 1 | Data architecture | ✅ ACF Pro approved |
| 2 | Typography | ✅ Plus Jakarta Sans approved (self-hosted) |
| 3 | Shipping & Returns | ✅ ACF Options Page (global) approved |
| 4 | Material composition | ✅ WC attribute `pa_material` approved |
| 5 | WPCode #11836 | ⚠️ Owner action required — review in WPCode admin |
| 6 | Post excerpt | ✅ Plain-text marketing blurb |

### UX Decisions Pending Confirmation (from 2.8.2 Blueprint)

| # | Decision | Proposed |
|---|---|---|
| A | Accordion: multi-open | Yes |
| B | Accordion: all closed by default | Yes |
| C | Button label | "Add to Bag" |
| D | Product title as `<h1>` | Yes |
| E | Quantity on mobile | Hidden |
| F | Swatch touch target 44px on mobile | Yes |
| G | Sticky summary (desktop) | Yes |
| H | Size Guide link | Yes |
| I | Network error state | Yes |

### Milestone 2.8.2 — Blueprint (Complete)

Full design specification in `.jedda/35_PRODUCT_SUMMARY_V2_BLUEPRINT.md` covering:
- Plus Jakarta Sans type system: 4 weights (300/400/500/600), full scale, color tokens, uppercase rules
- Spacing system: 8px base grid, 10 spacing tokens
- Complete component specs: title, price, variant selector, swatches, ATC, Buy Now, accordion (all 4 panels)
- All interaction states: default, hover, focus, active, disabled, loading, error, success
- Animation philosophy: 120–280ms ease, no spring/bounce
- Sticky summary (desktop), responsive rules, mobile behavior
- Accessibility: WCAG AA contrast, keyboard nav, ARIA semantics, `<h1>` for product title
- Complete CMS data map: every piece of content mapped to WC native / ACF / taxonomy / Options Page
- Plugin directory restructure plan (before implementation)
- 4 environment blockers documented

### Environment Blockers (Open)

1. **ACF Pro not installed** — must purchase and install on staging before Milestone 2.8.3
2. **WPCode #11836 unnamed** — unknown PDP impact, must review before implementation
3. **Sticky requires container flexbox audit** — floated Foundation columns may prevent sticky
4. **`<h2>` vs `<h1>` for product title** — requires hook or template override

## Current Risks

- ACF Pro not yet purchased — blocks content migration phase
- WPCode #11836 content unknown — may conflict with V2 elements
- Sticky summary may require container layout change (float → flex)
- Browser/CDP sessions have sometimes been unstable on staging

## Immediate Next Step

**Owner:** Purchase ACF Pro + review WPCode #11836 + confirm 9 UX decisions (see `.jedda/98_NEXT_ACTION.md`)  
**Engineer:** After confirmations received → Milestone 2.8.3 (Foundation: plugin restructure + ACF + fonts + taxonomy)
