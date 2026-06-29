# JEDDA Website

This repository is the working engineering and documentation home for the JEDDA website.

Current project status:

- WordPress + WooCommerce staging site.
- Upscale theme remains the functional base.
- WooCommerce remains the commerce engine.
- Midtrans remains the payment gateway.
- Epeken remains the shipping/rate layer.
- Product Page V2 work has started through a Git-owned custom plugin: `wp-content/plugins/jedda-commerce-ui`.
- PDP V2 is currently disabled by default after a failed full-page visual pass.
- Next implementation milestone: Gallery V2 only.

## New Conversation Startup Procedure

Any AI engineer resuming this project must do this first:

1. Confirm repository:
   - Working directory: `/Users/maverick/Documents/JEDDA WEBSITE`
   - Remote: `git@github.com:dibuatpekat-eng/jedda-website.git`
2. Run:
   - `git status --short --branch`
   - `git log -5 --oneline`
3. Read these files in order:
   - `.jedda/99_CURRENT_STATE.md`
   - `.jedda/98_NEXT_ACTION.md`
   - `.jedda/97_PROJECT_IDENTITY.md`
   - `.jedda/96_ENGINEERING_INDEX.md`
   - `.jedda/31_PRODUCT_PAGE_V2_VISUAL_RECOVERY.md`
   - `.jedda/28_PRODUCT_PAGE_V2_PLAN.md`
   - `.jedda/29_PRODUCT_PAGE_V2_IMPLEMENTATION_STRATEGY.md`
4. Do not start coding until the current component milestone is reverse-engineered.
5. Do not redesign the full PDP in one pass.
6. Do not touch cart, checkout, Midtrans, Epeken, payment, order, stock, or customer data unless explicitly approved.

## Current PDP V2 Rule

Product Page V2 must now be implemented component by component:

1. Gallery
2. Product Summary
3. Title & Price
4. Variant Selector
5. Add-to-Cart
6. Product Details / Accordion
7. Recommendations
8. Mobile

For each component:

- Reverse-engineer the current implementation first.
- Identify theme, plugin, snippet, and WooCommerce dependencies.
- Rebuild only that component.
- Compare against JEDDA design direction: Toteme, SSSTEIN, MOIA Seoul, Nothing Written.
- Provide before/after screenshots.
- Explain why the change matches the design direction.
- Wait for approval before moving to the next component.

## Immediate Next Milestone

Gallery V2 only.

Expected output after the next milestone:

- Actual gallery DOM map.
- Dependency map for gallery/theme/plugin/Slick/lazy-load/image data.
- Visual direction for gallery image scale and rhythm.
- Before screenshot of current gallery.
- Gallery-only implementation through `jedda-commerce-ui`.
- After screenshot.
- Rollback path.
- Documentation update.
- Commit and push.
