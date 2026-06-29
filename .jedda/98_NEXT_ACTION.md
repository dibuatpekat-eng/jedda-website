# Next Action

Status: Gallery V2.1 plan ready. Awaiting founder approval to implement.
Last updated: 2026-06-29.

## Current Situation

Gallery V2 is technically working on staging (verified via hard refresh):
- Thumbnail rail: 12px indicator strip ✓
- Arrows: hidden (display: none !important) ✓
- Main image: 672px (from 544px) ✓
- Mobile counter: injected ✓

Design verdict: directionally correct, not yet close enough to Toteme / SSSTEIN.
Founder has not approved Gallery V2. V2.1 refinement plan is ready.

## LiteSpeed Cache Note

Gallery V2 CSS with arrow fix only visible after hard refresh (Ctrl+Shift+R).
Normal page loads serve cached CSS (without !important on arrows).
This is a staging deployment concern, not a code logic concern.
To view Gallery V2 correctly on staging: hard refresh the product page.

## Gallery V2.1 Plan

Three changes. No HTML changes. All scoped to `body.single-product.jedda-pdp-v2`.

### Change 1 — Thumbnail strip: left → right
Move 12px indicator strip from left side to right side of image.
Image starts flush at gallery column left edge. 20px visual gain, no awkward left float.
```css
.de-product-single__thumbnail--philo {
  float: right; margin-right: 0; margin-left: 8px;
}
```

### Change 2 — Remove gallery column left padding
Foundation applies ~15px left padding to all columns. Removing it extends image
further left, to the row edge (closer to viewport).
```css
.de-product-single__images-left-philo {
  padding-left: 0;
}
```
Risk: must verify mobile (Foundation handles padding differently at breakpoints).

### Change 3 — Deliberate top breathing room
Replace clamp(8px, 1.5vw, 28px) with clamp(48px, 5vw, 80px).
Current value reads as a gap. Larger value reads as a curated editorial entry.
```css
.de-product-single__images-left-philo {
  padding-top: clamp(48px, 5vw, 80px);
}
```

## After V2.1

If V2.1 is approved: move to Product Summary component.
If V2.1 is still insufficient: propose V2.2 (gallery column negative margin into row padding).

## PDP V2 Component Order

1. Gallery ← V2 implemented, V2.1 plan ready, awaiting approval
2. Product Summary
3. Title & Price
4. Variant Selector
5. Add-to-Cart
6. Product Details / Accordion
7. Recommendations
8. Mobile

Each component requires approval before the next begins.
