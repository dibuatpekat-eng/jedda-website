# Milestone 2.8.0 — Product Summary Reverse Engineering

**Status:** Complete — awaiting founder approval before implementation  
**Date:** 2026-06-29  
**Scope:** Everything inside `.de-product-single__summary--philo` and its dependencies  
**Next milestone:** 2.8.1 — Product Summary V2 Initial Implementation (requires approval)

---

## 1. DOM Tree

The product summary column is:

```
.de-product-single__summary.de-product-single__summary--philo.small-12.large-5.column
  (w=605px, h=757px at 1512px viewport)
```

Children in order:

| # | Element | Class | Height | Notes |
|---|---|---|---|---|
| 1 | `div` | `.de-brand-product` | 0px | Empty — brand logo placeholder, unused |
| 2 | `h2` | `.product_title.entry-title` | 19px | Product title — "Kiro Cropped Vest" |
| 3 | `div` | — | 19px | Price wrapper (contains `h4` + schema.org meta tags) |
| 4 | `div` | — | 280px | Short description container (inline `<style>` + spacer + `.jd-wrap` accordion) |
| 5 | `form` | `.variations_form.cart.wvs-loaded` | 378px | WC variation form + ATC + Buy Now |
| 6 | `div` | `.clear` | 0px | Foundation clearfix |

---

## 2. Template Structure

### WooCommerce Template Override

Upscale intercepts WooCommerce template loading via:

```php
// df-woocommerce-mod.php
add_filter('woocommerce_locate_template', [$this, 'dahz_framework_woocommerce_locate_template'], 10, 3);
add_filter('wc_get_template_part',        [$this, 'dahz_framework_woocommerce_get_template_part'], 10, 3);
add_filter('woocommerce_enqueue_styles',  '__return_false'); // Disables all WC default CSS
```

Upscale's `content-single-product.php` fires these standard WooCommerce hooks:

| Hook | Priority | Default handler |
|---|---|---|
| `woocommerce_before_single_product_summary` | 10/20 | sale flash / gallery |
| `woocommerce_single_product_summary` | 5 | title |
| `woocommerce_single_product_summary` | 10 | rating, price |
| `woocommerce_single_product_summary` | 20 | short description (excerpt) |
| `woocommerce_single_product_summary` | 30 | add-to-cart form |
| `woocommerce_single_product_summary` | 40 | meta |
| `woocommerce_single_product_summary` | 50 | sharing |
| `woocommerce_after_single_product_summary` | 10 | product tabs |
| `woocommerce_after_single_product_summary` | 15 | upsells |
| `woocommerce_after_single_product_summary` | 20 | related products |

However, Upscale's Philo layout renders the gallery + summary as side-by-side Foundation columns (`.de-product-single__images-left-philo.large-7` + `.de-product-single__summary--philo.large-5`) rather than the standard WC stacked layout. The actual rendering is driven by Upscale's own PHP layout files, not the hook sequence above.

---

## 3. Element-by-Element Analysis

### 3.1 Product Title

| Property | Value |
|---|---|
| Element | `h2.product_title.entry-title` |
| Data source | WooCommerce post title (`wp_posts.post_title`) |
| Font | Overpass |
| Size | 16px |
| Weight | 400 (regular) |
| Letter-spacing | 1.1px |
| CSS owner | Upscale theme (`dahz-framework-blog.css`) |
| Admin edit | Products → Edit → Product name |

---

### 3.2 Price

| Property | Value |
|---|---|
| Element | Unnamed `div` > `h4` > `span.woocommerce-Price-amount.amount` |
| Data source | WooCommerce `_price` / `_regular_price` meta; dynamically updated on variation select |
| Font | Overpass |
| Size | 12px |
| CSS owner | Upscale theme |
| Admin edit | Products → Edit → General (simple) or Variations (variable) |
| Notes | Wrapped in `h4` (unusual — heading tag used for price display) |

Also present inside the price container: 3 hidden `meta` tags + 1 `link` tag (schema.org structured data — do not remove).

---

### 3.3 Accordion (`.jd-wrap`)

This is the most architecturally significant finding of the reverse engineering.

**Location of all three components:** All hardcoded in the WooCommerce **short description** (`post_excerpt`) field.

The short description contains:
1. A full `<style>` block (~35 rules, using `.jd-*` class names)
2. A `<div style="height:20px">` spacer
3. The `.jd-wrap` HTML (4 accordion items)
4. A `<script>` block with the `jdToggle()` function

**Accordion items:**

