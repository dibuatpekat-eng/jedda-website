# Milestone 2.8.2 — Product Summary V2 Complete Blueprint

**Status:** Design complete — awaiting founder approval before implementation  
**Date:** 2026-06-29  
**Depends on:** 2.8.0 (reverse engineering), 2.8.1 (architecture approved)  
**Typography decision:** Plus Jakarta Sans (self-hosted via plugin)  
**Next milestone:** 2.8.3 — Foundation (ACF + fonts, no visual changes)

This document defines exactly what the Product Summary should become. It is the authoritative design specification for Milestone 2.8.4 implementation.

---

## Part 1 — Typography System

### Typeface: Plus Jakarta Sans

**Why Plus Jakarta Sans for JEDDA:**
- Designed by Tokotype, an Indonesian type foundry — quiet heritage alignment with JEDDA's identity
- Geometric construction with humanist warmth — more approachable than Helvetica, more structured than humanist sans like Gill Sans
- 7 weights (200–800) with matching italics — full range for a complete typographic system
- Excellent screen rendering at small sizes (10–13px) where label text and measurements live
- Strong letter-spacing response — fashion labels read well at 0.08–0.12em tracking in uppercase
- Free under OFL license, self-hostable, no GDPR concerns

**Self-hosted weights (4 only — minimise font payload):**
| Weight | Numeric | Use |
|---|---|---|
| Light | 300 | Secondary body copy, measurement values, muted text |
| Regular | 400 | Primary body copy, price, standard labels |
| Medium | 500 | Tab labels (uppercase), variant labels, button text |
| SemiBold | 600 | Product title |

Weights 200, 700, 800 are excluded — unnecessary for this system and add payload.

**Font loading strategy:**
- Format: WOFF2 only (universal modern browser support, ~30% smaller than WOFF)
- `font-display: swap` — prevents invisible text flash; text renders immediately in system font
- Preload 400 and 500 weight WOFF2 files via `<link rel="preload" as="font">` in plugin PHP
- Italic variant: not loaded — this system does not use italic

---

### Type Scale

All sizes in px, optimised for the Product Summary column context (545px usable width).

