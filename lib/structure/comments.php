<?php
/**
 * Modify the comments section.
 *
 * @package     NICABM\ChildTheme
 * @author      Tim Jensen <tim@timjensen.us>
 * @license     GNU General Public License 2.0+
 * @since       0.3.3
 */

namespace NICABM\ChildTheme;

add_filter( 'comment_form_defaults', __NAMESPACE__ . '\\change_comment_form_args' );
/**
 * Modify the comment form arguments.
 *
 * @param array $args Comment form arguments.
 * @return array
 */
function change_comment_form_args( $args ) {
	$commenter = wp_get_current_commenter();

	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? ' aria-required=true' : '' );
	$html_req = ( $req ? ' required=required' : '' );

	$comment_field = sprintf( '<p class="comment-form-comment"><textarea id="comment" name="comment" placeholder="%s" cols="45" rows="8" maxlength="65525" aria-label="%s" aria-required="true" required="required"></textarea></p>',
		esc_attr__( 'Please type your comment here &hellip;', 'nicabm-theme' ),
		esc_attr_x( 'Comment', 'noun', 'nicabm-theme' )
	);

	$fields = [
		'author' => sprintf( '<p class="comment-form-author"><input id="author" name="author" type="text" value="%1$s" size="30" maxlength="245" placeholder="%2$s" aria-label="%2$s" %3$s /></p>',
			esc_attr( $commenter['comment_author'] ),
			esc_attr__( 'Enter Your Name *', 'nicabm-theme' ),
			esc_attr( $aria_req . $html_req )
		),
		'email'  => sprintf( '<p class="comment-form-email"><input id="email" name="email" type="email" value="%1$s" size="30" maxlength="100" placeholder="%2$s" aria-label="%2$s" %3$s /></p>',
			esc_attr( $commenter['comment_author_email'] ),
			esc_attr__( 'Enter Your Email Address *', 'nicabm-theme' ),
			esc_attr( $aria_req . $html_req )
		),
	];

	$args['title_reply']          = __( 'Please Leave A Comment', 'nicabm-theme' );
	$args['comment_notes_before'] = '';
	$args['comment_field']        = $comment_field;
	$args['fields']               = $fields;

	return $args;
}

// Remove comment meta (date/time).
add_filter( 'genesis_show_comment_date', '__return_false' );

add_filter( 'genesis_title_comments', __NAMESPACE__ . '\\do_comments_heading' );
/**
 * Builds the Comments heading, including the current number of comments.
 *
 * @return string
 */
function do_comments_heading() {
	$atts = array(
		'more' => __( '% Comments', 'nicabm-theme' ),
		'one'  => __( '1 Comment', 'nicabm-theme' ),
		'zero' => __( 'Leave a Comment', 'nicabm-theme' ),
	);

	ob_start();

	comments_number( $atts['zero'], $atts['one'], $atts['more'] );

	return sprintf( '<h3>%s</h3>', ob_get_clean() );
}

remove_action( 'genesis_comment_form', 'genesis_do_comment_form' );
add_action( 'genesis_before_comments', 'genesis_do_comment_form' );
