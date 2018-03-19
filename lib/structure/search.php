<?php
/**
 * Search
 *
 * @package     NICABM\ChildTheme
 * @author      Tim Jensen <tim@timjensen.us>
 * @license     GNU General Public License 2.0+
 * @since       0.3.3
 */

namespace NICABM\ChildTheme;

add_filter( 'genesis_search_text', function() {
	return __( 'Begin typing to search', 'nicabm-theme' );
} );
