# Design Language

Status: First read-only staging observation created on 2026-06-28.

This file records observed JEDDA website design patterns. It is descriptive, not prescriptive. Do not redesign from this file alone; use it as a reference before future changes.

## Overall Impression

- VERIFIED: JEDDA's storefront direction is minimalist, editorial, monochrome, and fashion-led.
- VERIFIED: Product imagery carries most of the emotional weight.
- VERIFIED: Interface copy is sparse and functional.
- VERIFIED: The site avoids loud promotional UI in the observed pages.
- ASSUMPTION: The intended brand feeling is quiet premium, studio-like, restrained, and image-first.

## Typography

- VERIFIED: Frontend typography observed uses `Helvetica Neue`, Helvetica, Roboto, Arial, sans-serif.
- VERIFIED: Navigation uses light-weight text, around `11px` on mobile observations and approximately `300` weight.
- VERIFIED: Product titles in mobile shop observation render around `10.5px`, weight `400`.
- VERIFIED: Cart empty-state heading text uses larger sizes, including `42px` for the hidden/zero-height Cart page title observation, `28px` for `New in store`, and `16px` for `Your cart is currently empty!`.
- VERIFIED: Product names are title case with restrained naming, e.g. `Rhea Flare Jacket`, `Kiro Cropped Vest`, `Semi Cropped Blazer (Bistre)`.
- ASSUMPTION: The typography strategy aims for understatement rather than overt luxury ornamentation.

## Spacing and Layout Rhythm

- VERIFIED: Navigation is simple and category-led: `Shop`, `New Arrival`, `About`, `My Account`, `Cart`.
- VERIFIED: Product categories/collections appear as terse filters: `SS26`, `AW25`, `SS25`, `Vests`, `Shirts`, `Skirts`, `Pants`, `Blazers`.
- VERIFIED: Shop page presents a dense product grid with repeated product cards and stock labels.
- VERIFIED: Cart empty state includes product recommendations under `New in store`.
- VERIFIED: Footer contains compact business/contact information and utility links.
- ASSUMPTION: The layout rhythm is intended to feel gallery-like and commerce-light, with minimal instructional copy.

## Button and Link Style

- VERIFIED: Observed UI relies more on text links than prominent buttons.
- VERIFIED: Shop product cards expose `Select options` text for variable products, but it appeared hidden in some mobile DOM samples.
- VERIFIED: Navigation and category controls appear as plain text rather than boxed buttons.
- ASSUMPTION: Future buttons should stay restrained, likely text-first or minimal monochrome controls, unless checkout usability requires stronger affordance.

## Image Treatment

- VERIFIED: Homepage uses large fashion imagery as the primary visual signal.
- VERIFIED: Product imagery is portrait-oriented; observed product images commonly report `1032x1548`, a 2:3 fashion/catalog ratio.
- VERIFIED: Mobile cart recommendations display product images at approximately `350x525`, preserving the 2:3 ratio.
- VERIFIED: Some homepage images are decorative or empty-alt.
- VERIFIED: Some product grid image observations returned `1x1` placeholder-like images, likely lazy-load or responsive placeholder behavior.
- ASSUMPTION: Image quality, cropping, and lazy-load behavior are central to perceived premium quality.

## Color Usage

- VERIFIED: Palette observed is restrained: black, white, near-black text, grey secondary text, and image-driven color.
- VERIFIED: Navigation text appears white over homepage imagery and dark/near-black on commerce pages.
- VERIFIED: Footer and commerce UI stay neutral and monochrome.
- ASSUMPTION: Future color additions should be rare and justified by product imagery, alerts, checkout clarity, or brand system needs.

## Mobile Behavior

- VERIFIED: Mobile homepage shows actual imagery when logged in, while public unauthenticated access shows coming-soon.
- VERIFIED: Mobile shop text is very small, with nav around `11px` and product titles around `10.5px`.
- VERIFIED: Mobile cart and checkout empty states are readable and stack into a single-column product recommendation layout.
- VERIFIED: Mobile checkout with empty cart resolves to the cart empty state, not a checkout form.
- NOT VERIFIED: Mobile menu opening/closing behavior.
- NOT VERIFIED: Mobile product detail interactions, variant selection, add-to-cart, and checkout form completion.
- ASSUMPTION: Mobile readability and tap targets need dedicated visual QA because the current premium-minimal direction uses very small text.

## Checkout Visual Experience

- VERIFIED: Checkout page exists and is configured with `[woocommerce_checkout]`.
- VERIFIED: Empty checkout redirects/displays the cart empty state and title `Cart - Jedda`.
- VERIFIED: Guest checkout is enabled.
- VERIFIED: Midtrans checkout payment copy says: `Choose Virtual Account, QRIS, GoPay, or Credit Card for a secure and seamless payment experience.`
- NOT VERIFIED: Checkout form visual design with an item in cart.
- NOT VERIFIED: Shipping-rate selection UI.
- NOT VERIFIED: Midtrans hosted payment page visual transition.
- ASSUMPTION: Checkout needs separate staged test data and email/payment safety controls before full UX review.

## Interface Copy Tone

- VERIFIED: Navigation copy is short and direct.
- VERIFIED: Product and collection labels are concise.
- VERIFIED: Checkout payment copy is functional and reassurance-oriented.
- VERIFIED: Empty cart copy says `Your cart is currently empty!` and `New in store`.
- VERIFIED: Public coming-soon copy is generic WordPress/Hostinger copy, not brand-specific.
- ASSUMPTION: JEDDA's ideal copy voice should be spare, calm, and useful, avoiding generic platform language.

## Premium Signals

- VERIFIED: Strong product photography and restrained monochrome UI support a premium feel.
- VERIFIED: Minimal navigation and sparse copy keep the site focused.
- VERIFIED: Product naming and collection structure feel fashion/editorial.
- VERIFIED: Large image-led homepage supports brand-first browsing.

## Less-Premium Signals / Watchouts

- VERIFIED: Generic public coming-soon page does not reflect the JEDDA brand.
- VERIFIED: Many `Out of Stock` labels on shop listing may reduce desire and make the catalog feel depleted.
- VERIFIED: Very small mobile typography may hurt readability.
- VERIFIED: Missing/empty image alt text weakens accessibility and SEO.
- VERIFIED: Lazy-load/placeholder image behavior needs visual QA because some sampled images appeared as `1x1`.
- VERIFIED: Admin toolbar/update notices were visible during logged-in observations and should not be confused with customer experience.
- ASSUMPTION: Because the site is visually restrained, small inconsistencies in spacing, image loading, stock labels, and copy will be more noticeable.

## Future Design Direction Guardrails

- ASSUMPTION: Preserve the quiet, editorial, image-first quality.
- ASSUMPTION: Prefer fewer, better UI elements over adding explanatory blocks.
- ASSUMPTION: Keep buttons and controls minimal, but do not sacrifice checkout clarity.
- ASSUMPTION: Use product photography as the primary color and emotion source.
- ASSUMPTION: Audit mobile typography carefully before increasing density.

