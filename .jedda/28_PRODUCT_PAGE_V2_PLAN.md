# Product Page V2 Design Plan

Status: Created 2026-06-29. Documentation only. No website code changed.
Scope: Product Detail Page V2 direction before visual implementation.

This plan uses:

- `20_DESIGN_RESEARCH.md`
- `21_DIGITAL_DESIGN_PRINCIPLES.md`
- `22_COMPONENT_DIRECTION.md`
- `23_CUSTOMER_JOURNEY_AUDIT.md`
- `24_VISUAL_GAP_ANALYSIS.md`
- `27_PRODUCT_PAGE_EXCELLENCE_SPRINT_2.md`

Milestone 2.4 does not authorize code changes, snippets, theme edits, plugin updates, or behavior changes.

## Objective

Define the JEDDA Product Page V2 direction before coding visual changes.

The PDP should feel like a quiet fitting appointment:

- Image-first.
- Precise.
- Calm.
- Commercially complete.
- Editorial without becoming vague.
- Minimal without leaving the customer uncertain.

The page should translate the reference direction from Toteme, ssstein, Nothing Written, and MOIA Seoul into JEDDA's own language. The goal is not to copy any reference. The goal is to make JEDDA's PDP feel restrained at rest and reassuring after every interaction.

## Current PDP Read

The current product page already has a good base:

- Product imagery leads the page.
- The page is visually quiet.
- Product details, fit, material, care, shipping, and returns are present.
- The primary purchase action is visible.
- Variant swatches are cleaner than default dropdowns.
- Sprint 2.1, 2.2, and 2.3 improved invalid variant validation, loading feedback, and success feedback through isolated staging snippets.

The remaining gap is the presentation system:

- The page still feels assembled from Upscale theme templates, WooCommerce output, plugin output, snippets, and product content.
- PDP interaction states are now better, but their visual treatment is not yet fully integrated into a JEDDA design system.
- Gallery, related products, spacing, type hierarchy, mobile rhythm, and lower-page content need one coherent direction.

## V2 Experience Principle

PDP V2 should not feel like a product template with decorative styling on top.

It should feel like a calm editorial commerce page where every decision point is obvious:

1. What is this piece?
2. What does it cost?
3. What color and size am I choosing?
4. Is it available?
5. What happens when I add it to cart?
6. What is it made of and how does it fit?
7. How does shipping, returns, and care work?
8. What should I look at next?

The customer should never need to decode the interface.

## Layout Direction

### Desktop

Target structure:

- Left side: large image/gallery area.
- Right side: stable purchase information column.
- Below: product narrative/details and recommendations.

Direction:

- Use an asymmetrical but disciplined split layout.
- Let imagery own the emotional space.
- Keep purchase information fixed in hierarchy, not necessarily sticky by default.
- Avoid decorative containers, nested cards, and heavy borders.
- Use whitespace to separate sections instead of boxes.
- Keep the page width controlled; avoid letting the PDP stretch into an empty wide layout.

Preferred rhythm:

1. Gallery and buy panel above the fold.
2. Description, fit, fabric, care, shipping, and returns immediately below or in quiet accordions.
3. Related/recommended products as a lower-page continuation, not a competing carousel near the purchase action.

### Mobile

Target structure:

- Image sequence first.
- Product title and price directly after the first meaningful image set.
- Variant/size and add-to-cart area close enough that the customer does not feel lost.
- Details below in compact accordions.
- Related products after the product decision is complete.

Direction:

- Mobile should feel like a refined vertical catalog.
- Images should be large and stable.
- Purchase controls must be thumb-friendly.
- Avoid tiny text copied from desktop.
- Avoid sticky purchase UI until it is tested against gallery behavior and content density.

## Typography Direction

Principle: quiet, readable, consistent.

PDP type hierarchy:

| Element | Direction |
| --- | --- |
| Product title | Restrained but clearly primary within the buy panel. Avoid oversized hero type. |
| Price | Close to the title, same visual family, slightly quieter than title but never hidden. |
| Variant labels | Small functional text with clear active/missing states. |
| Size options | Legible, tap-friendly, and visually equal until selected/unavailable. |
| Add-to-cart | Stable uppercase or title-case treatment matching the site's button system. |
| Validation/loading/success messages | Small, calm, specific, directly near the action. |
| Product description | Readable body text, not micro copy. |
| Details headings | Small functional headings or accordion labels with consistent casing. |
| Recommendation product names | Match product-grid metadata standard. |

