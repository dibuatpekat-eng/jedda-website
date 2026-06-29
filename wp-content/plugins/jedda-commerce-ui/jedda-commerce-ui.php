<?php
/**
 * Plugin Name: JEDDA Commerce UI
 * Description: Git-owned presentation layer for JEDDA commerce experiences.
 * Version: 0.2.0
 * Author: JEDDA
 * Text Domain: jedda-commerce-ui
 *
 * @package JeddaCommerceUI
 */

if (! defined('ABSPATH')) {
	exit;
}

define('JEDDA_COMMERCE_UI_VERSION', '0.2.0');
define('JEDDA_COMMERCE_UI_FILE', __FILE__);
define('JEDDA_COMMERCE_UI_PATH', plugin_dir_path(__FILE__));
define('JEDDA_COMMERCE_UI_URL', plugin_dir_url(__FILE__));

// Load classes
require_once JEDDA_COMMERCE_UI_PATH . 'includes/class-pdp.php';
require_once JEDDA_COMMERCE_UI_PATH . 'includes/class-assets.php';
require_once JEDDA_COMMERCE_UI_PATH . 'includes/class-taxonomy.php';
require_once JEDDA_COMMERCE_UI_PATH . 'includes/class-woocommerce.php';
require_once JEDDA_COMMERCE_UI_PATH . 'includes/class-acf-fields.php';
require_once JEDDA_COMMERCE_UI_PATH . 'includes/class-acf-options.php';

// Initialise
Jedda_PDP::init();
Jedda_Assets::init();
Jedda_Taxonomy::init();
Jedda_WooCommerce::init();
Jedda_ACF_Fields::init();
Jedda_ACF_Options::init();
