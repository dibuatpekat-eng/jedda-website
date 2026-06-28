# Website Knowledge Map

Status: Phase 2 read-only architecture mapping completed on 2026-06-28.

Scope: Staging website only at `https://beta.jeddawear.com`. Findings are based on WordPress admin inspection, WooCommerce settings/status, frontend browser inspection, plugin screens, Code Snippets, WPCode lists, and visible admin configuration. No WordPress settings, plugins, products, orders, files, or code were changed.

## Architecture Score

Score: 46 / 100.

Why this score:

- VERIFIED: The storefront is functional enough to operate as a premium WooCommerce site, with WooCommerce HPOS enabled, Midtrans sandbox configured on staging, Epeken present for Indonesian courier rates, WPBakery page structures, and a mature editorial visual direction.
- VERIFIED: The engineering architecture is fragile because business logic and presentation behavior are scattered across WPCode, Code Snippets, parent-theme WooCommerce template overrides, WPBakery content, theme options, and many plugins.
- VERIFIED: There is no active child theme, while WooCommerce template overrides exist in the parent theme.
- VERIFIED: At least one WooCommerce template override is outdated.
- VERIFIED: 40 plugins are active and 8 are inactive, with overlapping functionality in email, invoices/PDFs, import/demo tooling, custom code tools, Mailchimp tools, and rollback/downgrade tools.
- VERIFIED: Staging email is not safely blocked, even though recent SMTP failures exist.
- VERIFIED: WooCommerce is behind the security update recommendation shown in admin, and Action Scheduler has a large backlog.
- VERIFIED: Launch/waitlist behavior and order/payment page changes appear to depend on admin-side snippets rather than versioned application code.
- ASSUMPTION: The site can be stabilized without a full rebuild, but future engineering should first consolidate customizations, move durable logic into version-controlled theme/plugin code, and reduce plugin overlap.

## Overall Engineering Architecture

JEDDA is currently a WordPress + WooCommerce storefront built around the commercial `Upscale` theme, WooCommerce, WPBakery, Dahz theme companion plugins, Midtrans payments, Epeken shipping, YayMail/YaySMTP email tooling, and several admin-side custom-code systems.

The website is not a clean theme/plugin architecture yet. It is closer to an assembled WordPress commerce stack where many behaviors have been added through admin tools over time. This is common for fast-moving storefronts, but it makes engineering decisions slower because the source of truth is distributed across multiple admin surfaces.

Primary architecture layers:

- Platform: WordPress `6.8`, WooCommerce `9.3.3`, PHP `8.2.31`, MariaDB `11.8.8`, LiteSpeed.
- Commerce core: WooCommerce with HPOS enabled.
- Theme layer: `Upscale` parent theme, no child theme.
- Page-builder layer: WPBakery content for standard pages and WooCommerce utility pages.
- Design/content layer: Upscale theme options, WPBakery layouts, Slider Revolution, product imagery, and custom CSS/JS snippets.
- Payments: Midtrans WooCommerce gateway, sandbox on staging.
- Shipping: Epeken All Kurir likely controls courier rates; native WooCommerce zones are effectively unused.
- Email: WooCommerce emails customized through YayMail and sent/logged through YaySMTP; ShopMagic is active but not clearly in use from the visible Automations screen.
- Custom behavior: WPCode, Code Snippets, theme overrides, and possibly WPIDE-edited files.

## Theme Architecture

- VERIFIED: Active theme is `Upscale` version `3.9`.
- VERIFIED: No active child theme is present.
- VERIFIED: Parent-theme WooCommerce overrides exist:
  - `upscale/woocommerce/archive-product.php`
  - `upscale/woocommerce/single-product-reviews.php`
- VERIFIED: `archive-product.php` override is outdated: override version `3.4.0`, WooCommerce core version `8.6.0`.
- VERIFIED: Theme companion plugins from Dahz are active: Dahz Commerce Extender, Dahz Commerce Shortcode, and Dahz Portfolio.
- VERIFIED: Admin notices indicate missing/inactive theme-related plugins: required `YITH Woocommerce Wishlist` missing, `Dahz Social Instagram` and `Mailchimp for WP` inactive.
- VERIFIED: Browser/admin console showed theme JavaScript errors involving Foundation/equalizer behavior during inspection.

