<?php
/**
 * Main Site Navigation Template Part
 *
 * @package Aura_Skincare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cart_count = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 1;
?>

<div class="site-nav-wrapper">
	<div class="aura-container-wide">
		<div class="site-nav-inner">
			
			<!-- Mobile Hamburger Toggle -->
			<button class="mobile-menu-toggle" aria-label="<?php esc_attr_e( 'Toggle Menu', 'aura-skincare' ); ?>" aria-expanded="false">
				<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
					<line x1="3" y1="6" x2="21" y2="6"></line>
					<line x1="3" y1="12" x2="21" y2="12"></line>
					<line x1="3" y1="18" x2="21" y2="18"></line>
				</svg>
			</button>

			<!-- Site Branding / Logo -->
			<div class="site-branding">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo-link" rel="home">
						<svg class="site-logo-mark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
							<circle cx="12" cy="12" r="10" />
							<path d="M12 2a7 7 0 0 1 7 7c0 5-7 13-7 13S5 14 5 9a7 7 0 0 1 7-7z" fill="currentColor" fill-opacity="0.15" />
						</svg>
						<span class="site-logo-text">Aura</span>
					</a>
				<?php endif; ?>
			</div>

			<!-- Primary Desktop Navigation -->
			<nav class="site-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'aura-skincare' ); ?>">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_class'     => 'primary-menu',
							'container'      => false,
							'depth'          => 2,
							'fallback_cb'    => false,
						)
					);
				} else {
					// Editorial luxury default menu
					?>
					<ul class="primary-menu">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'aura-skincare' ); ?></a></li>
						<li class="menu-item-has-children">
							<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>">
								<span><?php esc_html_e( 'Shop', 'aura-skincare' ); ?></span>
								<svg class="dropdown-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<polyline points="6 9 12 15 18 9"></polyline>
								</svg>
							</a>
							<ul class="sub-menu">
								<li><a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>"><?php esc_html_e( 'All Products', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#bestsellers' ) ); ?>"><?php esc_html_e( 'Bestsellers', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>"><?php esc_html_e( 'New Arrivals', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>"><?php esc_html_e( 'Sets & Kits', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/gift-cards/' ) ); ?>"><?php esc_html_e( 'Gift Cards', 'aura-skincare' ); ?></a></li>
							</ul>
						</li>
						<li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>"><?php esc_html_e( 'About Us', 'aura-skincare' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" onclick="var c=document.getElementById('contact')||document.getElementById('colophon'); if(c){ c.scrollIntoView({behavior:'smooth'}); }"><?php esc_html_e( 'Contact Us', 'aura-skincare' ); ?></a></li>
					</ul>
					<?php
				}
				?>
			</nav>

			<!-- Utility Actions: Search, Account, Bag -->
			<div class="nav-actions">
				<!-- Search -->
				<button class="nav-action-btn nav-action-search" aria-label="<?php esc_attr_e( 'Search rituals', 'aura-skincare' ); ?>" onclick="showAuraToast('Search catalog activated')">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="11" cy="11" r="8"></circle>
						<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
					</svg>
				</button>

				<!-- Customer Account -->
				<a href="<?php echo esc_url( function_exists( 'wc_get_account_endpoint_url' ) ? wc_get_account_endpoint_url( 'dashboard' ) : '#' ); ?>" class="nav-action-btn nav-action-account" aria-label="<?php esc_attr_e( 'My Account', 'aura-skincare' ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
						<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
						<circle cx="12" cy="7" r="4"></circle>
					</svg>
				</a>

				<!-- Offcanvas Bag / Cart Trigger -->
				<button class="nav-action-btn nav-action-bag" data-cart-toggle="true" aria-label="<?php esc_attr_e( 'Open Ritual Bag', 'aura-skincare' ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
						<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
						<line x1="3" y1="6" x2="21" y2="6"></line>
						<path d="M16 10a4 4 0 0 1-8 0"></path>
					</svg>
					<span class="aura-cart-count-badge <?php echo ( $cart_count > 0 ) ? 'has-items' : ''; ?>">
						<?php echo esc_html( $cart_count ); ?>
					</span>
				</button>
			</div>

		</div>
	</div>
</div>
