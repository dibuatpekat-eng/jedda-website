<?php
/**
 * ACF Options Page — "Jedda Policy" global fields.
 *
 * Requires: ACF Pro (Options Page feature).
 * Status: PLACEHOLDER — ACF Pro not yet installed.
 *
 * Fields to be defined (Milestone 2.8.4):
 *   jedda_shipping_policy        Textarea   Shipping policy (all products)
 *   jedda_returns_policy         Textarea   Returns & Exchanges (all products)
 *   jedda_size_exchange_policy   Textarea   Size Exchange After Delivery
 *   jedda_preorder_policy        Textarea   Pre-Order Items policy
 *
 * Once registered, these appear at: WP Admin → Jedda Policy
 * Editors update policy text once; all products reflect the change.
 *
 * @package JeddaCommerceUI
 */

if (! defined('ABSPATH')) {
	exit;
}

class Jedda_ACF_Options {

	public static function init() {
		// Options page registered here once ACF Pro is installed.
		// add_action('acf/init', array(__CLASS__, 'register_options_page'));
	}
}