Interpretation:

The theme is doing more than visual styling. It participates in WooCommerce templates, commerce layout, shortcodes, and likely frontend interactions. Because there is no child theme, durable custom theme changes have no clean home. If files were edited directly through the theme or WPIDE, updates could overwrite them.

Recommended long-term direction:

- Create a child theme or small site-specific plugin as the version-controlled home for durable customizations.
- Audit parent-theme template overrides before any WooCommerce update.
- Keep WPBakery and theme options for page content/layout, but move business rules out of snippets/admin UI.

## Page Builder Architecture

- VERIFIED: WPBakery Page Builder `7.9` is active.
- VERIFIED: Main pages expose "Edit with WPBakery Page Builder" actions, including Home, Shop-adjacent pages, Cart, Checkout, My account, About, FAQ, Contact, and policy pages.
- VERIFIED: Home is the static front page; Blog is the posts page.
- VERIFIED: Checkout page contains the `[woocommerce_checkout]` shortcode.
- VERIFIED: Cart page contains the WooCommerce cart block.
- VERIFIED: A Launch Dashboard page exists as password-protected draft.
- VERIFIED: `/early-access/` and `Jacket Access` pages were recently created on 2026-06-27.

Interpretation:

WPBakery is a major page construction dependency. Future frontend work must treat WPBakery content as part of the architecture, not just content. Cart and Checkout appear to mix newer WooCommerce block usage and shortcode-based checkout, so checkout changes need careful page-level testing.

## WooCommerce Architecture

- VERIFIED: WooCommerce version is `9.3.3`.
- VERIFIED: WooCommerce HPOS is enabled.
- VERIFIED: WooCommerce database version reports `10.6.1`, newer than the active WooCommerce plugin version.
- VERIFIED: Product count is `88` products and `244` variations.
- VERIFIED: WooCommerce pages are set for Shop, Cart, Checkout, and My account.
- VERIFIED: Terms and conditions page is not set.
- VERIFIED: Guest checkout is enabled.
- VERIFIED: Account creation during checkout is enabled.
- VERIFIED: My Account registration is disabled.
- VERIFIED: Customer email is used as username and password setup link is disabled.
- VERIFIED: Currency is IDR with Indonesian number formatting.
- VERIFIED: WooCommerce Price Based on Country has zones for Indonesia and Southeast Asia, uses IDR, and bases pricing on shipping/geolocation behavior.

Customization points:

- Product listing and product availability display are affected by theme templates and WPCode snippets.
- Cart and checkout UI are affected by WPCode CSS/JS snippets.
- Order pay/order received/account order pages are affected by WPCode and Code Snippets.
- Purchase limits depend on Maximum Products per User plugins.
- Invoice/packing-slip behavior is split across multiple invoice/PDF plugins.

## Payment Architecture

- VERIFIED: Active payment gateway is Midtrans WooCommerce Payment Gateway `2.32.3`.
- VERIFIED: Midtrans sandbox mode is enabled on staging.
- VERIFIED: Main Midtrans gateway is enabled.
- VERIFIED: Midtrans-specific sub-gateways are disabled.
- VERIFIED: BACS, cheque, COD, and Epeken bank-transfer gateways are disabled.
- VERIFIED: Redirect payment mode is enabled.
- VERIFIED: 3D Secure is enabled.
- VERIFIED: Paid-order status maps to `processing`.
- VERIFIED: Save-card, immediate stock reduction, ignore-pending, and Midtrans debug logging are disabled.

Interpretation:

Midtrans is the core payment provider. Checkout validation should use only Midtrans sandbox methods. The safest first sandbox method to test is a non-card bank transfer / virtual account flow because it avoids card-token behavior and keeps payment completion reversible in staging.

Risk:

Payment-related page behavior is customized through snippets. Any payment testing must watch order status, stock behavior, customer emails, order-pay page rendering, and redirect/return behavior together.

