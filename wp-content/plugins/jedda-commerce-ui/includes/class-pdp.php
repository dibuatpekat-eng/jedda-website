<?php
/**
 * PDP V2 feature flag and request detection.
 *
 * Kill switches (checked in priority order):
 *   define('JEDDA_PDP_V2_DISABLED', true)
 *   update_option('jedda_pdp_v2_enabled', '0')
 *
 * Enable switches:
 *   define('JEDDA_PDP_V2_ENABLED', true)
 *   update_option('jedda_pdp_v2_enabled', '1')
 *
 * @package JeddaCommerceUI
 */

if (! defined('ABSPATH')) {
	exit;
}

class Jedda_PDP {

	public static function init() {
		add_filter('body_class', array(__CLASS__, 'add_body_classes'), 20);
	}

	/**
	 * Whether PDP V2 is enabled globally.
	 */
	public static function is_v2_enabled() {
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

		return (bool) apply_filters('jedda_pdp_v2_enabled', false);
	}

	/**
	 * Whether the current request is a PDP V2 page.
	 */
	public static function is_v2_request() {
		return function_exists('is_product') && is_product() && self::is_v2_enabled();
	}

	/**
	 * Add scoped body classes for PDP V2 styling.
	 */
	public static function add_body_classes($classes) {
		if (! self::is_v2_request()) {
			return $classes;
		}

		$classes[] = 'jedda-commerce-ui';
		$classes[] = 'jedda-pdp-v2';

		return $classes;
	}
}
