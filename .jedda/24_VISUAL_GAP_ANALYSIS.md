# Phase 7 — Visual Gap Analysis

Status: VERIFIED where observed on staging.
Staging URL: https://beta.jeddawear.com
Date: 2026-06-28

## Purpose

This document compares the current JEDDA staging website against the Phase 6 digital design direction.

The goal is not to copy ssstein, Toteme, Nothing Written, or MOIA Seoul. The goal is to hold JEDDA to its own standard: quiet, editorial, restrained, usable, precise, and premium after every interaction.

## Target Digital Language

From Phase 6, JEDDA should feel:

- Image-first, but not empty.
- Editorial, but still commercial.
- Restrained, but not unclear.
- Minimal, but never under-specified.
- Softly premium, with precise spacing and typography.
- Calm after every click, not just beautiful before interaction.

## Overall Gap

The current staging site has a strong visual base, especially in its product imagery, minimal navigation, and clean PDP content. The gap is consistency.

The visual system currently feels assembled from multiple layers:

- Theme defaults.
- WooCommerce defaults.
- Plugin-generated controls.
- Custom snippets.
- Editorial image choices.
- Checkout/cart block behavior.

This produces a site that can look premium in isolated moments but inconsistent across the full shopping journey.

## Gap Matrix

| Area | Current State | Target Standard | Gap | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Typography | Very small uppercase nav and product text; checkout/account headings sometimes hidden or zero-sized. | Restrained but legible type scale with clear hierarchy. | Type feels premium in the grid but fragile in forms and structural pages. | High | Medium | Define a complete commerce type scale for nav, product cards, PDP, cart, checkout, forms, errors, and empty states. | Visual system cleanup |
| Spacing | Homepage/grid feel clean; cart/checkout have theme/block spacing quirks. | Consistent vertical rhythm across journey. | Spacing does not yet feel governed by one system. | Medium | Medium | Establish spacing tokens and apply first to header, grid, PDP, cart, checkout, and empty states. | Visual system cleanup |
| Layout rhythm | Homepage and shop are image-led; checkout and account feel more default. | Editorial calm should continue into operational pages. | Premium feeling drops after browse phase. | High | Medium | Redesign operational layouts to match JEDDA rhythm without over-decorating. | Customer journey cleanup |
| Product grid | Clean 4-column desktop and 2-column mobile grid. | Image-led, stable, scannable, curated. | Out-of-stock-heavy first view and inconsistent mobile images reduce polish. | High | Medium | Stabilize product imagery and create sold-out sorting/display rules. | Customer journey cleanup |
| Product cards | Minimal image/title/price presentation. | Quiet but clearly interactive. | CTAs hidden and hover/focus/tap states are underdefined. | Medium | Low | Define card interaction states: default, hover, focus, tapped, sold out, loading image. | Visual system cleanup |
| PDP | Strong content and clear primary actions. | Reassuring product decision page with precise interaction feedback. | Content is strong, but validation/loading/success states are weak. | Critical | Medium | Fix variant validation and add-to-cart response before visual refinements. | Customer journey cleanup |
| Cart | Minimal and readable. | Calm, clear, action-oriented, reassuring. | Remove/coupon/quantity feedback is not yet premium. | Medium | Medium | Standardize cart controls and states. | Customer journey cleanup |
| Checkout | Restrained and simple. | Calm, explicit, trust-building. | Odd copy, hidden hierarchy, unverified validation. | High | Medium | Redefine checkout section hierarchy, field states, loading, errors, and payment handoff. | Customer journey cleanup |
| Navigation | Desktop is restrained. | Clear, stable, accessible on all breakpoints. | Mobile discoverability and search access need work. | High | Medium | Define desktop/mobile header patterns, menu behavior, search behavior, and cart state. | Customer journey cleanup |
| Buttons | PDP buttons are large and clear; other actions are inconsistent. | Buttons should communicate state precisely. | Disabled/loading/success/error states are inconsistent. | Critical | Medium | Create a button state standard and apply to PDP/cart/checkout. | Visual system cleanup |
| Forms | Checkout fields exist, but visual hierarchy and validation states are weak. | Forms should feel composed and reassuring. | Required, focus, error, success, and select states need design QA. | High | Medium | Design and test form states before full checkout testing. | Customer journey cleanup |
| Image treatment | Product imagery is strong; alt text and placeholders are inconsistent. | Images should be stable, meaningful, and polished. | Empty/numeric alt text and 1x1 placeholders hurt trust. | High | Medium | Standardize image alt, aspect ratio, placeholder, lazy-loading, and carousel behavior. | Visual system cleanup |
| Motion / interaction | Some default loading behavior exists. | Motion should be subtle, immediate, and informative. | Invalid add-to-cart can hang in loading; success is too implicit. | Critical | Medium | Define motion principles and repair conversion-state transitions. | Customer journey cleanup |
| Empty states | Cart has recommendations; search and 404 are generic. | Empty states should redirect intent elegantly. | Default Woo/theme copy remains visible. | Medium | Low | Write JEDDA empty/error copy and add useful next actions. | Customer journey cleanup |
| Mobile | Core pages fit narrow viewport. | Mobile should feel first-class, not compressed desktop. | Header/search visibility, image stability, cart speed, tap feedback need improvement. | High | Medium | Run dedicated mobile pass after core journey fixes. | Visual system cleanup |

