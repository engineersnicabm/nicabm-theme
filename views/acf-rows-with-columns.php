<?php
/**
 * @var array $row   Heading, width, align, bg_image, bg_color, content_block (array).
 * @var int   $index Row index.
 */

namespace NICABM\ChildTheme;

$heading   = $row['heading'];
$width     = $row['width'];
$alignment = $row['align'];
$padding   = $row['padding'] ?? 'normal';

$section_id      = sprintf( 'sales-page__section--%s-%s', get_the_ID(), $index );
$section_classes = sprintf( 'sales-page__section sales-page__section--padding-%s', $padding );

$inline_style = [];

// Background image.
if ( ! empty( $row['bg_image'] ) ) {
	$inline_style[] = sprintf( 'background-image: url(%s);',
		esc_url( wp_get_attachment_image_url( $row['bg_image'], 'full' ) )
	);
}

// Background color.
if ( ! empty( $row['bg_color'] ) ) {
	$inline_style[] = sprintf( 'background-color: %s;', esc_url( $row['bg_color'] ) );
}

$row_width_lookup = [
	'normal' => 'wrap',
	'narrow' => 'wrap wrap--narrow',
	'wide'   => 'wrap wrap--full',
];

$alignment_lookup = [
	'left'          => 'start-xs',
	'right'         => 'end-xs',
	'center'        => 'center-xs',
	'space-between' => 'between-xs',
	'space-around'  => 'around-xs',
];

?>

<section id="<?php echo esc_attr( $section_id ); ?>" class="<?php echo esc_attr( $section_classes ); ?>" style="<?php echo implode( '', $inline_style ); // WPCS: XSS ok. ?>">
	<div class="<?php echo esc_attr( $row_width_lookup[ $width ] ); ?>">
		<div class="row <?php echo esc_attr( $alignment_lookup[ $alignment ] ); ?>">
			<?php if ( ! empty( $heading ) ) : ?>
			<h2 class="col-xs-12"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>

			<?php
			array_walk( $row['content_block'], function ( $content ) {
				include NICABM_THEME_VIEWS_DIR . '/partials/content-block.php';
			} );
			?>
		</div>
	</div>
</section>
