<?php
/**
 * ACF Options Page — "Jedda Policy" global fields.
 *
 * Policy fields are global: edit once, all products reflect the change.
 * Field group is defined in acf-json/group_jedda_policy.json and loaded
 * via ACF's native JSON sync (configured in class-acf-fields.php).
 *
 * Appears in WP Admin under WooCommerce → Jedda Policy.
 *
 * Page slug:  jedda-policy
 * Capability: manage_woocommerce
 *
 * Fields (defined in group_jedda_policy.json):
 *   jedda_shipping_policy        Shipping policy (all products)
 *   jedda_returns_policy         Returns & Exchanges (all products)
 *   jedda_size_exchange_policy   Size Exchange After Delivery
 *   jedda_preorder_policy        Pre-Order Items policy (shown conditionally)
 *
 * Usage: get_field('jedda_shipping_policy', 'option')
 *
 * Requires: ACF Pro (Options Page feature).
 *
 * @package JeddaCommerceUI
 */

if (! defined('ABSPATH')) {
	exit;
}

class Jedda_ACF_Options {

	public static function init() {
		if (! function_exists('acf_add_options_page')) {
			return;
		}
		add_action('acf/init', array(__CLASS__, 'register_options_page'));
		add_filter('acf/settings/save_json', array(__CLASS__, 'save_json_path'));
	}

	public static function register_options_page() {
		acf_add_options_page(array(
			'page_title'  => 'Jedda Policy',
			'menu_title'  => 'Jedda Policy',
			'menu_slug'   => 'jedda-policy',
			'capability'  => 'manage_woocommerce',
			'parent_slug' => 'woocommerce',
			'redirect'    => false,
			'position'    => 58,
			'icon_url'    => 'dashicons-shield',
		));
	}

	/**
	 * Save ACF field group JSON back to the plugin directory when
	 * field groups are edited via WP Admin → Custom Fields.
	 * Keeps the JSON files version-controlled alongside the plugin code.
	 */
	public static function save_json_path($path) {
		return JEDDA_COMMERCE_UI_PATH . 'acf-json';
	}
}
