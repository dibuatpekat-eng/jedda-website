# Next Action

Status: Awaiting Gallery V2 approval before next component.
Last updated: 2026-06-29.

## Immediate Next Step

Gallery V2 has been implemented and pushed. It is not yet activated on staging.

**Required before any further implementation:**

1. Enable PDP V2 on staging for Gallery QA:
   - Set `jedda_pdp_v2_enabled` option to `1` via WordPress admin → Settings → General → (WP option), or ask the AI engineer to do it via browser.
2. Open a product page on staging while logged in.
3. Review the gallery against the Toteme / SSSTEIN reference direction.
4. Confirm or reject Gallery V2.
5. Only after approval: move to Product Summary component.

## Gallery V2 Activation

The plugin is installed on staging but deactivated. Two steps are needed:

Step 1 — Activate the plugin:
- WordPress admin → Plugins → JEDDA Commerce UI → Activate.

Step 2 — Enable PDP V2 feature flag:
- WordPress admin → set `jedda_pdp_v2_enabled = 1`, or run:
  `wp option update jedda_pdp_v2_enabled 1`

To disable after QA:
- `wp option update jedda_pdp_v2_enabled 0`
- OR deactivate the plugin.

## Open Decision — Thumbnail Visibility

Gallery V2 hides thumbnail images entirely (12px indicator strip).
If QA shows visible thumbnails are preferred, a fallback is documented in `32_GALLERY_V2_MILESTONE.md`.

## After Gallery V2 Approval

Next component: **Product Summary**.

Scope:
- Buy panel spacing and vertical rhythm.
- Title and price hierarchy.
- Short description placement.

Not included in Product Summary:
- Variant selector (separate component).
- Add-to-cart (separate component).
- Gallery (already done).
- Cart, checkout, payment, stock.

## PDP V2 Component Order

1. Gallery ← IMPLEMENTED, awaiting approval
2. Product Summary
3. Title & Price
4. Variant Selector
5. Add-to-Cart
6. Product Details / Accordion
7. Recommendations
8. Mobile

Each component requires approval before the next begins.
