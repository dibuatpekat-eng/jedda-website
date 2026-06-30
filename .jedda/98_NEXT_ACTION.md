# Next Action

Status: Milestone 2.8.4 complete. Pre-2.8.5 cleanups done. SSH key generated — awaiting hPanel upload. No engineer blockers.
Last updated: 2026-06-30.

## SSH Setup (Required Before 2.8.5 Deploys)

SSH key pair generated. Public key needs to be added to Hostinger hPanel by the site owner.

**Key facts:**
- Port 22: CLOSED/FILTERED from current network — DO NOT USE
- Port 65002: OPEN and reachable ✅
- Private key: `~/.ssh/id_ed25519_jedda_server` (on this machine)
- SSH alias configured: `ssh jedda-staging` (see `~/.ssh/config`)

**Steps to activate SSH (owner action):**

1. Log in to [hpanel.hostinger.com](https://hpanel.hostinger.com)
2. Select the `jeddawear.com` hosting plan
3. Go to: **Advanced → SSH Access**
4. Make sure SSH is **Enabled** (toggle it on if needed)
5. Click **Add SSH Key**
6. Paste this public key exactly:
   ```
   ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIAEJG/d2AOYB3rLFCAi+t91xdq5uaqyHyNELNo62ukzR jedda-staging-deploy
   ```
7. Give it a name like `jedda-staging-deploy` and save

**Test after key is uploaded:**
```bash
ssh jedda-staging "echo SSH_OK && whoami"
```
Expected output: `SSH_OK` then `u422677730`

**Once SSH works, immediately do:**
- Fix `class-acf-fields.php` — remove `if (! function_exists('acf')) { return; }` guard, then deactivate WPCode #13967
- Purge LiteSpeed static cache for `pdp-v24.css`, then deactivate WPCode #13968

**WP-CLI (available once SSH works):**
```bash
ssh jedda-staging "cd /home/u422677730/domains/jeddawear.com/public_html/beta && wp cache flush"
```

## Cleanup (Pending SSH)

- **WPCode #13967** (ACF JSON Loader): Active workaround for `class-acf-fields.php` bug. Diagnostic `admin_notices` block already stripped (2026-06-30). Deactivate once SSH available and plugin code fixed.
- **WPCode #13968** (pdp-v24 CSS override): Active workaround for LiteSpeed static file cache. Deactivate once SSH available and LiteSpeed cache purged. Note: LiteSpeed strips `?ver=` query strings from static files at the server level — version string bumps do NOT bust cache. Only new filenames or SSH cache purge work.

## Owner Actions Required (Content Entry)

### 1. Enter Kiro Cropped Vest product data in WP Admin

Go to: WP Admin → Products → Kiro Cropped Vest → Edit → scroll to "Jedda Product Data" meta box

Fill:
- **Details** (textarea): Product description for the DETAILS accordion (plain text, no HTML)
- **Composition** (text): e.g. `100% Viscose` or `Shell: 100% Linen, Lining: 100% Polyester`
- **Care Instructions** (textarea): One instruction per line (e.g. `Dry clean only`, `Do not bleach`)
- **Garment Measurements** (repeater): One row per size option (S/M, L/XL). Columns: Size, Bust (cm), Shoulder (cm), Front (cm), Back (cm)
- **Recommended Body Size** (repeater): One row per size option. Columns: Size, Bust up to (cm), Height (cm)

### 2. Enter global policy text in WP Admin

Go to: WP Admin → WooCommerce → Jedda Policy

Fill:
- **Shipping Policy**: Delivery times, courier, free shipping threshold
- **Returns & Exchanges**: Return window, condition requirements
- **Size Exchange After Delivery**: Specific size exchange terms
- **Pre-Order Policy**: Pre-order lead time, payment terms (leave blank if no pre-order products currently)

### 3. Rename WPCode #11836 (low priority)

Go to: WP Admin → WPCode → Snippets → find snippet ID 11836
Rename to: `My Account: Remove Payment Request Text`

## Next Milestone → 2.8.5 (Template + Typography)

Ready after content is entered in WP Admin and SSH is confirmed working.

Scope:
1. PHP template to render ACF fields inside accordions (details, composition, care, measurements, policy)
2. Plus Jakarta Sans applied to product title, price, labels, accordion, body
3. Accordion moved below ATC buttons (DETAILS/FIT & SIZING/MATERIAL & CARE/SHIPPING & RETURNS)
4. Multi-open accordion (all closed by default)
5. Interaction layer redesign: color/size/qty/ATC/Buy Now/hover/active/disabled/loading/success/validation/focus/transitions
6. **Slick vertical thumbnail strip**: re-initialize thumbnail slider with `vertical: true` + `slidesToShow: N`. Current Slick config is horizontal (one slide at a time). Vertical mode required for visible image strip.

## Full Milestone Sequence

| Milestone | Name | Status |
|---|---|---|
| 2.8.0 | Product Summary Reverse Engineering | ✅ Complete |
| 2.8.1 | Architecture | ✅ Complete — approved |
| 2.8.2 | Blueprint | ✅ Complete — approved |
| 2.8.3 | Foundation (plugin restructure + fonts + taxonomy + WC filters) | ✅ Complete — deployed |
| 2.8.4 | CMS Architecture + Gallery Thumbnail Upgrade | ✅ Complete — deployed |
| 2.8.5 | Template + Typography + Interaction Layer | After SSH confirmed + content entry |
| 2.8.6 | Full Rollout | After 2.8.5 approval |
