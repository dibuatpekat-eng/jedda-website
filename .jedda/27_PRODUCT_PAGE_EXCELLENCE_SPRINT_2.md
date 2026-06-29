# Sprint 2 — Product Page Excellence

Status: Recovery checkpoint.
Date: 2026-06-29
Scope: Staging product detail page only.

## Permanent Method Update

Every component sprint now starts with Component Reverse Engineering.

Before modifying a component, identify the layers that build it:

- Theme.
- WooCommerce templates.
- WPBakery / page builder.
- Product short description.
- Product long description.
- Custom CSS.
- Custom JS.
- WPCode snippets.
- Code Snippets.
- WooCommerce hooks.
- Plugin output.
- Dynamic product data.
- Taxonomies / attributes.
- Related products / recommendations logic.

If something looks or behaves poorly, first identify where it comes from. Then choose the cleanest layer to fix it.

## Current Outcome

Sprint 2 started with the correct target: fix the product page as a complete conversion component, beginning with the critical invalid add-to-cart interaction documented in Phase 7.

The first implementation attempt is not considered successful and should not be treated as the final Sprint 2 implementation.

No website code in the repository was modified.

## Product Page Problem Being Addressed

Phase 7 identified the PDP add-to-cart flow as a critical customer journey issue:

- Clicking `ADD TO CART` before selecting required variants could put the button into a loading state.
- The customer did not receive clear inline guidance.
- The page did not immediately recover the button state.
- Valid add-to-cart feedback was also too quiet, relying mostly on delayed cart-count change.

For JEDDA, this is a premium trust issue. A product page can be visually strong, but the moment of purchase intent must feel calm, specific, and reassuring.

## Product Page Reverse Engineering

Status: Initial map based on existing `.jedda` documentation and served PDP HTML inspection. A logged-in visual/admin recheck is still required before activating any new snippet.

### Known Platform Layers

| Layer | Product Page Role | Current Understanding | Cleanest Fix Layer |
| --- | --- | --- | --- |
| Theme | Owns the base PDP layout, gallery structure, product summary placement, typography defaults, and responsive behavior. | VERIFIED in prior docs: site uses the `Upscale` parent theme. | Avoid parent-theme edits. Use a controlled child theme/custom plugin later; use a temporary staging snippet only for narrowly scoped validation. |
| WooCommerce templates | Own product title, price, variation form, add-to-cart button, stock messages, tabs, related products, and notices. | VERIFIED in prior docs: WooCommerce is the commerce core and product pages use WooCommerce behavior. | Prefer Woo hooks/templates for durable fixes after source ownership is cleaner. |
| WPBakery / page builder | Can affect surrounding product content and layout modules. | VERIFIED in prior docs: WPBakery is active in the design/content layer. | Do not use for variant validation logic. |
| Product short description | Likely feeds summary content near the purchase area. | ASSUMPTION until inspected in product admin. | Content-only edits belong in product data, not JS. |
| Product long description | Feeds deeper product storytelling/details if enabled in tabs/accordions. | ASSUMPTION until inspected in product admin. | Content-only edits belong in product data, not JS. |
| Custom CSS | Affects PDP typography, button styling, swatches, accordion/tabs, mobile spacing, and hidden states. | VERIFIED in prior docs: custom CSS exists across admin snippets/theme/page layers. | Use small scoped CSS only when required by the behavior; defer broad visual refinement. |
| Custom JS | Affects variation, stock, waitlist, badges, checkout/cart fragments, and other dynamic states. | VERIFIED: existing PDP HTML includes older custom JS, including unrelated `MutationObserver` use. | New Sprint 2 fix must be event-based only and must not use `MutationObserver`. |
| WPCode snippets | Many active snippets influence product, cart, checkout, order, email, and launch flows. | VERIFIED in prior docs: WPCode has many active snippets. | Do not add more WPCode unless Code Snippets/admin path is unavailable and stable. |
| Code Snippets | Runs PHP/JS snippets from admin. | VERIFIED in prior docs: active Code Snippets exists; Sprint 2 attempted active snippet likely ID `12` was manually deactivated. | Temporary staging-only PDP validation can live here if admin/browser is stable and rollback is clear. |
| WooCommerce hooks | Provide durable event/action/filter points for notices, add-to-cart, variation form, and product metadata. | VERIFIED by platform behavior; exact hook ownership not yet mapped from theme files. | Best durable destination after snippet consolidation. |
| Plugin output | Plugins can add swatches, badges, waitlist, direct checkout, labels, cart fragments, analytics, and availability behavior. | VERIFIED in prior docs: plugin stack is layered and includes Woo-related extensions. | Do not alter plugin settings during PDP variant-validation sprint. |
| Dynamic product data | Product title, price, stock, variations, images, SKU, and attributes drive the PDP. | VERIFIED by WooCommerce product model. | Do not modify product data for this sprint. |
| Taxonomies / attributes | Color and size are variation attributes that drive required selection. | VERIFIED from Phase 7 behavior. | Validation should read WooCommerce variation select values rather than duplicating product rules. |
| Related products / recommendations | Woo/theme logic outputs related/recommended products below PDP. | VERIFIED in Phase 7 as present but visually inconsistent. | Out of scope for PDP Variant Validation milestone. |

