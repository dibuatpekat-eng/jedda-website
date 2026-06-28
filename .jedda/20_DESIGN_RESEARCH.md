# Phase 6 Design Research

Status: Created 2026-06-28. Documentation only. No website code changed.

Purpose: translate the Phase 6 reference research into a digital design direction for JEDDA before customer journey audit, visual refinement, or implementation.

Primary references:

- ssstein
- Toteme
- Nothing Written
- MOIA Seoul

Evidence labels:

- VERIFIED: observed in existing `.jedda` documentation, git history, direct browser interaction, or fetched reference content.
- NOT VERIFIED: not directly observable in this pass.
- ASSUMPTION: strategic interpretation from verified evidence.

## Current JEDDA Context

- VERIFIED: Existing `.jedda` documentation describes JEDDA as minimalist, editorial, monochrome, fashion-led, sparse in copy, and image-first.
- VERIFIED: The current site is WordPress + WooCommerce using the `Upscale` parent theme, WPBakery, WooCommerce templates, plugins, and snippets.
- VERIFIED: The current implementation is inconsistent and should not be copied as the only design source of truth.
- VERIFIED: Public unauthenticated `https://beta.jeddawear.com` currently shows a browser-check / coming-soon gate, so the complete public customer journey was not verified in this pass.
- ASSUMPTION: JEDDA should become quiet editorial commerce: fashion-led and image-first, with complete, reassuring commerce states underneath.

## ssstein

What it does well:

- VERIFIED: ssstein uses restrained typography, monochrome UI, large editorial imagery, and disciplined product grids.
- VERIFIED: Product cards are quiet and consistent: product image, name, price, color count, sold-out state.
- VERIFIED: Product pages contain core buying information without decorative clutter: name, price, color, size, size guide, add to cart, details, material/care, shipping, recommendations.
- ASSUMPTION: Its premium feeling comes from restraint, repetition, and trust in the imagery.

Relevant to JEDDA:

- Use product imagery as the main emotional signal.
- Keep product cards structured and quiet.
- Let collection pages feel like a refined catalog, not a promotional landing page.
- Keep PDP modules minimal but complete.

What JEDDA should not copy:

- Do not copy extremely small typography when it hurts mobile readability.
- Do not hide search, cart, filter, or add-to-cart interactions so much that they become ambiguous.
- Do not let minimalism remove feedback after clicks.

Interaction learning:

- VERIFIED: ssstein's quiet controls feel premium at rest, but several search/cart/add controls were difficult to target in automated inspection because visible and hidden labels overlapped.
- ASSUMPTION: JEDDA should borrow the calmness, not the fragility. Important controls should remain visually quiet but unmistakable, keyboard-focusable, and easy to verify.

## Toteme

What it does well:

- VERIFIED: Toteme's shop-all structure combines editorial restraint with strong commerce organization.
- VERIFIED: The collection experience uses controlled product tiles, clear filtering/sorting, and view-density choices such as 2 / 4 / 8.
- VERIFIED: Search, cart, empty bag, payment, and help states are treated as designed experiences rather than platform leftovers.
- VERIFIED: Toteme's empty bag content gives the shopper a clear next step, shipping expectation, subtotal, checkout path, and payment context.
- VERIFIED: Toteme handles edge cases with specific messaging, such as preorder and in-stock item conflicts.
- ASSUMPTION: Toteme feels premium because the system is complete. It does not only look polished; it anticipates uncertainty.

Relevant to JEDDA:

- JEDDA should use Toteme as the strongest reference for commerce completeness.
- Search should feel useful, not just present.
- Cart should reassure: item details, subtotal, shipping expectation, payment confidence, and next action.
- Checkout should explain what happens next, especially payment handoff.
- Edge cases should use calm, specific JEDDA-language messages.

What JEDDA should not copy:

- Do not copy an oversized mega-menu unless JEDDA's catalog depth requires it.
- Do not copy heavy modal/cookie behavior that interrupts shopping.
- Do not copy Toteme's hierarchy literally; JEDDA needs its own category logic and Indonesian customer context.

Interaction learning:

- ASSUMPTION: Toteme's most important lesson is that premium interaction is complete interaction. Every click should produce orientation: opening, loading, confirmation, correction, or next step.