| Tab | Content |
|---|---|
| Details | Free-text product description paragraph |
| Fit & Sizing | Size grid (cm measurements per size) + recommended body measurements box |
| Material & Care | Composition + care instructions |
| Shipping & Returns | Shipping, Exchanges, Size Exchange After Delivery, Pre-Order (4 sections, all same for every product) |

**Accordion behavior (`jdToggle`):**

```js
function jdToggle(hdr) {
  var body = hdr.nextElementSibling;
  var ico  = hdr.querySelector('.jd-ico');
  var isOpen = body.classList.contains('open');
  document.querySelectorAll('.jd-body.open').forEach(function(b) {
    b.classList.remove('open');
    b.previousElementSibling.querySelector('.jd-ico').classList.remove('open');
  });
  if (!isOpen) { body.classList.add('open'); ico.classList.add('open'); }
}
```

Accordion is "exclusive open" (only one item at a time). Details is open by default (`class="jd-body open"`).

**CSS typography:**

| Element | Font | Size | Weight | Color |
|---|---|---|---|---|
| `.jd-ttl` | Jost | 11px | 500 | #222 |
| `.jd-txt` | Jost | 12px | 300 | #666 |
| `.jd-lbl` | Jost | 10px | 500 | #888 |
| `.jd-bsr` | Jost | 11px | 300 | #666 |
| `.jd-size-tag` | Jost | 11px | 500 | #222 |

Note: Accordion uses **Jost** — a different typeface from the product title/price (Overpass). Two font families on one component panel.

---

### 3.4 Variation Form (`form.variations_form.cart.wvs-loaded`)

**Plugin:** woo-variation-swatches (adds visual swatch layer over raw WC `<select>`)

#### Color Row