## Typography

### Current Strength

The small, quiet typography on navigation and product cards can support JEDDA's premium direction. It avoids loud promotional energy and lets images carry the mood.

### Current Gap

The type system is incomplete. Product grid text may look intentional, but checkout and account headings show signs of theme/plugin workarounds, including visually hidden or zero-font headings. This makes the site feel less designed once customers leave the browse phase.

### JEDDA Standard

- Product grid text may be small, but must remain legible on mobile.
- Navigation can stay uppercase and restrained, but contrast and active states must be precise.
- Checkout and forms need visible hierarchy, not hidden structural headings.
- Error and success copy should use human, calm language.
- No default theme copy should remain if it has the wrong tone.

## Spacing

### Current Strength

The homepage and shop grid use whitespace effectively. They do not feel crowded.

### Current Gap

Spacing is inconsistent across commerce states. Empty cart, checkout fields, hidden headings, and block-generated layouts do not feel governed by one JEDDA rhythm.

### JEDDA Standard

- Use generous image spacing on browse pages.
- Use tighter, clearer spacing on operational pages like cart and checkout.
- Keep form spacing predictable and scannable.
- Avoid large empty gaps caused by hidden headings or plugin layout artifacts.

## Product Grid

### Current Strength

The grid has the strongest alignment with the Phase 6 direction:

- Image-first.
- Restrained metadata.
- Clean desktop rhythm.
- Simple mobile 2-column structure.

### Current Gap

The grid becomes less premium when:

- Many first-view products are out of stock.
- Mobile image sizing becomes inconsistent.
- Sorting/filtering controls are hidden.
- Product images have numeric or empty alt text.

### JEDDA Standard

- Product availability should feel curated.
- Sold-out products may remain visible, but should not dominate first impression.
- Product cards need stable image ratios and reliable loading.
- Product cards should have quiet but clear hover/focus/tap states.

## Product Cards

### Current Strength

The cards avoid clutter and keep focus on garments.

### Current Gap

The cards are too passive. Because `Select options` is hidden and hover/focus behavior is underdefined, customers may understand the grid visually but receive little interaction feedback.

### JEDDA Standard

Product cards should include:

- Stable image ratio.
- Product-aware alt text.
- Clear sold-out state.
- Subtle hover state on desktop.
- Clear focus-visible state for keyboard users.
- Tap feedback on mobile.
- No loud quick-buy pattern unless intentionally introduced later.

## Product Page

### Current Strength

The PDP content is reassuring. Fit, material, care, shipping, and returns are present, which supports premium confidence.

### Current Gap

The PDP is strongest before interaction and weakest during conversion. Invalid add-to-cart behavior is the most serious interaction gap observed.

### JEDDA Standard

The PDP should:

- Explain required selections before adding to cart.
- Prevent invalid loading states.
- Show clear add-to-cart success.
- Preserve selected variants.
- Offer clear next actions.
- Keep gallery images stable.
- Avoid carousel/offscreen artifacts.

## Navigation

### Current Strength

Desktop navigation is minimal and visually close to the desired direction.

### Current Gap

Mobile navigation and search need stronger verification and design definition. Search appears to exist in hidden/duplicated structures, which suggests theme/plugin residue rather than a single designed pattern.

### JEDDA Standard

Navigation should have defined states:

- Default.
- Hover.
- Focus-visible.
- Active page.
- Transparent-over-image.
- Scrolled or sticky, if used.
- Cart updated.
- Mobile menu open.
- Mobile menu closing.
- Search open.
- Search loading.
- Search empty.