## Shipping Architecture

- VERIFIED: Epeken All Kurir - Full Version `1.4.6.3` is active.
- VERIFIED: Native WooCommerce shipping zones show only `Rest of the world` with no standard methods.
- VERIFIED: WooCommerce exposes an Epeken All Kurir settings tab.
- NOT VERIFIED: Detailed Epeken courier/service/rate settings were not fully read because the admin section was slow enough to reset the browser automation session during Phase 1.

Interpretation:

Shipping likely depends primarily on Epeken rather than native WooCommerce shipping zones. This means checkout testing must include address-specific rate calculation, not just WooCommerce zone inspection.

Risk:

If Epeken configuration is the only shipping source, checkout can fail silently or show no methods when address, origin, courier API, or plugin settings are wrong.

## Email Architecture

- VERIFIED: WooCommerce emails are enabled.
- VERIFIED: Admin order notifications go to the JEDDA Gmail recipient visible in WooCommerce settings.
- VERIFIED: Customer emails enabled include Processing order, Completed order, Refunded order, Customer note, Reset password, and New account.
- VERIFIED: Order on-hold email is disabled.
- VERIFIED: YayMail and YayMail Conditional Logic are active.
- VERIFIED: YaySMTP is active, configured with SMTP delivery and full email logging.
- VERIFIED: YaySMTP Disable delivery is unchecked.
- VERIFIED: YaySMTP logs show mixed behavior: recent failed tests/registration messages, and earlier WooCommerce/customer emails logged as successful.
- VERIFIED: YaySMTP email log table is approximately `1230.20MB`.
- VERIFIED: ShopMagic is active, but the visible Automations screen shows no data/zero items while WooCommerce Status reports ShopMagic traces.

Interpretation:

Email is not safely blocked on staging. It is better described as inconsistently deliverable. Because WooCommerce emails are enabled and YaySMTP delivery is not disabled, staging can accidentally email real recipients if SMTP works for the event type.

Recommended direction:

- Add a staging-safe email policy before further checkout/order testing.
- Prefer a reversible staging-only email sink or disable-delivery mode over relying on SMTP failure.
- Reduce/rotate YaySMTP logs after backup review because the log table is abnormally large.

## Custom Code Locations

VERIFIED custom-code surfaces:

- WPCode Lite: 31 snippets total, 22 active, 9 inactive, 1 outdated, 15 trash items.
- Code Snippets: 10 snippets total, 2 active, 8 inactive.
- Parent theme WooCommerce overrides.
- WPBakery page content.
- Slider Revolution modules.
- WPIDE file manager/code editor is active, meaning direct admin-side file edits are possible.

Active Code Snippets:

- VERIFIED: `sss jam conditional code for thankyou page` filters WooCommerce thank-you text by order status.
- VERIFIED: `benerin ]]]` adds global footer JavaScript that removes direct text nodes from `document.body`.

Relevant inactive Code Snippets:

- VERIFIED: `Custom Order Pay Layout` rewrites the order-pay page presentation.
- VERIFIED: `Conditional Text on Orders Page` injects user-order status messaging into the account page content.
- VERIFIED: `Jedda Launch - WooCommerce Hook` connects checkout/order status behavior to a Supabase launch/waitlist flow and contains a hardcoded Supabase anon credential. The value is intentionally not recorded here.

Active WPCode snippets observed:

