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

$nicabm_sale_redirect = get_sales_page_post_meta( 'nicabm_sale_redirect' );

$redirect_start_time = strtotime( $nicabm_sale_redirect['redirect_time'] );
$redirect_url        = ! empty( $nicabm_sale_redirect['redirect_url'] ) ? $nicabm_sale_redirect['redirect_url'] : home_url();

// If a redirect start time is set and has passed, redirect the user.
if (
	$redirect_start_time
	&& current_time( 'timestamp' ) > $redirect_start_time
	&& ! is_user_logged_in()
) {
	wp_safe_redirect( $redirect_url );
	exit();
}

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

	if ( empty( $acf_meta['nicabm_rows'] ) ) {
		return '';
	}

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

/**
 * Returns the relevant post meta for the current page.
 *
 * @param string $meta_key Array key to return the value of.
 * @return mixed
 */
function get_sales_page_post_meta( $meta_key = '' ) {
	return get_post_meta_from_json( get_the_ID(), 'group_5a414a346a088', $meta_key );
}

add_action( 'genesis_loop', __NAMESPACE__ . '\\do_sales_page_rows' );
/**
 * Loop through all the layout rows and load the appropriate template.
 */
function do_sales_page_rows() {
	$acf_meta = get_sales_page_post_meta();

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