## Buttons

### Current Strength

PDP primary buttons have strong size and clarity.

### Current Gap

Button state logic is inconsistent. The add-to-cart button can visually imply disabled, accept a click, then enter loading without feedback.

### JEDDA Standard

Every important button needs:

- Default state.
- Hover state.
- Pressed/tap state.
- Focus-visible state.
- Disabled state.
- Loading state.
- Success state.
- Error recovery state.

The visual state and functional state must always agree.

## Forms

### Current Strength

Checkout is restrained and avoids unnecessary visual noise.

### Current Gap

Form hierarchy and validation are not yet premium. Required states, select controls, and error handling require a safe full checkout QA pass after staging email delivery is controlled.

### JEDDA Standard

Forms should:

- Show labels clearly.
- Distinguish required and optional fields.
- Show focus visibly.
- Validate near the field.
- Preserve entered values after errors.
- Explain address-dependent shipping changes.
- Use calm success/error messages.
- Never expose debug-like copy.

## Cart

### Current Strength

Filled cart is simple and readable. Empty cart includes product recommendations.

### Current Gap

Cart controls need refinement. Remove, coupon, quantity, and checkout transition should feel intentional and responsive.

### JEDDA Standard

Cart should:

- Show selected variants clearly.
- Update quantity with visible loading and updated totals.
- Make removal clear but quiet.
- Show coupon success/error states.
- Explain shipping calculation.
- Provide a confident checkout CTA.

## Checkout

### Current Strength

The checkout layout is simple, and the Midtrans explanation is helpful.

### Current Gap

Checkout has several trust leaks:

- Odd copy near Billing Address.
- Hidden or zero-sized headings.
- Unverified validation behavior.
- Shipping calculation explanation needs more clarity.
- Full order flow cannot be safely tested until email safety is solved.

### JEDDA Standard

Checkout should feel like a calm service desk:

- Clear sections.
- Clear fields.
- Clear payment explanation.
- Clear loading.
- Clear validation.
- Clear final submission state.
- No accidental copy.
- No hidden structural hacks visible through layout behavior.

## Image Treatment

### Current Strength

JEDDA's strongest premium signal is product imagery.

### Current Gap

Image implementation does not yet match the quality of the imagery itself:

- Empty hero alt text.
- Numeric product alt text.
- 1x1 placeholders.
- Offscreen carousel items.
- Inconsistent mobile image sizing.

### JEDDA Standard

Images should:

- Load with stable dimensions.
- Use consistent aspect ratios by context.
- Have meaningful alt text.
- Avoid broken placeholder flashes.
- Use hover image changes only if smooth and intentional.
- Never create layout shift that makes the grid feel unstable.

## Motion and Interaction

### Current Strength

The site avoids excessive animation, which is correct for JEDDA.

### Current Gap

The issue is not too little decoration. The issue is too little feedback. Important interactions do not always communicate what happened.

### JEDDA Standard

Motion should be:

- Short.
- Subtle.
- Functional.
- Reassuring.
- Never decorative at the expense of clarity.

Required interaction feedback:

- Click: visible pressed or loading state within 100-200ms.
- Invalid action: immediate inline guidance.
- Add to cart: visible success and next action.
- Cart update: subtotal/total loading and completion.
- Form focus: clear outline or field state.
- Form error: field-level message and summary if needed.
- Search: visible open state, loading state, result count, empty state.

## Premium Feeling

JEDDA's premium feeling should come from restraint plus reliability.

The current site has restraint. It needs reliability.

Premium does not mean:

- Hiding useful controls.
- Making text too small to read.
- Letting buttons hang in loading.
- Leaving default WooCommerce copy visible.
- Allowing placeholder images to appear.
- Treating mobile as secondary.

Premium means:

- Every page feels composed.
- Every click has a response.
- Every state has a designed message.
- Every image loads intentionally.
- Every control looks quiet but works clearly.
- Every error helps the customer continue.

## Visual Cleanup Priorities

1. Repair PDP variant validation and add-to-cart states.
2. Define button and form state system.
3. Stabilize product image loading and mobile grid sizing.
4. Redesign search, empty states, and 404 in JEDDA tone.
5. Normalize cart and checkout hierarchy.
6. Define mobile header/menu/search behavior.
7. Create a typography and spacing standard that applies beyond browse pages.
