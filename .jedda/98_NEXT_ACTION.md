# Next Action

Status: Milestone 2.8.3 (Foundation) complete. Blocked on owner: ACF Pro purchase.
Last updated: 2026-06-30.

## Owner Actions Required (Before 2.8.4 Can Begin)

### 1. Purchase ACF Pro — BLOCKING
URL: advancedcustomfields.com  
Cost: ~$49/yr  
Why: Repeater field (size measurement tables) and Options Page (global policy) require Pro.  
Install on staging only. Do not install on main site yet.

### 2. Review WPCode #11836 "Untitled Snippet" — BLOCKING
Go to: WP Admin → WPCode → Snippets → find snippet ID 11836  
Action: Read its content, name it, and document its purpose in a reply.  
Why: Unknown snippet runs on every page including PDP. Must be understood before V2 overrides any element it may be affecting.

## Next Milestone → 2.8.4 (Content Migration)

Blocked on ACF Pro. Once installed:

1. Activate ACF Pro on staging
2. Uncomment ACF field group in `class-acf-fields.php` and activate
3. Uncomment ACF Options Page in `class-acf-options.php` and activate
4. Fill all 4 ACF fields for Kiro Cropped Vest in WP Admin → Products
5. Fill Jedda Policy global fields in WP Admin → Jedda Policy
6. Verify data is readable via `get_field()` in PHP

## Full Milestone Sequence

| Milestone | Name | Status |
|---|---|---|
| 2.8.0 | Product Summary Reverse Engineering | ✅ Complete |
| 2.8.1 | Architecture | ✅ Complete — approved |
| 2.8.2 | Blueprint | ✅ Complete — approved |
| 2.8.3 | Foundation (plugin restructure + fonts + taxonomy + WC filters) | ✅ Complete — deployed |
| 2.8.4 | Content Migration (1 product to ACF) | Blocked: ACF Pro needed |
| 2.8.5 | Template + Typography implementation | After 2.8.4 |
| 2.8.6 | Full Rollout | After 2.8.5 approval |
