<?php
/**
 * @var array $header Header data.
 */

namespace NICABM\ChildTheme;

$lead_in      = $header['lead_in'] ?? '';
$page_heading = $header['page_heading'] ?? '';

$inline_style = [];

// Background color.
if ( ! empty( $header['bg_color'] ) ) {
	$inline_style[] = sprintf( 'background-color: %s;', esc_attr( $header['bg_color'] ) );
}

// Background image.
if ( ! empty( $header['bg_image'] ) ) {
	$image_url      = wp_get_attachment_image_url( $header['bg_image'], 'full' );
	$inline_style[] = sprintf( 'background: url(%s);', esc_url( $image_url ) );
}

if ( ! empty( $inline_style ) ) {
	$style_atts   = implode( ' ', $inline_style );
	$inline_style = " style=\"{$style_atts}\"";
}

?>

<div class="wrap"<?php echo $inline_style; ?>>
	<div class="row offer-page__site-header-row center-xs">
		<div class="col-xs-12 text-align--center">
			<p class="offer-page__intro-text"><?php echo esc_html( $lead_in ); ?></p>
			<h1 class="offer-page__page-heading"><?php echo esc_html( $page_heading ); ?></h1>
		</div>
	</div>
</div>
