<?php
/**
 * Jedda Badge taxonomy — categorical product labels.
 *
 * Terms: Pre-Order, New Arrival, Restocked, Limited Edition.
 * Replaces WPCode badge snippets (#3613, #5163, #5152) once PDP V2 is
 * the permanent state. Rendering logic added in Milestone 2.8.5.
 *
 * @package JeddaCommerceUI
 */

if (! defined('ABSPATH')) {
	exit;
}

class Jedda_Taxonomy {

	const BADGE_TAXONOMY = 'jedda_badge';

	public static function init() {
		add_action('init', array(__CLASS__, 'register_badge_taxonomy'));
	}

	public static function register_badge_taxonomy() {
		$labels = array(
			'name'          => 'Product Badges',
			'singular_name' => 'Product Badge',
			'search_items'  => 'Search Badges',
			'all_items'     => 'All Badges',
			'edit_item'     => 'Edit Badge',
			'update_item'   => 'Update Badge',
			'add_new_item'  => 'Add New Badge',
			'new_item_name' => 'New Badge Name',
			'menu_name'     => 'Badges',
		);

		register_taxonomy(
			self::BADGE_TAXONOMY,
			'product',
			array(
				'hierarchical'      => false,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'query_var'         => true,
				'rewrite'           => array('slug' => 'badge'),
			)
		);
	}
}
