<?php
/**
 * Header
 *
 * @package     NICABM\ChildTheme
 * @author      Tim Jensen <tim@timjensen.us>
 * @license     GNU General Public License 2.0+
 * @since       0.3.3
 */

namespace NICABM\ChildTheme;

// Remove custom Genesis custom header style.
remove_action( 'wp_head', 'genesis_custom_header_style' );

add_filter( 'genesis_seo_title', __NAMESPACE__ . '\\do_inline_header_logo', 10, 3 );
/**
 * Convert header image from background to inline.
 *
 * @param string $title Site title markup.
 * @param string $inside What goes inside the wrapping tags.
 * @param string $wrap The wrapping element (h1, h2, p, etc.).
 * @return string
 */
function do_inline_header_logo( $title, $inside, $wrap ) {

	if ( get_header_image() ) {

		$logo = sprintf('<img src="%s" width="%s" height="%s" alt="%s %s">',
			get_header_image(),
			esc_attr( get_custom_header()->width ),
			esc_attr( get_custom_header()->height ),
			esc_attr( get_bloginfo( 'name' ) ),
			esc_attr__( 'home page' )
		);

	} else {
		$logo = get_bloginfo( 'name' );
	}

	$inside = sprintf( '<a href="%s">%s<span class="screen-reader-text">%s</span></a>',
		home_url( '/' ),
		$logo,
		get_bloginfo( 'name' )
	);

	// Determine which wrapping tags to use
	$wrap = genesis_is_root_page() && 'title' === genesis_get_seo_option( 'home_h1_on' ) ? 'h1' : 'p';

	// A little fallback, in case an SEO plugin is active
	$wrap = genesis_is_root_page() && ! genesis_get_seo_option( 'home_h1_on' ) ? 'h1' : $wrap;

	// And finally, $wrap in h1 if HTML5 & semantic headings enabled
	$wrap = genesis_html5() && genesis_get_seo_option( 'semantic_headings' ) ? 'h1' : $wrap;

	return sprintf( '<%1$s %2$s>%3$s</%1$s>', $wrap, genesis_attr( 'site-title' ), $inside );

}

add_filter( 'genesis_attr_site-description', __NAMESPACE__ . '\\add_screen_reader_class_to_site_header' );
/**
 * Add class for screen readers to site description (if header image has been set) to hide it.
 *
 * @param array $attributes Site description attributes.
 * @return mixed
 */
function add_screen_reader_class_to_site_header( $attributes ) {
	if ( get_header_image() ) {
		$attributes['class'] .= ' screen-reader-text';
	}

	return $attributes;
}