- VERIFIED: `Jedda Launch - Form & Token` - HTML, site-wide footer.
- VERIFIED: `Biar muncul notif pas klik buy now yg sold out` - JavaScript, site-wide header.
- VERIFIED: `color and size font` - CSS, site-wide header.
- VERIFIED: `Untitled Snippet` - JavaScript, site-wide header.
- VERIFIED: `Pre Order Badge Mobile` - JavaScript, site-wide footer.
- VERIFIED: `Posisi Badge Preorder` - JavaScript, site-wide footer.
- VERIFIED: `Remove Pay Button - My Account Page (Agif)` - PHP, run everywhere.
- VERIFIED: `Spacing "Add-ons"` - JavaScript, site-wide footer.
- VERIFIED: `Pre-Order Badge` - JavaScript, site-wide header.
- VERIFIED: `Hide Order Again Button (Agif)` - JavaScript, site-wide footer.
- VERIFIED: `Hide Dashboard Notification (Agif)` - JavaScript, site-wide footer.
- VERIFIED: `Adjust YayMail Column Span` - PHP, run everywhere.
- VERIFIED: `Custom Login Styles (Agif)` - JavaScript, site-wide footer.
- VERIFIED: `Disable Hover Effect on Size Options (Agif)` - PHP, run everywhere.
- VERIFIED: `Order Page Condition Status (Agif)` - PHP, site-wide header.
- VERIFIED: `Payment Button for Customer Order Page (Agif)` - PHP, run everywhere.
- VERIFIED: `Product Page - Out of Stock Button (Agif)` - PHP, frontend only.
- VERIFIED: `CSS Out of Stock (Agif)` - CSS, site-wide header.
- VERIFIED: `Order Received Page - Styling Button Etc (Agif)` - PHP, run everywhere.
- VERIFIED: `JS Cart and Checkout` - JavaScript, site-wide header.
- VERIFIED: `CSS Cart & Checkout` - CSS, site-wide header.
- VERIFIED: `SSS Sj` - HTML, site-wide footer.

Interpretation:

Customizations are scattered. Several snippets target the same surfaces: cart, checkout, order received, order pay, account orders, out-of-stock buttons, preorder badges, and YayMail. This is high technical debt because behavior depends on execution order, insertion location, and admin configuration rather than a versioned code structure.

## Plugin Architecture

The following classifications use the terms:

- Essential: required for current visible functionality or likely core business flow.
- Replaceable: can be replaced later with cleaner code, another plugin, or a hosted service.
- Redundant: overlaps with another active/inactive plugin or should not stay active long term.

