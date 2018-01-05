<?php
/**
 * Enqueue additional styles and scripts
 *
 * @package     NICABM\ChildTheme
 * @author      Tim Jensen <tim@timjensen.us>
 * @license     GNU General Public License 2.0+
 * @since       0.1.0
 */

namespace NICABM\ChildTheme;

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\add_program_page_styles' );
/**
 * Renders any page-specific CSS that has been entered on the Program page edit screen.
 *
 * @since 0.1.0
 */
function add_program_page_styles() {
	if ( ! is_singular( 'nicabm_program' ) ) {
		return;
	}

	$custom_css = get_post_meta( get_the_ID(), 'nicabm_page_css', true );

	if ( empty( $custom_css ) ) {
		return;
	}

	echo '<style type="text/css">' . wp_kses_post( $custom_css ) . '</style>';
}
