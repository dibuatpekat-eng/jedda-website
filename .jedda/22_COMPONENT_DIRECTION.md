# JEDDA Component Direction

Status: Created 2026-06-28. Documentation only. No website code changed.

Purpose: translate Phase 6 design principles into component-level standards for future website fixes and features.

This is not an implementation spec and does not authorize code changes.

## Global Component Rules

- Components should be quiet, precise, and useful.
- Product imagery should remain dominant.
- Clarity should come from hierarchy, spacing, copy, and consistent states.
- Default WooCommerce/plugin output should not remain visible if it breaks the JEDDA tone.
- Accessibility states are part of the design language.
- Mobile behavior must be intentionally designed, not inherited from desktop.

## Header And Navigation

Desktop:

- Keep the brand immediately recognizable.
- Use a small set of top-level links.
- Keep search, account, and cart visible enough to trust.
- Use subtle active states.

Mobile:

- Header remains compact and stable.
- Menu trigger is easy to tap.
- Menu opens with a simple slide or fade.
- Menu close is obvious.
- Closed menu content is not focusable.
- Cart remains easy to reach.

States:

- Hover: underline, opacity, or quiet text state.
- Focus: visible focus ring or equivalent.
- Loading: no blocking unless required.
- Error: avoid generic browser or platform states.

## Product Grid Component

Desktop:

- Disciplined multi-column layout.
- Stable card dimensions.
- Consistent image ratio.
- Compact category/filter/sort row.
- Pagination or load-more that does not dominate the page.

Mobile:

- Prefer image clarity over density.
- One-column is safest for premium browsing; two-column only if typography and tap targets remain strong.
- Avoid cramped product metadata.

States:

- Loading: reserved image space or skeleton.
- Empty: short message and path back to key collection.
- Error: explain load failure and offer retry.
- Filtered empty: show applied filters and reset path.

## Product Card Component

Required:

- Product image.
- Product name.
- Price.
- Availability when relevant.
- Variant/color cue when useful.

Optional:

- Secondary image on hover.
- Color count.
- Quick add only when variant rules are simple.

States:

- Default.
- Hover.
- Focus.
- Loading image.
- Sold out.
- Quick add loading.
- Quick add success.
- Quick add error.

Direction:

- Hover should be subtle and useful.
- Focus should be visible.
- Essential information must not be hover-only.
- Sold-out state should be quiet but clear.

## Product Detail Component

Layout:

- Large gallery/image area.
- Stable purchase information area.
- Minimal product details.
- Related products lower on page.

Required:

- Product title.
- Price.
- Color/variant selector.
- Size selector.
- Size guide.
- Add to cart.
- Description.
- Material/care.
- Shipping/returns.
- Availability.

States:

- Variant selected.
- Variant unavailable.
- Size selected.
- Size missing.
- Add to cart loading.
- Add to cart success.
- Add to cart error.
- Gallery loading.
- Accordion expanded/collapsed.

Interaction:

- Variant and size clicks update immediately.
- Add to cart should never feel like nothing happened.
- Errors should appear near the action.
- Size guide should open without navigating away.
- Mobile gallery should swipe or scroll smoothly without trapping the user.

## Buttons And Links

Primary button:

- Add to cart.
- Checkout.
- Place order.
- High contrast, minimal shape, stable height.

Secondary button:

- Continue shopping.
- View bag.
- Apply coupon.
- Return/edit.

Text link:

- Navigation.
- Size guide.
- Policy.
- Remove/edit.

States:

- Default.
- Hover.
- Focus.
- Active.
- Loading.
- Disabled.
- Success.
- Error.

Rule: every commerce button must provide feedback after click.

## Forms

Field direction:

- Label above field.
- Simple border or underline.
- Clear focus state.
- Error text directly below field.
- Helper text only when useful.

Checkout form direction:

- Group fields by task.
- Keep section headings small and functional.
- Preserve order summary access.
- Avoid layout jumps after validation.

States:

- Empty.
- Focused.
- Filled.
- Invalid.
- Valid.
- Disabled.
- Loading.

