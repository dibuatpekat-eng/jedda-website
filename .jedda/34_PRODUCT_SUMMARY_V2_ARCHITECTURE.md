# Milestone 2.8.1 — Product Summary V2 Architecture

**Status:** Architecture proposal — awaiting founder approval before implementation  
**Date:** 2026-06-29  
**Depends on:** Milestone 2.8.0 (reverse engineering complete)  
**Next milestone:** 2.8.2 — Implementation (requires approval of this document)

---

## Part 1 — Data Architecture

### The Problem Being Solved

The current Product Summary stores all accordion content — product description, size measurements, material composition, care instructions, shipping policy, and the accordion's own CSS and JavaScript — as raw HTML inside the WooCommerce **Short Description** (`post_excerpt`) field.

Consequences:
- Non-technical editors cannot update product content without understanding HTML
- CSS (35 rules) and JS (`jdToggle()`) are duplicated in every product's page load
- Shipping & Returns (identical for all products) is copy-pasted per product — a change to policy requires updating every product individually
- Size measurement tables are fragile structured data stored as unstructured HTML
- No validation, no field labels, no guidance for editors
- The data has no machine-readable structure — cannot be queried, filtered, exported, or used in APIs

---

### Architecture Options Evaluated

#### Option 1 — ACF (Advanced Custom Fields)

**What it does:** Adds structured custom fields to the product edit screen via a visual field builder. Content editors fill in labelled fields (text, textarea, number, repeater, image) — no HTML required.

| Dimension | Assessment |
|---|---|
| Editor experience | Excellent — labelled fields, field descriptions, conditional logic, WYSIWYG text blocks |
| Maintainability | High — fields are defined in code (JSON export) or UI, version-controllable |
| Scalability | High — supports repeater fields (size tables), flexible content (variable accordion panels), image fields, relationship fields |
| Performance | Good — stores as standard `wp_postmeta` rows, same as WC native meta. No custom queries needed. |
| Migration complexity | Medium — requires creating field groups, then migrating content per product |
| Long-term flexibility | High — fields can be added, reorganised, or conditionally shown without touching templates |
| WC update compatibility | Excellent — no WC hooks used; field storage is pure WordPress post meta |
| Industry adoption | The de facto standard for structured content in WordPress premium/agency work |
| Cost | ACF Free: sufficient for basic fields. ACF Pro (~$49/yr): needed for Repeater (size tables) and Options Page (global fields like Shipping & Returns) |

**Best fit for:** All per-product structured content (Details, Fit & Sizing, Material & Care)

---

#### Option 2 — Meta Box

**What it does:** Similar to ACF — structured custom fields via a field builder. More developer-focused API.

| Dimension | Assessment |
|---|---|
| Editor experience | Good — similar to ACF, slightly less polished admin UI |
| Maintainability | High — well-structured, code-first configuration |
| Scalability | High — repeater and group fields in free version (Meta Box AIO) |
| Performance | Good — same post_meta storage as ACF |
| Migration complexity | Medium |
| Long-term flexibility | High |
| WC update compatibility | Excellent |
| Industry adoption | Smaller than ACF, but respected in developer community |
| Cost | Free (Meta Box AIO bundle) |

**Verdict vs ACF:** Meta Box wins on cost (repeater free). ACF wins on ecosystem, documentation, client familiarity, and community support. For a fashion brand where the owner edits products themselves, ACF's more polished admin UI is a meaningful advantage.

---

#### Option 3 — Native WooCommerce Post Meta

**What it does:** Store accordion content as plain WP post meta using `update_post_meta()` calls. No plugin required.

| Dimension | Assessment |
|---|---|
| Editor experience | None — no admin UI out of the box. Editors cannot update content without custom code or a field plugin |
| Maintainability | Low — requires custom PHP for admin UI or raw database editing |
| Scalability | Low — structured data (size tables) would require JSON encoding inside a single meta row |
| Performance | Best — zero overhead |
| Migration complexity | Low (just write to meta) |
| Long-term flexibility | Low — every field change requires PHP changes |
| WC update compatibility | Excellent |
| Industry adoption | Only appropriate for developer-only or API-driven stores |

