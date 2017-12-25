<?php
/**
 * @var array $row Heading, width, align, bg_image, bg_color, content_block (array).
 */

namespace NICABM\ChildTheme;

$heading = $row['heading'];
$width = $row['width'];
$alignment = $row['align'];

$alignment_lookup = [
	'left' => 'start-xs',
	'right' => 'end-xs',
	'center' => 'center-xs',
	'space-between' => 'between-xs',
	'space-around' => 'around-xs',
];

?>

	<section class="row <?php echo esc_attr( $alignment_lookup[ $alignment ] ); ?>">
		<?php
			array_walk( $row['content_block'], function( $content ) {
				include NICABM_THEME_VIEWS_DIR . '/partials/content-block.php';
			} );
		?>
	</section>
