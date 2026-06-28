# Business Logic

Status: Phase 3 read-only business logic mapping completed on 2026-06-28.

Scope: WooCommerce-related behavior identified through plugin settings, WPCode, Code Snippets, theme files, template overrides, and admin configuration. No settings or code were changed.

## Business Logic Score

Score: 41 / 100.

Reasoning:

- VERIFIED: Core commerce logic exists and is functional enough to operate: WooCommerce, Midtrans, Epeken, account creation, purchase limits, regional pricing, emails, and launch/waitlist behavior.
- VERIFIED: Business logic is not cleanly separated from presentation. Order/payment/checkout rules are mixed with CSS, DOM scripts, snippets, and parent theme files.
- VERIFIED: Launch/waitlist logic is especially risky because it lives in WPCode frontend code and a related inactive Code Snippets WooCommerce hook.
- VERIFIED: Payment and order status messaging are patched in multiple places.
- ASSUMPTION: The current business logic can be stabilized, but it should be consolidated before high-risk updates or launch campaigns.

## Commerce Flows

### Checkout And Account Creation

- VERIFIED: Guest checkout is enabled.
- VERIFIED: Account creation during checkout is enabled.
- VERIFIED: WPCode `JS Cart and Checkout` auto-checks the checkout create-account checkbox after a 3-second delay.
- VERIFIED: CSS Cart & Checkout forces display/visibility of account creation areas and hides some default WooCommerce checkout sections.
- VERIFIED: Checkout Field Editor plugin is active, but exact field definitions were not mapped in this phase.

Risk:

- High: Account creation behavior is partly controlled by a timed frontend script instead of WooCommerce settings or a server-side checkout rule.

Recommended home:

- Custom Plugin for checkout/account rules.
- Child Theme only for checkout presentation.

### Payment

- VERIFIED: Midtrans sandbox is enabled on staging.
- VERIFIED: Main Midtrans gateway is enabled.
- VERIFIED: Payment status maps paid orders to `processing`.
- VERIFIED: Several snippets modify Midtrans payment link/table display:
  - `Payment Button for Customer Order Page`
  - `Order Received Page - Styling Button Etc`
  - `CSS Cart & Checkout`
  - `JS Cart and Checkout`
- VERIFIED: My Account Pay button is removed from the order list by PHP snippet, while view-order payment link is intended to remain.

Risk:

- High: Payment continuation UX depends on Midtrans markup and DOM selectors. If Midtrans changes its output or WooCommerce updates templates, the payment link can become unclear or broken.

Recommended home:

- Custom Plugin for payment action rules.
- Child Theme/Woo template override for presentation.

### Shipping

- VERIFIED: Epeken All Kurir is active.
- VERIFIED: Native WooCommerce zones show no standard shipping methods.
- VERIFIED: Checkout CSS includes Epeken-specific popup positioning for `#div_epeken_popup`.
- NOT VERIFIED: Detailed Epeken courier/rate configuration.

Risk:

- High: Shipping logic likely depends on Epeken and address-specific checkout behavior that has not been fully verified.

Recommended home:

- Plugin settings remain in Epeken.
- Any display adjustments should live in Child Theme CSS.

### Order Status Messaging

- VERIFIED: Code Snippet 7 changes thank-you message by order status.
- VERIFIED: WPCode `Order Page Condition Status` reads `.order-status` from the DOM and writes a custom account message through CSS pseudo-content.
- VERIFIED: WPCode `Hide Dashboard Notification` hides My Account status message under certain conditions.
- VERIFIED: WPCode `CSS Cart & Checkout` defines default My Account message content as `Your Order Status Has Been Updated`.

Risk:

- High: Multiple snippets collaborate indirectly through generated DOM/CSS messages. The same customer-facing concept is controlled in several places.

Recommended home:

- Custom Plugin for order status copy/rules.
- Child Theme CSS for layout only.

### Launch / Waitlist / Private Access