**Verdict:** Not suitable as the primary data layer for a brand with non-technical content editors.

---

#### Option 4 — WooCommerce Product Attributes + Taxonomies

**What it does:** Uses WC's built-in attribute system (already used for Color/Size) to store structured product data. Taxonomies store categorized data.

| Dimension | Assessment |
|---|---|
| Editor experience | Good for categorical data (materials, care icons) — dropdown selection, not free text |
| Maintainability | Good — WC-native, no extra plugins |
| Scalability | Limited — designed for variation-driving attributes, not long-form content |
| Performance | Good — WC-optimized queries |
| Migration complexity | Low for categorical data |
| Long-term flexibility | Limited — poor fit for paragraphs, measurement tables, or formatted copy |
| WC update compatibility | Excellent |
| Industry adoption | Standard for product spec data (size, color, material tags) |

**Verdict:** Best used as a **complement** to ACF, not a replacement. Material composition ("Recycled Polyester, Viscose") could be a WC attribute. Care *icons* could be a taxonomy. Long-form care *instructions* stay in ACF.

---

#### Option 5 — Custom Post Types (Content as CPT)

**What it does:** Models accordion items or policy sections as their own post type, with product-to-content relationships.

| Dimension | Assessment |
|---|---|
| Editor experience | Moderate — separate edit screens for policies, related back to products |
| Maintainability | Moderate — adds architectural complexity |
| Scalability | High for shared content (one policy CPT, many products) |
| Performance | Lower — requires relational queries |
| Migration complexity | High |
| Long-term flexibility | High for complex content graphs |
| WC update compatibility | Good |
| Industry adoption | Over-engineering for this use case unless content is highly shared and complex |

**Verdict:** Appropriate if Jedda were managing a full editorial platform (e.g., lookbooks, brand stories, size guides as standalone pages). Overkill for accordion content within a product.

---

#### Option 6 — Headless / Decoupled (WC + Next.js or Nuxt)

**What it does:** WooCommerce as a headless API backend; custom frontend (React/Vue) renders product pages.

| Dimension | Assessment |
|---|---|
| Editor experience | Depends on frontend — can be excellent |
| Performance | Highest ceiling |
| Migration complexity | Extreme — requires full frontend rebuild, new hosting, new deployment pipeline |
| WC update compatibility | Decoupled — WC updates only affect API, not frontend |
| Industry adoption | Growing in luxury/fashion (Farfetch, Net-a-Porter use custom platforms; smaller brands use Shopify Hydrogen or WC headless) |
| Cost | Significant ongoing engineering cost |

**Verdict:** The right long-term direction for a scaling luxury brand, but not appropriate as a migration target from the current stack. This would be a Phase 3+ initiative, not a Product Summary V2 decision.

---

### Recommended Architecture

**Primary data layer: ACF Pro**

Rationale:
- Best editor experience for the owner editing products
- Handles all content types: free text (Details), structured tables (Fit & Sizing), short text (Composition, Care)
- Options Page handles global content (Shipping & Returns, Pre-Order policy) — edit once, reflect everywhere
- Repeater field cleanly models size measurement rows
- JSON export keeps field definitions in version control
- Most widely documented and supported in the WordPress ecosystem
- $49/yr is negligible against the engineering cost of alternatives

**Complement with WC Attributes for categorical data:**
- Material composition → WC product attribute `pa_material` (filterable, queryable, consistent across products)
- This attribute feeds into the Material & Care accordion alongside ACF care instructions
- Future: material filtering on shop page at zero extra cost

**Global/shared content → ACF Options Page:**
- Shipping & Returns policy → edit once in wp-admin → Options → Jedda Policy
- Pre-Order policy → same
- These appear in every product's accordion but are maintained centrally

#### Proposed ACF Field Groups

**Field Group: "Product Details" (attached to WooCommerce Products)**

