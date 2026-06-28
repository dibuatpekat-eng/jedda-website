# Technical Debt

Status: Phase 3 read-only technical debt mapping completed on 2026-06-28.

Scope: Custom code, plugin architecture, WooCommerce business logic, theme customization, and staging safety. No code or settings were changed.

## Maintainability Score

Score: 38 / 100.

Reasoning:

- VERIFIED: The current storefront behavior is spread across too many mutable admin surfaces.
- VERIFIED: WPCode has 22 active snippets and Code Snippets has 2 active snippets.
- VERIFIED: Several snippets are large, business-critical, selector-heavy, or unnamed/unclear.
- VERIFIED: Parent theme files contain custom behavior and WooCommerce overrides, but no child theme is active.
- VERIFIED: WPBakery Custom CSS is large and overlaps with WPCode CSS.
- VERIFIED: Multiple plugins overlap in document generation, migration/import, rollback/downgrade, and code editing.

## Refactoring Priority

Priority: High.

Why:

- Checkout, payment, order status, product availability, and launch/waitlist behavior are high-value surfaces.
- These surfaces are currently controlled by scattered snippets and DOM manipulation.
- WooCommerce updates are already recommended for security, but the customization architecture makes updates risky.

## Highest-Risk Customizations

1. WPCode `Jedda Launch - Form & Token`
   - Critical risk: large frontend business system, Supabase integration, token state changes, hardcoded credential, and product access behavior in one site-wide footer snippet.

2. Inactive Code Snippet `Jedda Launch - WooCommerce Hook`
   - Critical risk if reactivated: order hooks write external Supabase state and contain hardcoded credential; could conflict with active frontend token-used behavior.

3. Code Snippet `benerin ]]]`
   - High risk: removes all direct text nodes under `document.body`, site-wide.

4. WPCode `CSS Cart & Checkout`
   - High risk: 37k+ characters of global CSS affecting cart, checkout, mini cart, My Account, order received, Epeken popup, coupons, and account messaging.

5. WPCode `JS Cart and Checkout`
   - High risk: timed checkout account auto-check, order/account accordion behavior, inserted headings, and dependency on WooCommerce DOM structure.

6. WPCode `Product Page - Out of Stock Button`
   - High risk: hides/changes purchase state through JS MutationObserver and assumes Buy Now button exists.

7. WPCode `Payment Button for Customer Order Page`
   - High risk: payment continuation link depends on Midtrans URL/table selectors and injected CSS/JS.

8. WPCode `Order Received Page - Styling Button Etc`
   - High risk: changes Midtrans payment link text and styles on order received page.

9. Parent theme `woocommerce/archive-product.php`
   - High risk: outdated WooCommerce template override in parent theme.

10. Theme `functions.php` quantity customization plus WPCode `SSS Sj`
   - High risk: duplicate quantity-button behavior exists in both parent theme PHP and site-wide footer HTML/JS snippet.

## Debt Categories

### Scattered Custom Code

- VERIFIED: Business and presentation code lives in WPCode, Code Snippets, parent theme files, WPBakery Custom CSS, WooCommerce templates, and plugins.
- Impact: Hard to know which layer controls behavior; high regression risk.
- Long-term fix: Move durable business rules to a custom plugin and durable presentation code to a child theme.

### Parent Theme Customization

- VERIFIED: No child theme is active.
- VERIFIED: Parent theme `functions.php` includes custom additions.
- VERIFIED: Parent theme WooCommerce overrides exist.
- Impact: Theme updates can overwrite custom work.
- Long-term fix: Create child theme and move JEDDA-specific theme changes there.

### WooCommerce Template Drift

- VERIFIED: `archive-product.php` override is outdated.
- Impact: WooCommerce updates may break shop archive behavior or miss newer template changes.
- Long-term fix: Rebase override against current WooCommerce template in child theme.

### DOM-Dependent Business Behavior

- VERIFIED: Several snippets read or modify frontend DOM to control order/payment/status behavior.
- Impact: Markup changes can break business behavior without PHP errors.
- Long-term fix: Use WooCommerce hooks, filters, templates, and server-side state where possible.

### Duplicated Styling Systems

- VERIFIED: WPBakery Custom CSS, WPCode CSS, inline PHP-emitted CSS, theme options, and theme styles all affect the same pages.
- Impact: CSS specificity and order problems; hard to redesign safely.
- Long-term fix: Consolidate CSS by surface in a child theme.

### Duplicated Runtime Utilities

- VERIFIED: WPCode and Code Snippets both run custom code.
- VERIFIED: WPIDE is active.
- VERIFIED: Import/export/demo/rollback/downgrade utilities are active.
- Impact: Admin-side changes can bypass Git and increase operational risk.
- Long-term fix: Export code to repository, then reduce admin mutation tools.

### Staging Safety

- VERIFIED: Email delivery is not safely blocked.
- VERIFIED: Midtrans is sandbox on staging.
- VERIFIED: robots.txt blocks crawlers, but WordPress indexing setting remains unchecked and error-prone.
- Impact: Checkout testing can email real recipients.
- Long-term fix: Staging email sink/disable policy before order-flow testing.

## Recommended Refactoring Order

Do not execute without explicit approval:

1. Export all WPCode and Code Snippets code into version-controlled reference files.
2. Establish staging-safe email delivery policy.
3. Create a child theme as the home for CSS/JS/template presentation changes.
4. Create a small custom plugin for business logic: launch tokens, order status copy, payment action rules, checkout account behavior.
5. Rebase WooCommerce template overrides.
6. Consolidate cart/checkout/account CSS.
7. Remove duplicate quantity button implementations.
8. Decide one invoice/PDF/shipping-label stack.
9. Audit Epeken and purchase-limit settings.
10. Plan WooCommerce update only after the above is mapped and backed up.
