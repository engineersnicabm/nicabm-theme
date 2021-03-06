<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'aspire', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'aspire' ) );

//* Add Image upload and Color select to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

require_once __DIR__ . '/lib/output.php';

$nicabm_theme = wp_get_theme();

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', $nicabm_theme->get( 'Name' ) );
define( 'CHILD_THEME_URL', $nicabm_theme->get( 'Theme URI' ) );
define( 'CHILD_THEME_VERSION', $nicabm_theme->get( 'Version' ) );
define( 'NICABM_THEME_VIEWS_DIR', __DIR__ . '/views' );

// Composer dependencies.
require __DIR__ . '/vendor/autoload.php';

// Extend the theme's functions.php file.
require_once __DIR__ . '/lib/enqueue.php';
require_once __DIR__ . '/lib/functions/formatting.php';
require_once __DIR__ . '/lib/helpers.php';
require_once __DIR__ . '/lib/structure/comments.php';
require_once __DIR__ . '/lib/structure/footer.php';
require_once __DIR__ . '/lib/structure/header.php';
require_once __DIR__ . '/lib/structure/post.php';
require_once __DIR__ . '/lib/structure/search.php';

//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'aspire_enqueue_scripts_styles' );
function aspire_enqueue_scripts_styles() {
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Raleway:500,700|Open+Sans:400,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_script( 'aspire-global', get_bloginfo( 'stylesheet_directory' ) . "/js/theme{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION );

}

//* Add Font Awesome Support
add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome' );
function enqueue_font_awesome() {
	wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), '4.5.0' );
}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add accessibility support
add_theme_support( 'genesis-accessibility', array( 'drop-down-menu', 'search-form', 'skip-links' ) );

//* Add WooCommerce Support
add_theme_support( 'genesis-connect-woocommerce' );

//* Enqueue custom WooCommerce styles when WooCommerce active
add_filter( 'woocommerce_enqueue_styles', 'aspire_woocommerce_styles' );
function aspire_woocommerce_styles( $enqueue_styles ) {

	$enqueue_styles['aspire-woocommerce-styles'] = array(
		'src'     => get_stylesheet_directory_uri() . '/woocommerce/css/woocommerce.css',
		'deps'    => '',
		'version' => CHILD_THEME_VERSION,
		'media'   => 'screen'
	);

	return $enqueue_styles;

}

// Change number or products per row to 4
add_filter( 'loop_shop_columns', 'loop_columns' );
if ( ! function_exists( 'loop_columns' ) ) {
	function loop_columns() {
		return 4; // 4 products per row
	}
}

// WooCommerce | Display 30 products per page.
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 30;' ), 20 );

// Enable WooCommerce Gallery Features (Zoom, Lightbox, Slider)
add_action( 'after_setup_theme', 'yourtheme_setup' );
function yourtheme_setup() {
	/*add_theme_support( 'wc-product-gallery-zoom' );*/
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'       => 430,
	'height'      => 40,
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => false,
) );


add_filter('upload_mimes', 'cc_mime_types');
function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'footer-widgets',
	'footer',
) );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add new image sizes
add_image_size( 'portfolio-thumbnail', 340, 240, true );
add_image_size( 'blog-horizontal-large', 700, 285, true );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Unregister the header right widget area
unregister_sidebar( 'header-right' );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Unregister secondary navigation menu
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis' ) ) );

// Add featured image above the entry content
/*add_action( 'genesis_before_entry', 'aspire_featured_photo' );
function aspire_featured_photo() {

    if ( ! ( is_singular() && has_post_thumbnail() ) ) {
        return;
    }

    $image = genesis_get_image( 'format=url&size=single-posts' );

    $thumb_id = get_post_thumbnail_id( get_the_ID() );
    $alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );

    if ( '' == $alt ) {
        $alt = the_title_attribute( 'echo=0' );
    }

    printf( '<div class="featured-image"><img src="%s" alt="%s" class="entry-image"/></div>', esc_url( $image ), $alt );
}*/

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add support for footer menu
add_theme_support( 'genesis-menus', array(
	'primary' => 'Primary Navigation Menu',
	'footer'  => 'Footer Navigation Menu'
) );

//* Hook menu in footer
add_action( 'genesis_footer', 'aspire_footer_menu', 7 );
function aspire_footer_menu() {
	printf( '<nav %s>', genesis_attr( 'nav-footer' ) );
	wp_nav_menu( array(
		'theme_location' => 'footer',
		'container'      => false,
		'depth'          => 1,
		'fallback_cb'    => false,
		'menu_class'     => 'genesis-nav-menu',
	) );

	echo '</nav>';
}

// Theme Settings init
add_action( 'admin_menu', 'aspire_theme_settings_init', 15 );
/**
 * This is a necessary go-between to get our scripts and boxes loaded
 * on the theme settings page only, and not the rest of the admin
 */
function aspire_theme_settings_init() {
	global $_genesis_admin_settings;

	add_action( 'load-' . $_genesis_admin_settings->pagehook, 'aspire_add_portfolio_settings_box', 20 );
}

