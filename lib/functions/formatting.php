<?php
/**
 * Formatting
 *
 * @package     NICABM\ChildTheme
 * @author      Tim Jensen <tim@timjensen.us>
 * @license     GNU General Public License 2.0+
 * @since       0.3.3
 */

namespace NICABM\ChildTheme;

add_filter( 'get_the_content_more_link', __NAMESPACE__ . '\\change_more_link_text' );
/**
 * Replaces the default Genesis [Read More...] with Read More.
 *
 * @param string $more_link The content more link.
 *
 * @return string
 */
function change_more_link_text( $more_link ) {
	$new_more_link_text = __( 'Continue Reading &#10140;', 'child-theme-text-domain' );

	return sprintf( '&hellip; <div><a href="%s" class="more-link">%s</a></div>',
		get_the_permalink(),
		genesis_a11y_more_link( $new_more_link_text )
	);
}
