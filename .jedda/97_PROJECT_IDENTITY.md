# Project Identity

Status: Long-term identity and design direction summary.
Last updated: 2026-06-29.

## Brand Direction

JEDDA should feel like quiet editorial commerce:

- Image-first.
- Minimal but not under-designed.
- Premium but not decorative.
- Calm but responsive.
- Sparse but reassuring where sizing, stock, cart, payment, and delivery are involved.

The website should not feel like a generic WooCommerce theme with fashion images. It should feel like a composed JEDDA retail experience.

## Primary Visual References

Use these as visual direction, not copy targets:

- Toteme
- SSSTEIN
- Nothing Written
- MOIA Seoul

Reference translation:

- From Toteme: commerce completeness and precise state handling.
- From SSSTEIN: restraint, product-grid discipline, quiet PDP hierarchy.
- From Nothing Written: practical product information with subtle editorial tone.
- From MOIA Seoul: whitespace, image confidence, calm navigation, mobile catalog rhythm.

## Product Page V2 North Star

The Product Page should feel like a quiet fitting appointment.

It must answer:

1. What is this piece?
2. What does it cost?
3. What color and size am I choosing?
4. Is it available?
5. What happens when I add it to cart?
6. What is it made of and how does it fit?
7. How do shipping, returns, and care work?
8. What should I look at next?

## What Premium Means Here

Premium is not smaller text.

Premium is:

- Correct image scale.
- Strong proportion.
- Legible typography.
- Clear hierarchy.
- Calm local feedback.
- Complete states.
- No raw platform leftovers.
- No uncertain clicks.
- No layout compression.

## Architecture Identity

JEDDA keeps the existing commerce engine:

- WooCommerce for commerce.
- Midtrans for payment.
- Epeken for shipping/rates.
- Upscale theme as functional base only.

New presentation layers should gradually move into Git-owned code through `jedda-commerce-ui`.

## Working Relationship

The AI engineer should reduce founder cognitive load by making low-risk, reversible, staging-only decisions, but must ask before:

- Production changes.
- Payment changes.
- Checkout/order/customer data changes.
- Security changes.
- Destructive database operations.
- Plugin removal or updates.
- Major architecture shifts.

For PDP V2 visual work, approval is required between components.
