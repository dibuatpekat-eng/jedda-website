<?php
/**
 * WooCommerce filters for JEDDA Commerce UI.
 *
 * Scope: filters that apply only when PDP V2 is active on product pages.
 * Does not touch cart, checkout, payment, orders, or stock logic.
 *
 * @package JeddaCommerceUI
 */

if (! defined('ABSPATH')) {
	exit;
}

class Jedda_WooCommerce {

	public static function init() {
		add_filter('woocommerce_product_single_add_to_cart_text', array(__CLASS__, 'atc_label'));
		add_filter('woocommerce_product_title_tag', array(__CLASS__, 'product_title_tag'));
		add_filter('woocommerce_locate_template', array(__CLASS__, 'locate_template'), 20, 3);
	}

	/**
	 * Change "Add to cart" → "Add to Bag" on single product pages.
	 * Applies site-wide on product pages — this is a brand-level decision.
	 */
	public static function atc_label($text) {
		if (! function_exists('is_product') || ! is_product()) {
			return $text;
		}

		return __('Add to Bag', 'jedda-commerce-ui');
	}

	/**
	 * Render product title as <h1> on PDP V2 pages.
	 * Kept as a belt-and-suspenders filter alongside the template override.
	 */
	public static function product_title_tag($tag) {
		if (Jedda_PDP::is_v2_request()) {
			return 'h1';
		}

		return $tag;
	}

	/**
	 * Override WooCommerce templates with JEDDA PDP V2 versions.
	 *
	 * Runs at priority 20 (after Upscale's priority 10), so our templates
	 * take precedence when PDP V2 is active.
	 *
	 * Template files live at: templates/{wc-template-name}
	 * e.g. templates/single-product/title.php overrides
	 *      woocommerce/single-product/title.php
	 */
	public static function locate_template($template, $template_name, $template_path) {
		if (! Jedda_PDP::is_v2_request()) {
			return $template;
		}

		$plugin_template = JEDDA_COMMERCE_UI_PATH . 'templates/' . $template_name;

		if (file_exists($plugin_template)) {
			return $plugin_template;
		}

		return $template;
	}
}