### Product Page Area Map

| Area | Likely Source Layers | Sprint 2 Decision |
| --- | --- | --- |
| Gallery | Theme + WooCommerce product images + lazy-loading/plugin behavior. | Out of scope. Do not touch. |
| Product title | WooCommerce template + dynamic product data + theme typography. | Out of scope. Do not touch. |
| Price | WooCommerce template + dynamic product/variation pricing + theme styling. | Out of scope. Do not touch. |
| Short description | Product short description + WooCommerce summary template + theme styling. | Out of scope. Do not touch. |
| Size / variant selector | WooCommerce variation form + taxonomy attributes + swatch plugin/theme JS/CSS. | In scope only as read-only inputs for validation. |
| Add to cart | WooCommerce variation form + theme button styling + WooCommerce JS + custom snippets. | In scope only for preventing invalid stuck loading and showing guidance. |
| Out of stock / preorder states | WooCommerce stock data + plugin/snippet output + existing custom JS. | Out of scope. Do not touch. |
| Accordion / tabs | WooCommerce tabs + theme accordion styling/JS + product long description/data. | Out of scope. Do not touch. |
| Product description | Product long description + WooCommerce tabs/theme content. | Out of scope. Do not touch. |
| Recommendations / related products | WooCommerce related products + theme carousel/grid + product categories/tags. | Out of scope. Do not touch. |
| Mobile layout | Theme responsive CSS + Woo templates + plugin/snippet overlays. | Only smoke-test invalid validation if implementation happens. No visual/mobile layout change. |
| Interaction logic | WooCommerce variation events + theme/plugin scripts + custom WPCode/Code Snippets. | In scope only through a small event-based guard. No observer, no success feedback, no broader polish. |

## Incident Summary

During Sprint 2, a frontend snippet named `JEDDA PDP Interaction Polish - Sprint 2 Active` was activated on staging, likely Code Snippets ID `12`.

The snippet used a `MutationObserver` to keep PDP state in sync after WooCommerce variation changes. After activation, the PDP/browser became unstable and testing began to hang.

The fastest and safest recovery path was to deactivate the active snippet from WordPress admin. That recovery was completed manually by the founder.

After deactivation, a non-executing HTML check confirmed that the Sprint 2 snippet markers were no longer being served on the PDP:

- `JEDDA PDP Interaction Polish - Sprint 2 Active`: not found in served PDP HTML.
- `jedda-pdp-variant-guard`: not found in served PDP HTML.
- `jedda-pdp-polish`: not found in served PDP HTML.

The PDP HTML still contains older unrelated `MutationObserver` usage from existing site snippets, including out-of-stock / waitlist behavior. Those were not created by this Sprint 2 attempt and were not changed.

## Root Cause

The likely root cause was an observer feedback loop.

The active snippet observed DOM attribute/class changes while also setting attributes/classes as part of the state sync. This can cause repeated callbacks, browser main-thread pressure, and a locked testing session.

Even if the logic is technically bounded, observer-based code is a poor fit for this PDP interaction because WooCommerce already provides more specific event hooks.

## Lesson Learned

Do not use broad observers for PDP interaction polish unless there is no simpler event-based option.

Future frontend snippets must follow these rules:

1. Prefer event-based implementation over `MutationObserver`.
2. If an observer is unavoidable, observe the narrowest possible target and never observe attributes that the snippet itself mutates.
3. Add a kill switch before activation.
4. Activate only one small behavior at a time.
5. Test invalid, valid, reload, mobile, and rollback paths before adding the next behavior.
6. Avoid editing an existing snippet if the editor has shown append/replace instability; create a fresh snippet instead.

