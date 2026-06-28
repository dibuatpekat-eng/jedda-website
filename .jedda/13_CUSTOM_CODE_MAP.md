# Custom Code Map

Status: Phase 3 read-only custom code mapping completed on 2026-06-28.

Scope: Active WPCode snippets, active Code Snippets, relevant inactive launch hook snippet, theme `functions.php`, parent-theme WooCommerce template overrides, WPBakery Custom CSS/JS, and known custom CSS/JS surfaces. No code was changed.

Sensitive-data note: Some snippets contain external service credentials. Values are intentionally not copied into this documentation.

## Custom Code Surfaces

| Surface | Count / status | Risk | Notes |
| --- | --- | --- | --- |
| WPCode Lite | 22 active snippets | High | Main source of custom frontend, checkout, order, launch, and styling behavior. |
| Code Snippets | 2 active snippets | High | Thank-you order status text and global DOM text-node removal. |
| Code Snippets inactive history | Relevant inactive launch/order hook exists | High if reactivated | Contains WooCommerce/Supabase order hook logic and hardcoded credential. |
| Theme `functions.php` | Parent theme edited/extended | Medium | Framework file includes custom additions for cart fragments, jQuery, and quantity input. |
| Parent theme WooCommerce overrides | 2 overrides | High | `archive-product.php` is outdated versus WooCommerce core. |
| WPBakery Custom CSS | 11,175 characters | Medium | Large global CSS for mobile header, product detail, shop, footer, and responsive styling. |
| WPBakery Custom JS | Empty | Low | Header and footer custom JS fields are empty. |
| WordPress Customizer Additional CSS | NOT VERIFIED | Unknown | Customizer loaded, but Additional CSS field was not stably accessible during read-only inspection. |
| WPIDE | Active | High | Enables direct file edits from admin; exact edited files not verified. |

## Active WPCode Snippets

