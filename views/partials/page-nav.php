<?php
/**
 * @var array $nav_links Keys: text, link
 */
?>

<nav class="nav-primary" itemscope="" itemtype="https://schema.org/SiteNavigationElement" id="genesis-nav-primary" aria-label="Main navigation">
	<div class="wrap">
		<ul id="menu-primary-navigation" class="menu genesis-nav-menu menu-primary responsive-menu" style="touch-action: pan-y;">
			<?php foreach ( $nav_links as $nav_link ) : ?>
				<?php
				unset( $classes );
				$classes[] = 'menu-item';
				if ( ! empty( $nav_link['button'] ) ) {
					$classes[] = 'menu-item--button';
				}
				?>
				<li class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
					<a href="<?php echo esc_url( $nav_link['link'] ); ?>" itemprop="url">
						<span itemprop="name"><?php echo esc_html( $nav_link['text'] ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</nav>