## Required Kill Switch Standard

Every future staging frontend snippet should include a reversible kill switch before activation.

Recommended pattern:

```js
if (window.localStorage && window.localStorage.getItem('jedda:disable-pdp-polish') === '1') {
  return;
}
```

Rollback path:

1. Set `localStorage.setItem('jedda:disable-pdp-polish', '1')` in the affected browser if frontend access still works.
2. Deactivate the active snippet in Code Snippets or WPCode.
3. Clear page cache if caching is later enabled.
4. Verify the snippet marker is absent from served PDP HTML.

## Next Safe Implementation Path

The next implementation should be smaller than the failed attempt.

### Step 1 — Invalid Variant Guard Only

Implement only the invalid add-to-cart recovery.

Behavior:

- Listen to `click` on `.single_add_to_cart_button`.
- Listen to `submit` on `form.variations_form.cart`.
- If required variation selects are empty, prevent submit.
- Remove loading/busy/disabled states immediately.
- Show one concise inline message near the add-to-cart button.
- Add small field-level guidance near missing option groups.
- Focus the first missing option group when possible.
- Clear the message on WooCommerce variation events and select changes.

Do not add success messaging in the same first activation.

### Step 2 — Test

Required test after Step 1:

- PDP loads without hang.
- Sprint 2 snippet marker appears exactly once.
- Clicking add-to-cart with no variant does not enter a stuck loading state.
- Missing color and size are named clearly.
- Selecting color and size clears the warning.
- Reloading the PDP remains stable.
- The snippet can be deactivated quickly.

### Step 3 — Add Success Feedback Later

Only after Step 1 is stable, add restrained success feedback.

Preferred behavior:

- Listen to WooCommerce `added_to_cart` event.
- Show a calm inline success message.
- Include clear next action text such as `Added to cart. View cart or continue shopping.`
- Do not force a drawer/modal until the cart component has been reviewed.

## What Requires Approval

No approval is needed for a staging-only event-based invalid-variant guard if:

- It is implemented as a small isolated snippet.
- It has a kill switch.
- It does not touch payment, checkout, orders, stock, or customer data.
- It is tested before adding any second behavior.

Approval is required before:

- Production activation.
- Checkout/payment/order changes.
- Plugin updates/removal.
- Any database cleanup.
- Any broader architecture migration from snippets into a child theme or custom plugin.

## Current Blocker

After the rollback, the in-app logged-in browser session remained unstable:

- Loading the PDP through the logged-in browser timed out.
- Loading Code Snippets admin through the logged-in browser also timed out.
- The browser control session could not list tabs after the hang.
- On the Sprint 2 continuation check, the browser channel again timed out while listing tabs before any admin or PDP action.

A separate headless Chrome session could run, but unauthenticated traffic reached the browser-check gate instead of the real PDP, so it could not validate customer behavior.

Because the active browser/admin channel was not stable, no replacement snippet was activated in this checkpoint. Activating another frontend snippet without a working test and rollback channel would be unsafe.

## PDP Variant Validation Milestone Status

Status: Not activated.

Reason: The required precondition failed. Admin/browser stability could not be confirmed.

Decision: Stop before implementation. The next implementation remains PDP Variant Validation only:

- One behavior only.
- Event-based implementation only.
- No `MutationObserver`.
- No success feedback.
- No loading-state redesign.
- No recommendations logic.
- No visual refinement beyond the minimum inline validation message required by the behavior.

## Expected Impact After Next Safe Fix

Once the event-based invalid-variant guard is safely implemented, expected customer impact:

- PDP no longer feels broken when variants are missing.
- Customers receive specific guidance at the exact point of friction.
- The add-to-cart button state recovers immediately.
- The product page moves closer to the JEDDA design principle that every interaction should feel calm, intentional, and reassuring.

## Rollback Plan For Next Attempt

If the next event-based snippet causes issues:

1. Use the snippet kill switch if frontend access still works.
2. Deactivate the new snippet in Code Snippets.
3. Verify the marker is absent with a non-executing HTML check.
4. Keep the previous failed observer snippet inactive.
5. Document the failure before attempting a second fix.

## Follow-Up Recommendation

Before continuing implementation, recover a stable logged-in admin/browser channel, then restart with Step 1 only.

The next fix should be named clearly, for example:

`JEDDA PDP Variant Guard - Sprint 2`

It should not reuse the failed `JEDDA PDP Interaction Polish - Sprint 2 Active` snippet.
