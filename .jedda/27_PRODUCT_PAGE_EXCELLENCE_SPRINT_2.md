# Sprint 2 — Product Page Excellence

Status: Recovery checkpoint.
Date: 2026-06-29
Scope: Staging product detail page only.

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

A separate headless Chrome session could run, but unauthenticated traffic reached the browser-check gate instead of the real PDP, so it could not validate customer behavior.

Because the active browser/admin channel was not stable, no replacement snippet was activated in this checkpoint. Activating another frontend snippet without a working test and rollback channel would be unsafe.

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
