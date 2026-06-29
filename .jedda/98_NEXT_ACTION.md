# Next Action

Status: Milestone 2.8.4 complete. Pending content entry (owner) then 2.8.5. No engineer blockers.
Last updated: 2026-06-30.

## Cleanup (Low Priority)

Once LiteSpeed cache for `pdp-v24.css` clears naturally (may take hours/days), deactivate WPCode snippet #13968 ("Jedda Gallery: pdp-v24 cache override (temp)"). The permanent values are in the file itself.

When SSH is available: remove the `if (! function_exists('acf')) { return; }` guard in `class-acf-fields.php::init()` and then deactivate WPCode snippet #13967.

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
6. **Slick vertical thumbnail strip**: re-initialize thumbnail slider with `vertical: true` + `slidesToShow: N`. Current Slick config is horizontal (one slide at a time). Vertical mode required for visible image strip.

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
