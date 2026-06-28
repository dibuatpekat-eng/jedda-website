# Phase 7 — Customer Journey Audit

Status: VERIFIED on staging where observed.
Staging URL: https://beta.jeddawear.com
Date: 2026-06-28

## Audit Scope

This audit evaluates the current JEDDA staging shopping journey against the Phase 6 digital design direction in:

- `20_DESIGN_RESEARCH.md`
- `21_DIGITAL_DESIGN_PRINCIPLES.md`
- `22_COMPONENT_DIRECTION.md`

The audit was performed as a customer journey review, not as implementation work.

No website code was modified.
No settings were changed.
No plugins were updated.
No deployment was performed.
No real order was created.

## Verification Notes

- VERIFIED: Actual storefront pages were reviewed in a logged-in browser session on staging.
- VERIFIED: Homepage, shop, search results, empty search, PDP, cart, checkout, account dashboard, desktop, and mobile breakpoints were inspected.
- VERIFIED: Product selection and add-to-cart were tested using `Kiro Cropped Vest` with `Breen` and `S/M`.
- VERIFIED: Checkout was opened only as far as safe. Place order was not clicked.
- VERIFIED: Checkout email safety is still a concern from earlier `.jedda` documentation, so order submission and validation tests were intentionally avoided.
- NOT VERIFIED: Public logged-out customer storefront, because prior documentation indicates staging can present a gate/browser-check/coming-soon layer to unauthenticated visitors.
- NOT VERIFIED: Logged-out login/register screens, because the active audit session was logged in and logging out could disturb the working admin context.

Important caveat: the visual audit happened inside a logged-in admin session. The WordPress admin bar and logged-in account state are not part of the intended customer experience, but they did affect what was visible during the audit.

## Executive Read

JEDDA already has the foundation of a premium editorial commerce experience: image-led homepage, restrained navigation, clean product imagery, simple PDP content, and quiet cart/checkout flows. The strongest parts are the product imagery, minimal interface, and complete PDP information around fit, material, shipping, and returns.

The main weakness is not the aesthetic intention. The weakness is consistency and interaction reassurance. Several flows feel visually premium at rest but become less premium once clicked: invalid add-to-cart can enter a loading state without feedback, empty states are generic, checkout has odd copy and hidden headings, search is not clearly discoverable, and mobile image/layout behavior is inconsistent.

Phase 7 should prioritize making the journey feel intentional after every click.

## Journey Summary

| Step | Current State | Premium Fit | Main Gap |
| --- | --- | --- | --- |
| Homepage | Image-first and quiet, with minimal visible copy. | Strong direction. | No clear heading or customer guidance; logged-in nav contrast inconsistency; image alt missing. |
| Navigation / menu | Desktop nav is restrained and clear. Mobile nav/search visibility was weak in observed DOM. | Partially aligned. | Mobile discoverability and active/hover/focus states need clearer standards. |
| Collection / shop | Clean 4-column desktop grid and 2-column mobile grid. | Strong base. | Hidden sorting/filtering, heavy out-of-stock presence, inconsistent mobile image sizing. |
| Product cards | Image-led, restrained title and price. | Good aesthetic fit. | CTAs are hidden; product state and hover behavior do not give enough reassurance. |
| PDP | Strong product content, restrained typography, large primary actions. | Good base. | Variant validation feedback is weak; gallery/related-product placeholders feel unfinished. |
| Size / variant selection | Swatches work once selected. | Good if polished. | Invalid add-to-cart can show loading without clear error or recovery. |
| Add to cart | Valid add eventually updates cart count. | Functional but not reassuring. | Slow perceived response and no visible success message or next-step affordance. |
| Cart | Minimal and readable, with product, subtotal, shipping note, total, checkout. | Partially aligned. | Remove/coupon affordances are unclear; mobile load felt slow. |
| Checkout | Restrained single-column checkout and reassuring Midtrans copy. | Partially aligned. | Odd copy, hidden headings, unclear validation/loading states, shipping not yet explained enough. |
| Login / register / account | Logged-in dashboard is sparse and functional. | Neutral. | Logged-out login/register not verified; account dashboard lacks a premium service tone. |
| Search | Direct search URL works. Empty result exists. | Weak. | Search UI is hard to discover; empty state is generic and not helpful. |
| Empty states | Cart recommends products; search has generic Woo notice. | Mixed. | Empty states need editorial but useful next actions. |
| Error states | 404 exists and shows products. | Weak. | Tone and placeholder imagery do not match premium direction. |
| Mobile | Core pages are usable. | Partially aligned. | Navigation/search visibility, image loading, cart performance, and tap affordances need refinement. |