| Role | Size | Weight | Line-height | Letter-spacing | Case | Color |
|---|---|---|---|---|---|---|
| Product title | 20px | 600 | 1.25 | 0.02em | Title case | `--jedda-ink` (#171717) |
| Price | 14px | 400 | 1 | 0 | — | `--jedda-ink` |
| Sale price (original) | 12px | 300 | 1 | 0 | — | `--jedda-muted` (#686868), strikethrough |
| Section label (COLOR, SIZE) | 10px | 500 | 1 | 0.10em | UPPERCASE | `--jedda-ink` |
| Selected value (inline) | 10px | 400 | 1 | 0 | Title case | `--jedda-muted` |
| Accordion tab title | 10px | 500 | 1 | 0.10em | UPPERCASE | `--jedda-ink` |
| Accordion body | 13px | 300 | 1.7 | 0 | Sentence | `--jedda-muted` (#686868) |
| Measurement table label | 10px | 500 | 1 | 0.08em | UPPERCASE | `--jedda-muted` |
| Measurement table value | 11px | 400 | 1.8 | 0 | — | `--jedda-ink` |
| Button text | 10px | 500 | 1 | 0.10em | UPPERCASE | (varies by state) |
| Breadcrumb | 10px | 400 | 1 | 0.04em | — | `--jedda-muted` |
| Size guide link | 10px | 400 | 1 | 0 | — | `--jedda-muted`, underline on hover |
| Error / guidance text | 11px | 400 | 1.5 | 0 | Sentence | `#c0392b` |
| Success text | 11px | 400 | 1.5 | 0 | Sentence | `--jedda-ink` |

**Design rationale:**
- The scale is deliberately tight (10–20px range). A product summary is not a billboard; it is a reference document for someone who has already decided to look closely. Large type here would fight the gallery.
- 20px for the title creates a clear hierarchy without competing with the gallery image at 817px.
- 10px uppercase with 0.10em tracking: the standard fashion-label treatment. At this small size, tracking is essential for legibility. Never uppercase without tracking.
- Weight variation (300 → 600) does more work than size variation — consistent with how luxury brands build hierarchy without noise.

---

### Color Tokens (Typography)

| Token | Value | Use |
|---|---|---|
| `--jedda-ink` | `#171717` | Primary text, product title, prices, measurements |
| `--jedda-muted` | `#686868` | Secondary text, accordion body, labels after selection |
| `--jedda-ghost` | `#a0a0a0` | Placeholder states, disabled text |
| `--jedda-line` | `#d9d7d1` | Dividers, accordion borders, swatch borders |
| `--jedda-soft` | `#f6f5f2` | Input backgrounds, hover wash |
| `--jedda-error` | `#c0392b` | Validation errors |
| `--jedda-white` | `#ffffff` | ATC button text, inverse states |

---

### Uppercase Usage Policy

Uppercase is used **only** for:
- Section/variation labels: COLOR, SIZE, DETAILS, FIT & SIZING, MATERIAL & CARE, SHIPPING & RETURNS
- Button text: ADD TO BAG, BUY NOW
- Measurement section headers: GARMENT MEASUREMENTS, RECOMMENDED BODY SIZE

Uppercase is **never** used for:
- Product title
- Body copy (accordion paragraphs, care instructions)
- Price
- Variant values (Breen, Auburn, S/M, L/XL)
- Breadcrumb text

This respects the reader. Excessive uppercase creates visual noise; reserved uppercase creates signal.

---

### Accessibility — Type

- **Minimum contrast:** 4.5:1 (WCAG AA) for all text. `#171717` on `#ffffff` = 18.1:1. `#686868` on `#ffffff` = 5.7:1. `#a0a0a0` on `#ffffff` = 3.9:1 — `--jedda-ghost` must only be used for placeholder/non-content text.
- **Minimum touch-target size:** 44×44px for all interactive text links (size guide, clear selection)
- **No text in images.** All text as DOM text.
- **Zoom:** layout must remain usable at 200% browser zoom (WCAG AA)

---

## Part 2 — Spacing System

Base unit: **8px**. All spacing is a multiple of 4px (half-unit) or 8px (full unit).

### Spacing Tokens

| Token | Value | Use |
|---|---|---|
| `--space-1` | 4px | Micro gaps (label-to-value inline, icon margins) |
| `--space-2` | 8px | Within-component gaps (label to swatch row, between swatches) |
| `--space-3` | 12px | Title to price, ATC to Buy Now |
| `--space-4` | 16px | Standard internal section padding |
| `--space-5` | 20px | Between variation rows (Color row to Size row) |
| `--space-6` | 24px | Between major sections (price → divider, swatches → ATC area, ATC → accordion) |
| `--space-8` | 32px | Summary column top padding |
| `--space-10` | 40px | Summary column horizontal padding (left side, facing gallery) |

### Summary Column Vertical Rhythm

Reading top to bottom:

```
[32px top padding]
Breadcrumb                          10px / 300
[16px]
Product title                       20px / 600
[12px]
Price                               14px / 400
[24px]
──────── divider (0.5px) ────────
[24px]
COLOR    Breen                      (label + value row)
[8px]
[swatch row]
[20px]
SIZE     S / M     Size Guide       (label + value + link)
[8px]
[swatch row]
[24px]
──────── divider (0.5px) ────────
[16px]
[Quantity — minimal, inline with label or hidden]
[12px]
ADD TO BAG                          (full-width button, 52px height)
[8px]
BUY NOW                             (full-width button, 52px height)
[24px]
──────── divider (0.5px) ────────
[0]
DETAILS         ∨                   (accordion tab)
FIT & SIZING    ∨
MATERIAL & CARE ∨
SHIPPING & RETURNS ∨
```

---

## Part 3 — Visual and Information Hierarchy

### Current Problem

The current summary is a **flat stack**. Title (16px), price (12px), accordion (280px), form (378px) — all roughly equivalent visual weight. The eye has nowhere to go first.

### V2 Hierarchy Model

**Level 1 — Immediate identity (0–300ms scan):**
Product name. Price. These must be readable without slowing down.

**Level 2 — Decision (3–10s engagement):**
Variant selector (COLOR, SIZE). The user is making a choice. The UI must be clear, zero friction.

**Level 3 — Action (decision complete):**
ADD TO BAG. BUY NOW. Must be visually prominent but not aggressive.

**Level 4 — Consideration (research phase):**
Accordion content. This is reference material for the user who wants more. It should feel calm, accessible, never demanding attention.

The current UI inverts Levels 3 and 4 — the accordion comes before the purchase action. This forces the user to scroll past editorial content before reaching the ATC button. **In V2, the accordion moves below the ATC buttons.**

### Summary Column Element Order (V2)

1. Breadcrumb navigation
2. Product title
3. Price (with sale price if applicable)
4. Divider
5. COLOR label + selected value → color swatches
6. SIZE label + selected value + Size Guide link → size swatches
7. Divider
8. ADD TO BAG button (primary)
9. BUY NOW button (secondary)
10. Divider
11. Accordion: DETAILS / FIT & SIZING / MATERIAL & CARE / SHIPPING & RETURNS

---

## Part 4 — Component Specifications

### 4.1 Breadcrumb

```
Home  /  [Category]  /  [Product]
```

- 10px / 400 / `--jedda-muted`
- Letter-spacing: 0.04em
- Separator: "  /  " (spaces around slash)
- No truncation on desktop; last item (product name) hidden on mobile (screen space)
- Not a focus point — muted and small but correct for SEO and navigation

---

### 4.2 Product Title

- Plus Jakarta Sans 600, 20px, line-height 1.25
- Letter-spacing: 0.02em (very subtle — prevents optical tightness at this weight)
- Color: `--jedda-ink`
- Title case (not uppercase, not all-lower)
- Max 2 lines — if product name exceeds 2 lines, the 20px holds and the element grows naturally
- No truncation

---

### 4.3 Price

```
Rp 519.000           (regular price)
Rp 369.000  Rp 519.000    (sale state: new price left, old price strikethrough right)
Rp 369.000 – Rp 519.000   (variable product before variant selection)
```

- Regular price: 14px / 400 / `--jedda-ink`
- Sale price (new): 14px / 400 / `--jedda-ink`
- Sale price (original, strikethrough): 12px / 300 / `--jedda-muted`, `text-decoration: line-through`
- Price range (before selection): 13px / 400 / `--jedda-muted`
- Currency symbol and amount: not separated by non-breaking space inconsistency — ensure `Rp 519.000` format is consistent

**Transition on variant select:** When a specific variant is selected, price transitions from range to specific value. CSS `transition: opacity 150ms ease` on the price element — price fades out, new value fades in (WC JS handles this via `.single_variation` element; CSS only needs the transition).

---

### 4.4 Variant Selector

#### Label row

```
COLOR    Breen
```

- "COLOR": 10px / 500 / `--jedda-ink` / uppercase / letter-spacing 0.10em
- "Breen": 10px / 400 / `--jedda-muted` — updates on selection, empty string when nothing selected
- No separator character between label and value (space is sufficient)
- Both on one line, space-between layout

#### Color swatches

- Current: text button swatches (woo-variation-swatches `button` style)
- Keep button style — clean, legible, consistent with JEDDA's no-decoration direction
- Swatch dimensions: 40px width minimum, 30px height (current), 4px border-radius (very slight softening)
- Default state: 0.5px border `--jedda-line`, `--jedda-ink` text
- Selected state: 1.5px border `--jedda-ink` (bold border, not fill)
- Hover state: no background change (WPCode #2393 already disables hover — preserve this direction, encode it in plugin CSS under V2 flag)
- Out-of-stock state: 0.5px border `--jedda-line`, `--jedda-ghost` text, `position: relative` with thin diagonal line overlay (CSS `::after` pseudo)
- Gap between swatches: 6px

#### Size swatches

- Same rules as color
- SIZE GUIDE link: 10px / 400 / `--jedda-muted`, underline on hover, inline with SIZE label (flex row, space-between). Clicking opens Fit & Sizing accordion panel.
- Out-of-stock size: same diagonal treatment as color

#### Clear selection

- Small "Clear" text link appears below each swatch row once a selection is made
- 10px / 400 / `--jedda-ghost`, underline on hover
- woo-variation-swatches supports this natively (configure in plugin settings)

---

### 4.5 Quantity

Quantity is de-emphasized in luxury fashion UX. Most premium brands (The Row, Toteme, Net-a-Porter) either hide quantity entirely (default qty = 1 and user adds again for more) or make it minimal.

**V2 recommendation:** Keep quantity input but make it visually recessive.
- Placement: small row above ADD TO BAG — "QTY" label (10px / 500 / uppercase) + `-  1  +` inline
- Height: 32px (not the full-width 55px it currently has)
- Alternatively: a simple `input[type=number]` with minimal styling, no custom stepper buttons
- If conversion data later shows quantity is rarely changed, hide it in V2.1

---

### 4.6 ADD TO BAG Button

```
ADD TO BAG
```

- Full width (100% of content column)
- Height: 52px
- Background: `--jedda-ink` (#171717)
- Text: `--jedda-white` (#ffffff)
- Text: 10px / 500 / uppercase / letter-spacing 0.10em
- Border: 1px solid `--jedda-ink`
- Border-radius: 0 (sharp corners — luxury fashion signal)
- Hover: background `#333333` (slightly lighter ink), `transition: background-color 180ms ease`
- Focus-visible: 2px outline `--jedda-ink`, outline-offset 3px
- Disabled state (no variant selected): background `--jedda-soft`, text `--jedda-ghost`, border `--jedda-line`, cursor: not-allowed
- Loading state: text changes to "ADDING..." (Sprint 2.2 behavior), `aria-busy="true"`, no spinner needed
- Out-of-stock state: text "OUT OF STOCK", disabled, background `--jedda-soft`

**Label change:** WooCommerce default is "Add to cart." V2 changes to "Add to Bag" via `woocommerce_product_single_add_to_cart_text` filter in plugin PHP. Small signal, correct register for fashion.

---

### 4.7 BUY NOW Button

```
BUY NOW
```

- Full width (100% of content column)
- Height: 52px
- Background: `--jedda-white`
- Text: `--jedda-ink`
- Text: 10px / 500 / uppercase / letter-spacing 0.10em
- Border: 1px solid `--jedda-ink`
- Border-radius: 0
- Hover: background `--jedda-soft`, `transition: background-color 180ms ease`
- Focus-visible: 2px outline `--jedda-ink`, outline-offset 3px
- Disabled state: border `--jedda-line`, text `--jedda-ghost`

The visual hierarchy between ATC (filled) and Buy Now (outline) creates clear primary/secondary relationship without repeating the same button.

---

### 4.8 Accordion

#### Structure

Four panels in fixed order:
1. DETAILS
2. FIT & SIZING
3. MATERIAL & CARE
4. SHIPPING & RETURNS

#### Behavior changes from current

| Behavior | Current | V2 |
|---|---|---|
| Open mode | Exclusive (one at a time) | Multi-open (any number simultaneously) |
| Default state | Details open | All closed |
| Mobile default | Same as desktop | All closed |
| Animation | `max-height: 0 → 800px` (imprecise) | `max-height: 0 → measured height` or clip-path |

**Why multi-open:** A user reading Fit & Sizing while cross-referencing Material & Care should not have to toggle between them. Exclusive-open was a cosmetic convention; it actively reduces usability for research-phase behaviour.

**Why all closed by default:** The accordion is Level 4 (consideration) content. Opening Details by default pushes it into Level 2 (decision) territory, which it doesn't belong to. The accordion should feel like it's waiting to be explored, not pushing content.

#### Tab header

```
DETAILS                    ∨
```

- Full width, `display: flex`, `justify-content: space-between`, `align-items: center`
- Border-top: 0.5px solid `--jedda-line` (every tab)
- Border-bottom: 0.5px solid `--jedda-line` (last tab only)
- Padding: 14px 0
- Label: 10px / 500 / uppercase / letter-spacing 0.10em / `--jedda-ink`
- Chevron icon: 12px / `--jedda-muted`, rotates 180° when open, `transition: transform 220ms ease`
- Hover: label becomes `--jedda-ink` (if already ink, no change needed), cursor: pointer
- cursor: pointer on header

#### Panel body

- `overflow: hidden`
- `max-height: 0` (closed) → `max-height: [measured content height]px` (open)
- `transition: max-height 280ms ease`
- Inner padding: `padding-bottom: 20px`

#### Accessibility

- Tab header: `<button>` element (not a `<div>` with onclick). Currently uses `onclick="jdToggle(this)"` on a `<div>` — this will be fixed in V2 rendering.
- `aria-expanded="false|true"` on button
- `aria-controls="accordion-details"` on button
- `id="accordion-details"` on panel div
- `role="region"` on panel div
- `aria-labelledby` pointing back to the button

#### Panel content — DETAILS

```
[body paragraph]
```
- 13px / 300 / `--jedda-muted` / line-height 1.7
- Data source: ACF `jedda_details_text`

#### Panel content — FIT & SIZING

```
GARMENT MEASUREMENTS (cm)

S / M                L / XL
Bust      80         Bust      86
Shoulder  41.5       Shoulder  43
F. Length 48         F. Length 51
B. Length 39         B. Length 40.5

RECOMMENDED BODY SIZE

S / M    Bust up to 84 cm
L / XL   Bust up to 89 cm
```

- Section headers: 10px / 500 / uppercase / `--jedda-muted` / letter-spacing 0.08em
- Size tag (S/M, L/XL): 11px / 500 / `--jedda-ink`
- Measurement label (Bust, Shoulder): 11px / 300 / `--jedda-muted`
- Measurement value (80, 86): 11px / 400 / `--jedda-ink`
- Grid layout: CSS grid `1fr 1fr` for the two size columns
- Recommended size: `display: flex`, `justify-content: space-between`, 11px / 400

#### Panel content — MATERIAL & CARE

```
COMPOSITION
Recycled Polyester, Viscose

CARE INSTRUCTIONS
Dry clean recommended. Machine washable on a gentle cold cycle...
```

- Headers: 10px / 500 / uppercase / `--jedda-muted`
- Composition: 12px / 400 / `--jedda-ink` — data from WC attribute `pa_material`
- Care instructions: 13px / 300 / `--jedda-muted` / line-height 1.7 — data from ACF `jedda_care_instructions`
- Thin rule between composition and care: 0.5px / `--jedda-line`

#### Panel content — SHIPPING & RETURNS

Same typography as DETAILS body. Data from ACF Options Page (global).

Four sections: Shipping / Returns & Exchanges / Size Exchange After Delivery / Pre-Order Items
Each section: 10px / 500 / uppercase header + 13px / 300 / `--jedda-muted` body

---

### 4.9 Interaction States Summary

| Element | Default | Hover | Focus | Active | Disabled | Loading |
|---|---|---|---|---|---|---|
| Swatch (unselected) | 0.5px `--jedda-line` border | No background change | 2px outline | — | Diagonal overlay, `--jedda-ghost` text | — |
| Swatch (selected) | 1.5px `--jedda-ink` border | — | — | — | — | — |
| ADD TO BAG | filled `--jedda-ink` | `#333333` bg | 2px outline | — | `--jedda-soft` bg | "ADDING..." text, `aria-busy` |
| BUY NOW | outline `--jedda-ink` | `--jedda-soft` bg | 2px outline | — | `--jedda-line` border | — |
| Accordion tab | closed | cursor:pointer | 2px outline | open, chevron rotated | — | — |
| Price | static | — | — | variant price fades in | — | opacity fade |

---

## Part 5 — Behavior Specifications

### 5.1 Sticky Summary (Desktop)

**Problem:** At desktop (1512px viewport), the gallery image is 817px × ~1225px (2:3 portrait). The summary column is 757px tall. As the user scrolls, the summary disappears before the gallery ends. The user must scroll back up to make a purchase decision.

**Solution:** `position: sticky; top: [header-height + 24px]` on the summary column.

- Applies only at `≥1024px` (Foundation large breakpoint)
- Sticky container: `.de-product-single__summary--philo`
- `align-self: flex-start` required on the sticky element (parent must be `display: flex` or `display: grid` — verify Upscale's Philo layout container)
- Top offset: Upscale header height must be measured. Current header appears to be ~60–80px. Use CSS custom property `--jedda-header-height` set by JS measurement on load.
- The sticky summary scrolls with the page until top offset is reached, then pins
- When gallery ends (user scrolls below the product container), sticky releases

**Implementation note:** Verify Upscale's `.de-product-single__container--inner` uses flexbox or grid. If it uses Foundation float-based layout, `position: sticky` on a floated element does not work — requires adding `display: flex` to the container, which may affect the Philo layout. This is a dependency to validate in 2.8.3 (Foundation phase).

### 5.2 Mobile Behavior (≤768px)

- Foundation stacks columns: gallery full-width above, summary full-width below
- Sticky: disabled (not enough viewport height to justify)
- All accordion panels: closed by default (open on desktop too — all closed)
- Gallery counter (mobile): already rendered by Sprint 2 JS / plugin JS — preserve
- Breadcrumb: product name segment hidden (too much space); category remains
- Quantity: hidden on mobile if quantity UX is de-emphasized
- Button heights: 52px maintained (sufficient for touch targets)
- Swatch minimum touch target: current swatches at 30px height. V2 must set `min-height: 44px` on swatch list items for WCAG AA touch target compliance. Width at 40px minimum.

### 5.3 Variant Selection UX Flow

```
Page loads
  → All swatches inactive
  → Price shows range (if variable) or specific price (if single)
  → ATC button: disabled
  → Label shows: "COLOR  " | "SIZE  "

User selects COLOR (e.g., Breen)
  → Breen swatch: selected state (1.5px border)
  → Label updates: "COLOR  Breen"
  → Gallery images refresh to Breen colorway images
  → Gallery: opacity 0.7 during load → opacity 1.0 on complete (150ms transition)
  → Price: if color affects price, update via WC JS

User selects SIZE (e.g., S/M)
  → S/M swatch: selected state
  → Label updates: "SIZE  S / M"
  → ATC button: enabled (all required variants selected)
  → Price: updates to specific variant price (fade transition)

User clicks ADD TO BAG (all variants selected)
  → Sprint 2.2: button → "ADDING...", aria-busy="true"
  → WC processes cart addition
  → Sprint 2.3: success feedback inline
  → Button returns to "ADD TO BAG" state

User clicks ADD TO BAG (variant missing)
  → Sprint 2.1: validation fires, label guidance appears
  → Button does not submit
  → Cart count unchanged
```

### 5.4 Size Guide Link Behavior

Clicking "Size Guide" (next to SIZE label) opens the FIT & SIZING accordion panel:
1. Panel opens (if closed)
2. Page scrolls to bring the panel into view (smooth scroll)
3. No navigation away from page

Implementation: JS event listener on the Size Guide link. `document.querySelector` for the Fit & Sizing panel button → trigger click if closed → `scrollIntoView({ behavior: 'smooth', block: 'nearest' })`.

---

## Part 6 — Loading, Error, and Success States

### 6.1 Loading States

| Trigger | Element | Behavior |
|---|---|---|
| Page load | None | No skeleton/shimmer — content is server-rendered |
| Variant select → gallery update | Gallery images | `opacity: 0.7` during load, `1.0` on complete. Transition: 150ms ease |
| Variant select → price update | Price | WC JS updates `.single_variation` — add `transition: opacity 150ms ease` to price element |
| ATC click | ADD TO BAG button | "ADDING..." text, `aria-busy="true"` (Sprint 2.2 — preserve) |

### 6.2 Error States

| Trigger | Element | Behavior |
|---|---|---|
| ATC click, no variant selected | Guidance text below swatches | Sprint 2.1: inline message "Please select a [Color / Size]" — preserve |
| Variant is out of stock | Swatch | Diagonal overlay, `--jedda-ghost` text, unselectable |
| Network error on ATC | ADD TO BAG button | Return to "ADD TO BAG" state, show inline error message below button: "Something went wrong. Please try again." (11px / 400 / `--jedda-error`) |

Network error state is not currently handled. Sprint 2.3 handles success; a complementary error handler should be added in 2.8.4 implementation.

### 6.3 Success States

Sprint 2.3 handles ATC success feedback. Preserve the behavior exactly. In V2, the success message styling should be updated to match the new typography (11px / 400 / `--jedda-ink`).

---

## Part 7 — Animation Philosophy

**One rule:** The interface responds without calling attention to itself.

| Property | Duration | Easing | Notes |
|---|---|---|---|
| Button background on hover | 180ms | ease | Subtle, immediate response |
| Button border on hover | 180ms | ease | |
| Accordion open/close (height) | 280ms | ease | Slightly longer — content deserves a moment |
| Accordion chevron rotate | 220ms | ease | |
| Gallery opacity on variant change | 150ms | ease | Fast — implies refresh, not loading |
| Price opacity on variant select | 150ms | ease | |
| Swatch border on select | 120ms | ease | Near-instant — direct feedback |
| Sticky: no animation | — | — | Sticky transition should be instant |

**Never use:** bounce, spring, elastic, scale, rotate (except accordion chevron), translate-Y (except native scrolling). No entry animations on page load. No hover transforms on buttons or swatches.

---

## Part 8 — Accessibility Specification

### Keyboard Navigation

- Tab order: Breadcrumb → Title (non-interactive) → Price (non-interactive) → Color swatches → Size swatches → Size Guide link → Quantity → ADD TO BAG → BUY NOW → Accordion tabs (in order)
- Color swatches: `role="radiogroup"` / `role="radio"` — arrow keys navigate between options
- Size swatches: same
- Accordion tabs: `role="button"` (native `<button>` element), Enter/Space to toggle
- All focus states: visible 2px outline, `outline-offset: 2px`, color `--jedda-ink`
- Never `outline: none` or `outline: 0` without a visible focus-visible replacement

### Screen Reader Semantics

| Element | Semantic |
|---|---|
| Product title | `<h1>` (on product page — change from current `<h2>`) |
| Price | `<p aria-label="Price: Rp 519.000">` |
| COLOR label | `<fieldset><legend>Color</legend>` wrapping swatches |
| SIZE label | `<fieldset><legend>Size</legend>` wrapping swatches |
| Color swatch | `<input type="radio" name="color" value="Breen" aria-label="Breen">` — woo-variation-swatches renders `<li>` elements; may need `aria-role` augmentation |
| Accordion tab | `<button aria-expanded="false" aria-controls="panel-details">DETAILS</button>` |
| Accordion panel | `<div id="panel-details" role="region" aria-labelledby="tab-details">` |
| ATC button | `<button aria-disabled="true">` when disabled (not `disabled` attr, which removes from tab order) |

**Note:** `<h1>` for product title. The current implementation uses `<h2>`. On a product page, the product name IS the page `<h1>`. Upscale renders `<h2>` — V2 should either change this or add `aria-level="1"` to the `<h2>`. Changing to `<h1>` is the semantically correct approach. This must be implemented via PHP filter overriding Upscale's title template.

### Color Accessibility

- `#171717` on `#ffffff`: 18.1:1 — AAA
- `#686868` on `#ffffff`: 5.7:1 — AA
- `#a0a0a0` on `#ffffff`: 3.9:1 — fails AA for body text. `--jedda-ghost` must only be used for placeholder/non-content text (e.g., empty input placeholders, which have a special exemption in WCAG 2.1)
- Swatch borders: `--jedda-line` (#d9d7d1) is a UI element border, not text — does not need to meet contrast threshold under WCAG 2.1

---

## Part 9 — Responsive Behavior

### Breakpoints (Foundation)

| Breakpoint | Width | Behaviour |
|---|---|---|
| small | 0–767px | Single column, summary below gallery |
| medium | 768–1023px | Still single column in Foundation Philo layout (verify) |
| large | 1024px+ | Two-column: gallery (large-7) + summary (large-5) |

### Responsive Rules

| Element | ≥1024px | <768px |
|---|---|---|
| Summary column | `position: sticky; top: [header + 24px]` | Normal flow |
| Product title | 20px | 18px |
| Accordion | All closed | All closed |
| Breadcrumb | Full path | Category only |
| Summary padding-left | 40px (gap from gallery) | 0 (or theme default) |
| Button height | 52px | 52px (unchanged — already good touch target) |
| Swatch height | 30px (current) → 36px (V2, better touch) | 44px minimum |
| Gallery counter | Hidden | Visible (Sprint 2 JS) |

---

## Part 10 — Complete CMS Architecture

This section defines, for every piece of data visible in the Product Summary, exactly where it should live and how it should be managed.

### Governing Principles

1. WooCommerce native data for commerce-functional data (price, stock, variations, attributes)
2. ACF for editorial content (descriptions, measurements, care copy)
3. Taxonomies for categorical tag-like data (badges, material classification)
4. ACF Options Page for global policy content (same across all products)
5. Zero data in `post_excerpt` HTML (short description becomes plain text only)
6. Zero data in WPCode/Code Snippets snippets (configuration and logic only in plugin)

---

### Data Map — Complete

#### Product Title
| Property | Value |
|---|---|
| Data | `wp_posts.post_title` |
| Level | Product-level |
| Architecture | WooCommerce native |
| Admin | Products → Edit → Product name |
| Notes | No change from current |

#### Price
| Property | Value |
|---|---|
| Data | `_price`, `_regular_price`, `_sale_price` WC meta |
| Level | Product-level; per-variation for variable products |
| Architecture | WooCommerce native |
| Admin | Products → Edit → General (simple) or Variations tab |
| Notes | No change from current |

#### Color Options
| Property | Value |
|---|---|
| Data | WC product attribute "Color" |
| Level | Product-level (terms are global) |
| Architecture | WooCommerce global attribute `pa_color` |
| Admin | Products → Edit → Attributes |
| Recommendation | Convert to global attribute (`pa_color`) if not already — enables future shop filtering |

#### Size Options
| Property | Value |
|---|---|
| Data | WC product attribute "Size" |
| Level | Product-level |
| Architecture | WooCommerce global attribute `pa_size` |
| Admin | Products → Edit → Attributes |

#### Variation Stock and Price
| Property | Value |
|---|---|
| Data | WC variation meta (native) |
| Architecture | WooCommerce native |
| Admin | Products → Edit → Variations tab |

#### Product Details Paragraph
| Property | Value |
|---|---|
| Data | ACF field `jedda_details_text` (Textarea) |
| Level | Product-level |
| Architecture | ACF Pro |
| Admin | Products → Edit → **Product Details** (ACF field group) |
| Migrating from | `post_excerpt` hardcoded HTML |

#### Material Composition
| Property | Value |
|---|---|
| Data | WC global attribute `pa_material` |
| Level | Product-level (terms global: "Recycled Polyester", "Viscose", "Cotton", etc.) |
| Architecture | WooCommerce global attribute |
| Admin | Products → Edit → Attributes → Material |
| Why WC attribute not ACF | Material is categorical data that may be used for filtering ("Shop Sustainable"), querying, or display in search results. WC attributes are the correct primitive. ACF is for free-text editorial content. |
| Notes | Multiple values per product (e.g., "Recycled Polyester" + "Viscose") — use comma-separated or multiple terms |

#### Care Instructions
| Property | Value |
|---|---|
| Data | ACF field `jedda_care_instructions` (Textarea) |
| Level | Product-level |
| Architecture | ACF Pro |
| Admin | Products → Edit → **Care Instructions** |
| Migrating from | `post_excerpt` hardcoded HTML |

#### Size Measurements (garment cm table)
| Property | Value |
|---|---|
| Data | ACF Repeater `jedda_sizes` |
| Level | Product-level |
| Architecture | ACF Pro (Repeater — requires ACF Pro) |
| Sub-fields | `jedda_size_label` (Text), `jedda_size_bust` (Number), `jedda_size_shoulder` (Number), `jedda_size_front_length` (Number), `jedda_size_back_length` (Number) |
| Admin | Products → Edit → **Size Measurements** → + Add Size row |
| Notes | Each row = one size. Admin adds rows for each size (S/M, L/XL). Simple, labelled, no HTML. |

#### Recommended Body Size
| Property | Value |
|---|---|
| Data | ACF Repeater `jedda_rec_sizes` |
| Level | Product-level |
| Architecture | ACF Pro (Repeater) |
| Sub-fields | `jedda_rec_label` (Text), `jedda_rec_bust_max` (Text) |
| Admin | Products → Edit → **Recommended Body Size** → + Add row |

#### Shipping Policy
| Property | Value |
|---|---|
| Data | ACF Options Page field `jedda_shipping_policy` (Textarea) |
| Level | **Global** — same for all products |
| Architecture | ACF Options Page ("Jedda Policy") |
| Admin | WP Admin → **Jedda Policy** → Shipping |
| Why global | Shipping terms do not vary per product. Per-product copy-paste means a policy change requires editing every product. Global = edit once. |

#### Returns & Exchanges Policy
| Property | Value |
|---|---|
| Data | ACF Options Page `jedda_returns_policy` |
| Level | Global |
| Architecture | ACF Options Page |
| Admin | WP Admin → Jedda Policy → Returns |

#### Size Exchange After Delivery Policy
| Property | Value |
|---|---|
| Data | ACF Options Page `jedda_size_exchange_policy` |
| Level | Global |
| Architecture | ACF Options Page |

#### Pre-Order Policy
| Property | Value |
|---|---|
| Data | ACF Options Page `jedda_preorder_policy` |
| Level | Global |
| Architecture | ACF Options Page |
| Notes | Different from Pre-Order Badge (below) — this is the policy text, not the badge label |

#### Pre-Order / New Arrival Badge
| Property | Value |
|---|---|
| Data | Custom taxonomy `jedda_badge` |
| Level | Product-level (terms: "Pre-Order", "New Arrival", "Restocked", "Limited Edition") |
| Architecture | Custom taxonomy registered in `jedda-commerce-ui` plugin |
| Admin | Products → Edit → **Product Badge** (taxonomy checkbox) |
| Current state | WPCode snippets #3613, #5163, #5152 |
| Migration | Register taxonomy in plugin. Assign terms to products. Plugin renders badge overlay on gallery. Remove WPCode badge snippets under PDP V2 flag. |
| Why taxonomy not ACF | Badges are categorical, have a finite set of values, and may be used for filtering (shop by Pre-Order). Taxonomies are the correct WordPress primitive for this. ACF would be a text field which offers no constraint, no filtering, and no reuse. |

#### Out-of-Stock Button and CSS States
| Property | Value |
|---|---|
| Current | WPCode #2384 (button logic), WPCode #2378 (CSS) |
| Architecture | WC native stock status (`_stock_status`). Logic and CSS in `pdp-v22.css` under PDP V2 flag. |
| Migration | Migrate OOS styling to plugin CSS. Keep WPCode snippets active until V2 is fully approved and live, then deactivate. |

#### Buy Now Sold-Out Guard
| Property | Value |
|---|---|
| Current | WPCode #13041 |
| Architecture | Migrate JS logic to `pdp-v2.js` under PDP V2 flag |
| Migration | After V2 goes live and is stable, deactivate WPCode #13041 |

#### Variation Label Font (Jost → Plus Jakarta Sans)
| Property | Value |
|---|---|
| Current | WPCode #13040 injects Jost 11px for variation labels |
| Architecture | Plugin CSS under PDP V2 flag — variation label styles in `pdp-v22.css` |
| Migration | V2 CSS overrides WPCode #13040 styles. After V2 fully live, deactivate WPCode #13040. |

#### Sprint 2 Interaction Behaviors (#13, #18, #19)
| Property | Value |
|---|---|
| Current | Code Snippets active on PDP |
| Architecture | Preserve as-is during V2. These work correctly and are stable. |
| Long-term | After PDP V2 is the permanent state (post-launch), migrate these behaviors into plugin JS and deactivate Code Snippets. |

---

### ACF Field Group JSON Structure

Field groups should be defined in PHP (not database) using `acf_add_local_field_group()` in `includes/class-acf-fields.php`. This keeps field definitions version-controlled in the plugin.

JSON export (for ACF admin sync) will live at `jedda-commerce-ui/acf-json/`.

Field group key: `group_jedda_product_details`
Location rule: Post Type = product

---

### Plugin Architecture for V2

The current plugin (`jedda-commerce-ui.php`) is a single file. As V2 complexity grows (ACF integration, taxonomy registration, template rendering, hook management), a directory structure is required before implementation begins:

```
jedda-commerce-ui/
  jedda-commerce-ui.php          ← bootstrap: autoload, define constants, init classes
  includes/
    class-assets.php             ← enqueue CSS/JS/fonts
    class-pdp.php                ← PDP V2 hooks, woocommerce_single_product_summary rendering
    class-acf-fields.php         ← acf_add_local_field_group() definitions
    class-acf-options.php        ← ACF Options Page "Jedda Policy"
    class-taxonomy.php           ← register jedda_badge taxonomy
    class-woocommerce.php        ← WC filters (ATC text, price display, product title h1)
  templates/
    pdp/
      summary-accordion.php      ← accordion HTML template
      summary-variants.php       ← variant form template (if overriding)
  assets/
    css/
      pdp-v22.css                ← V2 styles (new filename per LiteSpeed cache rule)
    js/
      pdp-v2.js                  ← updated JS (accordion, size guide link, network error)
    fonts/
      plus-jakarta-sans/
        PlusJakartaSans-Light.woff2
        PlusJakartaSans-Regular.woff2
        PlusJakartaSans-Medium.woff2
        PlusJakartaSans-SemiBold.woff2
  acf-json/
    group_jedda_product_details.json
    group_jedda_policy_options.json
```

This refactor is **Milestone 2.8.3 task 0** — restructure the plugin before adding ACF integration. The refactor should not change any behaviour; it is organisational only.

---

## Part 11 — Environment Blockers

The following must be resolved before implementation begins. Per the permanent environment blocker policy, these are reported explicitly rather than worked around.

### Blocker 1 — ACF Pro Not Installed

**What:** ACF Pro is not currently active on staging. ACF Free is potentially available via WP plugin directory but Repeater and Options Page require Pro.

**Impact:** Milestone 2.8.3 (content migration) cannot proceed without ACF Pro. Without Repeater, size measurement tables cannot be structured. Without Options Page, global policy cannot be centralised.

**Cost:** ~$49/yr. One-time purchase.

**Resolution:** Purchase ACF Pro license at `advancedcustomfields.com`. Install on staging. Do not install on main site yet.

**Temporary workaround:** If ACF Pro is delayed, Phase 1 (plugin restructure + fonts) can proceed without it. Repeater-dependent phases (2.8.3+) block until ACF Pro is active.

### Blocker 2 — WPCode #11836 "Untitled Snippet" (Pre-existing, still open)

**What:** A snippet named "Untitled Snippet" runs in `site_wide_header` on every page including the PDP. Content not inspected.

**Impact:** Unknown. If this snippet affects PDP elements that V2 will redesign, it may conflict silently. If it handles critical business logic, removing it would break something.

**Resolution:** Review in WPCode admin (WP Admin → WPCode → Snippets → find ID 11836). Name it, document its purpose in `.jedda/`, and determine whether it needs to be preserved, migrated, or deactivated.

### Blocker 3 — Sticky Summary Requires Container Flexbox Audit

**What:** `position: sticky` on a child element only works if the parent is `display: flex` (with `align-items: flex-start`) or `display: block`. Upscale's Philo layout uses Foundation's grid, which may use floats.

**Impact:** If Foundation uses CSS floats for `.large-7` / `.large-5` columns, sticky will silently fail. This must be verified by inspecting `display` on `.de-product-single__container--inner` in the browser before implementation.

**Resolution:** During 2.8.3 foundation phase, inspect and document the container display value. If floated, either: (a) add `display: flex; align-items: flex-start` to the container under the PDP V2 scoped selector, or (b) accept that sticky is not available in this layout and use an alternative (JS-controlled sticky wrapper).

### Blocker 4 — `<h1>` vs `<h2>` for Product Title

**What:** Upscale renders product title as `<h2>`. Semantic HTML requires `<h1>` on product page. Changing to `<h1>` requires a Upscale hook or template override.

**Impact:** Accessibility (screen reader landmark hierarchy) and SEO. Not a visual blocker but an architectural one for V2.

**Resolution:** Add `woocommerce_product_title_tag` filter in plugin PHP (if Upscale exposes it) or override via `woocommerce_template_single_title` hook.

---

## Summary — What Must Be Decided Before 2.8.3 Begins

| # | Decision | Status |
|---|---|---|
| 1 | Plus Jakarta Sans | **Approved** |
| 2 | ACF Pro as data layer | **Approved (direction)** |
| 3 | Purchase ACF Pro | Owner action required |
| 4 | WPCode #11836 review | Owner action required |
| 5 | Multi-open accordion | Proposed in this doc — confirm |
| 6 | "Add to Bag" vs "Add to Cart" | Proposed — confirm |
| 7 | Product title as `<h1>` | Proposed — confirm |
| 8 | Quantity visible or hidden on mobile | Proposed hidden — confirm |
| 9 | All accordion panels closed by default | Proposed — confirm |

---

## Milestone 2.8.2 — Complete
**Awaiting founder confirmation of UX decisions and ACF Pro purchase before Milestone 2.8.3 (Foundation) begins.**
