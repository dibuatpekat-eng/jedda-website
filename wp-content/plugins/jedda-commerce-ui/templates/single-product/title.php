<?php
/**
 * Single product title — JEDDA PDP V2 override.
 *
 * Renders the product title as <h1> instead of Upscale's <h2>.
 * Applied only when jedda_pdp_v2_enabled is active.
 *
 * @package JeddaCommerceUI
 */

defined('ABSPATH') || exit;

the_title('<h1 class="product_title entry-title">', '</h1>');