## 1. Homepage

VERIFIED URL: `https://beta.jeddawear.com`

### What Works

- The homepage is image-first and minimal, which matches the Phase 6 direction for a quiet editorial brand.
- The desktop hero image gives immediate brand mood without needing a marketing-heavy hero section.
- The absence of promotional clutter helps JEDDA feel more premium than a conventional sales-led fashion storefront.

### Issues

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Homepage hero | The page has no clear visible heading or customer orientation beyond image and navigation. | Editorial restraint is good, but a customer still needs enough context to know where to go next. | Medium | Medium | Add a quiet, image-compatible first action or structured homepage rhythm without turning it into a marketing landing page. | Visual system cleanup |
| Homepage imagery | Hero images have empty alt text. | Premium includes accessibility and image meaning, especially for product/brand imagery. | Medium | Low | Add meaningful alt text for editorial and product images. | Customer journey cleanup |
| Header over hero | In the logged-in view, one nav item appeared dark while other items were white over the hero. | Inconsistent contrast breaks the polished, intentional feel. | Medium | Low | Standardize header contrast states over image backgrounds. | Visual system cleanup |
| Public access | Prior documentation indicates unauthenticated staging can show a gate/browser-check/coming-soon layer. | A true customer journey cannot be fully verified if public access is blocked or inconsistent. | High | Medium | Define whether staging is intentionally private; if public audit is needed, provide a clean customer-access path. | Customer journey cleanup |

### Interaction Read

The homepage feels premium when static because it is quiet and image-led. It becomes less verifiable as a customer experience because the audit session shows admin state, and the public logged-out state is not confirmed as a clean storefront.

## 2. Navigation / Menu

VERIFIED desktop links included: `SHOP`, `NEW ARRIVAL`, `ABOUT`, `MY ACCOUNT`, `CART`.

### What Works

- Desktop navigation is minimal and brand-appropriate.
- Small uppercase nav can work for JEDDA if spacing, contrast, and active states are consistent.
- Cart count updates after adding a product, which gives at least one global feedback signal.

### Issues

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Header nav | Active, hover, focus, and contrast states are not yet documented or consistently felt. | A premium site should feel precise before and after interaction. | Medium | Medium | Define header states for default, hover, focus-visible, active page, cart updated, and transparent-over-image modes. | Visual system cleanup |
| Mobile nav | Mobile navigation/search controls were not clearly visible in observed output. | Mobile customers need immediate, confident access to shop, search, account, and cart. | High | Medium | Audit and standardize mobile header controls, tap targets, menu opening, menu close behavior, and focus trap. | Customer journey cleanup |
| Search access | Search controls appeared hidden or duplicated in the DOM. | Search should feel intentional, not like leftover theme behavior. | Medium | Medium | Consolidate search into one visible, tested interaction pattern. | Customer journey cleanup |

### Interaction Read

Navigation currently feels best as a static desktop composition. It needs stronger interaction definition: after clicking menu/search/cart, customers should see immediate, legible feedback and an obvious way back.

## 3. Collection / Shop Page

VERIFIED URL: `https://beta.jeddawear.com/shop/`

Observed behavior:

- Desktop grid showed 4 columns.
- Mobile grid showed 2 columns.
- Many listed products were out of stock.
- Sorting/filter controls existed but were visually hidden.
- Desktop warm load was about 2 seconds in the logged-in audit session.
- Mobile shop loaded in about 1.6 seconds in the logged-in audit session.

### What Works

- The grid is image-led and restrained.
- Product imagery uses a consistent fashion-commerce ratio on desktop.
- The quiet product metadata supports the premium direction.

