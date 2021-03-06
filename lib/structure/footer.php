<?php
/**
 * Site footer
 *
 * @package     NICABM\ChildTheme
 * @author      Tim Jensen <tim@timjensen.us>
 * @license     GNU General Public License 2.0+
 * @since       0.2.0
 */

namespace NICABM\ChildTheme;

add_filter( 'genesis_footer_creds_text', __NAMESPACE__ . '\\do_footer_credits' );
/**
 * Apply the new footer credits if specified in the Genesis Theme Settings.
 *
 * @param string $creds_text default Genesis credits text.
 * @return string
 */
function do_footer_credits( $creds_text ) {
	$new_creds = genesis_get_option( 'footer_credits' );

	if ( ! $new_creds ) {
		return $creds_text;
	}

	return apply_filters( 'meta_content', wp_kses_post( $new_creds ) );
}
