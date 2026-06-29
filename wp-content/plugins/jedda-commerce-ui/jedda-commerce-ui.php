<?php
/**
 * Plugin Name: JEDDA Commerce UI
 * Description: Git-owned presentation layer for JEDDA commerce experiences. Milestone 2.6 starts with Product Page V2.
 * Version: 0.1.0
 * Author: JEDDA
 * Text Domain: jedda-commerce-ui
 *
 * @package JeddaCommerceUI
 */

if (! defined('ABSPATH')) {
	exit;
}

define('JEDDA_COMMERCE_UI_VERSION', '0.1.0');
define('JEDDA_COMMERCE_UI_FILE', __FILE__);
define('JEDDA_COMMERCE_UI_PATH', plugin_dir_path(__FILE__));
define('JEDDA_COMMERCE_UI_URL', plugin_dir_url(__FILE__));

/**
 * Determine whether PDP V2 should run on this request.
 *
 * Kill switches, in priority order:
 * - define('JEDDA_PDP_V2_DISABLED', true)
 * - update_option('jedda_pdp_v2_enabled', '0')
 *
 * Enable switches:
 * - define('JEDDA_PDP_V2_ENABLED', true)
 * - update_option('jedda_pdp_v2_enabled', '1')
 * - beta.jeddawear.com staging host
 *
 * @return bool
 */
function jedda_commerce_ui_is_pdp_v2_enabled() {
	if (defined('JEDDA_PDP_V2_DISABLED') && JEDDA_PDP_V2_DISABLED) {
		return false;
	}

	$option = get_option('jedda_pdp_v2_enabled', '');

	if ('0' === (string) $option) {
		return false;
	}

	if ('1' === (string) $option) {
		return (bool) apply_filters('jedda_pdp_v2_enabled', true);
	}

	if (defined('JEDDA_PDP_V2_ENABLED')) {
		return (bool) apply_filters('jedda_pdp_v2_enabled', (bool) JEDDA_PDP_V2_ENABLED);
	}

	$host = wp_parse_url(home_url(), PHP_URL_HOST);
	$is_staging_host = is_string($host) && false !== stripos($host, 'beta.jeddawear.com');

	return (bool) apply_filters('jedda_pdp_v2_enabled', $is_staging_host);
}

/**
 * Determine whether the current request is a PDP V2 target.
 *
 * @return bool
 */
function jedda_commerce_ui_is_pdp_v2_request() {
	return function_exists('is_product') && is_product() && jedda_commerce_ui_is_pdp_v2_enabled();
}

/**
 * Add scoped body classes for PDP V2 styling.
 *
 * @param array $classes Existing body classes.
 * @return array
 */
function jedda_commerce_ui_pdp_v2_body_class($classes) {
	if (! jedda_commerce_ui_is_pdp_v2_request()) {
		return $classes;
	}

	$classes[] = 'jedda-commerce-ui';
	$classes[] = 'jedda-pdp-v2';

	return $classes;
}
add_filter('body_class', 'jedda_commerce_ui_pdp_v2_body_class', 20);

/**
 * Enqueue PDP V2 assets only on product pages.
 *
 * @return void
 */
function jedda_commerce_ui_enqueue_pdp_v2_assets() {
	if (! jedda_commerce_ui_is_pdp_v2_request()) {
		return;
	}

	$css_path = JEDDA_COMMERCE_UI_PATH . 'assets/css/pdp-v2.css';
	$js_path  = JEDDA_COMMERCE_UI_PATH . 'assets/js/pdp-v2.js';

	$css_version = file_exists($css_path) ? (string) filemtime($css_path) : JEDDA_COMMERCE_UI_VERSION;
	$js_version  = file_exists($js_path) ? (string) filemtime($js_path) : JEDDA_COMMERCE_UI_VERSION;

	wp_enqueue_style(
		'jedda-pdp-v2',
		JEDDA_COMMERCE_UI_URL . 'assets/css/pdp-v2.css',
		array(),
		$css_version
	);

	wp_enqueue_script(
		'jedda-pdp-v2',
		JEDDA_COMMERCE_UI_URL . 'assets/js/pdp-v2.js',
		array(),
		$js_version,
		true
	);

	wp_script_add_data('jedda-pdp-v2', 'defer', true);

	wp_add_inline_script(
		'jedda-pdp-v2',
		'window.JEDDA_PDP_V2 = ' . wp_json_encode(
			array(
				'enabled'       => true,
				'killSwitchKey' => 'jedda:disable-pdp-v2',
				'milestone'     => '2.6',
			)
		) . ';',
		'before'
	);
}
add_action('wp_enqueue_scripts', 'jedda_commerce_ui_enqueue_pdp_v2_assets', 30);
