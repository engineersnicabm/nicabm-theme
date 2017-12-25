<?php
/**
 * @var array $content Includes 'width', and 'content' keys.
 */

namespace NICABM\ChildTheme;

$width_lookup = [
	'one-sixth'     => 'col-xs-12 col-sm-2',
	'one-fourth'    => 'col-xs-12 col-sm-3',
	'one-third'     => 'col-xs-12 col-sm-4',
	'one-half'      => 'col-xs-12 col-sm-6',
	'two-thirds'    => 'col-xs-12 col-sm-8',
	'three-fourths' => 'col-xs-12 col-sm-9',
	'five-sixths'   => 'col-xs-12 col-sm-10',
	'full'          => 'col-xs-12 col-sm-12',
];

?>

<div class="<?php echo esc_attr( $width_lookup[ $content['width'] ] ); ?>">
	<?php echo apply_filters( 'meta_content', wp_kses_post( $content['content'] ) ); // WPCS: XSS ok. ?>
</div>