| Field Name | Type | Label (admin) | Notes |
|---|---|---|---|
| `jedda_details_text` | Textarea | Product Details | The narrative description shown in Details tab |
| `jedda_composition` | Text | Material Composition | e.g., "Recycled Polyester, Viscose" |
| `jedda_care_instructions` | Textarea | Care Instructions | Free text; rendered in Material & Care tab |
| `jedda_sizes` | Repeater | Size Measurements | One row per size |
| → `jedda_size_label` | Text | Size Label | "S / M", "L / XL" |
| → `jedda_size_bust` | Number | Bust (cm) | |
| → `jedda_size_shoulder` | Number | Shoulder (cm) | |
| → `jedda_size_front_length` | Number | Front Length (cm) | |
| → `jedda_size_back_length` | Number | Back Length (cm) | |
| `jedda_rec_sizes` | Repeater | Recommended Body Size | |
| → `jedda_rec_size_label` | Text | Size Label | |
| → `jedda_rec_bust_max` | Text | Bust up to (cm) | |

**Field Group: "Jedda Global Policy" (ACF Options Page)**

| Field Name | Type | Label (admin) |
|---|---|---|
| `jedda_shipping_policy` | WYSIWYG / Textarea | Shipping Policy |
| `jedda_returns_policy` | Textarea | Returns & Exchanges |
| `jedda_size_exchange_policy` | Textarea | Size Exchange After Delivery |
| `jedda_preorder_policy` | Textarea | Pre-Order Policy |

Admin path: WP Admin → Jedda Policy → edit once → all products reflect the update.

#### What post_excerpt becomes
Short Description is freed entirely. Set to empty, or repurposed for a brief marketing blurb (plain text, no HTML) used in search previews and social sharing meta.

---

## Part 2 — Typography Architecture

### Current State Problems

1. **Two typefaces on one panel:** Overpass (title, price) vs. Jost (accordion, variation labels)
2. **Both are web-developer fonts, not fashion-editorial fonts:** Overpass is a high-legibility grotesque designed for road signage. Jost is a geometric sans optimised for UI. Neither signals luxury or craft.
3. **No typographic hierarchy:** Title at 16px Overpass 400, price at 12px Overpass — nearly no differentiation. A visitor cannot scan the panel and immediately read the price or name.
4. **Missing display scale:** No large, confidence-building heading moment on the product page.

---

### How Premium Minimalist Fashion Brands Use Typography