| ID | Name | Type / location | Purpose | Affects | Dependencies | Risk | Should remain there? | Recommended home |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 13948 | Jedda Launch - Form & Token | HTML / site wide footer | Implements SS26 waitlist form, token verification page, Supabase REST calls, product access locking, and optional waitlist button injection. | `/early-access/`, `/jacket-access/`, product pages with `jd_token`, Supabase launch tables. | Supabase REST/RPC, WooCommerce products/variations, URL params, theme product DOM, browser `fetch`. | Critical | No. Too large and business-critical for WPCode. | Custom Plugin for business logic plus Child Theme for presentation. |
| 13041 | Buy-now option alert | JS / site wide header | Prevents direct checkout when product variation options are incomplete and shows alert. | Single product pages with `.de-single-direct-checkout`. | Woo variation selects, theme direct checkout button. | Medium | Short term yes. | Child Theme JS or custom plugin asset. |
| 13040 | Color and size font | CSS / site wide header | Styles variation labels/swatches. | Product pages. | Variation Swatches plugin and theme selectors. | Low | Short term yes. | Child Theme CSS. |
| 11836 | Untitled Snippet | JS / site wide header | Removes text nodes containing `Request` inside My Account content. | My Account pages. | jQuery, Woo account DOM. | Medium | No. Name unclear and DOM-text based. | Remove or Child Theme JS after confirming target text. |
| 5163 | Pre Order Badge Mobile | JS / site wide footer | Repositions Advanced Woo Labels preorder badge on mobile product cards and hides New badge. | Mobile shop/product grids. | Advanced Woo Labels markup, theme product card DOM. | Medium | No long term. | Child Theme JS/CSS, or one badge plugin strategy. |
| 5152 | Posisi Badge Preorder | JS / site wide footer | Moves preorder badge into single product sale/new badge container. | Single product pages. | jQuery, Advanced Woo Labels, Upscale badge markup. | Medium | No long term. | Child Theme template/CSS. |
| 4969 | Remove Pay Button - My Account Page | PHP / everywhere | Removes Pay action from My Account order list while preserving view-order payment link. | My Account > Orders. | WooCommerce `woocommerce_my_account_my_orders_actions`. | Medium | Not ideal. | Custom Plugin because it is order/payment behavior. |
| 3653 | Spacing Add-ons | JS / site wide footer | Adds margin below `.wrapper__label-value`; logs success/fail to console. | Product add-ons/variation label areas. | Theme/product DOM. | Low | No. | Child Theme CSS; remove console logs. |
| 3613 | Pre-Order Badge | JS / site wide header | Renames badge text `New` to `New Arrival`. | Product grids/cards. | Theme badge DOM. | Low | No long term. | Child Theme filter/template if available, otherwise CSS/JS asset. |
| 2644 | Hide Order Again Button | JS / site wide footer | Hides `.order-again` elements. | Order received / My Account order detail. | WooCommerce order-again markup. | Medium | No. | Custom Plugin using WooCommerce filter/action. |
| 2642 | Hide Dashboard Notification | JS / site wide footer | Attempts to hide My Account generated status message if pseudo content matches expected text. | `/my-account/`. | CSS pseudo-content, account DOM. | Medium | No. Brittle pseudo-content detection. | Remove or replace with server-side message control. |
| 2531 | Adjust YayMail Column Span | PHP / everywhere | Forces YayMail product title column span to 2. | WooCommerce emails rendered by YayMail. | YayMail filter. | Medium | Acceptable short term. | Custom Plugin or email-template documentation. |
| 2395 | Custom Login Styles | JS / site wide footer | Restyles login labels, remember-me checkbox, lost password link, and login button by direct DOM styling. | My Account login form and possibly checkout login. | Login form selectors, Overpass font. | Medium | No. | Child Theme CSS and text filters. |
| 2393 | Disable Hover Effect on Size Options | PHP / everywhere | Outputs CSS in `wp_head` to disable swatch hover effects. | Product variation swatches. | Woo variation swatch markup. | Low | No. | Child Theme CSS. |
| 2386 | Order Page Condition Status | PHP / site wide header | Injects footer JS that reads `.order-status` and writes custom status message via generated CSS. | My Account order pages. | Woo order status DOM and CSS pseudo-content. | High | No. | Custom Plugin using WooCommerce hooks/templates. |
| 2385 | Payment Button for Customer Order Page | PHP / everywhere | Styles Midtrans payment info table and renames Midtrans redirect link to `Pay Now`. | Customer order/payment pages. | Midtrans table/link DOM. | High | No. | Custom Plugin or WooCommerce template override in child theme. |
| 2384 | Product Page - Out of Stock Button | PHP / frontend only | Watches variation availability and disables/renames Buy Now button when out of stock. | Variable product pages. | Woo variation availability DOM, theme direct checkout button. | High | No. Missing guard if button is absent. | Child Theme JS or custom plugin asset. |
| 2378 | CSS Out of Stock | CSS / site wide header | Hides WooCommerce variation availability text. | Product pages. | Woo variation availability markup. | Medium | Maybe short term. | Child Theme CSS; reconsider UX. |
| 2366 | Order Received Page - Styling Button Etc | PHP / everywhere | Styles Midtrans payment table/link and changes link text to `Click Here`. | Order received page. | Midtrans table/link DOM. | High | No. | Child Theme template/CSS or Custom Plugin. |
| 2217 | JS Cart and Checkout | JS / site wide header | Auto-checks account creation, makes order details/cust details accordions, adds Billing Information heading, toggles My Account order sections. | Checkout, order received, My Account order details. | jQuery, Woo checkout/order DOM, CSS from snippet 2193. | High | No. | Custom Plugin for behavior plus Child Theme assets. |
| 2193 | CSS Cart & Checkout | CSS / site wide header | Large CSS package for cart, mini cart, checkout, coupon, order received, My Account, Epeken popup, and responsive order details. | Cart, mini cart, checkout, order received, My Account. | Woo blocks, classic checkout shortcode, Upscale DOM, Epeken DOM, Overpass font. | High | No long term. | Child Theme CSS split by surface. |
| 2000 | SSS Sj | HTML / site wide footer | Adds quantity plus/minus buttons, search modal behavior, and product/search/shop CSS. | Product pages, search modal, shop archive. | jQuery, theme search/product DOM, Woo quantity input. | High | No. Duplicates `functions.php` quantity behavior. | Child Theme JS/CSS; remove duplicate quantity injection. |

