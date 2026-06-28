# Discovered Environment

Use VERIFIED / NOT VERIFIED / ASSUMPTION.

Status: First read-only staging audit completed on 2026-06-28.

## Repository

- VERIFIED: Correct GitHub repository is `dibuatpekat-eng/jedda-website`.
- VERIFIED: Local workspace is `/Users/maverick/Documents/JEDDA WEBSITE`.
- VERIFIED: Local `main` is aligned with `origin/main` after the documentation foundation commit.
- VERIFIED: Documentation folder is `.jedda/`.
- VERIFIED: No website code changes were made during Phase 1 audit.

## Staging Site

- VERIFIED: Staging URL is `https://beta.jeddawear.com`.
- VERIFIED: Public unauthenticated staging homepage showed a Hostinger/coming-soon style page with title `Coming Soon` and text `New WordPress website is being built and will be published soon`.
- VERIFIED: Logged-in admin session can view the actual storefront at `https://beta.jeddawear.com/`.
- VERIFIED: The actual storefront title is `Jedda`.
- VERIFIED: WooCommerce Site Visibility admin screen shows `Live` selected.
- VERIFIED: WordPress Reading Settings has `Discourage search engines from indexing this site` unchecked.
- VERIFIED: `robots.txt` returns `User-agent: *` and `Disallow: /`.
- ASSUMPTION: The public coming-soon gate is likely provided by Hostinger or another maintenance layer rather than WooCommerce Site Visibility.

## WordPress and WooCommerce

- VERIFIED: WordPress version is `6.8`.
- VERIFIED: WooCommerce version is `9.3.3`.
- VERIFIED: WooCommerce Status warns that WooCommerce should be updated to `10.5.3` or the latest version to resolve a security issue affecting WooCommerce versions `5.4` to `10.5.2`.
- VERIFIED: WooCommerce Status shows WordPress `7.0` is available.
- VERIFIED: WordPress update page says the site is automatically kept up to date with maintenance and security releases of WordPress only.
- VERIFIED: Dashboard/sidebar reported `33` updates; later frontend admin toolbar showed `36` updates available.
- VERIFIED: Comments moderation badge shows `93`.
- VERIFIED: WooCommerce orders menu badge shows `543`.
- NOT VERIFIED: Detailed order status distribution; the orders page was too heavy and reset the browser automation session.

## Hosting and Server

- VERIFIED: Hostinger admin menu/tools are present in WordPress admin.
- VERIFIED: Server info is LiteSpeed.
- VERIFIED: PHP version is `8.2.31`.
- VERIFIED: MySQL/MariaDB version is `11.8.8-MariaDB-log`.
- VERIFIED: WordPress memory limit is `12 GB`.
- VERIFIED: PHP post max size and max upload size are `12 GB`.
- VERIFIED: PHP time limit is `480`.
- VERIFIED: PHP max input vars is `5000`.
- VERIFIED: WooCommerce log directory is writable at `/home/u422677730/domains/jeddawear.com/public_html/beta/wp-content/uploads/wc-logs/`.

## Database

- VERIFIED: Total database size is approximately `1641.15MB`.
- VERIFIED: Database data size is approximately `1431.79MB`.
- VERIFIED: Database index size is approximately `209.36MB`.
- VERIFIED: `wp_yaysmtp_email_logs` is approximately `1230.20MB`, making it the dominant database table observed.
- VERIFIED: WooCommerce order tables exist, including `wp_wc_orders`, `wp_wc_orders_meta`, `wp_wc_order_addresses`, and related lookup tables.
- VERIFIED: `wp_wc_orders_meta` is approximately `34.56MB` data plus `72.59MB` index.
- VERIFIED: `wp_comments` is approximately `19.55MB` data plus `24.13MB` index.
- VERIFIED: Action Scheduler tables exist and contain several MB of data/logs.

## Active Plugins

