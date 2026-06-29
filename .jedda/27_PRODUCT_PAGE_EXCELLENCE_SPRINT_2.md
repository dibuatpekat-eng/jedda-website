# Sprint 2 — Product Page Excellence

Status: Sprint 2.1 milestone active on staging.
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

## Earlier Browser Blocker

After the rollback, the in-app logged-in browser session remained unstable:

- Loading the PDP through the logged-in browser timed out.
- Loading Code Snippets admin through the logged-in browser also timed out.
- The browser control session could not list tabs after the hang.
- On the Sprint 2 continuation check, the browser channel again timed out while listing tabs before any admin or PDP action.

A separate headless Chrome session could run, but unauthenticated traffic reached the browser-check gate instead of the real PDP, so it could not validate customer behavior.

At that checkpoint, no replacement snippet was activated. Activating another frontend snippet without a working test and rollback channel would have been unsafe.

## PDP Variant Validation Milestone Status

Status: Activated and tested on staging.

Snippet:

- `JEDDA PDP Variant Validation - Sprint 2.1`
- Code Snippets ID: `13`
- Scope: Product pages only through `wp_footer` with `is_product()` guard.
- Kill switch: `localStorage.setItem('jedda:disable-pdp-variant-validation', '1')`

Implementation rules followed:

- One behavior only: invalid required-variant add-to-cart validation.
- Event-based implementation only.
- No `MutationObserver`.
- No success feedback.
- No loading-state redesign.
- No recommendations logic.
- No visual refinement beyond the minimum inline validation message required by the behavior.

Why the environment is considered stable now:

- The upgraded extension-backed Chrome target was available separately from the old in-app browser.
- A real logged-in WordPress Chrome tab was claimed successfully.
- Admin navigation remained responsive across Plugins, Dashboard, Products, and Code Snippets.
- PDP navigation and DOM inspection worked.
- Raw CDP inspection worked by reading the PDP document title.
- Code Snippets opened after activation without hanging.
- Browser tab listing remained responsive after the regression test.

Why the previous issue appears resolved:

The prior blocker was tied to the old in-app/logged-in browser control path after the failed observer snippet. The upgraded environment exposes a separate Chrome extension target with a real logged-in profile and direct CDP capability. Navigation and inspection now complete through that path, so the browser tooling is no longer stuck at tab listing or admin navigation.

Regression test:

| Test | Result |
| --- | --- |
| PDP loads with snippet marker | PASSED. Marker appeared exactly once. |
| No variants selected before click | PASSED. `attribute_color` and `attribute_size` were empty. |
| Click `Add to cart` | PASSED. Inline validation appeared. |
| Loading/busy state | PASSED. Button did not retain `loading`; `aria-busy` remained absent. |
| Cart side effect | PASSED. Cart stayed `0`; no item was added. |
| Message text | PASSED. `Please select color and size before adding this piece to your cart.` |
| Field guidance | PASSED. `Please select color.` and `Please select size.` appeared. |
| Code Snippets after activation | PASSED. Snippets page opened and the new snippet appeared active. |

Rollback:

1. In frontend browser console, set `localStorage.setItem('jedda:disable-pdp-variant-validation', '1')` if emergency frontend bypass is needed.
2. Deactivate Code Snippets ID `13`, `JEDDA PDP Variant Validation - Sprint 2.1`.
3. Verify the PDP no longer contains `[data-jedda-pdp-variant-validation="2026-06-29"]`.
4. Keep the failed observer snippet inactive.

## PDP Loading Feedback Milestone Status

Status: Activated and tested on staging.

Final active snippet:

- `JEDDA PDP Loading Feedback - Sprint 2.2 Active`
- Code Snippets ID: `18`
- Scope: Product pages only through `wp_footer` with `is_product()` guard.
- Kill switch: `localStorage.setItem('jedda:disable-pdp-loading-feedback', '1')`

Superseded attempts:

- Code Snippets ID `14`: deactivated. Direct listener cleared too early.
- Code Snippets ID `15`: deactivated. Direct listener remained too fragile after variation state changes.
- Code Snippets ID `16`: deactivated. Delegated listener still did not initialize reliably enough.
- Code Snippets ID `17`: deactivated. XHR completion approach printed but needed load/pageshow-safe initialization.

Implementation rules followed:

- One behavior only: valid add-to-cart loading/busy feedback.
- Event-based implementation only: delegated form click/submit, `pageshow`, native XHR `loadend`, and add-to-cart completion events.
- No `MutationObserver`.
- No recommendations changes.
- No global PDP redesign.
- No checkout/cart logic changes.
- Minimal visual treatment: button opacity/cursor, `Adding...` text, and `aria-busy`.

Why the final approach was chosen:

The PDP variation form and theme/Woo scripts can update the add-to-cart button after variation selection. A direct button listener was too fragile. The final snippet initializes idempotently on page lifecycle events, uses delegated form-level capture so it can survive button updates, and clears only after an add-to-cart request completes.

Regression test:

