# Product Page V2 Milestone 2.6

Status: First safe V2 implementation milestone completed in Git.
Date: 2026-06-29
Scope: Custom plugin foundation plus initial PDP V2 presentation layer.

## Objective

Begin building JEDDA Product Page V2 as a Git-owned presentation layer while preserving the existing commerce engine.

This milestone does not change WooCommerce cart, checkout, Midtrans payment, Epeken shipping, orders, stock, coupons, taxes, or customer data.

## Implementation

Created custom plugin:

- `wp-content/plugins/jedda-commerce-ui/jedda-commerce-ui.php`
- `wp-content/plugins/jedda-commerce-ui/assets/css/pdp-v2.css`
- `wp-content/plugins/jedda-commerce-ui/assets/js/pdp-v2.js`
- `wp-content/plugins/jedda-commerce-ui/README.md`

The plugin starts Product Page V2 in enhancement mode:

- Product pages only.
- Adds `jedda-commerce-ui` and `jedda-pdp-v2` body classes only when enabled.
- Enqueues PDP V2 CSS/JS only on `is_product()` requests.
- Keeps WooCommerce templates, variation form, cart, checkout, payment, shipping, and orders untouched.
- Uses event-based JavaScript only.
- Uses no `MutationObserver`.

## Feature Flag And Kill Switch

Server-side disable:

- `define('JEDDA_PDP_V2_DISABLED', true)`
- or `update_option('jedda_pdp_v2_enabled', '0')`

Server-side enable:

- `define('JEDDA_PDP_V2_ENABLED', true)`
- or `update_option('jedda_pdp_v2_enabled', '1')`
- or staging host `beta.jeddawear.com`

Browser emergency kill switch:

- `localStorage.setItem('jedda:disable-pdp-v2', '1')`

Preferred rollback is server-side disable or plugin deactivation. The browser kill switch exists only as a quick local escape hatch.

## Presentation Layer Started

The first PDP V2 CSS pass begins replacing the inherited Upscale presentation layer with JEDDA-specific direction:

- Wider, calmer PDP layout rhythm.
- Desktop split between gallery and buy panel.
- Product image and thumbnail rhythm.
- Restrained product title and price hierarchy.
- Controlled buy-panel spacing.
- Variant/size group spacing and focus state direction.
- Add-to-cart button visual standard.
- Scoped styling for Sprint 2 validation/loading/success messages.
- Lower-page tabs, details, related, and upsell spacing direction.
- Mobile spacing and CTA tap-target adjustments.

The goal is not to polish Upscale defaults. The goal is to start a JEDDA-owned PDP presentation layer while using Upscale only as a functional base.

## JavaScript Scope

The PDP V2 JavaScript does not replace add-to-cart behavior.

It only:

- Honors the browser kill switch.
- Marks the PDP body as active.
- Adds form state classes when variation selections change.
- Uses event listeners for `change`, `click`, `DOMContentLoaded`, and `pageshow`.

No cart, checkout, payment, shipping, stock, or order logic is modified.

## Verification

Local verification completed:

| Check | Result |
| --- | --- |
| JavaScript syntax | PASSED with `node --check`. |
| Plugin file set | PASSED. Four expected files exist. |
| `MutationObserver` scan | PASSED. No implementation use found. |
| Checkout/payment/shipping logic scan | PASSED. Only guardrail comments/README references found. |
| PHP lint | NOT RUN. Local `php` command is unavailable in this environment. |
| Live staging activation | NOT RUN in this milestone. Requires WordPress plugin deployment/activation path. |

## Activation Test Required On Staging

Before considering PDP V2 visually validated in the browser:

1. Deploy/sync the plugin to staging.
2. Activate `JEDDA Commerce UI`.
3. Open a variable product PDP.
4. Confirm `jedda-pdp-v2` appears on `body`.
5. Confirm PDP V2 CSS and JS assets load only on product pages.
6. Test desktop PDP layout.
7. Test mobile PDP layout.
8. Test variant selection.
9. Test invalid add-to-cart.
10. Test valid add-to-cart.
11. Confirm Sprint 2 validation/loading/success snippets still work.
12. Confirm cart and checkout pages do not load PDP V2 assets.
13. Disable via server kill switch and confirm the previous PDP returns.

## Rollback

Rollback options:

1. Set `JEDDA_PDP_V2_DISABLED` to `true`.
2. Set `jedda_pdp_v2_enabled` option to `0`.
3. Deactivate the `JEDDA Commerce UI` plugin.
4. Revert the Git commit.

Because this milestone does not replace WooCommerce templates or deactivate Sprint 2 snippets, the current functional PDP remains the fallback.

## Next Recommended Milestone

After staging activation confirms the plugin loads safely, continue with one visual slice only:

- Tune PDP V2 typography and spacing against real PDP screenshots.
- Do not migrate Sprint 2 snippets yet.
- Do not change gallery behavior yet.
- Do not touch cart, checkout, Midtrans, Epeken, orders, or payment.