| Plugin | Status | Why it exists | Depends / functionality | Essential now | Redundant | Replaceable | Cleaner long-term solution |
| --- | --- | --- | --- | --- | --- | --- | --- |
| All-in-One WP Migration | Active | Site backup/migration/export. | Migration operations. | No for runtime. | Potentially. | Yes. | Keep inactive unless actively migrating; use host backups plus versioned code. |
| Classic Widgets | Active | Preserve legacy widget UI for theme compatibility. | Upscale/theme widget areas may depend on it. | Possibly. | No. | Later. | Remove only after confirming theme widgets work without it. |
| Code Snippets | Active | Runs PHP/JS custom snippets from admin. | Thank-you text and global DOM cleanup are active. | Yes for current behavior. | Yes with WPCode. | Yes. | Move durable snippets into a child theme or site plugin, then retire overlap. |
| Contact Form 7 | Active | Contact forms. | Contact page/forms. | Possibly. | Maybe if unused. | Yes. | Keep only if forms are active; otherwise consolidate form handling. |
| Customizer Export/Import | Active | Theme customizer migration. | Admin-only migration utility. | No. | Potentially. | Yes. | Deactivate outside migration windows after backup. |
| Dahz Commerce Extender | Active | Theme commerce extensions. | Upscale commerce behavior. | Likely yes. | No. | Hard. | Keep while Upscale remains active; reassess during theme refactor. |
| Dahz Commerce Shortcode | Active | Theme shortcodes. | WPBakery/theme shortcode content. | Likely yes. | No. | Hard. | Inventory shortcode usage before any removal. |
| Dahz Portfolio | Active | Theme portfolio content. | Portfolio sections if used. | Unknown. | Maybe. | Yes. | Remove if no portfolio content depends on it. |
| GTM4WP | Active | Google Tag Manager integration. | Analytics/marketing tags. | Business-dependent. | No. | Yes. | Keep with documented container ownership and staging tag policy. |
| Epeken All Kurir - Full Version | Active | Indonesian courier shipping/rates. | Checkout shipping methods/rates. | Likely yes. | No. | Later. | Keep short term; long term evaluate API reliability and support. |
| Hostinger AI | Active | Hostinger content/AI tooling. | Admin helper tooling. | No runtime. | Yes with onboarding/tools. | Yes. | Remove from staging/runtime if unused after host review. |
| Hostinger Easy Onboarding | Active | Host setup/onboarding. | Setup flow. | No runtime. | Yes. | Yes. | Deactivate after launch setup is complete. |
| Hostinger Tools | Active | Hostinger platform integration/cache/security helpers. | Hosting-level features. | Maybe. | Maybe. | Later. | Keep only if host requires it; document exact dependency. |
| WPCode Lite | Active | Runs admin-managed code snippets. | Many checkout/product/account/email/custom UI behaviors. | Yes for current behavior. | Yes with Code Snippets. | Yes. | Consolidate durable behavior into version-controlled child theme/site plugin. |
| WPBakery Page Builder | Active | Visual page builder. | Main page layout/content. | Yes. | No. | Long-term only. | Keep until redesign/rebuild; document page dependencies before changes. |
| Maximum Products per User for WooCommerce Pro | Active | Purchase limits. | Quantity/customer restriction logic. | Likely yes. | Paired with free version. | Yes. | Keep if launch scarcity depends on it; consider custom rule if limits are simple. |
| Maximum Products per User for WooCommerce | Active | Base/free purchase limit plugin. | Required by Pro or provides core module. | Likely yes. | Paired dependency. | Yes. | Confirm Pro dependency; keep both only if required. |
| Midtrans - WooCommerce Payment Gateway | Active | Payment processing. | Checkout payment and order status. | Yes. | No. | Later. | Keep; document sandbox/live credential separation and webhook URLs. |
| One Click Demo Import | Active | Imported theme demo content. | Setup/admin utility. | No runtime. | Yes. | Yes. | Deactivate after confirming no active runtime dependency. |
| WebToffee WooCommerce PDF Invoices, Packing Slips, Delivery Notes and Shipping Labels | Active | PDF invoices/packing slips/shipping labels. | Order documents/admin operations. | Maybe. | Yes with another PDF invoice plugin and shipping labels plugin. | Yes. | Choose one document system and remove overlap. |
| Slider Revolution | Active | Sliders/hero modules. | Homepage/editorial visual modules if used. | Possibly. | No if used. | Yes. | Replace with simpler theme/WPBakery/native sections in future redesign if possible. |
| ShopMagic for WooCommerce | Active | WooCommerce marketing/automation. | Automations unclear; visible admin shows none. | Not verified. | Maybe. | Yes. | Disable only after confirming no hidden automations/events. |
| CTX Feed | Active | Product feeds for marketplaces/ads. | Product feed exports. | Business-dependent. | No. | Yes. | Keep if feeds are used; document feed endpoints and owners. |
| Widget Importer & Exporter | Active | Widget migration. | Admin migration utility. | No runtime. | Yes. | Yes. | Deactivate outside migration windows. |
| Advanced Shipment Tracking for WooCommerce | Active | Tracking numbers/order shipment status. | Fulfillment notifications/tracking UI. | Possibly. | Maybe with Epeken/shipping label plugins. | Yes. | Keep if ops uses tracking; otherwise consolidate fulfillment tooling. |
| Checkout Field Editor for WooCommerce | Active | Custom checkout fields. | Checkout form structure. | Possibly yes. | No. | Yes. | Keep short term; long term encode required checkout fields in versioned code. |
| WooCommerce.com Update Manager | Active | WooCommerce.com extension updates. | Premium extension update licensing. | Maybe. | No. | No if premium extensions require it. | Keep if required by paid Woo extensions. |
| Variation Swatches for WooCommerce | Active | Visual variation selectors. | Product size/color UX. | Likely yes. | No. | Yes. | Keep if product UX depends on swatches; theme-native alternative possible later. |
| PDF Invoices & Packing Slips for WooCommerce | Active | PDF invoices/packing slips. | Order documents. | Maybe. | Yes with WebToffee PDF plugin and Pro labels plugin. | Yes. | Standardize on one invoice/packing-slip plugin. |
| WooCommerce Price Based on Country | Active | Regional pricing/currency rules. | Indonesia/Southeast Asia price behavior. | Likely yes. | No. | Yes. | Keep if international pricing matters; document zones and pricing policy. |
| WooCommerce | Active | Commerce core. | Products, cart, checkout, orders. | Yes. | No. | No. | Keep and update through staged compatibility process. |
| WordPress Importer (edited version) | Active | Content import. | Admin import utility. | No runtime. | Yes. | Yes. | Deactivate after import needs are complete; avoid edited plugin long term. |
| WP Downgrade | Active | Pins/downgrades WordPress core. | Core version control from admin. | No for runtime. | Yes with rollback tooling. | Yes. | Remove from active runtime after confirming update strategy. |
| WP Rollback | Active | Roll back plugin/theme versions. | Admin recovery tool. | No runtime. | Yes with downgrade/import tools. | Yes. | Keep only during controlled maintenance windows. |
| WPIDE - File Manager & Code Editor | Active | In-admin file editing. | Direct file edits. | No. | High risk. | Yes. | Disable after exporting/confirming code; use Git-based edits only. |
| Customizer For WooCommerce PDF Invoices | Active | Styles/customizes PDF invoices. | PDF invoice appearance. | Maybe. | Yes if invoice stack consolidated. | Yes. | Keep only with chosen PDF invoice plugin. |
| WooCommerce Shipping Labels, Dispatch Labels and Delivery Notes (Pro) | Active | Pro shipping labels/documents. | Fulfillment documents. | Maybe. | Yes with WebToffee/PDF invoice plugins. | Yes. | Standardize fulfillment document system. |
| YayMail Addon for Conditional Logic | Active | Conditional email content. | YayMail dynamic email templates. | Possibly yes. | No if used. | Yes. | Keep if templates depend on conditions; document conditions. |
| YayMail - WooCommerce Email Customizer | Active | Custom WooCommerce email templates. | Email branding/content. | Likely yes. | No. | Yes. | Keep short term; version or export templates before risky changes. |
| YaySMTP | Active | SMTP delivery and email logging. | Email sending/logs. | Yes if SMTP is intended. | No. | Yes. | Add staging email sink/disable-delivery policy; reduce logging. |
| Advanced Woo Labels | Inactive | Product labels/badges. | Product badges if activated. | No. | Maybe with custom badge snippets. | Yes. | Keep inactive; remove if replaced by snippets/theme. |
| Dahz Social Instagram | Inactive | Theme Instagram feed. | Social feed blocks. | No. | Maybe. | Yes. | Activate only if theme section requires it; otherwise remove. |
| LiteSpeed Cache | Inactive | Performance/cache. | Page/object optimization if activated. | No now. | No. | Yes. | Evaluate carefully after staging is safe; avoid cache during audits. |
| Mailchimp for WooCommerce | Inactive | WooCommerce/Mailchimp sync. | Marketing/customer sync. | No now. | Yes with MC4WP/MailPoet. | Yes. | Choose one email marketing system later. |
| MailPoet | Inactive | Email marketing/newsletters. | Marketing emails. | No now. | Yes with Mailchimp tools. | Yes. | Remove if Mailchimp is chosen; choose one marketing stack. |
| MailPoet Premium | Inactive | Paid MailPoet features. | Marketing email premium features. | No now. | Yes. | Yes. | Keep inactive only if license may be reused; otherwise remove. |
| MC4WP: Mailchimp for WordPress | Inactive | Mailchimp forms/integration. | Signup forms. | No now. | Yes with Mailchimp for WooCommerce/MailPoet. | Yes. | Choose one signup/CRM path. |
| Queue-Fair FREE Virtual Waiting Room | Inactive | Waiting room / traffic queue. | Launch traffic control if activated. | No now. | Maybe with custom Supabase launch flow. | Yes. | Decide between external queue or custom launch/waitlist flow; avoid both. |

