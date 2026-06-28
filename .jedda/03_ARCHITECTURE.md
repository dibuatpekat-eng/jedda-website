# Architecture

Status: First read-only staging audit completed on 2026-06-28.

## Platform

- VERIFIED: The website is a WordPress + WooCommerce storefront on staging at `https://beta.jeddawear.com`.
- VERIFIED: WordPress address and site address both resolve to `https://beta.jeddawear.com`.
- VERIFIED: WordPress version is `6.8`.
- VERIFIED: WooCommerce version is `9.3.3`.
- VERIFIED: Server stack reports LiteSpeed, PHP `8.2.31`, and MariaDB `11.8.8-MariaDB-log`.
- VERIFIED: WordPress language is `en_GB`.
- VERIFIED: WordPress debug mode is off.
- VERIFIED: External object cache is not enabled.
- VERIFIED: WooCommerce HPOS is enabled. Order datastore is `Automattic\WooCommerce\Internal\DataStores\Orders\OrdersTableDataStore`.
- VERIFIED: WooCommerce database version reports `10.6.1`, newer than the active WooCommerce plugin version `9.3.3`.

## Theme

- VERIFIED: Active theme is `Upscale` version `3.9`.
- VERIFIED: No active child theme is present. WooCommerce Status explicitly reports `Child theme: -`.
- VERIFIED: WooCommerce template overrides exist in the parent theme:
  - `upscale/woocommerce/archive-product.php`
  - `upscale/woocommerce/single-product-reviews.php`
- VERIFIED: `archive-product.php` override is outdated: override version `3.4.0`, WooCommerce core version `8.6.0`.
- ASSUMPTION: Any design or WooCommerce template customizations are currently happening through the parent theme, plugins, WPBakery, WPCode/Code Snippets, or admin settings rather than a child theme.

## WooCommerce Structure

- VERIFIED: WooCommerce pages:
  - Shop: `/shop/`
  - Cart: `/cart/`, contains WooCommerce cart block.
  - Checkout: `/checkout/`, contains `[woocommerce_checkout]` shortcode.
  - My account: `/my-account/`
  - Terms and conditions page: not set.
- VERIFIED: Store currency is IDR, currency position is left with space, thousand separator is `.`, decimal separator is `,`, number of decimals is `0`.
- VERIFIED: Product counts from WooCommerce Status include `88` products and `244` product variations.
- VERIFIED: Shop frontend lists fashion product categories and collection filters such as `SS26`, `AW25`, `SS25`, `Vests`, `Shirts`, `Skirts`, `Pants`, and `Blazers`.

## Payment Architecture

- VERIFIED: Active payment integration is Midtrans via `Midtrans - WooCommerce Payment Gateway` version `2.32.3`.
- VERIFIED: WooCommerce Payments settings show only the main `Midtrans - Payment via Midtrans` gateway enabled.
- VERIFIED: BACS, cheque, cash on delivery, Epeken bank-transfer gateways, and Midtrans-specific sub-gateways are disabled.
- VERIFIED: Midtrans environment is set to `sandbox`.
- VERIFIED: Midtrans 3D Secure is enabled.
- VERIFIED: Midtrans redirect payment mode is enabled.
- VERIFIED: Midtrans paid-order status maps to `processing`.
- VERIFIED: Midtrans save-card, immediate stock reduction, ignore-pending, and debug logging options are disabled.
- VERIFIED: Midtrans dashboard finish URL usage is enabled.

## Shipping Architecture

- VERIFIED: `Epeken All Kurir - Full Version` plugin is active.
- VERIFIED: WooCommerce Shipping Zones screen only shows `Rest of the world`, with no standard WooCommerce shipping methods offered to that zone.
- VERIFIED: WooCommerce shipping settings expose an `Epeken All Kurir` tab.
- NOT VERIFIED: Detailed Epeken All Kurir configuration could not be read during Phase 1 because the admin section was slow enough to reset the browser automation session.
- ASSUMPTION: Shipping rates and courier behavior likely depend primarily on Epeken rather than native WooCommerce shipping zones.

## Email and Automation Architecture

- VERIFIED: WooCommerce customer and admin emails are active in staging.
- VERIFIED: Admin order notification recipient is `jeddawear@gmail.com` for New order, Cancelled order, and Failed order.
- VERIFIED: Customer emails enabled include Processing order, Completed order, Refunded order, Customer note, Reset password, and New account.
- VERIFIED: Order on-hold email is disabled.
- VERIFIED: YayMail and YaySMTP are active.
- VERIFIED: ShopMagic plugin is active.
- VERIFIED: ShopMagic Automations admin screen shows `No Data` and `Total items 0`.
- VERIFIED: WooCommerce Status reports database/post type traces for ShopMagic, including `shopmagic_automation` count `2`.
- NOT VERIFIED: Whether inactive/hidden ShopMagic automations can still trigger outside the visible Automations screen.

## Likely Custom-Code Areas

- VERIFIED: `Code Snippets` is active.
- VERIFIED: `WPCode Lite` is active, and WooCommerce Status reports `46` `wpcode` posts.
- VERIFIED: `WPIDE - File Manager & Code Editor` is active.
- VERIFIED: `WPBakery Page Builder` and `Slider Revolution` are active.
- VERIFIED: Active theme includes WooCommerce template overrides.
- ASSUMPTION: Custom behavior may live in Code Snippets, WPCode, WPIDE-edited files, WPBakery page content, Slider Revolution modules, or parent-theme template overrides.