### Issues

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Collection grid | Many products display `Out of Stock`, including prominent first-row items. | A premium shop should feel available and curated, not depleted. | High | Medium | Decide whether sold-out products belong in the main grid, should sort lower, or should be filtered into archive/editorial context. | Customer journey cleanup |
| Collection controls | Sorting/filtering exists but appears hidden. | Customers cannot easily narrow product discovery. | Medium | Medium | Introduce restrained category/filter/sort controls aligned with JEDDA typography and spacing. | Customer journey cleanup |
| Mobile grid | Some mobile product images appeared inconsistently sized or as tiny/placeholder-like elements. | Inconsistent image sizing makes the site feel unfinished and less trustworthy. | High | Medium | Stabilize mobile image aspect ratios, lazy-loading behavior, and placeholder handling. | Visual system cleanup |
| Product metadata | Product card titles are very small. | Small type can be premium, but not if readability suffers on mobile. | Medium | Low | Define minimum product-card type sizes and line heights for desktop and mobile. | Visual system cleanup |

### Interaction Read

The shop page looks closest to the desired reference direction when it is stable. The main interaction gap is discovery: customers can browse images, but they are not given enough refined controls to filter, sort, understand stock state, or recover from out-of-stock-heavy browsing.

## 4. Product Cards

### What Works

- Product cards are image-first.
- Product title and price are visually restrained.
- The grid does not feel cluttered by badges or aggressive CTAs.

### Issues

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Product card CTA | `Select options` exists but is visually hidden in the grid. | Minimal cards are good, but customers still need confidence that cards are interactive. | Medium | Low | Keep cards quiet, but define hover/focus/tap behavior such as image change, underline, cursor, or subtle title state. | Visual system cleanup |
| Product image alt | Some product image alt text is numeric or empty. | Accessibility and image meaning are part of premium execution. | Medium | Low | Replace numeric/empty alt text with product-aware alt text. | Customer journey cleanup |
| Product state | Out-of-stock state is repeated and visually dominant. | Stock status should inform without making the collection feel like an error state. | Medium | Medium | Standardize sold-out visual treatment and sorting behavior. | Customer journey cleanup |

### Interaction Read

Product cards should not become loud. They should become clearer. Hover, focus, and tap should confirm that the image/title is actionable without adding heavy buttons everywhere.

## 5. Product Detail Page

VERIFIED URL: `https://beta.jeddawear.com/product/kiro-vest/`

### What Works

- PDP content is one of the strongest parts of the current site.
- Details, fit, material, care, shipping, and returns are present and useful.
- The primary actions are large and clear.
- Variant swatches are visually cleaner than default dropdowns.

### Issues

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Variant validation | Clicking `ADD TO CART` before selecting variants caused the button to enter a loading state without a visible error or recovery. | This is a trust-breaking interaction at the most important conversion point. | Critical | Medium | Prevent loading on invalid selection; show concise inline guidance near swatches and restore button state immediately. | Customer journey cleanup |
| Add-to-cart success | Valid add-to-cart eventually updated cart count, but no clear success message or next action appeared. | Customers need reassurance that the action worked and guidance to view cart or continue shopping. | High | Medium | Add a restrained success state: cart count update, mini-cart/drawer or inline message, and clear next actions. | Customer journey cleanup |
| PDP gallery | Some gallery/related images appeared as 1x1 placeholders or offscreen carousel elements. | Placeholder artifacts make a premium product page feel technically unfinished. | High | Medium | Stabilize gallery lazy loading, related-product carousel layout, and image placeholders. | Visual system cleanup |
| 404 from guessed slug | `/product/kiro-cropped-vest/` returned 404 while the actual product URL was `/product/kiro-vest/`. | Old/shared/slightly guessed product URLs may create avoidable customer dead ends. | Medium | Low | Add redirects for known renamed products or ensure product slugs match customer-facing names where appropriate. | Later architecture refactor |

### Interaction Read

The PDP content feels premium. The conversion interaction does not yet feel premium. The most important rule: a product page must never make the customer wonder whether their click broke something.

## 6. Size / Variant Selection

### What Works

- Swatches are cleaner than native dropdowns.
- Selected swatches correctly update hidden variation fields.
- After valid selection, the add-to-cart button becomes actionable.

### Issues

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Variant swatches | Invalid state is not explained before action. | Customers should know what is required before they hit a dead end. | High | Low | Show required option groups clearly and add inline selection guidance only when needed. | Customer journey cleanup |
| Focus states | Keyboard/focus behavior for swatches was not confirmed as visible. | Swatches must be accessible and reassuring for non-mouse users. | Medium | Medium | Add visible focus states and ARIA-complete swatch behavior. | Visual system cleanup |
| Disabled state | Button had disabled-like classes but still accepted click behavior. | Visual and functional states must agree. | High | Medium | Align button disabled state, click handling, loading state, and validation message. | Customer journey cleanup |

