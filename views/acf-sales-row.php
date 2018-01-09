<?php
/**
 * @var array $row   Row data.
 * @var int   $index Row index.
 */

namespace NICABM\ChildTheme;

$sales_row_content = get_sales_page_post_meta( 'nicabm_sales_row' );

$width   = 'normal';
$padding = 'normal';

$section_id      = sprintf( 'sales-page__section--%s-%s', get_the_ID(), $index );
$section_classes = sprintf( 'sales-page__section sales-page__section--padding-%s', $padding );

$inline_style = [];

// Background color.
if ( ! empty( $row['bg_color'] ) ) {
	$inline_style[] = sprintf( 'background-color: %s;', esc_attr( $row['bg_color'] ) );
}

$row_width_lookup = [
	'normal' => 'wrap',
	'narrow' => 'wrap wrap--narrow',
	'wide'   => 'wrap wrap--full',
];

?>

<section id="<?php echo esc_attr( $section_id ); ?>" class="<?php echo esc_attr( $section_classes ); ?>" style="<?php echo implode( '', $inline_style ); // WPCS: XSS ok.
?>">
	<div class="<?php echo esc_attr( $row_width_lookup[ $width ] ); ?>">
		<div class="row">
			<div class="col-xs-12 text-align--center">
				<?php echo apply_filters( 'meta_content', wp_kses_post( $sales_row_content ) ); // WPCS: XSS ok. ?>
			</div>
		</div>
	</div>
</section>
