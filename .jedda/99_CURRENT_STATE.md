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

## Current Risks

- Gallery V2 not yet visually confirmed on staging (plugin inactive).
- Thumbnail-at-12px approach is aggressive — fallback to 64px documented if needed.
- Browser/CDP sessions have sometimes been unstable on staging.
- Checkout/order/payment flows are not safe to test casually.
- Code Snippets/WPCode still create hidden dependency risk.
- PHP lint unavailable in local environment.

## Immediate Next Step

Activate Gallery V2 on staging for visual QA.
Founder reviews against Toteme / SSSTEIN direction.
Approve or adjust before proceeding to Product Summary.
