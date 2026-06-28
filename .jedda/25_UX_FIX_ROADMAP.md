# Phase 7 — UX Fix Roadmap

Status: Planning document only.
Date: 2026-06-28

## Purpose

This roadmap turns the Phase 7 customer journey audit and visual gap analysis into a prioritized implementation path.

No fixes are made in this phase.

## Timing Categories

- Customer journey cleanup: fixes that directly improve shopping, trust, add-to-cart, checkout, search, or recovery states.
- Visual system cleanup: fixes that standardize the design language across components and breakpoints.
- Later architecture refactor: fixes that likely require deeper theme, plugin, WooCommerce, staging, or performance decisions.

## Severity Scale

- Critical: Blocks or seriously damages purchase confidence.
- High: Meaningfully hurts usability, trust, conversion, or premium perception.
- Medium: Noticeable inconsistency or friction.
- Low: Refinement that improves polish but does not block core journey.

## Effort Scale

- Low: Copy, small style, configuration, or isolated template/state update.
- Medium: Component-level design/implementation and QA.
- High: Cross-system, plugin/theme, checkout/payment, or performance architecture work.

## Priority Roadmap

### P0 — Fix Conversion-Breaking Interaction States

These should be addressed before broad visual polish.

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| PDP add-to-cart | Invalid add-to-cart can enter loading without visible error or recovery. | The customer may think the site is broken at the main purchase moment. | Critical | Medium | Prevent invalid loading; show inline guidance near required swatches; restore button state immediately. | Customer journey cleanup |
| PDP button states | Button class/state can visually imply disabled while still accepting clicks. | Visual state and functional state disagree, reducing trust. | High | Medium | Align disabled, enabled, loading, success, and error states in the add-to-cart flow. | Customer journey cleanup |
| Add-to-cart success | Successful add-to-cart only updates cart count after delay; no clear success message was visible. | Customers need immediate reassurance and next-step guidance. | High | Medium | Add restrained success feedback: mini-cart/drawer, inline notice, or button success state with `View cart` / `Continue shopping`. | Customer journey cleanup |
| Checkout copy | `Give me one second` appears near Billing Address. | This feels accidental and unpolished in a high-trust area. | High | Low | Remove or replace with polished loading/help copy. | Customer journey cleanup |

### P1 — Make Mobile and Search Usable

These are high-impact customer journey issues.

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Mobile header | Menu/search visibility was not clear in observed mobile output. | Mobile customers need immediate access to browse, search, account, and cart. | High | Medium | Define and implement a mobile header with visible menu/search/cart controls and tested open/close behavior. | Customer journey cleanup |
| Search trigger | Search UI appears hidden or duplicated in the DOM. | Search should be a deliberate customer tool, not a leftover theme layer. | High | Medium | Consolidate search into one accessible pattern for desktop and mobile. | Customer journey cleanup |
| Empty search | Empty search uses generic WooCommerce copy and no curated next step. | Search failure should redirect intent. | Medium | Low | Add JEDDA-tone copy and links to shop all, new arrivals, and key categories. | Customer journey cleanup |
| Search results | Common search terms can return mostly sold-out products. | Search should feel helpful, not depleted. | Medium | Medium | Add stock-aware sorting or clearer sold-out handling on search results. | Customer journey cleanup |

### P2 — Stabilize Product Discovery

These improve the browsing phase and align it with the Phase 6 references.

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Shop grid | First impressions are dominated by out-of-stock products. | The store can feel unavailable rather than curated. | High | Medium | Define sold-out sorting, filtering, or archive treatment. | Customer journey cleanup |
| Mobile product images | Some images appeared tiny, inconsistent, or placeholder-like. | Product imagery is JEDDA's strongest premium signal. | High | Medium | Lock mobile card image ratios and lazy-loading placeholders. | Visual system cleanup |
| Product card interaction | CTAs are hidden and hover/focus/tap states are underdefined. | Quiet cards still need to feel clickable. | Medium | Low | Add subtle card states: image hover, title underline, focus-visible outline, mobile tap feedback. | Visual system cleanup |
| Product image alt | Some image alt text is empty or numeric. | Accessibility and polish are part of premium execution. | Medium | Low | Use product-aware alt text for hero, grid, gallery, and related images. | Customer journey cleanup |
| Collection controls | Sort/filter controls exist but appear hidden. | Customers need refined ways to browse. | Medium | Medium | Add restrained filters/category controls consistent with JEDDA type and spacing. | Customer journey cleanup |

### P3 — Refine Cart and Checkout Trust

