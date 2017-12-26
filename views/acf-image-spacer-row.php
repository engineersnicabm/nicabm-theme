<?php
/**
 * @var array $row Row meta data
 */

$width   = 'normal';
$padding = 'normal';

$section_id      = sprintf( 'sales-page__section--%s-%s', get_the_ID(), $index );
$section_classes = 'sales-page__section sales-page__section--image-spacer';

$inline_style = [];

// Background image.
if ( ! empty( $row['bg_image'] ) ) {
	$inline_style[] = sprintf( 'background-image: url(%s);',
		esc_url( wp_get_attachment_image_url( $row['bg_image'], 'full' ) )
	);
}

?>

<section id="<?php echo esc_attr( $section_id ); ?>" class="<?php echo esc_attr( $section_classes ); ?>" style="<?php echo implode( '', $inline_style ); // WPCS: XSS ok. ?>">
</section>