## Active Code Snippets

| ID | Name | Purpose | Affects | Dependencies | Risk | Recommended home |
| --- | --- | --- | --- | --- | --- | --- |
| 7 | sss jam conditional code for thankyou page | Replaces WooCommerce thank-you text based on order status: pending/on-hold vs processing/completed. | Checkout/order received page. | WooCommerce `woocommerce_thankyou_order_received_text`. | Medium | Custom Plugin because it is order status messaging. |
| 9 | benerin ]]] | Removes direct text nodes from `document.body` in footer. | Entire frontend. | Browser DOM. | High | Remove after identifying the original stray-text issue, or replace narrowly. |

## Relevant Inactive Code Snippet

| ID | Name | Purpose | Status | Risk |
| --- | --- | --- | --- | --- |
| 10 | Jedda Launch - WooCommerce Hook | Defines Woo AJAX endpoint to store launch token in Woo session, saves `_jd_launch_token` to orders, and updates Supabase token/waitlist status on processing/completed orders. | Inactive during inspection. | Critical if reactivated; contains hardcoded external service credential and writes external launch state from Woo order hooks. |

## Theme `functions.php`

VERIFIED: `functions.php` is primarily the Upscale/Dahz framework bootstrap, with custom additions appended near the end:

- Enqueues `wc-cart-fragments` when WooCommerce exists.
- Enqueues jQuery.
- Adds a `woocommerce_quantity_input_args` filter attempting to customize quantity input markup with plus/minus buttons.

Risk:

- Medium: This is in the parent theme, not a child theme.
- Medium: Quantity controls are also injected by WPCode snippet `SSS Sj`, creating duplicate behavior risk.
- Medium: Parent theme updates can overwrite changes if these were manually added.

Recommended home:

- Child Theme for presentation/quantity input template behavior.
- Custom Plugin only if quantity behavior becomes business logic.

## WooCommerce Template Overrides

| File | Purpose | Version status | Risk | Recommended home |
| --- | --- | --- | --- | --- |
| `upscale/woocommerce/archive-product.php` | Product archive/shop template; removes taxonomy archive description before running archive description hook. | Override version `3.4.0`; WooCommerce core version `8.6.0`. | High | Child Theme after updating against current WooCommerce template. |
| `upscale/woocommerce/single-product-reviews.php` | Product review display form customized by Upscale theme. | Override version `4.3.0`. | Medium | Child Theme only if JEDDA-specific edits are needed; otherwise keep as theme responsibility. |

## WPBakery Custom CSS / JS

- VERIFIED: WPBakery Custom CSS contains `11,175` characters.
- VERIFIED: WPBakery Custom CSS affects mobile header, product detail page, variation swatches, related products, shop archive, footer, media queries, and responsive layout.
- VERIFIED: WPBakery Custom JS header/footer fields are empty.

Risk:

- Medium: CSS is global and selector-heavy.
- Medium: It overlaps with WPCode CSS snippets for product, cart, checkout, account, and order pages.
- Low immediate risk if left unchanged.

Recommended home:

- Child Theme CSS, organized by surface: header, product, shop, cart/checkout/account, footer.

## Customizer / Theme Options

- VERIFIED: Upscale Customizer sections exist for General, Header, Footer, Blog, Color, Typography, WooCommerce Settings, Portfolio, Menus, Widgets, Homepage Settings, WooCommerce, and Export/Import.
- NOT VERIFIED: Additional CSS content from WordPress Customizer. The read-only inspection did not expose a stable Additional CSS editor field.
- ASSUMPTION: Theme options likely control key visual configuration and should be exported before redesign work.

