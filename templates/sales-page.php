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
remove_all_actions( 'genesis_before_loop', 10 );
remove_all_actions( 'genesis_before_loop', 15 );
remove_all_actions( 'genesis_loop', 5 );
remove_all_actions( 'genesis_loop', 10 );
remove_all_actions( 'genesis_loop', 15 );

add_filter( 'pre_wp_nav_menu', function ( $pre, $args ) {
	if ( 'primary' !== $args->theme_location ) {
		return $pre;
	}

	$acf_meta = get_sales_page_post_meta();

	$args->echo = true;

	$nav_links = [];
	foreach ( $acf_meta['nicabm_rows'] as $index => $row ) {
		if ( empty( $row['nav_link']['show_link'] ) ) {
			continue;
		}

		$nav_links[] = [
			'link' => sprintf( '#sales-page__section--%s-%s', get_the_ID(), $index ),
			'text' => $row['nav_link']['text'],
		];

	}

	// Append the store button link.
	$nav_links[] = [
		'button' => true,
		'link'   => $acf_meta['nicabm_store_button']['link'],
		'text'   => $acf_meta['nicabm_store_button']['text'],
	];

	ob_start();
	include NICABM_THEME_VIEWS_DIR . '/partials/page-nav.php';

	return ob_get_clean();
}, 10, 2 );

add_action( 'genesis_loop', __NAMESPACE__ . '\\do_sales_page_rows' );
/**
 * Returns the relevant post meta for the current page.
 *
 * @param string $meta_key Array key to return the value of.
 * @return mixed
 */
function get_sales_page_post_meta( $meta_key = '' ) {
	static $acf_meta = null;

	if ( ! empty( $acf_meta ) ) {

		if ( empty( $meta_key ) ) {
			return $acf_meta;
		}

		return $acf_meta[ $meta_key ];
	}

	$config = json_decode( file_get_contents( get_acf_json_dir() . '/group_5a414a346a088.json' ), true );

	$acf_meta = get_all_custom_field_meta( get_the_ID(), $config );

	if ( empty( $meta_key ) ) {
		return $acf_meta;
	}

	return $acf_meta[ $meta_key ];
}

/**
 * Loop through all the layout rows and load the appropriate template.
 */
function do_sales_page_rows() {
	$acf_meta = get_sales_page_post_meta();

	if ( empty( $acf_meta['nicabm_rows'] ) ) {
		return;
	}

	array_walk( $acf_meta['nicabm_rows'], function ( $row, $index ) {
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