- VERIFIED: WooCommerce Status reports `40` active plugins.
- VERIFIED: Active plugins observed:
  - Advanced Shipment Tracking for WooCommerce `3.8.4`
  - All-in-One WP Migration `7.90`
  - Checkout Field Editor for WooCommerce `2.0.4`
  - Classic Widgets `0.3`
  - Code Snippets `3.9.5`
  - Contact Form 7 `5.9.8`
  - CTX Feed `6.5.53`
  - Customizer Export/Import `0.9.7.3`
  - Customizer For WooCommerce PDF Invoices `1.2.2`
  - Dahz Commerce Extender `1.1.1`
  - Dahz Commerce Shortcode `1.4.1`
  - Dahz Portfolio `1.1.0`
  - Epeken All Kurir - Full Version `1.4.6.3`
  - GTM4WP `1.20.3`
  - Hostinger AI `3.0.39`
  - Hostinger Easy Onboarding `2.1.17`
  - Hostinger Tools `3.0.65`
  - Maximum Products per User for WooCommerce `4.4.0`
  - Maximum Products per User for WooCommerce Pro `4.4.0`
  - Midtrans - WooCommerce Payment Gateway `2.32.3`
  - One Click Demo Import `3.3.0`
  - PDF Invoices & Packing Slips for WooCommerce `4.5.2`
  - ShopMagic for WooCommerce `4.3.12`
  - Slider Revolution `6.7.20`
  - Variation Swatches for WooCommerce `2.1.3`
  - WebToffee WooCommerce PDF Invoices, Packing Slips, Delivery Notes and Shipping Labels `4.9.3`
  - Widget Importer & Exporter `1.6.1`
  - WooCommerce `9.3.3`
  - WooCommerce Price Based on Country `4.0.7`
  - WooCommerce Shipping Labels, Dispatch Labels and Delivery Notes (Pro) `1.7.0`
  - WooCommerce.com Update Manager `1.0.3`
  - WordPress Importer ( edited version ) `0.6.4`
  - WP Downgrade | Specific Core Version `1.2.6`
  - WP Rollback `3.1.0`
  - WPBakery Page Builder `7.9`
  - WPCode Lite `2.3.4`
  - WPIDE - File Manager & Code Editor `3.5.0`
  - YayMail - WooCommerce Email Customizer `4.0.8`
  - YayMail Addon for Conditional Logic `4.0.2`
  - YaySMTP `2.6.3`

## Inactive Plugins

- VERIFIED: WooCommerce Status reports `8` inactive plugins:
  - Advanced Woo Labels `2.38`
  - Dahz Social Instagram `1.0.1`
  - LiteSpeed Cache `7.6.2`
  - Mailchimp for WooCommerce `4.4.1`
  - MailPoet `5.3.7`
  - MailPoet Premium `5.3.0`
  - MC4WP: Mailchimp for WordPress `4.9.18`
  - Queue-Fair FREE Virtual Waiting Room `2.1.3`

## Checkout and Account Settings

- VERIFIED: Guest checkout is enabled.
- VERIFIED: Login during checkout is disabled.
- VERIFIED: Account creation during checkout is enabled.
- VERIFIED: Account registration on My Account page is disabled.
- VERIFIED: Email address is used as account login.
- VERIFIED: Password setup link is disabled.
- VERIFIED: Account/order retention fields observed in Accounts & Privacy are blank.
- VERIFIED: Checkout page redirects/displays cart empty state when cart is empty.
- NOT VERIFIED: Full checkout form visual state with items in cart. No products were added and no order was created.

## Payment Settings

- VERIFIED: Midtrans is enabled and set to sandbox mode.
- VERIFIED: Midtrans is the only enabled payment method on the WooCommerce Payments list.
- VERIFIED: Midtrans paid-order status is `processing`.
- VERIFIED: Midtrans redirect payment mode is enabled.
- VERIFIED: Midtrans notification URL shown by plugin uses `https://beta.jeddawear.com/?wc-api=WC_Gateway_Midtrans`.
- VERIFIED: Production Midtrans key fields exist in settings, but values were not recorded.
- NOT VERIFIED: Whether Midtrans dashboard itself points to staging-safe notification/finish URLs.

## Shipping Settings

- VERIFIED: Native WooCommerce shipping zones do not show configured methods except `Rest of the world` with no methods.
- VERIFIED: Epeken All Kurir plugin is active and exposes an admin settings section.
- NOT VERIFIED: Detailed Epeken courier/rate configuration.

## Email and Notification Settings

- VERIFIED: WooCommerce order/customer emails are enabled in staging.
- VERIFIED: New order, cancelled order, and failed order notifications go to `jeddawear@gmail.com`.
- VERIFIED: Customer-facing processing/completed/refunded/customer note/reset password/new account emails are enabled.
- VERIFIED: YaySMTP is active.
- VERIFIED: YayMail is active.
- VERIFIED: ShopMagic is active but visible automations list shows zero items.
- VERIFIED: YaySMTP uses `Other SMTP` with SSL on port `465` and SMTP authentication enabled.
- VERIFIED: YaySMTP full logging is enabled.
- VERIFIED: YaySMTP `Disable delivery` is unchecked.
- VERIFIED: Recent YaySMTP logs show both failed messages and successful WooCommerce messages. Staging email is not safely blocked.
- NOT VERIFIED: Exact SMTP error details for failed messages.