- VERIFIED: WPCode `Jedda Launch - Form & Token` implements:
  - Waitlist registration UI.
  - Product/color/size selection.
  - Email and phone collection.
  - Supabase RPC call for waitlist submission.
  - Token verification route on `/jacket-access/`.
  - Phone-number verification.
  - Private product URL redirect with `jd_token`, `jd_color`, `jd_size`, and `jd_variation`.
  - Product variation locking when token query parameters exist.
  - Optional waitlist button injection on out-of-stock original product pages, currently commented out.
- VERIFIED: The same snippet contains a hardcoded Supabase anon credential. The value is intentionally not copied here.
- VERIFIED: Inactive Code Snippet `Jedda Launch - WooCommerce Hook` contains WooCommerce order hook logic for storing launch token on orders and marking tokens/waitlist rows as purchased in Supabase.
- VERIFIED: Active WPCode launch snippet currently marks token used before redirecting to product page after phone verification, based on its inline comments and code.

Risk:

- Critical: Token state can be marked used before an actual successful WooCommerce payment if relying on the active frontend snippet behavior.
- Critical: Business-critical launch state is controlled by frontend JavaScript and external Supabase calls from WPCode.
- Critical: Hardcoded external credential is present in admin-managed code.
- High: There is a split-brain risk between active frontend token logic and inactive WooCommerce order hook logic if someone reactivates the hook later.

Recommended home:

- Custom Plugin for server-side token validation, WooCommerce session/order meta, Supabase integration, and order-status updates.
- Child Theme for the launch UI.
- Remove hardcoded credentials from snippets and store secrets in server-side config.

### Product Availability And Badges

- VERIFIED: Product variation availability text is hidden by CSS.
- VERIFIED: Buy Now button state is changed by frontend MutationObserver when variation stock is out of stock.
- VERIFIED: Product badge copy and placement are changed by multiple JS snippets.
- VERIFIED: Advanced Woo Labels plugin is inactive, but active snippets still reference Advanced Woo Labels selectors.

Risk:

- High: Customer availability cues depend on DOM scripts while the native WooCommerce stock text is hidden.
- Medium: Badge scripts may be stale if Advanced Woo Labels remains inactive.

Recommended home:

- Child Theme for badge/stock display.
- Custom Plugin only if availability behavior becomes a purchase rule.

### Purchase Limits

- VERIFIED: Maximum Products per User free and Pro plugins are active.
- NOT VERIFIED: Exact product/customer limit rules.

Risk:

- Medium: Purchase scarcity may depend on plugin settings not yet mapped.

Recommended home:

- Plugin settings short term.
- Custom Plugin if launch/scarcity rules need to be deterministic and versioned.

### Regional Pricing

- VERIFIED: WooCommerce Price Based on Country is active.
- VERIFIED: Indonesia and Southeast Asia zones exist from Phase 1/2 inspection.
- VERIFIED: IDR is the store currency.

Risk:

- Medium: Checkout totals can vary by geolocation/shipping location, so payment/shipping tests must include address context.

Recommended home:

- Keep in plugin unless pricing rules become simple enough to own in custom code.

### Email

- VERIFIED: WooCommerce emails are enabled.
- VERIFIED: YayMail customizes WooCommerce emails.
- VERIFIED: YaySMTP sends/logs emails; delivery is not safely disabled.
- VERIFIED: A WPCode snippet adjusts YayMail product title column span.

Risk:

- High on staging because real emails can send if SMTP succeeds.
- Medium in production because template logic spans WooCommerce, YayMail, Conditional Logic addon, YaySMTP, and snippets.

Recommended home:

- Keep email templates in YayMail short term.
- Move custom YayMail filters to Custom Plugin.
- Establish staging email sink/disable policy.

## Business Logic That Should Not Stay In WPCode

- Launch/waitlist Supabase integration.
- Token validation and used/purchased state.
- Checkout account creation behavior.
- Payment action visibility.
- Order status messaging.
- Order received/payment link behavior.
- Any rule that changes purchase eligibility, payment continuation, or customer communication.

