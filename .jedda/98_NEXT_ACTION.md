# Next Action

Status: Gallery V2.1 implemented and QA'd on staging. Awaiting founder approval.
Last updated: 2026-06-29.

## Current Situation

Gallery V2.1 is live on staging (beta.jeddawear.com/product/kiro-vest/):
- Wrapper expanded to full viewport width ✓
- Image: 817px = 54.0% of 1512px viewport ✓
- Thumbnail strip: right side, 12px indicator ✓
- Arrows: hidden (display: none !important) ✓
- Top breathing room: 75.6px at 1512px ✓
- Related Products: unaffected ✓
- Mobile: unaffected (Foundation stacks at ≤768px) ✓

LiteSpeed cache issue resolved: CSS renamed to `pdp-v21.css`, exclusion filter added to plugin.

## Immediate Next Step

**Founder reviews Gallery V2.1 against Toteme / SSSTEIN direction.**

URL to review: https://beta.jeddawear.com/product/kiro-vest/

Hard refresh (Ctrl+Shift+R) if CSS looks stale.

Three scenarios:
1. **Approved** → move to Product Summary component
2. **Needs adjustment** → propose specific V2.2 changes
3. **Too aggressive** → roll back to V2.0 (set `jedda_pdp_v2_enabled=0` or deactivate plugin)

## After Gallery Approval

Move to Product Summary component:
- Title & price hierarchy
- Buy panel spacing
- Variant selector presentation
- Tab/accordion spacing

## PDP V2 Component Order

1. Gallery ← V2.1 implemented, awaiting founder approval
2. Product Summary
3. Title & Price
4. Variant Selector
5. Add-to-Cart
6. Product Details / Accordion
7. Recommendations
8. Mobile

Each component requires approval before the next begins.

## LiteSpeed Cache Note

LiteSpeed CSS optimization was caching old CSS bundles indefinitely.
**Fixed by:**
- Renaming CSS to `pdp-v21.css` (new filename = no cached entry)
- Adding `litespeed_optimize_css_excludes` filter in plugin PHP

For future CSS changes: rename the file (e.g., `pdp-v22.css`) when deploying a new milestone to guarantee a fresh cache entry. The exclusion filter prevents LiteSpeed from bundling the file, but a fresh filename is the safest guarantee.
