# Plugin Inventory

Status: Phase 3 read-only plugin inventory completed on 2026-06-28.

Scope: WordPress admin and WooCommerce status inspection on staging. No plugins were updated, activated, deactivated, configured, or edited.

## Summary

- VERIFIED: Active plugins: `40`.
- VERIFIED: Inactive plugins: `8`.
- VERIFIED: The plugin stack supports commerce, payments, shipping, page building, email customization/delivery, product feeds, migration/import, rollback, custom code, and theme companion behavior.
- VERIFIED: There is meaningful plugin overlap in custom-code management, PDF/invoice/shipping documents, migration/import tools, rollback/downgrade tools, and marketing/email tooling.
- ASSUMPTION: Runtime stability would improve if admin-only utilities and duplicated document/marketing tools were eventually removed from the active runtime after dependency review.

## Active Plugins

| Plugin | Role | Current dependency | Essential now | Replaceable | Risk | Long-term recommendation |
| --- | --- | --- | --- | --- | --- | --- |
| WooCommerce | Commerce core. | Products, cart, checkout, orders, customers, HPOS. | Yes | No | High if updated without compatibility audit. | Keep; update only through staging compatibility plan. |
| Midtrans - WooCommerce Payment Gateway | Payment gateway. | Checkout payments, Midtrans redirect/Snap flow, order payment status. | Yes | Later | High. | Keep; document sandbox/live credentials and webhook/return behavior. |
| Epeken All Kurir - Full Version | Indonesian courier shipping. | Checkout shipping rates and courier options. | Likely yes | Later | High. | Keep short term; verify courier configuration and API health. |
| WPBakery Page Builder | Page builder. | Core page layouts and WooCommerce utility pages. | Yes | Long-term | Medium | Keep until redesign/rebuild; document page dependencies first. |
| Slider Revolution | Slider/visual module system. | Possible hero/editorial modules. | Possibly | Yes | Medium | Keep if active modules are used; replace with simpler native sections later. |
| Upscale companion: Dahz Commerce Extender | Theme commerce features. | Upscale commerce behavior. | Likely yes | Hard | Medium | Keep while Upscale remains active. |
| Upscale companion: Dahz Commerce Shortcode | Theme shortcodes. | WPBakery/theme shortcode content. | Likely yes | Hard | Medium | Inventory shortcode usage before removal. |
| Dahz Portfolio | Theme portfolio content. | Portfolio post type/sections if used. | Unknown | Yes | Low | Remove later if no portfolio pages depend on it. |
| Variation Swatches for WooCommerce | Product variation UI. | Color/size swatches on product pages. | Likely yes | Yes | Medium | Keep short term; future child theme can own final styling. |
| WooCommerce Price Based on Country | Regional pricing behavior. | Indonesia and Southeast Asia pricing zones. | Likely yes | Yes | Medium | Keep if international pricing remains part of strategy. |
| Maximum Products per User for WooCommerce | Purchase limit base plugin. | Customer/product purchase limits. | Likely yes | Yes | Medium | Confirm active rules; replace with custom business logic if simple. |
| Maximum Products per User for WooCommerce Pro | Purchase limit premium layer. | Pro limits/rules. | Likely yes | Yes | Medium | Keep only if rules are actively used. |
| Checkout Field Editor for WooCommerce | Checkout field customization. | Checkout form structure. | Possibly yes | Yes | Medium | Export field map; move critical fields to versioned code later. |
| Advanced Shipment Tracking for WooCommerce | Tracking/fulfillment updates. | Order tracking fields and customer tracking UX. | Possibly | Yes | Medium | Keep if operations uses it; otherwise consolidate. |
| WebToffee PDF Invoices, Packing Slips, Delivery Notes and Shipping Labels | Order documents. | Invoices/packing slips/shipping labels. | Maybe | Yes | Medium | Choose one document plugin stack. |
| PDF Invoices & Packing Slips for WooCommerce | Order documents. | Invoices/packing slips. | Maybe | Yes | Medium | Likely redundant with WebToffee stack. |
| Customizer For WooCommerce PDF Invoices | Invoice template styling. | PDF invoice appearance. | Maybe | Yes | Medium | Keep only if tied to the chosen invoice plugin. |
| WooCommerce Shipping Labels, Dispatch Labels and Delivery Notes (Pro) | Fulfillment documents. | Labels/delivery notes. | Maybe | Yes | Medium | Consolidate with invoice/label plugin decision. |
| YayMail - WooCommerce Email Customizer | Email template design. | WooCommerce email branding. | Likely yes | Yes | Medium | Keep short term; export templates before email changes. |
| YayMail Addon for Conditional Logic | Conditional email content. | YayMail dynamic conditions. | Possibly | Yes | Medium | Keep if conditions exist; document conditions. |
| YaySMTP | SMTP delivery/logging. | Email sending and logs. | Yes if email delivery intended | Yes | High on staging | Configure staging-safe delivery policy; reduce log retention. |
| ShopMagic for WooCommerce | Marketing automation. | Visible automations not verified as active. | Not verified | Yes | Medium | Audit hidden automations before removal. |
| CTX Feed | Product feeds. | Catalog feeds for ads/marketplaces. | Business-dependent | Yes | Medium | Document feed endpoints and owners. |
| GTM4WP | Google Tag Manager. | Tracking/analytics tags. | Business-dependent | Yes | Medium | Keep with staging vs production tag policy. |
| Contact Form 7 | Contact forms. | Contact page or form submissions. | Possibly | Yes | Low | Keep only if active forms are used. |
| Code Snippets | Admin-run snippets. | Two active frontend/PHP customizations. | Yes for current behavior | Yes | High | Move durable code into child theme/custom plugin. |
| WPCode Lite | Admin-run snippets. | 22 active customizations across launch, product, checkout, cart, account, order, and email surfaces. | Yes for current behavior | Yes | High | Move durable code into child theme/custom plugin. |
| WPIDE - File Manager & Code Editor | Admin file editing. | Possible direct file edits. | No | Yes | High | Disable after auditing/exporting any edited files. |
| Classic Widgets | Legacy widget compatibility. | Theme widget screens. | Possibly | Later | Low | Keep until widget dependency is verified. |
| WooCommerce.com Update Manager | Extension licensing/updates. | Paid Woo extension updates. | Maybe | No if required | Low | Keep if premium extensions require it. |
| All-in-One WP Migration | Migration/backup utility. | Site import/export/backups. | No runtime | Yes | Medium | Keep inactive unless migrating; rely on backups and Git. |
| Customizer Export/Import | Customizer migration. | Theme option import/export. | No runtime | Yes | Low | Deactivate outside migration windows. |
| One Click Demo Import | Demo import. | Theme demo setup. | No runtime | Yes | Low | Remove after confirming no runtime dependency. |
| Widget Importer & Exporter | Widget migration. | Widget import/export. | No runtime | Yes | Low | Deactivate outside migration windows. |
| WordPress Importer (edited version) | Content import. | Admin imports. | No runtime | Yes | Medium | Avoid edited plugin long term. |
| WP Downgrade | Core downgrade/pinning. | Admin core rollback strategy. | No runtime | Yes | High | Remove from active runtime after update plan exists. |
| WP Rollback | Plugin/theme rollback. | Admin rollback utility. | No runtime | Yes | Medium | Use only during controlled maintenance windows. |
| Hostinger Tools | Hosting integration. | Hostinger platform tooling. | Maybe | Later | Low | Keep only if host requires it. |
| Hostinger Easy Onboarding | Host setup. | Onboarding checklist. | No runtime | Yes | Low | Remove after setup. |
| Hostinger AI | AI/content helper. | Admin helper. | No runtime | Yes | Low | Remove if unused. |

