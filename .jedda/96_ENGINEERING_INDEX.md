# Engineering Index

Status: Long-term continuity index.
Last updated: 2026-06-29.

## Start Here

For any new AI engineer, read in this order:

1. `99_CURRENT_STATE.md`
2. `98_NEXT_ACTION.md`
3. `97_PROJECT_IDENTITY.md`
4. `96_ENGINEERING_INDEX.md`
5. `31_PRODUCT_PAGE_V2_VISUAL_RECOVERY.md`
6. `28_PRODUCT_PAGE_V2_PLAN.md`
7. `29_PRODUCT_PAGE_V2_IMPLEMENTATION_STRATEGY.md`
8. `07_CHANGELOG_AI.md`

## Core Project Documents

| File | Purpose |
| --- | --- |
| `00_START_HERE.md` | Original project entry. |
| `01_ENGINEERING_CONSTITUTION.md` | Engineering rules and component reverse-engineering requirement. |
| `03_ARCHITECTURE.md` | Architecture context. |
| `04_DISCOVERED_ENVIRONMENT.md` | Discovered staging/environment information. |
| `07_CHANGELOG_AI.md` | Chronological AI work log. |
| `12_PLUGIN_INVENTORY.md` | Plugin inventory context. |
| `13_CUSTOM_CODE_MAP.md` | WPCode/Code Snippets/custom code context. |
| `17_ENGINEERING_CLEANUP_ROADMAP.md` | Operational cleanup and custom-code refactor direction. |

## Design And UX Direction

| File | Purpose |
| --- | --- |
| `20_DESIGN_RESEARCH.md` | Reference learning from ssstein, Toteme, Nothing Written, MOIA Seoul. |
| `21_DIGITAL_DESIGN_PRINCIPLES.md` | JEDDA digital design principles. |
| `22_COMPONENT_DIRECTION.md` | Component-level standards. |
| `23_CUSTOMER_JOURNEY_AUDIT.md` | Full journey audit. |
| `24_VISUAL_GAP_ANALYSIS.md` | Visual gap audit against design direction. |
| `25_UX_FIX_ROADMAP.md` | UX roadmap. |

## Product Page Sprint

| File | Purpose |
| --- | --- |
| `27_PRODUCT_PAGE_EXCELLENCE_SPRINT_2.md` | Sprint 2 PDP interaction milestones and incident history. |
| `28_PRODUCT_PAGE_V2_PLAN.md` | Approved PDP V2 design plan. |
| `29_PRODUCT_PAGE_V2_IMPLEMENTATION_STRATEGY.md` | Approved technical path: small custom plugin in enhancement mode. |
| `30_PRODUCT_PAGE_V2_MILESTONE_2_6.md` | First plugin foundation milestone, now reclassified after failed visual QA. |
| `31_PRODUCT_PAGE_V2_VISUAL_RECOVERY.md` | Failed visual attempt, recovery, real Upscale DOM map, and next-try guardrails. |

## Active Code

| Path | Status |
| --- | --- |
| `wp-content/plugins/jedda-commerce-ui/` | Git-owned custom plugin exists. Installed on staging but deactivated after failed visual pass. |
| `wp-content/plugins/jedda-commerce-ui/jedda-commerce-ui.php` | PDP V2 feature flag and asset loading. Disabled by default. |
| `wp-content/plugins/jedda-commerce-ui/assets/css/pdp-v2.css` | First visual CSS attempt exists but must not be activated as-is. Needs component-by-component rebuild. |
| `wp-content/plugins/jedda-commerce-ui/assets/js/pdp-v2.js` | Small event-based helper; no `MutationObserver`. |

## Non-Negotiable Guardrails

- Do not touch production without explicit approval.
- Do not touch checkout/payment/order/customer data without explicit approval.
- Do not update WordPress, WooCommerce, plugins, or theme without explicit approval.
- Do not add more messy snippets for PDP V2.
- Do not use `MutationObserver` for PDP interaction work unless no simpler event-based option exists.
- Do not redesign the full PDP at once.
- Do not use generic WooCommerce selectors for Upscale PDP layout.

## Component Workflow

Every PDP V2 component milestone must include:

1. Component reverse engineering.
2. Dependency map.
3. Before screenshot.
4. Design-direction explanation.
5. Component-only implementation.
6. After screenshot.
7. Regression check.
8. Rollback plan.
9. Documentation update.
10. User approval before the next component.
