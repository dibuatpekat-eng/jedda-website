# Product Page V2 Implementation Strategy

Status: Created 2026-06-29. Documentation only, except repo hygiene `.DS_Store` ignore.
Scope: Technical strategy for building PDP V2 safely on staging.

This document converts `28_PRODUCT_PAGE_V2_PLAN.md` into an implementation path. It does not authorize PDP coding yet.

## Objective

Build Product Page V2 without risking WooCommerce, Midtrans, Epeken, existing order/payment flows, checkout, product stock, or customer data.

The implementation path must:

- Preserve WooCommerce as the commerce source of truth.
- Preserve Midtrans payment behavior.
- Preserve Epeken shipping/rate behavior.
- Avoid checkout/cart side effects.
- Avoid adding more untracked snippet complexity.
- Be testable on staging before any production decision.
- Be reversible.

## Current Technical Context

The current PDP is built from layered ownership:

- Upscale parent theme layout and styling.
- WooCommerce product templates and hooks.
- Product images, attributes, variations, stock, short description, and long description.
- Variation swatches/plugin output.
- WPBakery/theme/page-builder layer where applicable.
- Custom CSS and custom JS.
- WPCode and Code Snippets.
- Sprint 2 temporary PDP snippets:
  - Code Snippets ID `13`: PDP variant validation.
  - Code Snippets ID `18`: PDP loading feedback.
  - Code Snippets ID `19`: PDP success feedback.

Sprint 2 snippets are temporary staging guards. They improved the conversion interaction, but PDP V2 should not keep growing as disconnected snippets.

## Option Evaluation

### Option 1 — Continue Using Code Snippets / WPCode

What it controls:

- PHP hooks.
- Inline CSS/JS.
- Small behavior patches.
- WooCommerce hook output.
- Emergency staging fixes.

Risk:

- Medium for small isolated fixes.
- High if used for V2 presentation because snippets become hard to trace, test, diff, and review.
- High chance of recreating the current inconsistent layer stack.
- Activation mistakes can affect the frontend immediately.

Maintainability:

- Poor for PDP V2.
- Good only for temporary, reversible staging experiments.
- Not version-controlled unless manually exported/documented.

Rollback path:

- Deactivate the snippet.
- Use localStorage kill switches for frontend JS snippets.
- Clear cache if needed.

Compatibility with WooCommerce updates:

- Fragile. Snippets often depend on theme/plugin DOM details and undocumented timing.
- Update conflicts are hard to detect before runtime.

Fit for PDP V2:

- Not recommended as the main path.
- Acceptable only as a temporary bridge for already-active Sprint 2 behavior guards until migrated.

### Option 2 — Build A Small Custom Site Plugin

What it controls:

- Version-controlled PHP hooks.
- PDP-specific frontend JS enqueueing.
- PDP-specific CSS enqueueing.
- Feature flags and kill switches.
- WooCommerce hook integrations.
- Optional shortcode/helper functions if needed.
- Future migration of snippet logic into Git-owned code.

Risk:

- Low to medium if scoped to product pages only.
- Lower than snippets because changes are reviewable, diffable, and deployable.
- Risk rises if the plugin starts overriding checkout, payment, stock, or shipping logic. Those are out of scope.

Maintainability:

- Strong.
- Keeps PDP V2 behavior and presentation in one owned layer.
- Easier to test, rollback, and eventually promote from staging.

Rollback path:

- Disable the custom plugin on staging.
- Feature-flag PDP V2 off.
- Revert the Git commit.
- Keep WooCommerce/Upscale defaults as fallback.

Compatibility with WooCommerce updates:

- Better than snippets if using documented WooCommerce hooks and enqueue APIs.
- Still requires template/version checks if it later includes template overrides.

Fit for PDP V2:

- Best main implementation path.
- Ideal for a staged PDP module that can enhance the current Upscale PDP first, then later own more of the presentation.

### Option 3 — Build A Child Theme Layer

What it controls:

- Theme CSS.
- Theme templates.
- WooCommerce template overrides if placed in the child theme.
- Frontend asset structure.
- Layout markup if templates are overridden.

Risk:

- Medium.
- Safe for visual styling if scoped.
- Higher if overriding WooCommerce templates too early.
- Parent theme dependency remains; parent updates can still affect inherited behavior.

Maintainability:

- Good for CSS/presentation.
- Mixed for complex PDP behavior.
- Can become messy if used for business logic or plugin-like behavior.

Rollback path:

- Revert child theme commits.
- Disable child theme changes if isolated in files.
- Switch back to parent theme only if absolutely necessary, but that is broader and should not be the normal rollback.

Compatibility with WooCommerce updates:

