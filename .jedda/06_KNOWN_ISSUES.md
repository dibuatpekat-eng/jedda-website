# Known Issues

Status: First read-only staging audit completed on 2026-06-28.

## High Priority

- VERIFIED: WooCommerce Status displays a security notice recommending update to WooCommerce `10.5.3` or latest. Active WooCommerce version is `9.3.3`.
- VERIFIED: Action Scheduler notice reports `2335` past-due actions; something may be wrong.
- VERIFIED: Phase 2 mapping found checkout/order/payment/product behavior spread across WPCode, Code Snippets, parent-theme WooCommerce overrides, WPBakery content, and plugins.
- VERIFIED: WPCode contains `22` active snippets, and Code Snippets contains `2` active snippets. Several target WooCommerce cart, checkout, order, account, email, product badge, and launch flows.
- VERIFIED: An inactive launch/waitlist WooCommerce hook snippet contains a hardcoded external service credential. The credential value is intentionally not recorded here.
- VERIFIED: WordPress Reading Settings has `Discourage search engines from indexing this site` unchecked on staging, and the founder reported an error when attempting to enable it.
- VERIFIED: `robots.txt` currently blocks all crawlers with `User-agent: *` and `Disallow: /`.
- VERIFIED: WooCommerce customer emails and admin order emails are enabled on staging.
- VERIFIED: YaySMTP `Disable delivery` is unchecked, so email delivery is not intentionally blocked at the plugin level.
- VERIFIED: YaySMTP logs show staging email can succeed: several WooCommerce order/customer emails on 2026-06-28 logged `Success`.
- VERIFIED: YaySMTP logs also show recent failures, including `Email Test` and `[Jedda] New User Registration`, so current email behavior is inconsistent rather than safely blocked.
- VERIFIED: YaySMTP email log table is approximately `1230.20MB`, dominating the database size.
- VERIFIED: Active theme has no child theme while WooCommerce template overrides exist in the parent theme.
- VERIFIED: `upscale/woocommerce/archive-product.php` override is outdated against WooCommerce core template version.

## Medium Priority

- VERIFIED: WooCommerce Site Visibility admin shows `Live` while unauthenticated public homepage shows a coming-soon page. The protection source is inconsistent or layered.
- VERIFIED: WooCommerce database version reports `10.6.1`, while the active WooCommerce plugin is `9.3.3`.
- VERIFIED: Many plugin updates are pending: update count observed as `33` in dashboard/sidebar and `36` in admin toolbar.
- VERIFIED: WPBakery license/activation notice is visible in admin.
- VERIFIED: WPBakery beta update notice appears in admin and warns beta is intended for testing only and must not be installed on production websites.
- VERIFIED: Theme notice says required plugin `YITH Woocommerce Wishlist` is missing and `Dahz Social Instagram` / `Mailchimp for WP` are inactive.
- VERIFIED: WPIDE file manager/code editor is active, increasing risk of untracked admin-side code edits.
- VERIFIED: Code Snippets and WPCode Lite are active, with `46` WPCode posts reported.
- VERIFIED: Several runtime/development utilities are active even though they are not needed for normal storefront runtime: WPIDE, WP Downgrade, WP Rollback, import/export/demo-import tools, and migration tools.
- VERIFIED: Multiple invoice/document plugins are active at the same time, creating likely overlap and maintenance risk.
- VERIFIED: WooCommerce native shipping zones show no active methods; shipping likely depends on Epeken configuration that was not verified.
- VERIFIED: Terms and conditions page is not set in WooCommerce pages.
- VERIFIED: Comments moderation count is `93`.

## Premium UX Issues

- VERIFIED: Public unauthenticated staging page shows generic coming-soon copy rather than a branded JEDDA staging/private access experience.
- VERIFIED: Homepage actual frontend has no captured text headings in DOM during audit; the experience appears highly image-led.
- VERIFIED: Several homepage hero images have empty alt text.
- VERIFIED: Shop product grid shows many `Out of Stock` labels, which can make the shopping experience feel unavailable/heavy if not intentionally curated.
- VERIFIED: Some shop/cart image observations produced `1x1` rendered/natural images in the read-only DOM sample, suggesting possible lazy-loading placeholders or image handling that needs visual QA.
- VERIFIED: Empty cart and empty checkout show the same cart empty state with `New in store` recommendations.
- VERIFIED: Checkout with empty cart resolves to Cart page/title, so full checkout visual experience is not verified.
- VERIFIED: Mobile observations show very small navigation/product typography around `11px` and product title text around `10.5px`, which may feel refined but risks readability/tap clarity.
- ASSUMPTION: Because the design leans minimalist and editorial, small spacing/typography issues will be highly visible to premium customers.

## Not Yet Verified

- NOT VERIFIED: Full checkout flow with product in cart.
- NOT VERIFIED: Shipping rate calculation and courier options.
- NOT VERIFIED: Midtrans dashboard notification/finish URL configuration.
- NOT VERIFIED: Exact SMTP failure reason for failed messages.
- NOT VERIFIED: Mobile menu interaction details.
- NOT VERIFIED: Product detail page visual/state behavior.
- NOT VERIFIED: Order status distribution in the order list.
- NOT VERIFIED: Exact contents and safety of Code Snippets/WPCode snippets.
