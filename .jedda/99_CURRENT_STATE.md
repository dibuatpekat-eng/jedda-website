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

## Gallery V2 — Implemented, QA Complete, Design Review Complete

Gallery V2 was implemented and QA'd on 2026-06-29.
Design review conducted. Verdict: technically correct, not yet close enough to Toteme/SSSTEIN.
V2.1 refinement plan ready. Awaiting founder approval to implement.

To view Gallery V2 correctly on staging: hard refresh (Ctrl+Shift+R) the product page.
Normal page loads serve LiteSpeed-cached CSS (arrows visible, old layout).

### Reverse Engineering — Now Complete

CSS cascade for gallery arrows:
- `dahz-framework-blog.css:28136` — base `.de-slick-product-arrows { display: flex }`
- `dahz-framework-blog.css:27202` — philo-specific transform positioning
- `dahz-framework-blog.css:27227` — `.de-product-single__images--philo:hover` → `opacity: 1`
- `pdp-v2.css` — `display: none !important` removes all states

Layout constraint: `.row` max-width 1280px centered → 116px side margins at 1512px viewport.
Gallery column ceiling: ~712px (Foundation large-7). Image at 672px = 44.5% viewport. Toteme: 55-62%.
HTML change required to exceed this ceiling. V2.1 stays within CSS-only.

`df-commerce.js` confirmed: zero product gallery arrow manipulation. Safe.

### Design Gap Analysis

| Dimension | Current | Target (Toteme/SSSTEIN) |
|---|---|---|
| Image % of viewport | 44.5% | 55-62% |
| Thumbnail position | left of image | right or none |
| Arrows on image | visible (LiteSpeed cache) | zero chrome |
| Top breathing room | 8-28px | 48-80px |
| Whitespace feeling | default grid | curated |

## Gallery V2 — Implementation Complete, Awaiting QA

Gallery V2 was implemented on 2026-06-29 by the Claude Code engineer.

What changed (inside `jedda-commerce-ui`):
- `pdp-v2.css`: replaced failed full-page attempt with gallery-only rules targeting real Upscale selectors.
- `pdp-v2.js`: replaced with gallery counter only.

Summary of gallery changes:
- Thumbnail rail reduced to 12px indicator strip (from 100px + 48px gap).
- Thumbnail images hidden; active slide shown via 2px left-border mark.
- Gallery arrows hidden.
- Crosshair cursor removed from main image.
- Gallery column breathing room added.
- Mobile image counter (`1 / 6`) injected via JS.
- Main image gains ~128px of width — 44% of viewport vs 36%.

Full analysis: `32_GALLERY_V2_MILESTONE.md`.

**Status: not yet activated on staging. Requires plugin activation + feature flag.**

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