These should follow the main PDP/add-to-cart fixes.

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Cart remove action | Remove item control is visually unclear. | Customers need understandable control over their cart. | Medium | Low | Use a quiet but readable remove treatment with hover/focus state. | Visual system cleanup |
| Cart quantity | Quantity controls need explicit loading/update feedback. | Cart totals must feel accurate after changes. | Medium | Medium | Add loading state and updated subtotal/total feedback for quantity changes. | Customer journey cleanup |
| Coupon | Coupon interaction states are not defined. | Coupon flows easily create confusion. | Low | Low | Define closed, open, applying, success, invalid, and removed states. | Customer journey cleanup |
| Empty cart | Empty cart has recommendations but generic hierarchy/copy. | Empty cart should recover shopping intent gracefully. | Medium | Low | Add concise JEDDA copy, continue-shopping CTA, and curated links. | Customer journey cleanup |
| Checkout hierarchy | Some checkout headings are hidden or zero-sized. | Checkout needs visible structure to feel safe. | High | Medium | Restore section hierarchy for billing, delivery, order summary, and payment. | Visual system cleanup |
| Checkout forms | Required, focus, error, success, and select states are not fully verified. | Checkout cannot feel premium without clear form feedback. | High | Medium | Design and QA full field states in a safe checkout testing mode. | Customer journey cleanup |
| Shipping explanation | Shipping is calculated during checkout but not deeply explained at initial view. | Customers need cost certainty before payment. | Medium | Low | Add concise copy explaining when shipping is calculated and where it appears. | Customer journey cleanup |

### P4 — Clean Error and Recovery Pages

These support trust and polish.

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| 404 page | Copy tone feels unrelated to JEDDA. | Even error pages should feel intentional and brand-aligned. | Medium | Low | Rewrite 404 in quiet JEDDA tone with clear next actions. | Visual system cleanup |
| 404 product imagery | Latest-product imagery can show placeholder artifacts. | Broken-looking imagery damages trust. | Medium | Medium | Stabilize image rendering on error/recommendation modules. | Visual system cleanup |
| Old product URLs | A guessed product-name slug returned 404 while actual product URL differed. | Shared or old links may create avoidable dead ends. | Medium | Low | Add redirects for known renamed products and review product slug consistency. | Later architecture refactor |
| Account dashboard | Logged-in dashboard is functional but sparse. | Post-purchase pages should feel like customer care. | Low | Medium | Refine account copy, spacing, orders empty state, addresses, and account details. | Visual system cleanup |

### P5 — Architecture and Safe QA Prerequisites

These are needed before deeper checkout/payment validation and performance work.

| Page / Component | Problem | Why It Matters | Severity | Effort | Recommended Fix | Timing |
| --- | --- | --- | --- | --- | --- | --- |
| Staging email safety | Earlier `.jedda` docs indicate Woo/staging emails may still send. | Full checkout validation can accidentally trigger real emails. | High | Medium | Disable outbound staging email or route all email to safe logs/inbox before checkout QA. | Later architecture refactor |
| Public logged-out audit | Clean unauthenticated customer storefront was not verified. | The actual public customer journey may differ from logged-in audit. | High | Medium | Provide safe public staging access or a clean customer test account/session. | Customer journey cleanup |
| Mobile cart performance | Mobile cart load felt slow. | High-intent customers may abandon during delay. | High | Medium | Profile cart assets, Woo block rendering, scripts, and caching. | Later architecture refactor |
| Theme/plugin layering | Visual behavior appears influenced by parent theme, Woo defaults, blocks, snippets, and plugins. | Inconsistency will recur unless ownership boundaries are clarified. | High | High | Decide which layer owns each component before larger refactors. | Later architecture refactor |

## Recommended Implementation Order

1. Make staging safe for full customer QA.
2. Fix PDP invalid add-to-cart and success feedback.
3. Fix mobile header/search/cart access.
4. Replace checkout odd copy and restore checkout hierarchy.
5. Define button and form interaction states.
6. Stabilize product grid images and sold-out handling.
7. Redesign empty states and search recovery.
8. Normalize cart controls and checkout field feedback.
9. Clean 404 and account dashboard.
10. Profile mobile cart and deeper architecture issues.

## Interaction Standards for Future Fixes

Every future customer-facing change should answer these questions before shipping:

- What happens within 100-200ms after click or tap?
- Is loading visible and does it prevent duplicate action?
- If the action succeeds, what confirms success?
- If the action fails, where does the customer see the error?
- Does the message explain what to do next?
- Does focus move somewhere logical?
- Does the state work with keyboard, touch, and mouse?
- Does the mobile version provide the same confidence as desktop?
- Does the interaction feel calm, intentional, and premium?

## Definition of Done for Customer Journey Cleanup

A customer journey fix is not done until:

- Desktop and mobile are both checked.
- Hover, focus, pressed, loading, success, empty, and error states are checked where relevant.
- Copy matches JEDDA tone.
- No default Woo/theme copy remains in the changed flow unless intentionally approved.
- Cart and checkout changes are tested only after staging email safety is confirmed.
- Screenshots or notes are added to the relevant `.jedda` documentation if behavior changes meaningfully.

## What Not To Do

- Do not make the site visually louder to solve clarity.
- Do not add generic ecommerce badges, banners, or aggressive CTAs.
- Do not copy reference websites directly.
- Do not treat desktop as the primary design and compress it for mobile.
- Do not polish static layouts while leaving broken interaction states unresolved.
- Do not submit checkout orders until staging email/payment safety is verified.

## Phase 7 Conclusion

The site already has the right direction: quiet, image-led, and restrained. The roadmap is about making that direction dependable across the full customer journey.

The highest-value improvement is not a new visual style. It is a more reliable interaction system: clear variant validation, immediate add-to-cart feedback, mobile navigation/search clarity, and checkout trust.