Messages:

- Error: specific and calm.
- Success: confirms completion and next step.
- Empty: neutral, not apologetic.

## Search Component

Direction:

- Opens quickly.
- Input focuses automatically.
- Suggestions or popular categories appear when useful.
- Results use the product-grid language.
- No-results offers a next step.

States:

- Closed.
- Open.
- Typing.
- Loading.
- Results.
- No results.
- Error.
- Clear/close.

Do not:

- Make search only an ambiguous icon.
- Show generic no-results copy.
- Let search trap focus after close.

## Filter And Sort Components

Direction:

- Keep filters lightweight.
- Use filters that help buying decisions: category, size, color, availability, price/order if needed.
- Applied filters must be visible and removable.

States:

- Closed.
- Open.
- Applied.
- Loading.
- Empty result.
- Reset.

Interaction:

- Opening should be smooth and contained.
- Applying should show immediate feedback.
- Reset should be easy to find.

## Cart Component

Cart may be a drawer or page, but it must be complete.

Required states:

- Empty.
- Filled.
- Updating quantity.
- Removing item.
- Removed with undo or confirmation.
- Stock conflict.
- Coupon applied.
- Coupon error.
- Shipping unavailable.
- Checkout handoff.

Content:

- Product thumbnail.
- Product name.
- Variant.
- Quantity.
- Price.
- Subtotal.
- Shipping expectation.
- Checkout action.
- Continue shopping.

Interaction:

- Quantity update shows progress.
- Remove does not erase context.
- Checkout click shows progress or navigates immediately.
- Errors explain how to recover.

## Checkout Component

Direction:

- More explicit than editorial pages, but still restrained.
- Organized by task.
- Clear order summary.
- Clear payment handoff.

Required states:

- Empty checkout.
- Guest checkout.
- Logged-in checkout.
- Shipping loading.
- Shipping unavailable.
- Payment method selected.
- Payment redirect/handoff.
- Validation error.
- Payment failure.
- Order success.

Interaction:

- Inline validation after blur or submit.
- Place order loading state.
- Duplicate-submit prevention.
- Payment copy explains what happens next.
- Success state confirms order, payment, and next communication.

## Feedback Message Component

Tone:

- Short.
- Calm.
- Specific.
- Human but not chatty.

Preferred examples:

- `Select a size to continue.`
- `This size is currently unavailable.`
- `Added to cart.`
- `Your cart is empty.`
- `We could not update the quantity. Please try again.`

Avoid:

- Raw plugin messages.
- `Oops!`
- `Something went wrong` without recovery guidance.

## Empty State Component

Use for:

- Empty cart.
- No search results.
- Empty category.
- Filtered empty result.
- Failed load.

Direction:

- Say what happened.
- Keep tone calm.
- Provide one clear next action.
- Use curated product/category links when possible.

## Loading State Component

Use for:

- Product images.
- Collection filtering.
- Search.
- Add to cart.
- Cart quantity updates.
- Checkout submit.
- Payment handoff.

Direction:

- Feedback appears near the action.
- Reserve layout space.
- Avoid full-page blocking unless unavoidable.
- Preserve perceived responsiveness.

## Error State Component

Use for:

- Validation errors.
- Stock conflicts.
- Shipping unavailable.
- Payment failure.
- Product load failure.
- Search failure.

Direction:

- Explain specifically.
- Keep the user in context.
- Provide recovery.
- Use brand-quiet language.

## Success State Component

Use for:

- Added to cart.
- Quantity updated.
- Coupon applied.
- Form submitted.
- Order placed.

Direction:

- Confirm what changed.
- Show the next step.
- Do not over-animate.
- Keep the brand tone calm.

## Implementation Guardrail For Future Phases

This document does not change the website.

Future implementation should happen only after:

- Customer journey audit is complete.
- Relevant `.jedda` docs are updated.
- The implementation path is chosen deliberately: child theme, custom plugin, theme setting, or controlled snippet.
- Staging safety checklist is satisfied.

The component standard for JEDDA is: quiet, editorial, image-first, and commerce-complete.