Avoid:

- Fragile micro text on mobile.
- Mixed casing between similar controls.
- Theme/plugin default headings that create sudden visual tone changes.
- Hidden structural headings that damage hierarchy or accessibility.

## Spacing Direction

Principle: spacing creates confidence.

Desktop:

- Generous spacing around the gallery.
- Tighter, more controlled spacing inside the buy panel.
- Clear vertical rhythm between title, price, options, CTA, feedback, and details.
- Related products should have enough top spacing to feel like a new section, not an accidental overflow.

Mobile:

- Keep image-to-title transition clear.
- Keep option groups close enough to read as one purchase task.
- Use consistent vertical gaps between option label, options, validation, CTA, and success.
- Avoid large dead zones created by hidden carousel elements or lazy-loading artifacts.

Suggested spacing language:

- Gallery/image gaps: generous.
- Buy panel internal gaps: compact and scannable.
- Feedback messages: close to the action they explain.
- Accordions/details: quiet but not cramped.

## Image And Gallery Treatment

Principle: images are the primary brand signal.

V2 gallery should:

- Use stable aspect ratios.
- Avoid 1x1 placeholders and offscreen carousel artifacts.
- Make the primary product image large enough to inspect.
- Keep thumbnail or secondary image navigation quiet.
- Preserve image quality and crop consistency.
- Support mobile vertical browsing smoothly.
- Provide product-aware alt text.

Desktop direction:

- Large primary image or grid-style image sequence.
- If thumbnails remain, they should be minimal and clearly active.
- Avoid heavy carousel chrome.

Mobile direction:

- Prefer vertical image scroll or stable swipe that does not trap the user.
- Avoid small thumbnails that compete with the garment.
- Preserve add-to-cart access without covering image content prematurely.

What should not happen:

- Placeholder images should not appear as visible product content.
- Gallery motion should not feel like a promotional slider.
- Images should not shift layout while loading.

## Product Info Hierarchy

The buy panel should be ordered by decision priority:

1. Product title.
2. Price.
3. Color/variant.
4. Size.
5. Size guide.
6. Stock/preorder/out-of-stock state.
7. Add to cart.
8. Validation/loading/success feedback.
9. Short product note or key fit cue.
10. Details, material/care, shipping/returns.

This hierarchy should stay consistent across products.

Do not move useful product details so far down that the customer must hunt for material, fit, or shipping confidence. But also do not let details crowd the first purchase decision.

## Price Placement

Price should sit close to the product title.

Direction:

- Make price easy to find before variant selection.
- If variation price changes later, update in place without layout jump.
- Do not hide price under description, accordions, or plugin notices.
- Discount pricing, if used later, must be calm and exact, not promotional.

Price should feel like product information, not a sales badge.

## Variant And Size Section

Principle: variant selection should feel tactile, not puzzling.

Required states:

- Default.
- Hover.
- Focus-visible.
- Selected.
- Missing/required.
- Unavailable.
- Out of stock.
- Preorder, if applicable later.

Direction:

- Keep color and size groups visually separate but close.
- Use labels that tell the customer what they are choosing.
- Selected state must be unmistakable.
- Missing state should appear only when helpful, not permanently shout at rest.
- Unavailable state should be disabled and explained.
- Size guide should open without losing PDP context.

Current Sprint 2 validation should remain as the behavior baseline until V2 replaces it with a cleaner component-level implementation.

## Add-To-Cart Area

Principle: the moment of purchase intent must never feel uncertain.

Required states:

- Default: clear, stable, ready.
- Disabled/unavailable: visual and functional state must agree.
- Invalid: no stuck loading; explain missing selection near the controls.
- Loading: immediate local feedback after valid click.
- Success: calm inline confirmation after completion.
- Error: specific, recoverable, and close to the button.

Direction:

- Keep add-to-cart visually dominant but not loud.
- Preserve a stable button height across default/loading/success.
- Avoid decorative animation.
- Avoid auto-opening mini-cart until cart V2 is designed.
- Do not rely on cart badge alone for success.

