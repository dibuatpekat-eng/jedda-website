# JEDDA Commerce UI

Git-owned commerce presentation layer for JEDDA.

Milestone 2.6 starts Product Page V2 as a product-page-only enhancement module. The plugin preserves WooCommerce, Midtrans, Epeken, cart, checkout, payment, order, and stock logic.

## Product Page V2

PDP V2 is enabled only when:

- `JEDDA_PDP_V2_ENABLED` is defined as `true`, or
- the `jedda_pdp_v2_enabled` option is set to `1`.

PDP V2 is disabled when:

- `JEDDA_PDP_V2_DISABLED` is defined as `true`, or
- the `jedda_pdp_v2_enabled` option is set to `0`, or
- browser localStorage contains `jedda:disable-pdp-v2 = 1`.

The browser kill switch is intentionally secondary. The server-side constant or option is the preferred rollback path.

PDP V2 is disabled by default. Do not auto-enable by staging hostname.

## Scope Guardrails

- Product pages only.
- Presentation and product-page interaction helpers only.
- No checkout changes.
- No cart logic changes.
- No payment changes.
- No shipping/rate changes.
- No stock/order changes.
- No `MutationObserver`.
