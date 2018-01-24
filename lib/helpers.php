<?php
/**
 * Helper functions.
 *
 * @package     NICABM\ChildTheme
 * @author      Tim Jensen <tim@timjensen.us>
 * @license     GNU General Public License 2.0+
 * @since       0.3.0
 */

namespace NICABM\ChildTheme;

use function NICABM\Utility\get_acf_json_dir;

/**
 * Returns the relevant post meta for the current page.
 *
 * @param int    $post_id Post ID.
 * @param string $field_group_id ACF field group ID.
 * @param string $meta_key       $meta_key Array key to return the value of.
 * @return array|bool|null
 */
function get_post_meta_from_json( int $post_id, string $field_group_id, $meta_key = '' ) {
	static $acf_meta = null;

	if ( ! is_null( $acf_meta ) ) {

		if ( empty( $meta_key ) ) {
			return $acf_meta;
		}

		if ( ! isset( $acf_meta[ $meta_key ] ) ) {
			return false;
		}

		return $acf_meta[ $meta_key ];
	}

	$config = json_decode( file_get_contents( get_acf_json_dir() . "/{$field_group_id}.json" ), true );

	$acf_meta = get_all_custom_field_meta( $post_id, $config );

	// Now that $acf_meta is set we can call this function again.
	return get_post_meta_from_json( $post_id, $field_group_id, $meta_key );
}

/**
 * Remove the Genesis structural wrap for the specified context.
 *
 * @param string $context Location ID, such as 'header', 'site-inner', and 'footer'.
 */
function remove_genesis_structural_wrap( string $context ) {
	$genesis_wraps = get_theme_support( 'genesis-structural-wraps' );
	$genesis_wraps = current( (array) $genesis_wraps );

	$modified_wraps = array_filter( (array) $genesis_wraps, function( $value ) use ( $context ) {
		return $value !== $context;
	} );

	add_theme_support( 'genesis-structural-wraps', $modified_wraps );
}
