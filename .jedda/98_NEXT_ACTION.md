# Next Action

Status: Milestone 2.8.4 complete (pending final deploy + content entry). No owner blockers.
Last updated: 2026-06-30.

## Immediate: Deploy pdp-v24.css Revision (Engineer)

SSH to 77.37.81.144 timed out during the 2.8.4 session. The CSS file (`pdp-v24.css`) was revised locally to fix the opacity issue (0.42 → 0.6 + box-shadow active indicator) but not yet pushed to server.

Steps:
1. SCP `pdp-v24.css` to staging server (use SCP+tar, not SSH heredoc)
2. Clear LiteSpeed CSS cache on staging
3. Hard refresh browser, verify thumbnail strip is visible at 0.6 opacity
4. Verify active thumbnail has inset left box-shadow indicator

## Owner Actions Required (Content Entry)

### 1. Enter Kiro Cropped Vest product data in WP Admin

Go to: WP Admin → Products → Kiro Cropped Vest → Edit → scroll to "Jedda Product Data" meta box

Fill:
- **Details** (textarea): Product description for the DETAILS accordion (plain text, no HTML)
- **Composition** (text): e.g. `100% Viscose` or `Shell: 100% Linen, Lining: 100% Polyester`
- **Care Instructions** (textarea): One instruction per line (e.g. `Dry clean only`, `Do not bleach`)
- **Garment Measurements** (repeater): One row per size option (S/M, L/XL). Columns: Size, Bust (cm), Shoulder (cm), Front (cm), Back (cm)
- **Recommended Body Size** (repeater): One row per size option. Columns: Size, Bust up to (cm), Height (cm)

### 2. Enter global policy text in WP Admin

Go to: WP Admin → WooCommerce → Jedda Policy

Fill:
- **Shipping Policy**: Delivery times, courier, free shipping threshold
- **Returns & Exchanges**: Return window, condition requirements
- **Size Exchange After Delivery**: Specific size exchange terms
- **Pre-Order Policy**: Pre-order lead time, payment terms (leave blank if no pre-order products currently)

### 3. Rename WPCode #11836 (low priority)

Go to: WP Admin → WPCode → Snippets → find snippet ID 11836  
Rename to: `My Account: Remove Payment Request Text`

## Next Milestone → 2.8.5 (Template + Typography)

Ready after content is entered in WP Admin.

Scope:
1. PHP template to render ACF fields inside accordions (details, composition, care, measurements, policy)
2. Plus Jakarta Sans applied to product title, price, labels, accordion, body
3. Accordion moved below ATC buttons (DETAILS/FIT & SIZING/MATERIAL & CARE/SHIPPING & RETURNS)
4. Multi-open accordion (all closed by default)
5. Interaction layer redesign: color/size/qty/ATC/Buy Now/hover/active/disabled/loading/success/validation/focus/transitions

## Full Milestone Sequence

| Milestone | Name | Status |
|---|---|---|
| 2.8.0 | Product Summary Reverse Engineering | ✅ Complete |
| 2.8.1 | Architecture | ✅ Complete — approved |
| 2.8.2 | Blueprint | ✅ Complete — approved |
| 2.8.3 | Foundation (plugin restructure + fonts + taxonomy + WC filters) | ✅ Complete — deployed |
| 2.8.4 | CMS Architecture + Gallery Thumbnail Upgrade | ✅ Complete — pending deploy + content entry |
| 2.8.5 | Template + Typography + Interaction Layer | After 2.8.4 content entry |
| 2.8.6 | Full Rollout | After 2.8.5 approval |
