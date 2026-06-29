# Next Action

Status: Milestone 2.8.2 (Product Summary V2 Blueprint) complete. Awaiting owner actions and UX confirmations.
Last updated: 2026-06-29.

## Owner Actions Required (Before 2.8.3 Can Begin)

### 1. Purchase ACF Pro — BLOCKING
URL: advancedcustomfields.com  
Cost: ~$49/yr  
Why: Repeater field (size measurement tables) and Options Page (global policy) require Pro.  
Install on staging only. Do not install on main site yet.

### 2. Review WPCode #11836 "Untitled Snippet" — BLOCKING
Go to: WP Admin → WPCode → Snippets → find snippet ID 11836  
Action: Read its content, name it, and document its purpose in a reply.  
Why: Unknown snippet runs on every page including PDP. Must be understood before V2 overrides any element it may be affecting.

### 3. Confirm 9 UX Decisions

| # | Question | Proposed default |
|---|---|---|
| A | Allow multiple accordion panels open simultaneously? | Yes (multi-open) |
| B | All accordion panels closed by default? | Yes (all closed) |
| C | Button label: "Add to Bag" or "Add to Cart"? | "Add to Bag" |
| D | Product title as `<h1>` (not `<h2>`)? | Yes — semantic HTML |
| E | Quantity input visible or hidden on mobile? | Hidden on mobile |
| F | Swatch minimum touch target: 44px height on mobile? | Yes — WCAG AA |
| G | Sticky summary column on desktop? | Yes |
| H | Size Guide link next to SIZE label? | Yes — opens Fit & Sizing panel |
| I | Network error state on ATC failure? | Yes — add inline error message |

Full UX specification: `.jedda/35_PRODUCT_SUMMARY_V2_BLUEPRINT.md`

## After Owner Actions Confirmed → Milestone 2.8.3 (Foundation)

No visual changes on staging. Infrastructure only:

1. Plugin directory restructure (single PHP → class-based includes/)
2. Install ACF Pro, define field groups in plugin PHP
3. Create ACF Options Page "Jedda Policy"
4. Register `jedda_badge` taxonomy in plugin
5. Download Plus Jakarta Sans WOFF2 files (300, 400, 500, 600 weights)
6. Add fonts to `jedda-commerce-ui/assets/fonts/`
7. Register font preloads in plugin PHP
8. Verify sticky container layout (flexbox vs float)
9. Rename CSS to `pdp-v22.css` (LiteSpeed cache rule)

## Full Milestone Sequence

| Milestone | Name | Status |
|---|---|---|
| 2.8.0 | Product Summary Reverse Engineering | ✅ Complete |
| 2.8.1 | Architecture | ✅ Complete — approved |
| 2.8.2 | Blueprint | ✅ Complete — awaiting UX confirmations |
| 2.8.3 | Foundation (plugin restructure + ACF + fonts) | Blocked on owner actions |
| 2.8.4 | Content Migration (1 product to ACF) | After 2.8.3 |
| 2.8.5 | Template + Typography implementation | After 2.8.4 |
| 2.8.6 | Full Rollout | After 2.8.5 approval |
