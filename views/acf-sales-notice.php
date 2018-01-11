<?php
/**
 * @var array $row   Row data.
 * @var int   $index Row index.
 */

namespace NICABM\ChildTheme;

$sales_row_content = get_sales_page_post_meta( 'nicabm_sales_notice' );

if ( empty( $sales_row_content ) ) {
	return '';
}

foreach ( $sales_row_content as $sales_notice ) {
	$start_time = strtotime( $sales_notice['time_start'] ) ?? null;
	$too_early  = current_time( 'timestamp' ) < $start_time;

	// Skip if it's not time to display the notice.
	if ( $too_early ) {
		continue;
	}

	// Build an array of messages indexed by the start time.
	$sales_notices[ $start_time ] = [
		'time_end' => strtotime( $sales_notice['time_end'] ) ?? null,
		'message'  => $sales_notice['message'],
	];
}

if ( empty( $sales_notices ) ) {
	return '';
}

// Sort the array by keys (start time), then grab the last element of the array.
ksort( $sales_notices );
$notice = end( $sales_notices );

$notice_expired = isset( $notice['time_end'] ) && current_time( 'timestamp' ) > $notice['time_end'];
if ( $notice_expired ) {
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

<section id="<?php echo esc_attr( $section_id ); ?>" class="<?php echo esc_attr( $section_classes ); ?>" style="<?php echo implode( '', $inline_style ); // WPCS: XSS ok.?>">
	<div class="<?php echo esc_attr( $row_width_lookup[ $width ] ); ?>">
		<?php echo apply_filters( 'meta_content', wp_kses_post( $notice['message'] ) ); // WPCS: XSS ok. ?>
	</div>
</section>