## 7. Add to Cart Behavior

Observed:

- Invalid add-to-cart: button entered loading state with no visible notice.
- Valid add-to-cart: cart count updated to `CART 1` after several seconds.
- No visible success notice was found after valid add-to-cart.

### Issues

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Add-to-cart feedback | Success is only implied by cart count and hidden mini-cart text. | Premium commerce should reassure immediately without forcing customers to inspect the header. | High | Medium | Add intentional success feedback: subtle message, cart drawer, or button state change with next action. | Customer journey cleanup |
| Perceived speed | Valid add-to-cart took several seconds in the audit session. | Even if technically successful, slow feedback feels uncertain. | High | Medium | Show immediate local loading state, disable repeat clicks, and complete with visible confirmation. | Customer journey cleanup |
| Error handling | Invalid add-to-cart did not show a useful error. | This can block purchase intent. | Critical | Medium | Replace theme/plugin default failure behavior with clear variant-required feedback. | Customer journey cleanup |

## 8. Cart

VERIFIED URL: `https://beta.jeddawear.com/cart/`

### What Works

- Filled cart is minimal and readable.
- Product, selected options, quantity, subtotal, shipping note, total, and checkout action are present.
- Empty cart recommends products, which is directionally useful.

### Issues

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Empty cart | Copy is generic and lacks a strong continue-shopping path. | Empty states should help customers recover elegantly. | Medium | Low | Add a quiet continue-shopping CTA and curated product/category links. | Customer journey cleanup |
| Remove item | Remove control appears visually unclear, with text styling not matching the action importance. | Destructive actions should be easy to understand but not visually loud. | Medium | Low | Use a clear text/icon treatment with hover/focus and confirmation only if needed. | Visual system cleanup |
| Coupon | `ADD A COUPON` appears minimal but under-explained. | Coupon flows often create friction if customers cannot understand whether a code is applied. | Low | Low | Add clear applied, invalid, and loading states for coupon interaction. | Customer journey cleanup |
| Mobile cart speed | Mobile cart load felt slow in the audit session. | Cart is a high-intent page; slow loading creates purchase anxiety. | High | Medium | Profile cart block rendering and reduce blocking assets/scripts. | Later architecture refactor |

### Interaction Read

The cart has a good quiet base. It needs clearer feedback for quantity changes, coupon application, remove action, and transition to checkout.

## 9. Checkout

VERIFIED URL: `https://beta.jeddawear.com/checkout/`

Checkout was reviewed only up to the safe point before placing an order.

### What Works

- The checkout is restrained and not visually noisy.
- Product summary and total are visible.
- Midtrans payment copy is reassuring.
- The single-column feel can support a premium checkout if refined.

### Issues

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Checkout copy | The phrase `Give me one second` appears near Billing Address. | This feels accidental/debug-like and breaks customer trust. | High | Low | Replace with polished loading/help copy or remove it. | Customer journey cleanup |
| Headings | Some checkout headings appear visually hidden or styled with zero font size. | Hidden visual hierarchy weakens clarity and accessibility. | High | Medium | Restore visible, well-sized section headings: Billing, Delivery, Order Summary, Payment. | Visual system cleanup |
| Form required states | Required labels are visible, but field-level required behavior was not fully verified because order submission was avoided. | Checkout must make missing information obvious before payment. | High | Medium | Define required, optional, error, success, focus, disabled, and loading states for all fields. | Customer journey cleanup |
| Shipping explanation | Shipping is calculated during checkout, but the timing and method are not deeply explained. | Customers need cost certainty before payment. | Medium | Medium | Add concise shipping calculation copy near address and order summary. | Customer journey cleanup |
| Place order safety | Full validation/order flow remains NOT VERIFIED due email-delivery risk. | A checkout cannot be considered production-ready until validation and payment handoff are safely tested. | High | Medium | Disable outbound staging emails or use safe test inbox before full checkout QA. | Later architecture refactor |

### Interaction Read

Checkout is visually restrained but not yet reassuring enough. Premium checkout should feel calm, explicit, and precise: every field focus, validation error, address update, shipping calculation, payment selection, and submission state must be visible and predictable.

## 10. Login / Register / Account

