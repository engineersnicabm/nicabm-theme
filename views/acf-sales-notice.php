<?php
/**
 * @var array $row   Row data.
 * @var int   $index Row index.
 */

namespace NICABM\ChildTheme;

$sales_row_content = get_sales_page_post_meta( 'nicabm_sales_notice' );

if ( empty( $sales_row_content['time_start'] ) ) {
	return '';
}

$notice_start_time = strtotime( $sales_row_content['time_start'] );
$notice_end_time   = $sales_row_content['time_end']
	? strtotime( $sales_row_content['time_end'] )
	: null;

// Check if current time is outside of the start-end range.
$current_time = current_time( 'timestamp' );
if (
	$current_time < $notice_start_time
	|| isset( $notice_end_time ) && $current_time > $notice_end_time
) {
	return '';
}

$width   = 'wide';
$padding = 'normal';

$section_id      = sprintf( 'sales-page__section--%s-%s', get_the_ID(), $index );
$section_classes = 'sales-page__section sales-page__section--notice';

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
		<?php echo apply_filters( 'meta_content', wp_kses_post( $sales_row_content['message'] ) ); // WPCS: XSS ok.
		?>
	</div>
</section>