- Good for CSS.
- Template overrides require ongoing WooCommerce template version maintenance.

Fit for PDP V2:

- Good secondary path for presentation styling.
- Not the best first owner for PDP behavior.
- Best used together with a custom site plugin: plugin owns hooks/behavior, child theme owns theme-level presentation if a child theme already exists and is stable.

### Option 4 — Override WooCommerce Templates

What it controls:

- Exact PDP markup.
- Product summary order.
- Gallery structure.
- Add-to-cart template structure.
- Tabs/details layout.
- Related products markup.

Risk:

- Medium to high.
- Powerful but easy to break compatibility if done too early.
- Requires careful template version tracking.
- Can affect variation, stock, plugin output, and theme integrations.

Maintainability:

- Good only when overrides are deliberate, minimal, and documented.
- Poor if copied wholesale from WooCommerce/theme without ownership.

Rollback path:

- Remove or rename the override template.
- Revert the Git commit.
- Fall back to WooCommerce/theme default template.

Compatibility with WooCommerce updates:

- Requires active maintenance.
- WooCommerce template changes must be reviewed after updates.

Fit for PDP V2:

- Not recommended as the first implementation step.
- Appropriate later for the V2 presentation rebuild after the current PDP layers are mapped and the safer enhancement layer proves the design.

### Option 5 — Use WPBakery / Theme Settings Where Appropriate

What it controls:

- Page-builder content areas.
- Some visual settings.
- Theme options.
- Non-commerce editorial modules.

Risk:

- Low for content-only/editorial adjustments.
- Medium if used to shape commerce-critical PDP structure.
- Can hide implementation details in the database instead of Git.

Maintainability:

- Acceptable for page content and simple visual settings.
- Poor for PDP V2 component behavior.
- Harder to review and roll back than Git-owned files.

Rollback path:

- Manually revert setting/content changes.
- Restore from backup.
- Export settings where possible before changes.

Compatibility with WooCommerce updates:

- Usually separate from WooCommerce core, but theme/page-builder output can conflict with theme templates.

Fit for PDP V2:

- Use sparingly.
- Suitable for product content cleanup, editorial copy, and possibly theme option alignment.
- Not suitable as the core PDP V2 implementation layer.

## Recommended Implementation Path

Recommended path: build PDP V2 as a small custom site plugin first, with optional child-theme styling only when necessary.

The custom plugin should be the primary owner of PDP V2 because it gives JEDDA:

- Version control.
- A clear rollback path.
- A controlled feature flag.
- Product-page-only scoping.
- A place to migrate Sprint 2 snippet behavior.
- Cleaner separation from checkout, payment, shipping, and order flows.

The plugin should start as an enhancement layer on top of the current Upscale PDP, not a full replacement.

Recommended module shape:

- `jedda-site-core` or `jedda-commerce-ui` custom plugin.
- PDP V2 feature flag, disabled by default until staging tests pass.
- Product-page-only asset enqueueing.
- CSS and JS files in Git, not inline snippets.
- Event-based JS only.
- WooCommerce hooks used only for product-page presentation and feedback.
- No checkout, payment, shipping, order, or stock logic.

Optional later layer:

- Child theme files for durable theme presentation if the current theme structure requires it.
- WooCommerce template overrides only after the plugin enhancement layer proves the V2 direction and the template ownership map is complete.

## Why Not More Snippets

PDP V2 should not continue as Code Snippets/WPCode because:

- Snippets are hard to review as a system.
- Snippets make rollback dependent on admin UI access.
- Snippets can duplicate behavior across WPCode, Code Snippets, theme JS, and plugin output.
- Snippets encourage one-off fixes instead of component ownership.
- The Sprint 2 observer incident showed how risky frontend snippets can be when activated without enough isolation.

Allowed snippet use from this point:

- Emergency rollback only.
- Temporary one-behavior staging tests when no safer layer exists.
- Existing Sprint 2 guards until migrated.

Disallowed snippet use:

- PDP layout rebuild.
- Gallery rebuild.
- Add-to-cart state expansion.
- Mini-cart behavior.
- Checkout/cart/payment changes.
- Multi-behavior frontend scripts.

## `.DS_Store` Repo Hygiene

`.DS_Store` should not appear in Git status.

Action taken in this milestone:

- Added `.DS_Store` to `.gitignore`.

Reason:

- It is local macOS Finder metadata.
- It has no relationship to PDP V2.
- Ignoring it reduces repo noise without deleting user files or touching website behavior.

## Isolated Module Strategy

PDP V2 should be built as an isolated module before replacing the current PDP.

Phase 1: Enhancement mode.

