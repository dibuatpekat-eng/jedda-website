<?php
/**
 * Asset enqueueing — CSS, JS, fonts, preloads, LiteSpeed exclusions.
 *
 * CSS file naming convention (LiteSpeed cache rule):
 *   Each new milestone gets a new CSS filename to guarantee a fresh
 *   LiteSpeed CSS optimisation cache entry.
 *   pdp-v21.css = Gallery V2.1
 *   pdp-v22.css = Product Summary V2 (typography tokens, font-face) [superseded]
 *   pdp-v23.css = Product Summary V2 (typography + flex container + sticky)
 *
 * @package JeddaCommerceUI
 */

if (! defined('ABSPATH')) {
	exit;
}

class Jedda_Assets {

	public static function init() {
		add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueue'), 30);
		add_action('wp_head', array(__CLASS__, 'preload_fonts'), 1);
		add_filter('litespeed_optimize_css_excludes', array(__CLASS__, 'litespeed_excludes'));
	}

	public static function enqueue() {
		if (! Jedda_PDP::is_v2_request()) {
			return;
		}

		$css_v21_path = JEDDA_COMMERCE_UI_PATH . 'assets/css/pdp-v21.css';
		$css_v23_path = JEDDA_COMMERCE_UI_PATH . 'assets/css/pdp-v23.css';
		$js_path      = JEDDA_COMMERCE_UI_PATH . 'assets/js/pdp-v2.js';

		// Gallery V2.1 styles
		wp_enqueue_style(
			'jedda-pdp-v21',
			JEDDA_COMMERCE_UI_URL . 'assets/css/pdp-v21.css',
			array(),
			file_exists($css_v21_path) ? (string) filemtime($css_v21_path) : JEDDA_COMMERCE_UI_VERSION
		);

		// Product Summary V2 styles (font-face, tokens, flex container, sticky)
		wp_enqueue_style(
			'jedda-pdp-v23',
			JEDDA_COMMERCE_UI_URL . 'assets/css/pdp-v23.css',
			array('jedda-pdp-v21'),
			file_exists($css_v23_path) ? (string) filemtime($css_v23_path) : JEDDA_COMMERCE_UI_VERSION
		);

		// Gallery + interaction JS
		wp_enqueue_script(
			'jedda-pdp-v2',
			JEDDA_COMMERCE_UI_URL . 'assets/js/pdp-v2.js',
			array(),
			file_exists($js_path) ? (string) filemtime($js_path) : JEDDA_COMMERCE_UI_VERSION,
			true
		);

		wp_script_add_data('jedda-pdp-v2', 'defer', true);

		wp_add_inline_script(
			'jedda-pdp-v2',
			'window.JEDDA_PDP_V2 = ' . wp_json_encode(
				array(
					'enabled'       => true,
					'killSwitchKey' => 'jedda:disable-pdp-v2',
					'milestone'     => '2.8',
				)
			) . ';',
			'before'
		);
	}

	/**
	 * Preload critical font weights in <head> for fastest render.
	 * Only preload 400 (Regular) and 500 (Medium) — most-used weights.
	 */
	public static function preload_fonts() {
		if (! Jedda_PDP::is_v2_request()) {
			return;
		}

		$fonts = array(
			'PlusJakartaSans.woff2',
			'PlusJakartaSans-LatinExt.woff2',
		);

		foreach ($fonts as $font_file) {
			$url = JEDDA_COMMERCE_UI_URL . 'assets/fonts/plus-jakarta-sans/' . $font_file;
			echo '<link rel="preload" href="' . esc_url($url) . '" as="font" type="font/woff2" crossorigin>' . "\n";
		}
	}

	/**
	 * Exclude our CSS files from LiteSpeed CSS optimisation bundling.
	 * New filename per milestone = guaranteed fresh cache entry.
	 */
	public static function litespeed_excludes($excludes) {
		$excludes[] = 'jedda-commerce-ui/assets/css/pdp-v21.css';
		$excludes[] = 'jedda-commerce-ui/assets/css/pdp-v23.css';
		return $excludes;
	}
}