| Test | Result |
| --- | --- |
| Existing commits pushed before work | PASSED. `origin/main` was updated before 2.2 started. |
| Code Snippets and PDP precheck | PASSED. Admin and PDP remained responsive in extension-backed Chrome. |
| PDP markers | PASSED. Variant validation marker `1`; loading feedback marker `1`. |
| Invalid variant click | PASSED. 2.1 validation still owns the missing-variant state; no loading/busy state appeared. |
| Valid variation selection | PASSED. `Breen` + `S/M` selected and variation ID `13113` resolved. |
| Valid add-to-cart immediate state | PASSED. Button changed to `Adding...`, gained `aria-busy="true"`, and gained `jedda-pdp-is-adding`. |
| Valid add-to-cart completion | PASSED. Button restored to `Add to cart`, `aria-busy` was removed, and cart count updated. |
| Code Snippets after activation | PASSED. Snippets page remained responsive and both Sprint snippets were visible. |

Rollback:

1. In frontend browser console, set `localStorage.setItem('jedda:disable-pdp-loading-feedback', '1')` if emergency frontend bypass is needed.
2. Deactivate Code Snippets ID `18`, `JEDDA PDP Loading Feedback - Sprint 2.2 Active`.
3. Verify the PDP no longer contains `[data-jedda-pdp-loading-feedback="2026-06-29"]`.
4. Keep superseded snippets `14`, `15`, `16`, and `17` inactive.

## PDP Success Feedback Milestone Status

Status: Activated on staging and manually verified by the owner in Chrome.

Active snippet:

- `JEDDA PDP Success Feedback - Sprint 2.3 Active`
- Code Snippets ID: `19`
- Scope: Product pages only through `wp_footer` with `is_product()` guard.
- Kill switch: `localStorage.setItem('jedda:disable-pdp-success-feedback', '1')`

Implementation rules followed:

- One behavior only: immediate success confirmation after a valid PDP add-to-cart.
- Event-based implementation only: click/submit intent tracking, WooCommerce `added_to_cart`, and native XHR `loadend` completion.
- No `MutationObserver`.
- No recommendations changes.
- No checkout/cart logic changes.
- No global PDP redesign.
- No mini-cart auto-open.
- Minimal visual treatment: a quiet inline `Added to cart.` status message under the add-to-cart action.

Experience alternatives evaluated:

| Option | Decision | Reason |
| --- | --- | --- |
| Subtle inline confirmation | Chosen | Best matches JEDDA's premium direction: local, calm, restrained, and reassuring without interrupting the product page. |
| Button success-state change only | Rejected for this milestone | Too easy to miss after the loading state resolves and can make the button feel like a changing control instead of a stable purchase action. |
| Mini-cart interaction | Rejected for this milestone | More intrusive and touches the cart surface before the cart component has its own review. This would be a second behavior. |
| Cart badge update only | Rejected as the primary feedback | Useful as background confirmation, but too subtle to reassure the customer at the moment of purchase intent. |

Why the final approach was chosen:

JEDDA's reference direction from Toteme, ssstein, Nothing Written, and MOIA Seoul favors quiet precision over noisy UI. A local inline confirmation gives the customer certainty without a modal, toast, drawer, or checkout pressure. It keeps the PDP focused on the garment while making the purchase interaction feel intentional and complete.

Verification:

| Test | Result |
| --- | --- |
| Owner manual Chrome PDP access | PASSED. Staging product page opened normally. |
| Invalid add-to-cart flow | PASSED. Invalid variant state remained testable and did not show success feedback. |
| Valid add-to-cart flow | PASSED. Valid add-to-cart could be completed safely on staging. |
| Success feedback | PASSED. Inline success feedback appeared after valid add-to-cart. |
| Code Snippets admin | PASSED. Admin remained responsive after activation. |
| Codex browser/CDP session | BLOCKED. Clean automation sessions timed out on PDP access, while the owner manually verified the site was healthy. Treat this as a Codex browser/CDP session issue, not a website issue. |

Rollback:

1. In frontend browser console, set `localStorage.setItem('jedda:disable-pdp-success-feedback', '1')` if emergency frontend bypass is needed.
2. Deactivate Code Snippets ID `19`, `JEDDA PDP Success Feedback - Sprint 2.3 Active`.
3. Verify the PDP no longer contains `jedda-pdp-success-feedback-sprint-23`.
4. Keep earlier Sprint snippets isolated; do not merge validation, loading, and success feedback until the PDP behavior is migrated into a cleaner version-controlled layer.

## Expected Impact So Far

The event-based invalid-variant guard and loading feedback should improve the most fragile PDP conversion moments:

- PDP no longer feels broken when variants are missing.
- Customers receive specific guidance at the exact point of friction.
- The add-to-cart button state recovers immediately.
- Valid add-to-cart now gives immediate busy feedback instead of feeling inert.
- Successful add-to-cart now receives calm inline confirmation instead of relying only on a delayed cart-count change.
- The product page moves closer to the JEDDA design principle that every interaction should feel calm, intentional, and reassuring.

## Rollback Plan For Next Attempt

If the next event-based snippet causes issues:

1. Use the snippet kill switch if frontend access still works.
2. Deactivate the new snippet in Code Snippets.
3. Verify the marker is absent with a non-executing HTML check.
4. Keep the previous failed observer snippet inactive.
5. Document the failure before attempting a second fix.

## Follow-Up Recommendation

For the next Sprint 2 milestone, continue with one behavior only and keep each implementation isolated in its own reversible snippet until the PDP behavior is migrated into a cleaner version-controlled layer.

Do not reuse the failed `JEDDA PDP Interaction Polish - Sprint 2 Active` snippet.