## Nothing Written

What it does well:

- VERIFIED: Nothing Written bridges brand philosophy and practical product browsing with concise editorial copy.
- VERIFIED: Navigation is commerce-ready: search, login, currency, bag, women, men, archives, about.
- VERIFIED: Product categories are practical and shopper-oriented.
- VERIFIED: Empty bag messaging is simple and understandable.
- ASSUMPTION: It feels premium because product utility and brand point of view are both present.

Relevant to JEDDA:

- A short brand/editorial statement can help JEDDA feel intentional when used sparingly.
- Categories should be clear enough for shopping, not only poetic.
- Empty states should be plain, useful, and calm.
- Product information can be practical without weakening the brand.

What JEDDA should not copy:

- Do not copy excessive category density.
- Do not keep hidden/offscreen navigation in a way that confuses focus, testing, or accessibility.
- Do not overload the first view with too many utilities.

Interaction learning:

- VERIFIED: Nothing Written's cart click leads to a dedicated basket page with an empty state.
- VERIFIED: Desktop search accepted typed input; mobile search was less visible in inspected output.
- ASSUMPTION: JEDDA should combine this practical clarity with a quieter, more consistent interaction layer.

## MOIA Seoul

What it does well:

- VERIFIED: MOIA uses a highly restrained visual system: simple text navigation, large campaign imagery, and very little UI decoration.
- VERIFIED: Product listing is spare, image-led, and direct.
- VERIFIED: Mobile browsing becomes an immersive vertical product scroll.
- ASSUMPTION: Its premium feeling comes from proportion, silence, and confidence in imagery.

Relevant to JEDDA:

- Use calm image scale and whitespace.
- Let mobile product browsing feel like a considered catalog scroll.
- Keep navigation simple and text-led.
- Let restraint create confidence.

What JEDDA should not copy:

- Do not remove feedback where commerce requires reassurance.
- Do not rely on empty links or invisible labels.
- Do not let sparse UI become ambiguous UI.

Interaction learning:

- VERIFIED: MOIA has very few visible button affordances in the inspected homepage state.
- ASSUMPTION: JEDDA should borrow MOIA's restraint but provide clearer purchase, cart, checkout, error, and success feedback.

## Cross-Reference Translation For JEDDA

JEDDA should sit between:

- ssstein and MOIA for restraint, rhythm, imagery, and quietness.
- Toteme for commerce completeness and interaction confidence.
- Nothing Written for pragmatic product information and subtle editorial context.

The target is not to copy a reference website. The target is to define JEDDA as:

Quiet editorial commerce. Image-first, restrained, consistent, and premium, but never vague at the moment of decision.

## JEDDA Interaction Standard

Every important interaction must answer: what happens after the click?

- Navigation click: the destination should load quickly, active context should be clear, and the user should not feel lost.
- Search click: search opens, input focuses, suggestions or results orient the shopper, and empty results offer a next step.
- Filter/sort click: control opens smoothly, applied filters are visible, loading is acknowledged, and reset is easy.
- Product card hover: image or text feedback may change subtly, but no essential purchase information should be hover-only.
- Product click: transition to PDP should feel immediate and stable.
- Variant click: active option must be visible; unavailable options must be disabled and explained.
- Add to cart click: button shows loading, then success or specific error.
- Cart quantity click: quantity updates with visible progress and no layout jump.
- Checkout submit: duplicate submits are prevented, validation is inline, and payment handoff is explained.

Interactions should feel:

- Premium: quiet, stable, and intentional.
- Smooth: short transitions, no jarring jumps.
- Reassuring: clear state changes after customer action.
- Responsive: immediate feedback even if the network is slow.
- Consistent: same state language across product, cart, and checkout.

Interactions should not feel:

- Distracting: no decorative motion.
- Fragile: no hidden critical controls.
- Generic: no raw platform messages as the final experience.
- Uncertain: no click without visible result.

## Research Conclusion

JEDDA's future design work should protect the current brand instinct: sparse, monochrome, editorial, and image-led. But the site must add system-level refinement: designed loading states, empty states, error states, success states, focus states, cart feedback, and checkout reassurance.

Premium is not fewer UI states. Premium is every state feeling considered.
