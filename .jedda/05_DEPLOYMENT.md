# Deployment

Status: First read-only staging audit completed on 2026-06-28.

## Environments

- VERIFIED: Staging site is `https://beta.jeddawear.com`.
- VERIFIED: Production was not accessed during Phase 1.
- VERIFIED: WordPress admin access used during Phase 1 was for staging only.
- VERIFIED: The staging WordPress install lives under a server path containing `/public_html/beta/`.
- ASSUMPTION: Production likely lives separately from the `/beta/` path, but production path and deployment flow are not verified.

## Current Staging Safety

- VERIFIED: Public unauthenticated staging homepage displays a coming-soon page.
- VERIFIED: WooCommerce Site Visibility admin setting shows `Live`, despite public coming-soon behavior.
- VERIFIED: WordPress Reading Settings does not discourage search engines from indexing.
- VERIFIED: `https://beta.jeddawear.com/robots.txt` returns `User-agent: *` and `Disallow: /`, so crawlers are currently blocked at robots.txt level.
- VERIFIED: Midtrans is in sandbox mode.
- VERIFIED: WooCommerce customer and admin emails are enabled.
- VERIFIED: YaySMTP mail delivery is not globally disabled; `Disable delivery` is unchecked.
- VERIFIED: YaySMTP logs show mixed results: recent test/user-registration messages failed, while multiple WooCommerce order/customer emails earlier on 2026-06-28 logged `Success`.
- VERIFIED: Staging can accidentally send real customer/admin emails if SMTP succeeds.
- NOT VERIFIED: Whether Hostinger/staging layer blocks all public shop/product/cart/checkout URLs for unauthenticated visitors.

## Staging Safety Fix Plan

- Recommended first fix: do not rely only on WordPress `Discourage search engines from indexing this site`; keep or add server/hosting-level staging protection because robots.txt already blocks all crawlers and public visitors see a coming-soon gate.
- Recommended indexing investigation: reproduce the WordPress Reading Settings save error only after a backup/safe window, then inspect server/WAF/PHP error logs for the `options.php` POST. Do not force-save through the browser until the cause is known.
- Recommended email fix before checkout testing: enable a staging-only mail block/capture approach, such as YaySMTP disable delivery, redirect-all-to-internal mailbox, or hosting-level SMTP block. The current state is not safe because prior WooCommerce emails logged `Success`.
- Recommended payment approach: Midtrans sandbox is safe for checkout testing. Use Midtrans Bank Transfer / Virtual Account first because it avoids real card or e-wallet credentials; complete payment only through Midtrans sandbox tools/instructions if needed.

## Release/Deployment Rules

- VERIFIED: Documentation requires staging-first work and explicit approval before production changes.
- VERIFIED: No deployment was performed during Phase 1.
- VERIFIED: No code, WordPress settings, plugins, products, stock, orders, coupons, pages, menus, shipping, payment, or email settings were changed during Phase 1.
- ASSUMPTION: Future deployment should be treated as high-risk until hosting access, backup/restore process, staging-to-production flow, and rollback plan are documented.

## Access That Would Improve Later Engineering

- LATER: Hosting/staging panel access would help verify staging isolation, backups, PHP settings, cron, caching, SMTP, and deployment/rollback paths.
- LATER: Read-only SFTP or theme/plugin source access would help map parent theme overrides, WPCode/Code Snippets logic, and any file-level customizations.
- LATER: Midtrans dashboard read-only access would help verify sandbox/production notification URLs and finish URLs before checkout testing.
- LATER: SMTP/YaySMTP read-only logs/settings would help confirm whether staging emails can reach real customers.
- NOT NEEDED NOW: These were not required to complete the first browser/admin read-only audit.