Sprint 2.1, 2.2, and 2.3 establish the expected behavior pattern:

- Invalid selection: specific inline guidance.
- Valid add: immediate `Adding...` feedback.
- Completed add: quiet inline `Added to cart.` confirmation.

PDP V2 should integrate these states visually instead of leaving them as isolated snippet polish.

## Validation, Loading, And Success Feedback

Feedback should be local, calm, and specific.

Validation:

- Appears near the missing option or add-to-cart action.
- Names the missing requirement.
- Does not use raw WooCommerce alert styling as the final design.

Loading:

- Appears immediately after a valid add-to-cart click.
- Prevents duplicate submit.
- Does not create layout jump.

Success:

- Confirms the item was added.
- Stays close to the purchase action.
- Should not force the customer into cart.
- May later include a quiet `View cart` text link only after cart behavior is reviewed.

Error:

- Explains what failed and how to recover.
- Does not blame the customer.
- Preserves selected variants where possible.

## Short Description And Long Description

Short description direction:

- Use for a concise product point of view or fit cue.
- Keep it near the decision area if it helps buying confidence.
- Avoid generic marketing copy.

Long description/details direction:

- Fit, material, care, shipping, and returns should be structured and easy to scan.
- Accordions are acceptable if they are stable, accessible, and smooth.
- Open/close motion should be short and layout-safe.
- Do not hide essential fit or material information behind ambiguous labels.

Content tone:

- Editorial but useful.
- Plain where clarity matters.
- No generic theme copy.

## Recommendations And Related Products

Principle: recommendations should extend the styling story, not interrupt purchase.

Direction:

- Place recommendations below the main PDP decision and details.
- Use the same product-card language as the collection grid.
- Avoid carousel artifacts, placeholder images, or tiny offscreen elements.
- Prioritize visually relevant related products when possible.
- Sold-out recommendations should not dominate the first related row.

Later V2 recommendation logic should consider:

- Same collection/drop.
- Same category.
- Complementary silhouettes.
- Color/material compatibility.
- Recently viewed only if it feels useful and not noisy.

Do not redesign recommendations before product card/grid standards are stable.

## Mobile Layout Direction

Mobile priorities:

1. Large stable images.
2. Product title and price.
3. Variant and size selection.
4. Add-to-cart with local feedback.
5. Product details.
6. Recommendations.

Mobile rules:

- Tap targets must be comfortable.
- Option labels and feedback must be readable.
- Avoid horizontal overflow.
- Avoid hidden purchase controls.
- Avoid sticky CTA until tested; if introduced, it must not cover gallery or feedback.
- Gallery should not trap scroll.
- Accordions should not jump the customer away from their context.

Mobile should feel intentionally sparse, not like compressed desktop.

## Interaction Principles

Every PDP interaction should answer what happened after the click.

| Interaction | V2 Standard |
| --- | --- |
| Image click/swipe | Movement is smooth, no blank frame, active image context is clear. |
| Variant click | Selection updates immediately; missing/error state clears when resolved. |
| Size guide click | Opens in context; close is obvious; focus returns correctly. |
| Add to cart invalid | Button does not enter stuck loading; missing fields are named. |
| Add to cart valid | Button shows immediate loading; duplicate submit is prevented. |
| Add success | Inline success confirms completion without interrupting browsing. |
| Add error | Message is specific and recoverable. |
| Accordion click | Opens smoothly with stable spacing and visible focus. |
| Related product click | Navigates cleanly without carousel confusion. |

Interaction feeling:

- Premium: quiet, exact, and stable.
- Intentional: every state has a reason.
- Smooth: short transitions, no theatrical motion.
- Reassuring: feedback is near the action.
- Accessible: focus and state are visible.

## Existing PDP Layers That Should Remain For Now

These layers can remain during safe incremental cleanup:

- Upscale parent theme as the base layout provider.
- WooCommerce product template output.
- WooCommerce variation form and product data.
- Existing product images and product content.
- Current swatch plugin/output if stable.
- Sprint 2.1 validation snippet ID `13` as temporary behavior guard.
- Sprint 2.2 loading feedback snippet ID `18` as temporary behavior guard.
- Sprint 2.3 success feedback snippet ID `19` as temporary behavior guard.
- Existing details/material/care/shipping content, subject to content cleanup later.

