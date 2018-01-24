<?php
/**
 * Upsell Page Template
 * Template Name: NICABM Upsell Page
 * Template Post Type: nicabm_offer
 *
 * @package     NICABM\ChildTheme
 * @author      Tim Jensen <tim@timjensen.us>
 * @license     GNU General Public License 2.0+
 * @since       0.3.0
 */

namespace NICABM\ChildTheme;

remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_do_nav', 12 );

// Replace default content with sales page rows.
remove_all_actions( 'genesis_before_loop', 10 );
remove_all_actions( 'genesis_before_loop', 15 );
remove_all_actions( 'genesis_loop', 5 );
remove_all_actions( 'genesis_loop', 10 );
remove_all_actions( 'genesis_loop', 15 );

// Remove the Genesis structural wrap from the header for styling purposes.
remove_genesis_structural_wrap( 'header' );

add_action( 'genesis_header', __NAMESPACE__ . '\\do_offer_page_header' );
/**
 *
 */
function do_offer_page_header() {
	$header = get_upsell_page_post_meta( 'nicabm_header' );

	include NICABM_THEME_VIEWS_DIR . '/acf-upsell-header.php';
}

add_action( 'genesis_loop', __NAMESPACE__ . '\\do_sales_page_rows' );
/**
 * Returns the relevant post meta for the current page.
 *
 * @param string $meta_key Array key to return the value of.
 * @return mixed
 */
function get_upsell_page_post_meta( $meta_key = '' ) {
	return get_post_meta_from_json( get_the_ID(), 'group_5a68bb9f4ee61', $meta_key );
}

/**
 * Loop through all the layout rows and load the appropriate template.
 */
function do_sales_page_rows() {
	$acf_meta = get_upsell_page_post_meta();

	if ( empty( $acf_meta['nicabm_rows'] ) ) {
		return;
	}

	echo '<div class="entry-content">';

	array_walk( $acf_meta['nicabm_rows'], function ( $row, $index ) {
		$layout_type = isset( $row['acf_fc_layout'] ) ? $row['acf_fc_layout'] : '';

		$template_path = NICABM_THEME_VIEWS_DIR . '/acf-' . str_replace( '_', '-', $layout_type ) . '.php';

		if ( file_exists( $template_path ) ) {
			// Load the template for each row of the current layout type.
			include $template_path;
		}
	} );

	echo '</div>';
}

// Run the Genesis loop.
\genesis();