VERIFIED URL in logged-in state: `https://beta.jeddawear.com/my-account/`

### What Works

- Logged-in dashboard is simple and functional.
- Account sections are present: orders, downloads, addresses, account details, communication, logout.

### Issues

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Login/register | Logged-out login/register experience was not verified. | A premium customer journey includes account creation and returning-customer login. | Medium | Low | Test in a clean logged-out customer session once staging access is safe. | Customer journey cleanup |
| Account dashboard | Dashboard feels functional but sparse, with limited service tone. | Account pages should feel like aftercare, not leftover WooCommerce defaults. | Low | Medium | Refine copy, spacing, and order/address empty states. | Visual system cleanup |

## 11. Search

VERIFIED direct URLs:

- `/?s=jacket&post_type=product`
- `/?s=zzzxxy-no-product&post_type=product`

### What Works

- Search results route works.
- Empty search returns a clear no-products message.

### Issues

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Search trigger | Search UI appeared hidden or duplicated in the DOM. | Customers should not need to guess how to search. | High | Medium | Define one search entry point in header/mobile menu and remove conflicting hidden patterns. | Customer journey cleanup |
| Search results | Search results are very plain and out-of-stock-heavy for common terms like jacket. | Search should help customers recover intent quickly. | Medium | Medium | Add result counts, category suggestions, and better sold-out handling. | Customer journey cleanup |
| Empty search | Empty result copy is generic WooCommerce language. | Premium empty states should be useful and brand-appropriate. | Medium | Low | Add refined copy plus links to shop all, new arrival, and key categories. | Customer journey cleanup |

## 12. Empty States

### Current Empty States Observed

- Empty cart: `Your cart is currently empty!` plus `New in store` products.
- Empty search: `No products were found matching your selection.`
- 404: informal surf-themed copy plus latest products.

### Direction

Empty states should be quiet, useful, and composed. They should not feel like default WooCommerce output or unrelated theme copy.

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Empty cart | Helpful products exist, but copy and hierarchy are generic. | Empty cart is a recovery moment. | Medium | Low | Use concise JEDDA copy and a clear return-to-shop action. | Customer journey cleanup |
| Empty search | No curated next step. | Search failure should redirect intent, not end it. | Medium | Low | Add suggested categories and popular products. | Customer journey cleanup |
| 404 | Tone feels unrelated to JEDDA and imagery can show placeholders. | Error pages still shape brand trust. | Medium | Medium | Rewrite 404 in JEDDA tone and stabilize product image rendering. | Visual system cleanup |

## 13. Error States

The most important error-state issue observed is PDP variant validation. The site allowed a click that resulted in loading without visible recovery.

Error states should:

- Appear near the action that caused them.
- Use calm, human copy.
- Explain exactly what to do next.
- Never trap a button in loading.
- Preserve the customer's selected context.
- Avoid red-heavy alarm unless payment or destructive action truly failed.

## 14. Mobile Experience

### What Works

- The shop page uses a 2-column product grid.
- Cart content is readable on a narrow viewport.
- Primary PDP actions are full-width and easy to tap.

### Issues

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Mobile header | Search/menu discoverability was weak in observed output. | Mobile is likely a primary shopping context. | High | Medium | Standardize visible header controls and menu/search behavior. | Customer journey cleanup |
| Mobile grid images | Some images appeared inconsistent or placeholder-like. | Product imagery is the core of fashion commerce. | High | Medium | Lock image ratios, loading placeholders, and lazy-load thresholds. | Visual system cleanup |
| Mobile cart | Cart load felt slow. | High-intent mobile customers are sensitive to delay. | High | Medium | Profile cart scripts/assets and optimize block rendering. | Later architecture refactor |
| Mobile tap states | Hover does not exist on mobile, so tap feedback must be explicit. | Customers need reassurance after each tap. | Medium | Medium | Define pressed/loading/success states for product cards, swatches, cart actions, and checkout buttons. | Visual system cleanup |

## Customer Journey Priority

The immediate Phase 7 cleanup should focus on:

1. PDP variant validation and add-to-cart feedback.
2. Search discoverability and useful empty search states.
3. Mobile header/menu/search clarity.
4. Checkout copy, headings, and form feedback.
5. Product grid stock-state handling and mobile image stability.

The current site has the right quietness. The next step is making that quietness reliable.
