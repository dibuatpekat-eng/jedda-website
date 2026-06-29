<?php
/**
 * ACF field group definitions for JEDDA product data.
 *
 * Requires: ACF Pro (for Repeater field and Options Page).
 * Status: PLACEHOLDER — ACF Pro not yet installed.
 *
 * Fields to be defined (Milestone 2.8.4):
 *   jedda_details_text          Textarea   Product Details body copy
 *   jedda_composition           Text       Material composition (fallback if not using pa_material)
 *   jedda_care_instructions     Textarea   Care instructions
 *   jedda_sizes                 Repeater   Garment measurements per size
 *     jedda_size_label          Text         Size name (e.g. S / M)
 *     jedda_size_bust           Number       Bust cm
 *     jedda_size_shoulder       Number       Shoulder cm
 *     jedda_size_front_length   Number       Front length cm
 *     jedda_size_back_length    Number       Back length cm
 *   jedda_rec_sizes             Repeater   Recommended body size
 *     jedda_rec_label           Text         Size name
 *     jedda_rec_bust_max        Text         Bust up to (cm)
 *
 * Field group JSON will be stored in /acf-json/ for version control.
 *
 * @package JeddaCommerceUI
 */

if (! defined('ABSPATH')) {
	exit;
}

class Jedda_ACF_Fields {

	public static function init() {
		// ACF field groups are registered here once ACF Pro is installed.
		// add_action('acf/init', array(__CLASS__, 'register_field_groups'));
	}
}