## Inactive Plugins

| Plugin | Role | Reason to keep/remove later |
| --- | --- | --- |
| Advanced Woo Labels | Product labels/badges. | Inactive while badge behavior is handled through snippets; likely remove or reactivate intentionally, not both. |
| Dahz Social Instagram | Theme Instagram integration. | Keep inactive unless theme content depends on it. |
| LiteSpeed Cache | Performance/cache. | Useful later, but keep inactive during audits and while staging behavior is changing. |
| Mailchimp for WooCommerce | Mailchimp commerce sync. | Duplicates other inactive marketing tools; choose one marketing stack. |
| MailPoet | Newsletter/email marketing. | Duplicates Mailchimp candidates. |
| MailPoet Premium | Premium MailPoet features. | Keep only if MailPoet is chosen. |
| MC4WP: Mailchimp for WordPress | Mailchimp forms. | Duplicates Mailchimp for WooCommerce and MailPoet candidates. |
| Queue-Fair FREE Virtual Waiting Room | Launch traffic queue. | Potential overlap with custom Supabase launch/waitlist logic. |

## Plugin Architecture Findings

- VERIFIED: WPCode and Code Snippets both run custom code in production/staging runtime.
- VERIFIED: Multiple active PDF/invoice/shipping-label plugins overlap.
- VERIFIED: Multiple migration/import plugins are active even though they are not required for normal storefront runtime.
- VERIFIED: WP Downgrade, WP Rollback, and WPIDE are active, increasing admin-side operational risk.
- VERIFIED: Email architecture spans WooCommerce, YayMail, YayMail Conditional Logic, YaySMTP, and possibly ShopMagic.
- VERIFIED: Product launch/scarcity behavior spans WPCode, Code Snippets history, Maximum Products per User, WooCommerce, and Supabase.

