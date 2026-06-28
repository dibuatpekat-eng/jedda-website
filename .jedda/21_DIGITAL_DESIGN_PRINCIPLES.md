# JEDDA Digital Design Principles

Status: Created 2026-06-28. Documentation only. No website code changed.

Purpose: define JEDDA's own digital design language so future fixes and features follow one consistent standard.

## Core Direction

JEDDA's website should feel like a quiet fashion studio with complete commerce underneath.

- Image-first, not interface-first.
- Editorial, but not obscure.
- Minimal, but not under-designed.
- Premium, but not decorative.
- Calm, but responsive.
- Sparse, but reassuring where money, sizing, delivery, stock, and payment are involved.

## Reference Translation

- From ssstein: restraint, product grid discipline, sparse text, and quiet PDP hierarchy.
- From Toteme: complete commerce states, useful search, confident cart, polished checkout handoff, and specific edge-case messages.
- From Nothing Written: practical product information, direct category structure, and concise editorial framing.
- From MOIA Seoul: calm image scale, whitespace, quiet navigation, and mobile catalog rhythm.

JEDDA should not copy any reference literally. JEDDA should translate these shared qualities into its own ready-to-wear context.

## Typography

Principle: typography should be quiet, readable, and consistent.

- Use restrained sans-serif typography.
- Product names, prices, nav, form labels, and checkout copy should follow one controlled scale.
- Body and product text can be small, but never fragile on mobile.
- Use weight and spacing before size.
- Use larger type only for true editorial or campaign moments.
- Product names should be direct and clean.
- Interface copy should be short, useful, and consistent in casing.

Avoid:

- Micro text copied from references when it damages readability.
- Random theme/plugin font weights.
- Overly large promotional type.
- Mixed uppercase/lowercase patterns across similar controls.

## Spacing

Principle: spacing should create rhythm, not decoration.

- Use generous whitespace around campaign imagery.
- Use tighter, disciplined spacing inside product grids, cart, forms, and checkout.
- Maintain a consistent vertical rhythm: header, title/filter row, grid/content, pagination, footer.
- Keep page sections unframed unless the component genuinely needs containment.
- Avoid nested cards and decorative section boxes.

JEDDA's premium feeling should come from proportion, not from ornamental UI.

## Product Grid

Principle: the product grid is the main commercial expression of the brand.

- Desktop should use a refined multi-column grid.
- Mobile should prioritize image scale and readability over density.
- Product image ratios must be consistent.
- Product card metadata must be consistent across categories.
- Filter/sort controls should be compact but obvious.
- Applied filters should be visible and reversible.
- Empty or failed product loads should be designed states.

Avoid:

- Loud badges by default.
- Inconsistent crop ratios.
- Product information that appears only on hover.
- Stock labels that make the store feel depleted unless the state is necessary.

## Product Cards

Principle: product cards should be quiet but informative.

Required:

- Product image.
- Product name.
- Price.
- Availability state when relevant.
- Variant/color cue when useful.

Optional:

- Secondary image on hover.
- Color count.
- Quick add only when variant logic and feedback are reliable.

Interaction:

- Hover should be subtle: image swap, opacity, or underline.
- Focus state must be visible.
- Quick add must show loading, success, and error.
- Sold-out should feel intentional, not broken.

## Product Page

Principle: the product page should feel like a quiet fitting appointment.

Required hierarchy:

- Product images.
- Product name and price.
- Color/variant.
- Size selector and size guide.
- Stock state.
- Add to cart.
- Description.
- Material/care.
- Fit notes if available.
- Shipping/returns.
- Related or recently viewed products.

Interaction:

- Selecting a variant updates the active state immediately.
- Unavailable options are disabled and explained.
- Add to cart shows loading, then success or specific error.
- Size guide opens without losing PDP context.
- Accordions open smoothly and do not cause harsh layout jumps.
- Gallery behavior is stable on mobile.

Avoid:

- Hidden purchase controls.
- Generic WooCommerce alerts as the primary feedback.
- Decorative PDP modules that delay the buying decision.

## Navigation

Principle: navigation should feel quiet but obvious.

- Keep top-level navigation limited.
- Make search, account, and cart discoverable.
- Active states should be subtle but present.
- Category depth should match JEDDA's catalog, not a reference site's catalog.
- Mobile menu should open predictably, close easily, and trap focus.
- Closed menus/drawers should not remain focusable.

Avoid:

- Oversized mega-menu before it is needed.
- Icon-only critical controls without visible affordance and accessible labels.
- Off-canvas elements that confuse keyboard or screen reader flow.

## Cart

Principle: cart should feel like a composed checkpoint.

Required states:

- Empty cart.
- Filled cart.
- Quantity updating.
- Item removed.
- Stock conflict.
- Coupon success/error if coupons are used.
- Shipping unavailable.
- Checkout handoff.

Cart content:

- Product thumbnail.
- Product name.
- Selected variant.
- Quantity.
- Price.
- Subtotal.
- Shipping expectation.
- Clear checkout action.
- Continue shopping path.

Interaction:

- Quantity changes should acknowledge loading immediately.
- Remove should provide confirmation or undo.
- Errors should preserve cart context.
- Success should clearly show what changed.

## Checkout

Principle: checkout should be calm, linear, and trustworthy.

- Use clear sections: contact, shipping, billing, payment, review.
- Keep order summary visible or easily reachable.
- Explain shipping and payment transitions before they happen.
- Payment methods should feel official and safe.
- Validation should be inline and specific.
- Place order should prevent duplicate submit and show progress.
- Success page should confirm order status, payment state, and next communication.

Avoid:

- Generic checkout clutter.
- Surprise redirects.
- Hidden costs until late in the journey.
- Error messages that do not tell the shopper how to recover.

## Mobile Behavior

Principle: mobile is the primary proof of restraint.

- Preserve editorial calm without making text and controls too small.
- Use thumb-friendly tap targets.
- Avoid horizontal overflow.
- Keep product image scroll smooth and stable.
- Cart and checkout CTAs may be sticky only when they help decision-making.
- Mobile menu should not compete with product imagery.

Mobile should feel like a refined catalog, not a compressed desktop layout.

## Motion And Interaction

Principle: motion should confirm, not perform.

- Hover: subtle, immediate, and useful.
- Focus: visible and calm.
- Loading: immediate feedback within the clicked component.
- Transitions: short, stable, and layout-safe.
- Animation: only when it improves orientation or confidence.
- Error: specific, calm, and recoverable.
- Success: acknowledge action and show the next step.

Timing direction:

- Hover feedback: immediate to 150ms.
- Menu/drawer/accordion: 150-250ms.
- Add-to-cart loading: immediate.
- Page transitions: only if they do not slow perceived response.

Avoid:

- Decorative animation.
- Long fades.
- Interactions with no feedback.
- Hover-only behavior on touch-critical features.

## Empty, Loading, Error, And Success States

Principle: every state should feel designed.

Empty states:

- Short message.
- Reason when useful.
- Clear next step.
- No over-apology.

Loading states:

- Reserve space to avoid layout shift.
- Show progress near the action.
- Keep the page usable where possible.

Error states:

- Specific.
- Calm.
- Recoverable.
- Written in JEDDA's voice, not raw platform voice.

Success states:

- Confirm what happened.
- Show the next step.
- Avoid excessive celebration.

## Premium Feel

Premium for JEDDA means:

- Consistency.
- Image quality.
- Calm hierarchy.
- Readable restraint.
- Complete commerce states.
- Fast perceived response.
- Thoughtful copy.
- No generic platform residue.
- No hidden critical controls.

The target is not a more decorated website. The target is a more intentional website.
