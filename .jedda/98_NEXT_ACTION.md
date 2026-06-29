# Next Action

Status: Immediate next milestone definition.
Last updated: 2026-06-29.

## Immediate Next Milestone

Gallery V2.

This is the next implementation milestone. It is not a full PDP redesign.

## Objective

Rebuild only the Product Page gallery presentation toward JEDDA V2 direction while preserving WooCommerce, Upscale functionality, variation behavior, cart, checkout, Midtrans, Epeken, payment, orders, stock, and customer data.

## Why Gallery First

The failed full-page PDP V2 pass proved that broad visual changes are too risky. The gallery is the strongest brand signal and should be handled as an independent component with its own reverse engineering.

## Required Work Before Coding

1. Confirm repository and latest commit.
2. Confirm staging PDP is stable and `JEDDA Commerce UI` is inactive or PDP V2 disabled.
3. Open the current PDP in a logged-in browser.
4. Capture before screenshots:
   - Desktop first viewport.
   - Gallery close-up.
   - Mobile gallery.
5. Reverse-engineer the actual gallery implementation:
   - `.de-product-single__images-left-philo`
   - `.de-product-single__images-container`
   - `.de-product-single__thumbnail`
   - `.thumbnails.slick`
   - `.de-product-single__images`
   - `.de-product-single__images--philo-inner`
   - Main image elements.
   - Thumbnail image elements.
   - Slick slider behavior.
   - Lazy-load classes.
   - Product image data source.
6. Identify dependencies:
   - Upscale theme.
   - WooCommerce product image data.
   - Slick carousel/theme scripts.
   - Lazy-load behavior.
   - Any snippets that affect PDP images.
7. Define Gallery V2 visual direction before coding:
   - Image scale.
   - Main image ratio.
   - Thumbnail role.
   - Desktop rhythm.
   - Mobile rhythm.
   - Loading/placeholder behavior.

## Allowed Implementation

Only gallery-focused code through `wp-content/plugins/jedda-commerce-ui`.

Allowed:

- Gallery-scoped CSS.
- Gallery-scoped JS only if needed and event-based.
- PDP V2 activation only for gallery test if safe and reversible.

Not allowed:

- Product summary changes.
- Title/price changes.
- Variant selector changes.
- Add-to-cart changes.
- Details/accordion changes.
- Related products changes.
- Cart/checkout/payment/shipping/order changes.
- Full PDP layout grid changes.

## Expected Output After Gallery V2

- Gallery DOM/dependency map.
- Before screenshots.
- Gallery-only V2 implementation.
- After screenshots.
- Explanation of why it matches Toteme / SSSTEIN / MOIA Seoul / Nothing Written.
- Regression notes.
- Rollback plan.
- Documentation update.
- Commit and push.
- Stop and wait for approval before Product Summary or any other component.

## Success Criteria

Gallery V2 succeeds only if:

- Main product image scale is preserved or improved.
- Page does not compress.
- Product summary is not affected.
- Add-to-cart behavior is unchanged.
- Mobile gallery remains usable.
- The result feels more premium, intentional, and image-led than the original.