- Keep Upscale/WooCommerce PDP as the base.
- Add V2 classes, CSS, and event-based JS only on product pages.
- Restyle current PDP sections without changing checkout/cart/payment.
- Migrate Sprint 2 feedback behavior from snippets into the plugin after parity tests pass.

Phase 2: Controlled structure mode.

- Use WooCommerce hooks to reorder or wrap PDP sections where needed.
- Keep WooCommerce variation form intact.
- Keep Midtrans, Epeken, cart, checkout, and orders untouched.

Phase 3: Template ownership mode.

- Override only the smallest necessary WooCommerce templates.
- Track WooCommerce template versions.
- Keep fallbacks and rollback commits ready.

Phase 4: Snippet retirement.

- Deactivate Sprint 2 PDP snippets one by one after plugin parity tests pass.
- Verify invalid, loading, and success states after each deactivation.
- Remove snippet dependency only after staging has remained stable.

## Safe Staging Test Plan

Before any PDP V2 code:

1. Confirm staging backup/restore point.
2. Export current active PDP-related snippets.
3. Confirm staging email safety before any checkout/order tests.
4. Identify a small set of representative products:
   - Variable in-stock product.
   - Variable out-of-stock option.
   - Sold-out product.
   - Product with full details/material/care content.
   - Product with related products.

For each PDP V2 implementation batch:

1. Enable the PDP V2 feature flag on staging only.
2. Verify the product page loads.
3. Verify gallery images and layout at desktop and mobile widths.
4. Verify color and size selection.
5. Verify invalid add-to-cart.
6. Verify valid add-to-cart without creating an order.
7. Verify cart count update.
8. Verify inline validation/loading/success feedback.
9. Verify out-of-stock and unavailable states.
10. Verify details/accordion behavior.
11. Verify related products do not show placeholder artifacts.
12. Verify Code Snippets/WPCode admin remains responsive.
13. Verify no console errors from PDP V2 assets.
14. Disable the feature flag and verify the old PDP returns.

Do not test place-order flow until staging email/payment safety is explicitly prepared.

## Compatibility Guardrails

WooCommerce:

- Do not modify cart, checkout, orders, taxes, stock, coupons, or session logic in PDP V2.
- Use documented hooks and enqueue APIs.
- Keep the variation form compatible with WooCommerce variation scripts.
- Avoid replacing `add_to_cart` behavior unless it is a wrapper around existing WooCommerce events.

Midtrans:

- Do not touch payment gateway settings, scripts, checkout fields, order status logic, or payment redirects.
- PDP V2 should end at add-to-cart confirmation.

Epeken:

- Do not touch courier rates, shipping zones, checkout shipping fields, or address logic.
- PDP V2 may show shipping/returns copy, but must not calculate shipping.

Existing order/payment flows:

- Do not create real orders.
- Do not alter order received, payment link, My Account payment, or checkout snippets during PDP V2.
- Keep PDP V2 isolated from checkout templates.

## Rollback Strategy

For enhancement-mode plugin work:

1. Disable PDP V2 feature flag.
2. Deactivate the custom PDP V2 plugin if needed.
3. Revert the Git commit.
4. Confirm current Upscale PDP loads.
5. Keep Sprint 2 snippets active until plugin parity is verified.

For child-theme presentation work:

1. Revert the child theme file commit.
2. Clear cache if needed.
3. Confirm Upscale inherited styles return.

For later template overrides:

1. Remove/rename the override template.
2. Revert the Git commit.
3. Confirm WooCommerce/theme default template returns.
4. Check WooCommerce status for outdated templates after any update.

## Recommended First Coding Batch After Approval

Do not start until Milestone 2.5 is approved.

First coding batch should be:

- Create the custom plugin scaffold.
- Add no customer-facing visual change at first.
- Add a PDP-only feature flag.
- Enqueue an empty PDP V2 CSS/JS pair only when flag is on and `is_product()` is true.
- Verify activation/deactivation.
- Commit and push.

Second coding batch:

- Add visual-only PDP baseline CSS for typography, spacing, buy-panel rhythm, and current feedback styling.
- Do not change gallery behavior, recommendations, cart, checkout, or payment.

Third coding batch:

- Migrate Sprint 2 snippet behavior into the plugin one behavior at a time:
  1. Variant validation parity.
  2. Loading feedback parity.
  3. Success feedback parity.
- Deactivate matching snippets only after parity passes.

## Final Recommendation

Build PDP V2 as a small custom site plugin in enhancement mode first.

Use the child theme only for presentation pieces that belong to theme styling. Delay WooCommerce template overrides until the enhancement layer proves the design and the PDP ownership map is complete.

This path gives JEDDA the best balance of:

- Customer safety.
- Commerce compatibility.
- Design control.
- Maintainability.
- Rollback.
- A clean escape from snippet sprawl.