## Duplicated Functionality

- VERIFIED: Two admin code systems are active: WPCode and Code Snippets.
- VERIFIED: Multiple invoice/document/label plugins are active: WebToffee PDF/labels, PDF Invoices & Packing Slips, Customizer for WooCommerce PDF Invoices, and WooCommerce Shipping Labels/Dispatch Labels Pro.
- VERIFIED: Multiple migration/import/admin utility plugins are active at runtime: All-in-One WP Migration, One Click Demo Import, Widget Importer & Exporter, WordPress Importer edited version, Customizer Export/Import.
- VERIFIED: WP Downgrade and WP Rollback are both active.
- VERIFIED: Multiple marketing/email stack candidates exist, mostly inactive: Mailchimp for WooCommerce, MC4WP, MailPoet, MailPoet Premium, plus ShopMagic active.
- VERIFIED: Product labels/badges appear handled through snippets while Advanced Woo Labels is inactive.

## Assessment of Original Development Practices

Positive signs:

- VERIFIED: The site uses established WordPress/WooCommerce plugins rather than fully custom commerce code.
- VERIFIED: HPOS is enabled, which is the modern WooCommerce order storage path.
- VERIFIED: Midtrans is configured in sandbox on staging.
- VERIFIED: Visual design direction is coherent and premium-leaning.
- VERIFIED: Some custom behaviors are named with author/context, which helps trace history.

