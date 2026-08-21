<?php
/**
 * The footer template for Aura Skincare Theme
 * Fully connected to WordPress Customizer, Menus, and Widgets
 *
 * @package Aura_Skincare
 */

$brand_desc  = get_theme_mod( 'aura_footer_brand_desc', 'Elevated skincare made with clean ingredients and backed by science. Formulated in Switzerland & New York.' );
$insta_url   = get_theme_mod( 'aura_social_instagram', 'https://instagram.com' );
$tiktok_url  = get_theme_mod( 'aura_social_tiktok', 'https://tiktok.com' );
$pin_url     = get_theme_mod( 'aura_social_pinterest', 'https://pinterest.com' );
$email       = get_theme_mod( 'aura_concierge_email', 'concierge@aura-skincare.local' );
$copyright   = get_theme_mod( 'aura_footer_copyright', 'AURA Skincare. All rights reserved.' );
?>

	<!-- ── FOOTER ─────────────────────────────── -->
	<footer id="colophon" class="site-footer" role="contentinfo">
		
		<!-- Trust Badges Bar -->
		<div class="trust-badges-bar">
			<div class="aura-container-wide">
				<div class="trust-badges-grid">
					
					<div class="trust-badge-item">
						<svg class="trust-badge-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
							<rect x="1" y="3" width="15" height="13"></rect>
							<polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
							<circle cx="5.5" cy="18.5" r="2.5"></circle>
							<circle cx="18.5" cy="18.5" r="2.5"></circle>
						</svg>
						<div>
							<div class="trust-badge-title"><?php esc_html_e( 'FREE SHIPPING', 'aura-skincare' ); ?></div>
							<div class="trust-badge-desc"><?php printf( esc_html__( 'On all orders over $%d', 'aura-skincare' ), esc_html( get_theme_mod( 'aura_free_shipping_threshold', 75 ) ) ); ?></div>
						</div>
					</div>

					<div class="trust-badge-item">
						<svg class="trust-badge-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
							<polyline points="20 6 9 17 4 12"></polyline>
						</svg>
						<div>
							<div class="trust-badge-title"><?php esc_html_e( '30-DAY RITUAL', 'aura-skincare' ); ?></div>
							<div class="trust-badge-desc"><?php esc_html_e( 'Guaranteed skin satisfaction', 'aura-skincare' ); ?></div>
						</div>
					</div>

					<div class="trust-badge-item">
						<svg class="trust-badge-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
							<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
						</svg>
						<div>
							<div class="trust-badge-title"><?php esc_html_e( '100% CLEAN', 'aura-skincare' ); ?></div>
							<div class="trust-badge-desc"><?php esc_html_e( 'No sulfates or parabens', 'aura-skincare' ); ?></div>
						</div>
					</div>

					<div class="trust-badge-item">
						<svg class="trust-badge-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
							<rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
							<path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
						</svg>
						<div>
							<div class="trust-badge-title"><?php esc_html_e( 'SECURE CHECKOUT', 'aura-skincare' ); ?></div>
							<div class="trust-badge-desc"><?php esc_html_e( '256-bit encrypted payments', 'aura-skincare' ); ?></div>
						</div>
					</div>

					<div class="trust-badge-item">
						<svg class="trust-badge-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
							<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
							<polyline points="22 4 12 14.01 9 11.01"></polyline>
						</svg>
						<div>
							<div class="trust-badge-title"><?php esc_html_e( 'DERM TESTED', 'aura-skincare' ); ?></div>
							<div class="trust-badge-desc"><?php esc_html_e( 'Hypoallergenic formulas', 'aura-skincare' ); ?></div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<!-- Main Footer Grid with WP Widgets / Nav Menus -->
		<div class="footer-main">
			<div class="aura-container-wide">
				<div class="footer-columns-grid">
					
					<!-- Column 1: Brand -->
					<div class="footer-col-brand">
						<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
							<?php dynamic_sidebar( 'footer-1' ); ?>
						<?php else : ?>
							<div class="footer-brand-title"><?php bloginfo( 'name' ); ?></div>
							<p class="footer-brand-desc">
								<?php echo esc_html( $brand_desc ); ?>
							</p>
							<div class="footer-social-links">
								<?php if ( ! empty( $insta_url ) ) : ?>
									<a href="<?php echo esc_url( $insta_url ); ?>" class="social-icon-btn" aria-label="Instagram" target="_blank" rel="noopener">
										<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
									</a>
								<?php endif; ?>
								<?php if ( ! empty( $tiktok_url ) ) : ?>
									<a href="<?php echo esc_url( $tiktok_url ); ?>" class="social-icon-btn" aria-label="TikTok" target="_blank" rel="noopener">
										<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>
									</a>
								<?php endif; ?>
								<?php if ( ! empty( $pin_url ) ) : ?>
									<a href="<?php echo esc_url( $pin_url ); ?>" class="social-icon-btn" aria-label="Pinterest" target="_blank" rel="noopener">
										<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>

					<!-- Column 2: Shop Menu -->
					<div>
						<div class="footer-col-title"><?php esc_html_e( 'SHOP', 'aura-skincare' ); ?></div>
						<?php
						if ( has_nav_menu( 'footer_shop' ) ) {
							wp_nav_menu(
								array(
									'theme_location' => 'footer_shop',
									'menu_class'     => 'footer-links-list',
									'container'      => false,
									'depth'          => 1,
								)
							);
						} else {
							?>
							<ul style="list-style:none; display:flex; flex-direction:column; gap:0.65rem; font-size:0.88rem;">
								<li><a href="<?php echo esc_url( home_url( '/#bestsellers' ) ); ?>"><?php esc_html_e( 'All Products', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#bestsellers' ) ); ?>"><?php esc_html_e( 'Bestsellers', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#categories' ) ); ?>"><?php esc_html_e( 'New Arrivals', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#categories' ) ); ?>"><?php esc_html_e( 'Sets & Kits', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#newsletter' ) ); ?>"><?php esc_html_e( 'Gift Cards', 'aura-skincare' ); ?></a></li>
							</ul>
							<?php
						}
						?>
					</div>

					<!-- Column 3: Collections Menu -->
					<div>
						<div class="footer-col-title"><?php esc_html_e( 'COLLECTIONS', 'aura-skincare' ); ?></div>
						<?php
						if ( has_nav_menu( 'footer_collections' ) ) {
							wp_nav_menu(
								array(
									'theme_location' => 'footer_collections',
									'menu_class'     => 'footer-links-list',
									'container'      => false,
									'depth'          => 1,
								)
							);
						} else {
							?>
							<ul style="list-style:none; display:flex; flex-direction:column; gap:0.65rem; font-size:0.88rem;">
								<li><a href="<?php echo esc_url( home_url( '/#categories' ) ); ?>"><?php esc_html_e( 'Hydration', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#categories' ) ); ?>"><?php esc_html_e( 'Brightening', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#categories' ) ); ?>"><?php esc_html_e( 'Anti-Aging', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#categories' ) ); ?>"><?php esc_html_e( 'Sensitive Skin', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#promise' ) ); ?>"><?php esc_html_e( 'Clean Skin', 'aura-skincare' ); ?></a></li>
							</ul>
							<?php
						}
						?>
					</div>

					<!-- Column 4: About Menu -->
					<div>
						<div class="footer-col-title"><?php esc_html_e( 'ABOUT', 'aura-skincare' ); ?></div>
						<?php
						if ( has_nav_menu( 'footer_about' ) ) {
							wp_nav_menu(
								array(
									'theme_location' => 'footer_about',
									'menu_class'     => 'footer-links-list',
									'container'      => false,
									'depth'          => 1,
								)
							);
						} else {
							?>
							<ul style="list-style:none; display:flex; flex-direction:column; gap:0.65rem; font-size:0.88rem;">
								<li><a href="<?php echo esc_url( home_url( '/#ritual' ) ); ?>"><?php esc_html_e( 'Our Story', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#promise' ) ); ?>"><?php esc_html_e( 'Ingredients', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#promise' ) ); ?>"><?php esc_html_e( 'Sustainability', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#press' ) ); ?>"><?php esc_html_e( 'Press', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Careers', 'aura-skincare' ); ?></a></li>
							</ul>
							<?php
						}
						?>
					</div>

					<!-- Column 5: Help Menu -->
					<div>
						<div class="footer-col-title"><?php esc_html_e( 'HELP', 'aura-skincare' ); ?></div>
						<?php
						if ( has_nav_menu( 'footer_help' ) ) {
							wp_nav_menu(
								array(
									'theme_location' => 'footer_help',
									'menu_class'     => 'footer-links-list',
									'container'      => false,
									'depth'          => 1,
								)
							);
						} else {
							?>
							<ul style="list-style:none; display:flex; flex-direction:column; gap:0.65rem; font-size:0.88rem;">
								<li><a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>"><?php esc_html_e( 'FAQ', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#shipping' ) ); ?>"><?php esc_html_e( 'Shipping & Returns', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#track' ) ); ?>"><?php esc_html_e( 'Track Order', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Contact Us', 'aura-skincare' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'aura-skincare' ); ?></a></li>
							</ul>
							<?php
						}
						?>
					</div>

					<!-- Column 6: Concierge Support -->
					<div>
						<div class="footer-col-title"><?php esc_html_e( 'CONCIERGE', 'aura-skincare' ); ?></div>
						<p style="font-size:0.85rem; color:rgba(255,255,255,0.6); line-height:1.5; margin-bottom:1rem;">
							<?php esc_html_e( 'Need advice matching formulas to your skin type?', 'aura-skincare' ); ?>
						</p>
						<a href="mailto:<?php echo esc_attr( $email ); ?>" class="aura-btn aura-btn-gold aura-btn-sm" style="width:100%; justify-content:center;">
							<span><?php esc_html_e( 'Consult Skin Expert', 'aura-skincare' ); ?></span>
						</a>
					</div>

				</div>
			</div>
		</div>

		<!-- Footer Bottom Bar -->
		<div style="border-top: 1px solid rgba(255,255,255,0.08); padding: 1.5rem 0; font-size: 0.78rem; color: rgba(255,255,255,0.45);">
			<div class="aura-container-wide" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
				<div>© <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( $copyright ); ?></div>
				<div style="display: flex; gap: 1.5rem;">
					<?php
					if ( has_nav_menu( 'footer_legal' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'footer_legal',
								'container'      => false,
								'depth'          => 1,
							)
						);
					} else {
						?>
						<a href="<?php echo esc_url( home_url( '/#terms' ) ); ?>" style="color: inherit;">Terms of Service</a>
						<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>" style="color: inherit;">Privacy Policy</a>
						<a href="<?php echo esc_url( home_url( '/#cookies' ) ); ?>" style="color: inherit;">Cookie Settings</a>
						<?php
					}
					?>
				</div>
			</div>
		</div>

	</footer>

	<!-- Offcanvas AJAX Cart Drawer -->
	<?php get_template_part( 'template-parts/cart/cart-drawer' ); ?>

	<!-- Toast Notification Container -->
	<div id="aura-toast" style="position:fixed; bottom:24px; left:50%; transform:translateX(-50%) translateY(100px); background:#141311; color:#fff; padding:12px 24px; border-radius:100px; font-size:14px; font-weight:600; box-shadow:0 8px 30px rgba(0,0,0,0.3); z-index:999999; transition:all 0.3s cubic-bezier(0.16,1,0.3,1); opacity:0; pointer-events:none;">
		<span id="aura-toast-msg">Added to your ritual bag</span>
	</div>

	<script>
	function showAuraToast(msg) {
		const t = document.getElementById('aura-toast');
		const m = document.getElementById('aura-toast-msg');
		if(t && m) {
			m.textContent = msg;
			t.style.opacity = '1';
			t.style.transform = 'translateX(-50%) translateY(0)';
			setTimeout(() => {
				t.style.opacity = '0';
				t.style.transform = 'translateX(-50%) translateY(100px)';
			}, 3000);
		}
	}
	</script>

	<?php wp_footer(); ?>
</body>
</html>
