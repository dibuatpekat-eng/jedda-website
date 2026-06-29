# Gallery V2 Milestone

Status: Implementation complete. Awaiting staging QA and founder approval.
Date: 2026-06-29.
Scope: Gallery component only, through `jedda-commerce-ui` plugin.

## Objective

Rebuild the Product Page gallery presentation toward JEDDA V2 direction — specifically
Toteme and SSSTEIN design language — while preserving WooCommerce, Upscale theme
functionality, Slick carousel behavior, variation logic, cart, checkout, Midtrans,
Epeken, payment, orders, stock, and customer data.

## What Was Reverse Engineered

### DOM Structure (verified live on staging, 1512px viewport)

```
.de-product-single__images-left-philo       712px  [large-7 Foundation column]
└── .de-product-single__images-container    692px
    ├── .de-product-single__thumbnail--philo  100px  float: left
    │   └── .thumbnails.slick               100px × 477px
    │       6 slides, vertical Slick, slidesToShow 3
    └── .de-product-single__images--philo   544px
        └── .de-product-single__images--philo-inner  544px × 826px
            6 slides, horizontal Slick, slidesToShow 1
```

Gallery column space before V2:
- Thumbnail: 100px + 48px gap = 148px (21.4% of gallery column)
- Main image: 544px (76.4% of gallery column, 36% of viewport)

Gallery column space after V2:
- Thumbnail indicator strip: 12px + 8px gap = 20px (2.9% of gallery column)
- Main image: ~672px (94.4% of gallery column, 44% of viewport)

### CSS Ownership

| File | Role |
| --- | --- |
| `dahz-framework-blog.css` | Primary gallery structure and behavior |
| `custom.css` | Thumbnail gap (48px), mobile thumbnail hide |
| `jedda-commerce-ui/pdp-v2.css` | V2 override layer (scoped to `body.jedda-pdp-v2`) |

### JS Ownership

| File | Role |
| --- | --- |
| `dahz-framework-themes.js` | Slick initialization |
| `df-commerce.js` | Gallery behavior and slide control |
| `jedda-commerce-ui/pdp-v2.js` | Mobile counter only (event-based) |

### Slick Configuration

Main slider: horizontal, 1 slide, infinite, lazyLoad ondemand, arrows enabled, asNavFor thumbnail.
Thumbnail slider: vertical, 3 slides, focusOnSelect, no arrows, asNavFor main.

Both sliders are initialized by theme JS before our deferred plugin JS runs.
Our JS checks for `slick-initialized` class before hooking events — safe in both init orders.

### Image Data

Natural size: 1032×1548px (2:3 portrait ratio).
Before V2 display: 524×786px at 544px container width.
After V2 display: ~634×951px at 672px container width.
Improvement: +21% wider, image now occupies 44% of viewport vs 36%.

## Changes Made

### pdp-v2.css — Gallery-only rules

All rules scoped to `body.single-product.jedda-pdp-v2`.

| Change | Selector | Why |
| --- | --- | --- |
| Gallery breathing room | `.de-product-single__images-left-philo` | `padding-top: clamp(8px, 1.5vw, 28px)` — image breathes from header |
| Thumbnail width | `.de-product-single__thumbnail--philo` | `width: 12px; margin-right: 8px` — minimal indicator strip |
| Thumbnail images hidden | `.de-product-single__thumbnail img` | `display: none` — images not needed at 12px width |
| Thumbnail opacity reset | `.slick-slide` | `opacity: 1` always — no fade treatment |
| Inactive indicator | `.slick-slide::before` | Thin `--jedda-line` left mark on all slides |
| Active indicator | `.slick-slide.slick-current::before` | `--jedda-ink` left mark — precise, no animation |
| Hover indicator | `.slick-slide:not(.slick-current):hover::before` | `--jedda-muted` — subtle response |
| Arrows hidden | `.de-slick-product-arrows` | `display: none` — no chrome on the image |
| Cursor removed | `.woocommerce-main-image:hover` | `cursor: default` — no crosshair |
| Mobile counter | `.jedda-gallery-counter` | Hidden desktop / visible mobile via media query |

### pdp-v2.js — Gallery counter only

- Kill switch respected.
- `body.jedda-pdp-v2` guard.
- Checks for `slick-initialized` to handle both early and late execution.
- Injects `.jedda-gallery-counter` div below gallery column.
- Listens to `afterChange.jeddaGalleryCounter` on main slider.
- Format: `1 / 6` — minimal numeric.
- `aria-hidden="true"` — decorative only.
- Double-init guard prevents duplicate counters on `pageshow` restore.

## Reference Alignment

### Toteme
- Image presence: Toteme's PDP image typically fills 55–62% of PDP width. At 672px / 1512px viewport, JEDDA's image reaches 44.5% of viewport — meaningfully closer. ✓
- Navigation: Toteme uses thumbnail strip, not arrows. V2 hides arrows. ✓
- Indicator: Toteme's active thumbnail uses minimal mark. V2 uses 2px left border mark. ✓

### SSSTEIN
- Gallery chrome: SSSTEIN has near-zero gallery chrome. V2 reduces thumbnail to 12px indicator strip. ✓
- Image dominance: SSSTEIN's image fills its column. V2 gives main image 94% of gallery column. ✓
- Arrows: SSSTEIN has no arrows on product image. V2 removes them. ✓

## UX Issues Addressed

| Issue | Before | After |
| --- | --- | --- |
| Image scale | 544px (36% of viewport) | ~672px (44% of viewport) |
| Thumbnail overhead | 148px (21% of gallery column) | 20px (2.9%) |
| Arrow chrome | Always visible on image | Hidden |
| Active thumbnail state | Opacity fade only | Left border mark (precise) |
| Mobile affordance | None (zero navigation signal) | `1 / 6` counter below gallery |
| Crosshair cursor | Present on hover | Removed |

## What Was Not Changed

- Slick initialization parameters (slidesToShow, vertical, asNavFor, lazyLoad).
- DOM structure of gallery or thumbnails.
- WooCommerce variation image swap behavior.
- Product summary column.
- Title, price, variants, add-to-cart, tabs, recommendations.
- Cart, checkout, Midtrans, Epeken, orders, stock.
- Sprint 2 snippets (IDs 13, 18, 19) — still active and unchanged.

## Open Decision — Thumbnail Visibility

The V2 implementation hides thumbnail images entirely (12px indicator strip only).
This is the most aggressive form of gallery chrome reduction, aligned with SSSTEIN.

If QA shows that customers or the founder want visible thumbnail images, the fallback is:

```css
/* Fallback: 64px visible thumbnails */
body.single-product.jedda-pdp-v2 .de-product-single__thumbnail--philo {
  width: 64px;
  margin-right: 12px;
}
body.single-product.jedda-pdp-v2 .de-product-single__thumbnail img {
  display: block; /* restore visibility */
}
```

This keeps the +72px image gain (vs full +128px) while making thumbnails visible.

## Rollback

1. Set `jedda_pdp_v2_enabled` option to `0` via WordPress admin or WP-CLI.
2. OR deactivate `JEDDA Commerce UI` plugin.
3. Verify `body.jedda-pdp-v2` absent from DOM.
4. Original gallery returns immediately — no database changes, no snippet changes.

Git revert available but should not be needed given the feature flag.

## Next Milestone

After founder approval of Gallery V2:
- Product Summary component (buy panel spacing, title, price hierarchy).
- Do not start until Gallery V2 is approved.
