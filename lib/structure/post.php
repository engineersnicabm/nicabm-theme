<?php
/**
 * Modify the structure of the post.
 *
 * @package     NICABM\ChildTheme
 * @author      Tim Jensen <tim@timjensen.us>
 * @license     GNU General Public License 2.0+
 * @since       0.3.3
 */

namespace NICABM\ChildTheme;

add_filter( 'image_size_names_choose', __NAMESPACE__ . '\\extend_image_size_choices' );
/**
 * Adds image sizes to the available choices.
 *
 * @param array $sizes WP image sizes.
 * @return array
 */
function extend_image_size_choices( $sizes ) {

	$add_sizes = [
		'portfolio-thumbnail'   => __( 'Portfolio Thumbnail', 'nicabm-theme' ),
		'blog-horizontal-large' => __( 'Blog Horizontal - Large', 'nicabm-theme' ),
	];

	return array_merge( (array) $sizes, $add_sizes );
}

//add_action( 'genesis_entry_content', __NAMESPACE__ . '\\do_post_featured_image', 8 );
/**
 * Render the featured image at the top of the post.
 */
function do_post_featured_image() {
	if ( ! is_singular() ) {
		return;
	}

	$featured_image = get_the_post_thumbnail( get_the_ID(), 'blog-horizontal-large' );

	echo wpautop( $featured_image );
}

add_filter( 'genesis_post_info', __NAMESPACE__ . '\\post_info_shortcodes' );
/**
 * Replace standard post info with comments and post edit link only.
 *
 * @param string $post_info Genesis post info shortcodes.
 * @return string
 */
function post_info_shortcodes( $post_info ) {
	return '[post_comments] [post_edit]';
}

add_action( 'genesis_before_content_sidebar_wrap', __NAMESPACE__ . '\\remove_entry_footer_post_info' );
/**
 * Remove the post info from the entry footer.
 */
function remove_entry_footer_post_info() {
	if ( is_singular() ) {
		return;
	}

	remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
}

add_filter( 'genesis_post_meta', __NAMESPACE__ . '\\remove_post_tags_from_post_meta' );
/**
 * Removes the post tags shortcode from post meta.
 *
 * @param string $post_meta Post meta, typically "[post_categories] [post_tags]"
 * @return string
 */
function remove_post_tags_from_post_meta( $post_meta ) {
	return str_replace( '[post_tags]', '', (string) $post_meta );
}

add_filter( 'shortcode_atts_post_categories', __NAMESPACE__ . '\\change_post_categories_list_prefix' );
/**
 * Change post categories before text from "Filed Under:" to "Related Posts:".
 *
 * @param array $atts
 * @return array
 */
function change_post_categories_list_prefix( $atts ) {
	$atts['before'] = __( 'Related Posts: ', 'nicabm-theme' );

	return $atts;
}

/**
 * Modify the Previous pagination link text.
 */
add_filter( 'genesis_prev_link_text', function() {
	return '&#60;';
} );

/**
 * Modify the Next pagination link text.
 */
add_filter( 'genesis_next_link_text', function() {
	return '&#62;'; // > sign.
} );