| Brand | Display | UI / Body | Character |
|---|---|---|---|
| Toteme | Custom extended serif (close to Canela or Editorial New) | Clean sans (appears to be Helvetica Neue or custom) | Editorial warmth, measured confidence |
| SSSTEIN | Geometric sans (close to Suisse Int'l or Aktiv) | Same sans, weight variation | Austere, architectural, no decoration |
| The Row | Light condensed serif (similar to Freight Text or Caslon) | Minimal sans | Quiet luxury, understatement |
| Aesop | Custom serif (close to GT Sectra) | Clean sans | Artisanal, literary |
| COS | Geometric sans (Helvetica-adjacent) | Same | Modern, systematic |
| Jacquemus | Humanist sans (warm, slightly irregular) | Same | Playful luxury, Mediterranean warmth |
| A.P.C. | Classic grotesque (Helvetica-influenced) | Same | Parisian restraint |
| Lemaire | Serif display + clean sans | Pairing | Craft-forward, intellectual |

**Pattern:** The brands closest to JEDDA's Toteme/SSSTEIN direction split into two camps:
1. **Toteme direction** — pairing a refined display serif (editorial, slightly literary) with a clean functional sans for labels and UI
2. **SSSTEIN direction** — single-typeface system using a high-quality geometric sans across all scales

---

### Typography Options Evaluated

#### Option A — Cormorant Garamond + Inter (Recommended)

**Cormorant Garamond** (display, product names, section headers):
- Free via Google Fonts; designed by Christian Thalmann
- Based on the Garamond tradition — refined, literary, works exceptionally at large display sizes
- Extremely high contrast between thin strokes and thick — creates editorial elegance at 24px+
- Used by numerous emerging luxury brands, jewellery, fine fashion labels

**Inter** (UI, price, labels, accordion body, variation labels, buttons):
- Free via Google Fonts; designed by Rasmus Andersson
- The most precisely engineered grotesque for screen legibility
- Industry-standard for premium digital products (Linear, Vercel, Stripe, Notion)
- Excellent at 10–14px — the exact range where price, labels, and measurements live
- Optical sizing: readable at 10px without sacrificing sharpness

**Pairing rationale for JEDDA:**
- Product name in Cormorant Garamond 300 at 22–24px: editorial weight, commands attention, reads as "fashion object" not "web product"
- Price, labels, measurements in Inter 400–500 at 11–13px: precise, functional, confident
- High contrast between serif display and sans UI creates typographic rhythm that signals intentionality
- Both free: no licensing cost, no GDPR font-hosting concerns (self-hostable)

**Risk:** Cormorant can feel "delicate" at small sizes — must only be used at display scale (≥18px). All body copy and labels use Inter.

---

#### Option B — Plus Jakarta Sans (Single Typeface)

**Plus Jakarta Sans** (all scales):
- Free via Google Fonts; designed by Tokotype — an **Indonesian** type foundry
- Geometric sans with humanist warmth; available in 6 weights
- Signals modernity, precision, and (for a discerning eye) Indonesian craft heritage
- Would be a meaningful brand signal: an Indonesian luxury brand using a typeface from an Indonesian foundry

**Pairing rationale:**
- 300 weight for product title, body accordion text
- 500–600 weight for price, labels, section headers
- Creates a single-typeface system — cleaner, easier to maintain
- The SSSTEIN direction: everything done with weight and spacing, no serif "signalling"

**Risk:** Less distinctively "editorial" than the serif+sans pairing. If JEDDA's direction is closer to Toteme (warm, editorial) than SSSTEIN (austere, minimal), this may not provide enough typographic warmth.

---

#### Option C — GT Sectra + Neue Haas Grotesk (Licensed, Industry Standard)

**GT Sectra** (Grilli Type, display):
- The typeface of choice for dozens of luxury/editorial brands (used by Aesop, various fashion publications)
- Inktrapped serif, editorial, contemporary
- ~CHF 300+ per style for web licensing

**Neue Haas Grotesk** (Linotype, UI):
- The original Helvetica — more neutral than the commercial version, designed for screen
- Used by Prada, COS, countless premium brands
- Expensive: ~$250–500+ for web licensing

**Verdict:** The gold standard if budget allows. For a growing brand, the licensing overhead is significant. Recommend revisiting this option at Series A stage or when the brand is ready for a full identity investment.

---

#### Option D — Editorial New + Inter (Mid-tier)

**Editorial New** (Pangram Pangram, display):
- Widely used by premium DTC brands (appears on dozens of Shopify luxury storefronts)
- Stylish high-contrast serif with distinctive "wink" to the italic
- ~$250+ for web licensing
- Risk: Has become recognisable as the "DTC luxury brand serif" — slightly overused in 2024–2026

**Verdict:** Strong choice. Slightly more expensive than Option A, and slightly more "template-feeling" due to widespread adoption. Option A (Cormorant + Inter) achieves a similar editorial effect for free.

---

### Typography Recommendation

**Primary recommendation: Option A — Cormorant Garamond + Inter**

Usage rules:
- `Cormorant Garamond, 300` → product name, section display headers, any text ≥20px
- `Inter, 400` → price, accordion body copy, accordion section sub-headers (`.jd-lbl`)
- `Inter, 500` → variation labels (Color, Size), price when selected variant, button text, measurement data
- `Inter, 300` → secondary body copy, measurement values

Self-host both via Google Fonts download + served from `/wp-content/themes/` or the `jedda-commerce-ui` plugin's `assets/fonts/` directory. This eliminates Google Fonts DNS round-trips and avoids GDPR font-loading concerns.

**Alternative if single-typeface is preferred:** Option B — Plus Jakarta Sans. The Indonesian origin adds a quiet brand story. Use 300 for display, 500–600 for UI.

**Do not continue with Overpass.** It belongs to a different design language (technical/governmental) and does not communicate luxury. **Do not continue with Jost.** It was introduced per-product in raw HTML and was never a deliberate brand decision — it is an implementation artifact, not a typographic choice.

---

## Part 3 — Migration Strategy

### Phase 0 — Prerequisite (before any implementation)

1. **Decision:** Founder approves data architecture (ACF recommended) and typography direction
2. **Decision:** Confirm ACF Pro purchase or evaluate Meta Box free alternative
3. **Inventory:** Review WPCode snippet #11836 ("Untitled Snippet") — name it, document it, or deactivate before V2 work begins

### Phase 1 — Foundation (Milestone 2.8.2)

1. Install ACF Pro (or activate if already present)
2. Define field groups in JSON (version-controllable) — no database changes yet
3. Create ACF Options Page "Jedda Policy" with Shipping & Returns, Pre-Order, Returns fields
4. Add font files (Cormorant Garamond + Inter) to `jedda-commerce-ui/assets/fonts/`
5. Register fonts in `jedda-commerce-ui.php` with `preload` hints

Nothing changes on staging. No existing product content is touched.

### Phase 2 — Content Migration (Milestone 2.8.3)

1. Migrate one product (Kiro Cropped Vest) to ACF fields — fill in Details, Fit & Sizing, Composition, Care
2. Fill in global Jedda Policy fields (Shipping & Returns content)
3. Empty the Short Description field of its `<style>`, `<script>`, and `.jd-wrap` HTML
4. Verify: product still displays correctly (old rendering) — ACF fields are populated but not yet rendered

### Phase 3 — Template (Milestone 2.8.4)

1. Add PHP to `jedda-commerce-ui` that hooks into `woocommerce_single_product_summary` at priority 19 (just before the short description at 20)
2. Render accordion from ACF fields — structured PHP template, no inline styles or scripts
3. Move `.jd-wrap` CSS into `pdp-v22.css`
4. Move `jdToggle()` into `pdp-v2.js`
5. Remove the old short description hook (priority 20) for PDP V2 pages only (scoped to `jedda_pdp_v2_enabled`)

### Phase 4 — Typography (part of Milestone 2.8.4)

1. Apply Cormorant Garamond to `.product_title` (replace Overpass)
2. Apply Inter to all summary UI elements
3. Set type scale: title 22px / 300, price 13px / 400, labels 11px / 500, body 12px / 400
4. Remove Jost references from anywhere they appear

### Phase 5 — Rollout (Milestone 2.8.5)

1. Migrate all remaining products to ACF fields
2. Test each product: measurements, care content, Details text
3. Verify Shipping & Returns pulls from global option (not per-product)
4. Full staging QA — desktop + mobile
5. Founder approval → push to production

### Rollback at any phase

- ACF fields populated but templates not switched: existing rendering continues
- Feature flag (`jedda_pdp_v2_enabled`) controls whether new templates are used — can be toggled per-product or globally
- `post_excerpt` content is not deleted until Phase 5 is fully approved — it remains as a fallback

---

## Summary — Decisions Required

| # | Decision | Options | Recommendation |
|---|---|---|---|
| 1 | Data architecture | ACF Pro / Meta Box / Native meta | **ACF Pro** |
| 2 | Typography | Cormorant+Inter / Plus Jakarta Sans / licensed | **Cormorant Garamond + Inter** (or Plus Jakarta Sans if single-typeface preferred) |
| 3 | Shipping & Returns | Per-product / ACF Options Page | **ACF Options Page** |
| 4 | Material composition | ACF text / WC attribute | **WC attribute `pa_material`** |
| 5 | WPCode #11836 | Keep / document / deactivate | **Review and name before V2** |
| 6 | Post excerpt after migration | Empty / marketing blurb | **Marketing blurb (plain text)** |

---

## Milestone 2.8.1 — Complete
**Awaiting founder decisions on architecture and typography before proceeding to Milestone 2.8.2.**