| Property | Value |
|---|---|
| Label | "Color" |
| Element | `label` + `select.woo-variation-raw-select` (hidden) + `ul.variable-items-wrapper.button-variable-items-wrapper` |
| Options | Breen, Auburn |
| Item type | `li.variable-item.button-variable-item` (text button, 30px height) |
| Data source | WooCommerce product attribute `Color` |
| Admin edit | Products → Edit → Attributes → Color |
| Label font | Jost 11px (from WPCode snippet #13040 "color and size font") |

#### Size Row

| Property | Value |
|---|---|
| Label | "Size" |
| Options | S/M, L/XL |
| Data source | WooCommerce product attribute `Size` |
| Admin edit | Products → Edit → Attributes → Size |
| Hover effect | Disabled by WPCode snippet #2393 "Disable Hover Effect on Size Options" |

#### Single Variation Wrap (`.single_variation_wrap`)

Contains: variation price display + quantity field + ATC button

| Element | Details |
|---|---|
| Quantity | `input[type=number]`, min=0, val=1 |
| ATC button | `button.single_add_to_cart_button.de-btn.de-btn--boxed.de-btn--fill` |
| ATC height | 55px |
| ATC colors | White bg, 1px black border, black text, 14px, 1px letter-spacing |
| ATC label | "Add to cart" (state-changes to "Adding..." via Sprint 2.2 snippet) |

#### Buy Now Button

| Element | Details |
|---|---|
| Element | `button.de-single-direct-checkout.de-btn.de-btn--boxed.de-btn--fill` |
| Label | "Buy Now" |
| Owner | Upscale theme feature (direct-to-checkout) |
| Height | 55px (same style as ATC) |
| WPCode | Snippet #13041 adds sold-out notification on click |

---

## 4. CSS Ownership Map

| Element | Owner | File/ID |
|---|---|---|
| `.de-product-single__summary` layout, padding | Upscale theme | `dahz-framework-blog.css` |
| `h2.product_title` typography | Upscale theme | `dahz-framework-blog.css` |
| Price `h4` | Upscale theme | `dahz-framework-blog.css` |
| `.jd-wrap` accordion (all 35 rules) | Per-product inline `<style>` in post_excerpt | Product short description |
| Variation label font (Jost, 11px) | WPCode #13040 | "color and size font" |
| Swatch hover disable | WPCode #2393 | "Disable Hover Effect on Size Options" |
| Out-of-stock button state | WPCode #2384 | "Product Page - Out of Stock Button" |
| Out-of-stock CSS | WPCode #2378 | "CSS Out of Stock (Agif)" |
| ATC / Buy Now button style | Upscale theme `.de-btn` | `dahz-framework-blog.css` |
| Pre-order badge | WPCode #3613 + #5163 + #5152 | site_wide_header + footer |
| Sprint 2 interactions | Code Snippets #13, #18, #19 | variant validation, loading, success |

**WooCommerce default stylesheet: fully disabled** (`woocommerce_enqueue_styles` returns false). All WC styling comes from Upscale theme.

---

## 5. JavaScript Ownership Map

| Feature | Owner | Location |
|---|---|---|
| `jdToggle()` accordion | Inline `<script>` in post_excerpt | Per-product, hardcoded in short description |
| Variation form updates | WooCommerce core JS | `woocommerce/assets/js` |
| Swatch UI layer | woo-variation-swatches plugin | Plugin JS |
| Sprint 2.1 — Variant validation | Code Snippets #13 | Inline on PDP |
| Sprint 2.2 — Loading feedback | Code Snippets #18 | Inline on PDP |
| Sprint 2.3 — Success feedback | Code Snippets #19 | Inline on PDP (`window.__jeddaPdpSuccessFeedbackInit`) |
| Buy Now sold-out notification | WPCode #13041 | site_wide_header |
| Gallery counter (mobile) | `jedda-commerce-ui/assets/js/pdp-v2.js` | Plugin (PDP V2 only) |

---

## 6. Data Source Map (Admin Editing Workflow)

| Content | Where it's stored | How to edit (admin) |
|---|---|---|
| Product name | `wp_posts.post_title` | Products → Edit → Product name |
| Price | `_price`, `_regular_price` meta | Products → Edit → Variations |
| Color options | WC product attribute "Color" | Products → Edit → Attributes tab |
| Size options | WC product attribute "Size" | Products → Edit → Attributes tab |
| Color + size variation stock/price | WC variations | Products → Edit → Variations tab |
| Accordion: Details text | Hardcoded HTML in post_excerpt | Products → Edit → Short Description (requires HTML) |
| Accordion: Fit & Sizing measurements | Hardcoded HTML in post_excerpt | Products → Edit → Short Description (requires HTML) |
| Accordion: Material & Care | Hardcoded HTML in post_excerpt | Products → Edit → Short Description (requires HTML) |
| Accordion: Shipping & Returns | Hardcoded HTML in post_excerpt | Products → Edit → Short Description (requires HTML) |
| Accordion CSS (35 rules) | Hardcoded `<style>` in post_excerpt | Products → Edit → Short Description (requires HTML) |
| Accordion JS (jdToggle) | Hardcoded `<script>` in post_excerpt | Products → Edit → Short Description (requires HTML) |
| Pre-order badge | WPCode snippets | WPCode admin |

---

## 7. What Must Be Preserved

| Component | Why |
|---|---|
| WooCommerce variation form output | WC core renders price updates, stock validation, cart submission |
| woo-variation-swatches swatch layer | Renders visual swatches over raw selects |
| Sprint 2 snippet interactions (#13, #18, #19) | Variant validation + loading + success feedback |
| WPCode #2384 out-of-stock button | Business logic for sold-out state |
| WPCode #2393 hover disable | Existing interaction design decision |
| WPCode #13041 Buy Now notification | Sold-out guard on Buy Now path |
| schema.org meta tags (hidden inside price container) | SEO structured data |
| Foundation column layout (`small-12 large-5`) | Mobile stacking behavior |

---

## 8. What Should Be Rebuilt

| Component | Current problem |
|---|---|
| Accordion `<style>` block | Duplicated per product; not cacheable; 35 rules inline per page load |
| Accordion `<script>` block | `jdToggle` duplicated in every product's short description |
| Accordion HTML markup | Hardcoded raw HTML in post_excerpt — non-technical editors cannot update measurements, copy, or add new tabs |
| Font inconsistency | Accordion uses Jost; title/price uses Overpass — two typefaces for one panel |
| Price `h4` wrapper | Price displayed inside a heading element — semantically incorrect |
| Spacer `<div style="height:20px">` | Inline spacer div — layout spacing should be in CSS |

---

## 9. What Should Be Migrated to CMS-Friendly Architecture

This is the primary CMS architecture concern for this milestone.

### Critical: Accordion Content

**Current:** 4 accordion items hardcoded as raw HTML inside the WooCommerce short description. Every product requires manual HTML editing to add/update product details, measurements, and care instructions.

**Proposed migration (3 options, in order of preference):**

#### Option A — ACF Custom Fields (Recommended)
Create structured ACF fields:
- `jedda_details_text` (textarea) — Details tab body copy
- `jedda_composition` (text) — e.g., "Recycled Polyester, Viscose"
- `jedda_care_instructions` (textarea)
- `jedda_size_measurements` (repeater or flexible content — one row per size: label, bust, shoulder, front length, back length)
- `jedda_recommended_body_size` (repeater — one row per size: label, bust)

Shipping & Returns content is identical across all products — move to a global option (ACF Options Page or site option) and inject it once from PHP. Zero per-product editing needed.

The `jedda-commerce-ui` plugin renders the accordion from these fields via `woocommerce_single_product_summary` hook (priority 20, replacing the current short description output).

Admin experience: fully point-and-click. No HTML. Fields labelled in plain language.

#### Option B — Keep Short Description, Move CSS + JS to Plugin
Move the `.jd-wrap` CSS and `jdToggle()` JS out of per-product HTML and into `pdp-v22.css` and `pdp-v2.js`. Short description remains HTML but no longer carries `<style>` and `<script>` tags.

This is simpler to implement but does not fix the editor experience problem.

#### Option C — WooCommerce Product Tabs Plugin
Add a dedicated product tabs plugin (e.g., "WooCommerce Product Tabs" or "YITH WooCommerce Tab Manager") to manage accordion items from the product admin UI without ACF.

Lower implementation cost than ACF Option A, but adds another plugin dependency.

**Recommendation: Option A (ACF).** ACF is already available on this installation. It provides the cleanest long-term architecture with zero plugin additions and full compatibility with the `jedda-commerce-ui` rendering layer.

---

## 10. Active WPCode Snippets Affecting the PDP

Snippets running on the product page at the time of reverse engineering:

| ID | Title | Location | Affects PDP? |
|---|---|---|---|
| 2393 | Disable Hover Effect on Size Options | everywhere | YES — swatch hover styles |
| 2384 | Product Page - Out of Stock Button | frontend_only | YES — sold-out state |
| 13041 | Buy Now sold-out notification | site_wide_header | YES — Buy Now guard |
| 13040 | color and size font | site_wide_header | YES — variation label typography |
| 11836 | Untitled Snippet | site_wide_header | UNKNOWN — content not inspected |
| 3613 | Pre-Order Badge | site_wide_header | YES — pre-order badge overlay |
| 2378 | CSS Out of Stock | site_wide_header | YES — sold-out CSS state |
| 2217 | JS Cart and Checkout | site_wide_header | Indirect — cart JS |
| 2193 | CSS Cart & Checkout | site_wide_header | Indirect — cart CSS |

Sprint 2 Code Snippets (not WPCode):

| ID | Title | State |
|---|---|---|
| 13 | JEDDA PDP Variant Validation | Active |
| 18 | JEDDA PDP Loading Feedback | Active |
| 19 | JEDDA PDP Success Feedback | Active |

---

## 11. Environment Blocker: WPCode Snippet #11836 "Untitled Snippet"

An unnamed snippet (#11836) runs in `site_wide_header` and its content was not inspected during this reverse engineering pass. Its impact on the product summary is unknown.

**Recommendation:** Before implementing Product Summary V2, the owner should review #11836 in WPCode admin and either name it, document its purpose, or deactivate it if it is no longer needed. An unnamed snippet is a maintenance risk.

---

## 12. Summary: What to Do in Milestone 2.8.1

Given the findings above, the Product Summary V2 implementation should:

1. **Extract CSS and JS from post_excerpt** — move all `.jd-wrap` styles into `pdp-v22.css`, move `jdToggle()` into `pdp-v2.js`. Short description field is freed up.

2. **Either:**
   - (Option A) Migrate accordion content to ACF fields and render from PHP hook in the plugin — founder decision needed
   - (Option B) Continue using the short description but without the `<style>` and `<script>` tags

3. **Fix font consistency** — unify Jost vs. Overpass decision across the entire summary. Pick one typeface and apply it consistently to title, price, labels, accordion copy, and variation labels.

4. **Fix price element** — move price out of `h4` into a properly semantic element.

5. **Remove inline spacer div** — replace `<div style="height:20px">` with a CSS margin.

6. **Visual redesign** — apply spacing, hierarchy, and typographic improvements per the JEDDA design direction (this is the V2 design work).

7. **Do not touch:** variation form rendering, Sprint 2 snippet behavior, Buy Now feature, WC attribute structure, schema.org tags, or stock/checkout logic.

---

## Milestone 2.8.0 — Complete
**Awaiting founder approval to begin Milestone 2.8.1 — Product Summary V2 Implementation.**
