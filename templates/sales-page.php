<?php
/**
 * Sales Page Template
 * Template Name: NICABM Sales Page
 * Template Post Type: nicabm_program
 *
 * @package     NICABM\ChildTheme
 * @author      Tim Jensen <tim@timjensen.us>
 * @license     GNU General Public License 2.0+
 * @since       0.1.0
 */

namespace NICABM\ChildTheme;

use function NICABM\Utility\get_acf_json_dir;

// Replace default content with sales page rows.
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', __NAMESPACE__ . '\\do_sales_page_rows' );

/**
 * Returns the relevant post meta for the current page.
 *
 * @return array|null
 */
function get_sales_page_post_meta() {
	static $acf_meta = null;

	if ( ! empty( $acf_meta ) ) {
		return $acf_meta;
	}

	$config = json_decode( file_get_contents( get_acf_json_dir() . '/group_5a414a346a088.json' ), true );

	$acf_meta = get_all_custom_field_meta( get_the_ID(), $config );

	return $acf_meta;
}

/**
 * Loop through all the layout rows and load the appropriate template.
 */
function do_sales_page_rows() {
	$acf_meta = get_sales_page_post_meta();

	if ( empty( $acf_meta['nicabm_rows'] ) ) {
		return;
	}

	array_walk( $acf_meta['nicabm_rows'], function( $row ) {
		$layout_type = isset( $row['acf_fc_layout'] ) ? $row['acf_fc_layout'] : '';

		$template_path = NICABM_THEME_VIEWS_DIR . '/acf-' . str_replace( '_', '-', $layout_type ) . '.php';

		if ( file_exists( $template_path ) ) {
			// Load the template for each row of the current layout type.
			include $template_path;
		}
	} );
}

// Run the Genesis loop.
\genesis();