Reason:

These layers keep the staging PDP functional while V2 direction is defined. They should not be ripped out during visual planning.

## Existing PDP Layers To Eventually Replace

These should be replaced or consolidated in a later V2 presentation layer:

- Snippet-based PDP interaction polish.
- Theme/plugin default WooCommerce notices when visible to customers.
- Inconsistent gallery/carousel placeholder behavior.
- Any custom JS that depends on broad `MutationObserver` loops.
- Related-product carousel or grid output that creates offscreen/placeholder artifacts.
- Scattered custom CSS that controls PDP spacing/type without a single system.
- Any product content field usage that makes essential details inconsistent across products.

Target replacement layer:

- A version-controlled PDP presentation layer, preferably in a child theme or custom plugin after architecture approval.
- WooCommerce hooks/templates should own durable PDP structure.
- JavaScript should be event-based and component-scoped.
- CSS should use a small PDP token system for type, spacing, state, and responsive behavior.

## What Can Be Improved Safely On Top Of Upscale Now

Safe incremental improvements:

- Tighten PDP typography scale within existing selectors.
- Normalize buy-panel spacing.
- Style current Sprint feedback messages to match the JEDDA system.
- Refine variant and size selected/missing/focus states.
- Stabilize visible gallery image ratios if the fix is scoped and reversible.
- Improve accordion spacing and typography if current behavior remains intact.
- Add product-aware alt text through media/product data.
- Improve recommendation section spacing without changing recommendation logic.
- Document and test all changes one behavior or visual area at a time.

Conditions:

- Changes must be staging-first.
- Changes must be reversible.
- Changes must not touch checkout/payment/orders.
- Changes must not combine broad layout redesign with behavior changes.
- Changes must not depend on `MutationObserver`.

## What Should Be Rebuilt As V2 Presentation Later

Rebuild later:

- Full PDP layout system.
- Gallery component.
- Buy panel component.
- Variant/size component.
- Add-to-cart state component.
- Product details/accordion component.
- Related products component.
- Mobile PDP structure.
- Component-level CSS token system.
- Snippet consolidation into version-controlled code.

Why later:

The current theme/plugin stack is layered. A full V2 presentation rebuild should happen only after ownership is clear and after the PDP layers are mapped in code/templates. Rebuilding too early inside snippets or scattered CSS would recreate the inconsistency V2 is meant to solve.

## What Should Not Be Touched Yet

Do not touch yet:

- Checkout behavior.
- Payment behavior.
- Order creation.
- Customer data.
- Product stock logic.
- Plugin updates/removal.
- Broad theme replacement.
- Recommendation algorithm.
- Mini-cart auto-open behavior.
- Global header/navigation redesign.
- Full cart redesign.
- Production activation.

Do not combine:

- PDP visual redesign with checkout/cart changes.
- Gallery rebuild with add-to-cart behavior changes.
- Recommendation redesign with product card/grid redesign.
- Snippet consolidation with visual experimentation.

## Recommended Next Implementation Sequence

After this plan is approved, the safest next work should be:

1. PDP V2 visual baseline on top of current Upscale theme: typography, spacing, buy-panel rhythm, and current feedback styling only.
2. Gallery stabilization: image ratios, placeholders, thumbnails/mobile behavior.
3. Variant and size visual state pass: selected, focus, missing, unavailable.
4. Product details/accordion refinement.
5. Recommendations presentation cleanup.
6. Later architecture work: migrate temporary PDP snippets into version-controlled component code.

Each step should be tested independently.

## Definition Of Done For PDP V2 Direction

PDP V2 direction is ready when future implementation can answer:

- Which layer owns the change?
- Which PDP area is being touched?
- Which states are affected?
- What is the rollback?
- Does the change preserve the quiet fitting appointment feeling?
- Does the interaction provide immediate, local, calm feedback?
- Does mobile remain first-class?
- Does the change move PDP behavior from snippet patching toward a durable component system?

## Milestone 2.4 Conclusion

JEDDA PDP V2 should not be a louder product page.

It should be a more precise one.

The current PDP already carries the right mood. V2 should protect that restraint while turning every purchase decision, state, and edge case into a composed part of the JEDDA experience.
