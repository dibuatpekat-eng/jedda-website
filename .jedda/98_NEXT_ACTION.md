# Next Action

Status: Milestones 2.8.0 (Reverse Engineering) and 2.8.1 (Architecture) complete. Awaiting founder approval on 6 decisions.
Last updated: 2026-06-29.

## Decisions Required Now (Founder)

Six decisions must be made before Milestone 2.8.2 (implementation) can begin:

| # | Question | Options | Recommendation |
|---|---|---|---|
| 1 | Data architecture for accordion content | ACF Pro / Meta Box / keep post_excerpt | **ACF Pro** |
| 2 | Typography direction | Cormorant Garamond + Inter / Plus Jakarta Sans / licensed fonts | **Cormorant Garamond + Inter** |
| 3 | Shipping & Returns storage | Per-product copy-paste (current) / ACF Options Page (global) | **ACF Options Page** |
| 4 | Material composition | ACF text field / WC product attribute `pa_material` | **WC attribute** |
| 5 | WPCode #11836 "Untitled Snippet" | Review in WPCode admin — name it, document it, or deactivate | **Review before V2** |
| 6 | What post_excerpt becomes | Empty / plain-text marketing blurb for SEO/social | **Marketing blurb** |

See full architecture rationale: `.jedda/34_PRODUCT_SUMMARY_V2_ARCHITECTURE.md`

## After Approval → Milestone 2.8.2 (Foundation)

No visual changes. Infrastructure only:
1. Install / activate ACF Pro on staging
2. Define field groups in JSON (version-controllable)
3. Create ACF Options Page "Jedda Policy"
4. Add Cormorant Garamond + Inter font files to `jedda-commerce-ui/assets/fonts/`
5. Register font preloads in plugin PHP

Staging remains unchanged. Editors can start filling in product fields once ACF is live.

## Milestone Order Going Forward

| Milestone | Name | Status |
|---|---|---|
| 2.8.0 | Product Summary Reverse Engineering | ✅ Complete |
| 2.8.1 | Product Summary V2 Architecture | ✅ Complete — awaiting approval |
| 2.8.2 | Foundation (ACF + fonts) | Blocked on approval |
| 2.8.3 | Content Migration (1 product) | After 2.8.2 |
| 2.8.4 | Template + Typography | After 2.8.3 |
| 2.8.5 | Full Rollout | After 2.8.4 approval |
