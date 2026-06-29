# Product Page V2 Visual Recovery

Status: Staging recovered. Failed visual attempt documented.
Date: 2026-06-29

## Summary

Milestone 2.6 installed and activated `JEDDA Commerce UI` on staging for review. The result was not acceptable as Product Page V2.

The active V2 looked worse than the stable PDP:

- Product image area became too small.
- Product summary felt compressed.
- Hierarchy did not improve.
- The page did not reflect Toteme, SSSTEIN, MOIA Seoul, or Nothing Written.
- Generic WooCommerce layout selectors were applied to the wrong container.

This is classified as a failed visual attempt, not a successful V2 presentation milestone.

## Recovery Completed

Staging recovery action:

- Deactivated `JEDDA Commerce UI` in WordPress admin.

Result:

- WordPress Plugins screen now shows `JEDDA Commerce UI` with `Activate`.
- Plugin files remain installed.
- PDP V2 CSS/JS no longer affects customers.

Fresh logged-in PDP recovery verification:

| Check | Result |
| --- | --- |
| `body.jedda-pdp-v2` | Absent. |
| `body.jedda-commerce-ui` | Absent. |
| `pdp-v2.css` asset | Absent. |
| `pdp-v2.js` asset | Absent. |
| Original product image area | Restored at approximately `544px` wide on desktop review viewport. |
| Original summary column | Restored at approximately `508px` wide on desktop review viewport. |
| Add-to-cart button | Restored at approximately `448px` wide on desktop review viewport. |

Repository safety change:

- PDP V2 is disabled by default.
- The plugin no longer auto-enables on `beta.jeddawear.com`.
- Future activation requires `JEDDA_PDP_V2_ENABLED` or `jedda_pdp_v2_enabled = 1`.

## Why The First Attempt Failed

The first implementation used generic WooCommerce selectors such as:

- `.woocommerce-product-gallery`
- `.summary`
- `div.product`

The actual Upscale PDP does not use those as the primary layout containers for the active visual structure. The real PDP uses theme-specific `de-product-single` containers.

The CSS grid landed on the wrong level of the page and interacted badly with Upscale's existing inner layout. That compressed the product information column and reduced image scale instead of creating a premium editorial PDP.

The failure was not caused by WooCommerce, Midtrans, Epeken, checkout, cart, or payment logic. It was a presentation-layer targeting failure.

## Actual Upscale PDP DOM Map

Stable logged-in PDP inspection on `Kiro Cropped Vest` showed the real active structure:

| Area | Real selector | Role | Observed desktop size / position |
| --- | --- | --- | --- |
| Overall wrapper | `.de-product-single__wrapper` | Theme-level PDP wrapper. | About `1280px` wide. |
| Main PDP layout | `.de-product-single__layout-philo` | Upscale product layout root. | About `1280px` wide. |
| Main content row | `.de-product-single__container` | Contains gallery and summary columns. | About `1280px` wide. |
| Gallery column | `.de-product-single__images-left-philo` | Left visual column. | About `712px` wide. |
| Gallery container | `.de-product-single__images-container` | Contains thumbnails and main image. | About `692px` wide. |
| Thumbnail rail | `.de-product-single__thumbnail` | Vertical thumbnail column. | About `100px` wide. |
| Thumbnail slider | `.thumbnails.slick` | Slick vertical thumbnail slider. | Theme/plugin controlled. |
| Main image area | `.de-product-single__images` | Main product image frame. | About `544px` wide. |
| Main image slider | `.de-product-single__images--philo-inner` | Slick main product image slider. | Theme/plugin controlled. |
| Product summary | `.de-product-single__summary` | Buy panel/content column. | About `508px` wide. |
| Title | `.product_title.entry-title` | Product title. | `H2`, about `16px` font size. |
| Price | `.de-product-single__summary .price` / variation price output | Price display. | Theme/WooCommerce controlled. |
| Variant form | `form.variations_form` | WooCommerce variation and add-to-cart form. | About `448px` wide. |
| Variants/swatches | `.variable-items-wrapper` | Swatch plugin output. | Plugin/theme controlled. |
| Add to cart | `.single_add_to_cart_button` | WooCommerce add-to-cart button. | About `448px` wide. |
| Details/tabs | `.de-product-single__description-tabs` | Upscale product tabs/details area. | Currently zero-height wrapper with content influence. |
| Related wrapper | `.de-product-single__description-linked-products` | Related products container. | About `1280px` wide. |
| Related products | `.related.products`, `ul.products` | WooCommerce/Upscale related products. | Slick/product grid controlled. |

The next visual attempt must target these selectors deliberately and avoid applying layout rules to `div.product` or generic `.summary` as if they were the primary layout containers.

## Next Visual Direction Before CSS

Before the next CSS patch, define the intended proportions against the real DOM:

| Area | Direction |
| --- | --- |
| Image scale | Preserve or increase the current main image presence; do not reduce it below the stable original. |
| Content column width | Keep the buy panel calm and readable, roughly in the `420px-520px` range on desktop unless the layout is intentionally rebalanced. |
| Spacing | Add rhythm between title, price, details, variants, CTA, and feedback without widening gaps arbitrarily. |
| Vertical rhythm | Make the buy panel scan like a fitting appointment: title/price, product note, color, size, CTA, details. |
| Typography hierarchy | Improve hierarchy through spacing, weight, and order before shrinking text. |
| CTA hierarchy | Add-to-cart should remain stable, full-width within the buy panel, and visually confident. |
| Mobile behavior | Inspect mobile DOM separately before applying desktop assumptions. |

## Rule Before Next Visual Attempt

Do not style generic WooCommerce layout selectors for PDP V2 layout.

Before visual code resumes, target the real Upscale PDP DOM structure:

- Main PDP layout container.
- Gallery/image container.
- Thumbnail container.
- Product summary container.
- Product title.
- Price.
- Variant/swatch section.
- Add-to-cart form/button.
- Details/accordion/tabs.
- Related products.

## Next Attempt Requirements

The next PDP V2 attempt must start from a clear visual direction, not random CSS changes.

Define before coding:

- Image scale.
- Content column width.
- Spacing.
- Vertical rhythm.
- Typography hierarchy.
- CTA hierarchy.
- Mobile behavior.

The goal is premium, intentional, calm, and aligned with Toteme, SSSTEIN, MOIA Seoul, and Nothing Written. The goal is not simply smaller, quieter, or more minimal.

## Guardrail

The plugin may remain installed, but PDP V2 must stay disabled until the real DOM targeting plan and visual direction are reviewed.
