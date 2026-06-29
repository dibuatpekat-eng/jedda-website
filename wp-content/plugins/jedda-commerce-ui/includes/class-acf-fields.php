<?php
/**
 * ACF field group configuration — JEDDA product data.
 *
 * Field groups are defined in JSON files in /acf-json/ and loaded via
 * ACF's native JSON sync. This avoids PHP-based acf_add_field_group()
 * registration which has class-level conflicts in ACF Pro 6.8.4 when
 * called from multiple hook callbacks in the same request.
 *
 * JSON files:
 *   acf-json/group_jedda_product.json  — per-product structured fields
 *   acf-json/group_jedda_policy.json   — global policy fields (options page)
 *
 * To add or modify fields:
 *   Edit the field group in WP Admin → Custom Fields. ACF will
 *   automatically sync changes back to /acf-json/ (handled by
 *   class-acf-options.php's save_json filter).
 *
 * Usage (frontend/backend):
 *   get_field('jedda_details_text', $product_id)
 *   get_field('jedda_shipping_policy', 'option')
 *
 * @package JeddaCommerceUI
 */

if (! defined('ABSPATH')) {
	exit;
}

class Jedda_ACF_Fields {

	public static function init() {
		if (! function_exists('acf')) {
			return;
		}
		add_filter('acf/settings/load_json', array(__CLASS__, 'load_json_path'));
	}

	/**
	 * Tell ACF to load field group JSON from the plugin's acf-json/ directory.
	 * Allows field groups to be defined as JSON files without PHP registration.
	 */
	public static function load_json_path($paths) {
		$paths[] = JEDDA_COMMERCE_UI_PATH . 'acf-json';
		return $paths;
	}
}