Problem signs:

- VERIFIED: No child theme despite parent-theme template overrides.
- VERIFIED: Heavy reliance on admin snippets for checkout, payment, order, product, and email behavior.
- VERIFIED: Multiple active plugins are setup/migration/development utilities that should not usually remain active in a stabilized runtime.
- VERIFIED: Multiple plugins solve overlapping document/email/marketing/custom-code problems.
- VERIFIED: At least one active snippet performs broad global DOM manipulation.
- VERIFIED: A launch/order integration snippet contains a hardcoded external service credential.
- VERIFIED: Admin notices and WooCommerce status indicate update/security/compatibility work is overdue.

Conclusion:

The original implementation is commercially practical but not yet engineering-clean. It appears optimized for getting the store live and iterating quickly in admin, not for long-term maintainability, version control, or low-risk WooCommerce updates.

## Technical Debt

- Custom code is split between WPCode, Code Snippets, parent theme overrides, WPBakery, and possibly WPIDE edits.
- No clear version-controlled source of truth for snippets.
- WooCommerce template override drift exists.
- Plugin count and overlap are high.
- Staging email safety is incomplete.
- Action Scheduler backlog suggests automation/queue health needs attention.
- Large SMTP log table creates database maintenance risk.
- WooCommerce security update path is blocked by unknown compatibility risk.
- Checkout/order/account pages are touched by many independent snippets, making regressions likely.

## Architectural Risks

- Checkout regressions from snippet ordering, WPCode location, or WooCommerce updates.
- Payment return/order status regressions from Midtrans + custom order page snippets.
- Email leakage from staging to real customers/admin recipients.
- Parent-theme update overwriting custom files if direct edits exist.
- WooCommerce update breaking outdated template overrides or checkout/payment customizations.
- Shipping failure if Epeken API/settings/address logic is not healthy.
- Launch/waitlist data inconsistency if Supabase token handling and WooCommerce order hooks are not audited.
- Performance/admin bloat from large logs, many plugins, and Action Scheduler backlog.

## Recommended Next Steps

Do not implement these yet without approval:

1. Export and archive all WPCode and Code Snippets contents into documentation or version-controlled files.
2. Create a staging-safe email policy before any checkout testing that could create orders.
3. Inventory WPBakery pages and shortcodes, especially Home, Shop, Cart, Checkout, My Account, Early Access, and Launch Dashboard.
4. Verify Epeken configuration and perform a safe shipping-rate calculation test.
5. Map Midtrans sandbox checkout with one low-risk virtual account flow.
6. Audit the parent theme and WPIDE for direct file edits.
7. Choose one long-term home for custom code: child theme for presentation, small site plugin for business rules.
8. Consolidate duplicate PDF/invoice/label plugins after confirming operational dependencies.
9. Plan WooCommerce update in staging only after template/snippet compatibility is mapped.
