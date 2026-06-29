# Current State

Status: Handoff source of truth.
Last updated: 2026-06-29.

## Repository

- Local path: `/Users/maverick/Documents/JEDDA WEBSITE`
- Remote: `git@github.com:dibuatpekat-eng/jedda-website.git`
- Branch: `main`
- Latest known pushed commit: `d5ad81d fix: disable failed pdp v2 visual layer`

## Staging State

- Staging URL: `https://beta.jeddawear.com`
- Public unauthenticated response may show Hostinger coming-soon gate.
- Logged-in WordPress admin/browser is needed for accurate storefront review.
- `JEDDA Commerce UI` plugin files are installed on staging but the plugin was deactivated after failed visual QA.
- Fresh logged-in PDP verification after deactivation showed no PDP V2 body classes and no PDP V2 assets.

## Completed Work

Design and documentation:

- Phase 6 design research completed.
- Digital design principles completed.
- Component direction completed.
- Customer journey audit completed.
- Visual gap analysis completed.
- PDP V2 design plan completed.
- PDP V2 implementation strategy completed.

Sprint 2 PDP interactions:

- Milestone 2.1: PDP variant validation via Code Snippets ID `13`.
- Milestone 2.2: PDP loading feedback via Code Snippets ID `18`.
- Milestone 2.3: PDP success feedback via Code Snippets ID `19`.

Custom code:

- `wp-content/plugins/jedda-commerce-ui` exists.
- PDP V2 is disabled by default.
- The plugin no longer auto-enables on staging host.

## Failed Work

The first PDP V2 visual pass failed.

Do not repeat:

- Do not apply full-page CSS to generic WooCommerce selectors.
- Do not use `div.product`, `.summary`, or `.woocommerce-product-gallery` as primary Upscale PDP layout targets.
- Do not redesign multiple PDP components in one milestone.
- Do not equate minimalism with smaller/compressed layout.

Why it failed:

- The real Upscale PDP visual structure uses `de-product-single__...` theme containers.
- Generic WooCommerce selectors landed on the wrong layer.
- The CSS compressed the image and summary columns.
- The result looked worse and did not match the approved references.

Recovery:

- `JEDDA Commerce UI` was deactivated on staging.
- PDP V2 disabled by default in code.
- Recovery documented in `31_PRODUCT_PAGE_V2_VISUAL_RECOVERY.md`.

## Current Architecture

- WooCommerce is the commerce engine.
- Midtrans handles payment.
- Epeken handles shipping/rates.
- Upscale theme remains the functional base.
- WPBakery/theme/page-builder layers may affect content and layout.
- Variation swatches plugin affects variant UI.
- Code Snippets/WPCode still contain important business and PDP behavior logic.
- `jedda-commerce-ui` is the intended Git-owned presentation layer.

## Current Implementation Strategy

PDP V2 must be implemented component by component:

1. Gallery
2. Product Summary
3. Title & Price
4. Variant Selector
5. Add-to-Cart
6. Product Details / Accordion
7. Recommendations
8. Mobile

Each component requires:

- Reverse engineering.
- Dependency map.
- Before screenshots.
- Component-only implementation.
- After screenshots.
- Design-direction explanation.
- Approval before continuing.

## Current Risks

- Full-page visual changes can break the PDP quickly.
- Upscale DOM differs from generic WooCommerce assumptions.
- Browser/CDP sessions have sometimes been unstable.
- Public staging can show coming-soon gate.
- Checkout/order/payment flows are not safe to test casually.
- Code Snippets/WPCode still create hidden dependency risk.
- PHP lint is unavailable in the local Codex environment.

## Current Sprint Status

Product Page V2 foundation exists but visual implementation is paused after recovery.

No new visual implementation should start until the next component is reverse-engineered.

## Immediate Next Milestone

Gallery V2 only.

The next AI engineer must not start Product Summary, Title & Price, Variant Selector, Add-to-Cart, Details, Recommendations, or Mobile until Gallery V2 is approved.

## Expected Output After Next Milestone

After Gallery V2, the repo should include:

- Updated documentation with Gallery DOM/dependency map.
- Before/after screenshots referenced in the milestone report.
- Gallery-only code changes in `jedda-commerce-ui`.
- Regression notes confirming Product Summary/Add-to-Cart/cart/checkout/payment were not touched.
- Rollback plan.
- Commit and push.

## AI Handoff Summary

What has been completed:

- Project documentation and design direction are established.
- PDP interaction fixes for validation/loading/success exist as temporary Code Snippets.
- Custom plugin `jedda-commerce-ui` exists as Git-owned future presentation layer.
- Failed PDP V2 full-page attempt was recovered and documented.

What failed and must not be repeated:

- A broad PDP visual CSS pass using generic WooCommerce selectors.
- Any full-page redesign that touches gallery, summary, variants, CTA, details, and recommendations together.

Why the first PDP V2 visual pass failed:

- It targeted generic WooCommerce layout selectors instead of actual Upscale `de-product-single__...` containers.
- It compressed the image and buy panel.
- It did not improve hierarchy or match the approved fashion references.

Current architecture:

- WooCommerce + Upscale + plugins power the current PDP.
- `jedda-commerce-ui` is present but disabled by default.
- Sprint 2 snippets still own temporary PDP interaction improvements.

Current implementation strategy:

- Component-by-component PDP V2 through `jedda-commerce-ui`.
- Reverse engineer first, implement one component, screenshot, explain, wait.

Current risks:

- Hidden theme/plugin/snippet dependencies.
- Mis-targeted CSS.
- Browser/session instability.
- Commerce flow sensitivity.

Current sprint status:

- V2 foundation exists.
- Visual implementation is paused.
- Staging is recovered.

Immediate next milestone:

- Gallery V2.

Expected output after next milestone:

- Gallery-only V2 improvement with before/after screenshots, dependency map, rollback, docs, commit, and push.