// Add Portfolio Settings box to Genesis Theme Settings
function aspire_add_portfolio_settings_box() {
	global $_genesis_admin_settings;

	add_meta_box( 'genesis-theme-settings-aspire-portfolio', __( 'Portfolio Page Settings', 'aspire' ), 'aspire_theme_settings_portfolio', $_genesis_admin_settings->pagehook, 'main' );
}

/**
 * Adds Portfolio Options to Genesis Theme Settings Page
 */
function aspire_theme_settings_portfolio() { ?>

	<p><?php _e( "Display which category:", 'genesis' ); ?>
		<?php wp_dropdown_categories( array(
			'selected'        => genesis_get_option( 'aspire_portfolio_cat' ),
			'name'            => GENESIS_SETTINGS_FIELD . '[aspire_portfolio_cat]',
			'orderby'         => 'Name',
			'hierarchical'    => 1,
			'show_option_all' => __( "All Categories", 'genesis' ),
			'hide_empty'      => '0'
		) ); ?></p>

	<p><?php _e( "Exclude the following Category IDs:", 'genesis' ); ?><br/>
		<input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[aspire_portfolio_cat_exclude]" value="<?php echo esc_attr( genesis_get_option( 'aspire_portfolio_cat_exclude' ) ); ?>" size="40"/><br/>
		<small><strong><?php _e( "Comma separated - 1,2,3 for example", 'genesis' ); ?></strong></small>
	</p>

	<p><?php _e( 'Number of Posts to Show', 'genesis' ); ?>:
		<input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[aspire_portfolio_cat_num]" value="<?php echo esc_attr( genesis_option( 'aspire_portfolio_cat_num' ) ); ?>" size="2"/>
	</p>

	<p>
		<span class="description"><?php _e( '<b>NOTE:</b> The Portfolio Page displays the "Portfolio Page" image size plus the excerpt or full content as selected below.', 'aspire' ); ?></span>
	</p>

	<p><?php _e( "Select one of the following:", 'genesis' ); ?>
		<select name="<?php echo GENESIS_SETTINGS_FIELD; ?>[aspire_portfolio_content]">
			<option style="padding-right:10px;" value="full" <?php selected( 'full', genesis_get_option( 'aspire_portfolio_content' ) ); ?>><?php _e( "Display post content", 'genesis' ); ?></option>
			<option style="padding-right:10px;" value="excerpts" <?php selected( 'excerpts', genesis_get_option( 'aspire_portfolio_content' ) ); ?>><?php _e( "Display post excerpts", 'genesis' ); ?></option>
		</select></p>

	<p>
		<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[aspire_portfolio_content_archive_limit]"><?php _e( 'Limit content to', 'genesis' ); ?></label>
		<input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[aspire_portfolio_content_archive_limit]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[aspire_portfolio_content_archive_limit]" value="<?php echo esc_attr( genesis_option( 'aspire_portfolio_content_archive_limit' ) ); ?>" size="3"/>
		<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[aspire_portfolio_content_archive_limit]"><?php _e( 'characters', 'genesis' ); ?></label>
	</p>

	<p>
		<span class="description"><?php _e( '<b>NOTE:</b> Using this option will limit the text and strip all formatting from the text displayed. To use this option, choose "Display post content" in the select box above.', 'genesis' ); ?></span>
	</p>
	<?php
}

// Enable shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'aspire' ),
	'description' => __( 'This is the front page 1 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'aspire' ),
	'description' => __( 'This is the front page 2 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'aspire' ),
	'description' => __( 'This is the front page 3 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'aspire' ),
	'description' => __( 'This is the front page 4 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-mid-left',
	'name'        => __( 'Home Mid Left Sidebar', 'aspire' ),
	'description' => __( 'This is the Home Mid Left section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-mid-right',
	'name'        => __( 'Home Mid Right Sidebar', 'aspire' ),
	'description' => __( 'This is the Home Mid Right section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-mid-wide',
	'name'        => __( 'Home Mid Wide Sidebar', 'aspire' ),
	'description' => __( 'This is the Home Mid Wide section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-5',
	'name'        => __( 'Front Page 5', 'aspire' ),
	'description' => __( 'This is the front page 5 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-6',
	'name'        => __( 'Front Page 6', 'aspire' ),
	'description' => __( 'This is the front page 6 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-7',
	'name'        => __( 'Front Page 7', 'aspire' ),
	'description' => __( 'This is the front page 7 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-8',
	'name'        => __( 'Front Page 8', 'aspire' ),
	'description' => __( 'This is the front page 8 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-9',
	'name'        => __( 'Front Page 9', 'aspire' ),
	'description' => __( 'This is the front page 9 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-10',
	'name'        => __( 'Front Page 10', 'aspire' ),
	'description' => __( 'This is the front page 10 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-11',
	'name'        => __( 'Front Page 11', 'aspire' ),
	'description' => __( 'This is the front page 11 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-12',
	'name'        => __( 'Front Page 12', 'aspire' ),
	'description' => __( 'This is the front page 12 section.', 'aspire' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-13',
	'name'        => __( 'Front Page 13', 'aspire' ),
	'description' => __( 'This is the front page 13 section.', 'aspire' ),
) );
