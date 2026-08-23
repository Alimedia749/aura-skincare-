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
	<!-- ── CONTACT & CONCIERGE SECTION ────────── -->
	<section id="contact" class="aura-contact-section" style="background: #FAF7F2; padding: 5rem 0; border-top: 1px solid var(--color-border);">
		<div class="aura-container-wide">
			<div style="max-width: 720px; margin: 0 auto 3.5rem auto; text-align: center;">
				<span class="section-eyebrow" style="color: var(--color-gold); font-size: 0.78rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase;"><?php esc_html_e( 'DIRECT CONCIERGE & SUPPORT', 'aura-skincare' ); ?></span>
				<h2 class="section-title" style="font-family: var(--font-heading); font-size: clamp(2rem, 3.5vw, 2.75rem); color: var(--color-heading); margin: 0.75rem 0 1rem; font-weight: 400;"><?php esc_html_e( 'Connect with Our Skin Specialists', 'aura-skincare' ); ?></h2>
				<p style="color: var(--color-text-light); font-size: 0.95rem; line-height: 1.7;"><?php esc_html_e( 'Have questions about botanical formulations, ritual pairings, or your current order? Our aesthetic advisors are here to assist you.', 'aura-skincare' ); ?></p>
			</div>

			<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; max-width: 1120px; margin: 0 auto 3.5rem auto;">
				
				<!-- Card 1: Direct Support -->
				<div style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 12px; padding: 2.2rem; text-align: center; transition: transform 0.3s ease, box-shadow 0.3s ease; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
					<div style="width: 52px; height: 52px; border-radius: 50%; background: var(--color-gold-light); color: var(--color-gold); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
						<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
					</div>
					<h3 style="font-family: var(--font-heading); font-size: 1.25rem; color: var(--color-heading); margin-bottom: 0.5rem;"><?php esc_html_e( 'Direct Client Care', 'aura-skincare' ); ?></h3>
					<p style="font-size: 0.88rem; color: var(--color-text-light); margin-bottom: 1rem; line-height: 1.6;"><?php esc_html_e( 'Available Mon-Fri 9:00 AM – 7:00 PM EST', 'aura-skincare' ); ?></p>
					<a href="tel:+18002872754" style="color: var(--color-gold); font-weight: 600; text-decoration: none; font-size: 0.95rem; letter-spacing: 0.04em;">+1 (800) 287-2754</a>
				</div>

				<!-- Card 2: Email Inquiries -->
				<div style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 12px; padding: 2.2rem; text-align: center; transition: transform 0.3s ease, box-shadow 0.3s ease; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
					<div style="width: 52px; height: 52px; border-radius: 50%; background: var(--color-gold-light); color: var(--color-gold); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
						<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
					</div>
					<h3 style="font-family: var(--font-heading); font-size: 1.25rem; color: var(--color-heading); margin-bottom: 0.5rem;"><?php esc_html_e( 'Skin Consultation', 'aura-skincare' ); ?></h3>
					<p style="font-size: 0.88rem; color: var(--color-text-light); margin-bottom: 1rem; line-height: 1.6;"><?php esc_html_e( 'Detailed responses within 2 hours', 'aura-skincare' ); ?></p>
					<a href="mailto:concierge@aura-skincare.local" style="color: var(--color-gold); font-weight: 600; text-decoration: none; font-size: 0.95rem; letter-spacing: 0.04em;">concierge@aura-skincare.local</a>
				</div>

				<!-- Card 3: Flagship Studio -->
				<div style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 12px; padding: 2.2rem; text-align: center; transition: transform 0.3s ease, box-shadow 0.3s ease; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
					<div style="width: 52px; height: 52px; border-radius: 50%; background: var(--color-gold-light); color: var(--color-gold); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
						<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
					</div>
					<h3 style="font-family: var(--font-heading); font-size: 1.25rem; color: var(--color-heading); margin-bottom: 0.5rem;"><?php esc_html_e( 'Botanical Lab & Studio', 'aura-skincare' ); ?></h3>
					<p style="font-size: 0.88rem; color: var(--color-text-light); margin-bottom: 1rem; line-height: 1.6;"><?php esc_html_e( '742 Evergreen Botanical Way, SoHo, NY', 'aura-skincare' ); ?></p>
					<span style="color: var(--color-gold); font-weight: 600; font-size: 0.95rem;"><?php esc_html_e( 'Open Daily for Consultations', 'aura-skincare' ); ?></span>
				</div>

			</div>

			<!-- Interactive Message Form -->
			<div style="max-width: 720px; margin: 0 auto; background: #ffffff; border: 1px solid var(--color-border); border-radius: 16px; padding: clamp(2rem, 4vw, 3rem); box-shadow: 0 10px 30px rgba(0,0,0,0.04);">
				<h3 style="font-family: var(--font-heading); font-size: 1.5rem; color: var(--color-heading); margin-bottom: 0.5rem; text-align: center;"><?php esc_html_e( 'Send a Direct Inquiry', 'aura-skincare' ); ?></h3>
				<p style="font-size: 0.88rem; color: var(--color-text-light); text-align: center; margin-bottom: 2rem;"><?php esc_html_e( 'Our clinical advisors will respond with a tailored recommendation.', 'aura-skincare' ); ?></p>
				
				<form onsubmit="event.preventDefault(); showAuraToast('Thank you! Your message has been sent to our Skin Concierge.'); this.reset();" style="display: grid; gap: 1.25rem;">
					<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.25rem;">
						<div>
							<label style="display: block; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--color-heading); margin-bottom: 0.4rem;"><?php esc_html_e( 'Full Name', 'aura-skincare' ); ?></label>
							<input type="text" required placeholder="Jane Doe" style="width: 100%; padding: 0.85rem 1rem; border: 1px solid var(--color-border); border-radius: 6px; font-family: inherit; font-size: 0.9rem; background: #FAF7F2; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--color-gold)'" onblur="this.style.borderColor='var(--color-border)'">
						</div>
						<div>
							<label style="display: block; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--color-heading); margin-bottom: 0.4rem;"><?php esc_html_e( 'Email Address', 'aura-skincare' ); ?></label>
							<input type="email" required placeholder="jane@example.com" style="width: 100%; padding: 0.85rem 1rem; border: 1px solid var(--color-border); border-radius: 6px; font-family: inherit; font-size: 0.9rem; background: #FAF7F2; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--color-gold)'" onblur="this.style.borderColor='var(--color-border)'">
						</div>
					</div>

					<div>
						<label style="display: block; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--color-heading); margin-bottom: 0.4rem;"><?php esc_html_e( 'Primary Skin Concern / Subject', 'aura-skincare' ); ?></label>
						<select style="width: 100%; padding: 0.85rem 1rem; border: 1px solid var(--color-border); border-radius: 6px; font-family: inherit; font-size: 0.9rem; background: #FAF7F2; outline: none;">
							<option><?php esc_html_e( 'Formula Recommendation for My Skin Type', 'aura-skincare' ); ?></option>
							<option><?php esc_html_e( 'Order Status & Tracking Inquiry', 'aura-skincare' ); ?></option>
							<option><?php esc_html_e( 'Wholesale & Partnership Request', 'aura-skincare' ); ?></option>
							<option><?php esc_html_e( 'Press & Editorial Inquiries', 'aura-skincare' ); ?></option>
						</select>
					</div>

					<div>
						<label style="display: block; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--color-heading); margin-bottom: 0.4rem;"><?php esc_html_e( 'Your Message', 'aura-skincare' ); ?></label>
						<textarea rows="4" required placeholder="How can we assist your ritual journey today?" style="width: 100%; padding: 0.85rem 1rem; border: 1px solid var(--color-border); border-radius: 6px; font-family: inherit; font-size: 0.9rem; background: #FAF7F2; outline: none; resize: vertical; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--color-gold)'" onblur="this.style.borderColor='var(--color-border)'"></textarea>
					</div>

					<button type="submit" class="aura-btn aura-btn-primary" style="justify-content: center; width: 100%; padding: 1rem; font-size: 0.9rem;">
						<span><?php esc_html_e( 'Submit Message to Concierge', 'aura-skincare' ); ?></span>
						<svg viewBox="0 0 20 20" width="16" height="16" fill="currentColor"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
					</button>
				</form>
			</div>

		</div>
	</section>

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
						<ul style="list-style:none; display:flex; flex-direction:column; gap:0.65rem; font-size:0.88rem; margin:0; padding:0;">
							<li><a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'All Products', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/#bestsellers' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Bestsellers', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'New Arrivals', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Sets & Kits', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/gift-cards/' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Gift Cards', 'aura-skincare' ); ?></a></li>
						</ul>
					</div>

					<!-- Column 3: Collections Menu -->
					<div>
						<div class="footer-col-title"><?php esc_html_e( 'COLLECTIONS', 'aura-skincare' ); ?></div>
						<ul style="list-style:none; display:flex; flex-direction:column; gap:0.65rem; font-size:0.88rem; margin:0; padding:0;">
							<li><a href="<?php echo esc_url( home_url( '/#categories' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Cleansers', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/#categories' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Serums & Oils', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/#categories' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Moisturizers', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/#categories' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Eye Care', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/#categories' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Toners & Mists', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/#categories' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Botanical Oils', 'aura-skincare' ); ?></a></li>
						</ul>
					</div>

					<!-- Column 4: About Menu -->
					<div>
						<div class="footer-col-title"><?php esc_html_e( 'ABOUT', 'aura-skincare' ); ?></div>
						<ul style="list-style:none; display:flex; flex-direction:column; gap:0.65rem; font-size:0.88rem; margin:0; padding:0;">
							<li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Our Story', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Ingredients & Science', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Sustainability', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/#press' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Press & Editorial', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/careers/' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Careers', 'aura-skincare' ); ?></a></li>
						</ul>
					</div>

					<!-- Column 5: Help Menu -->
					<div>
						<div class="footer-col-title"><?php esc_html_e( 'HELP', 'aura-skincare' ); ?></div>
						<ul style="list-style:none; display:flex; flex-direction:column; gap:0.65rem; font-size:0.88rem; margin:0; padding:0;">
							<li><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'FAQ', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/shipping-returns/' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Shipping & Returns', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/track-order/' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Track Order', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Contact Us', 'aura-skincare' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; transition:color 0.2s;"><?php esc_html_e( 'Privacy Policy', 'aura-skincare' ); ?></a></li>
						</ul>
					</div>

					<!-- Column 6: Concierge & Contact Details -->
					<div>
						<div class="footer-col-title"><?php esc_html_e( 'CONCIERGE & CONTACT', 'aura-skincare' ); ?></div>
						<div style="font-size:0.85rem; color:rgba(255,255,255,0.7); line-height:1.6; margin-bottom:1.25rem; display:flex; flex-direction:column; gap:0.5rem;">
							<div><strong style="color:var(--color-gold);"><?php esc_html_e( 'Call:', 'aura-skincare' ); ?></strong> <a href="tel:+18002872754" style="color:inherit; text-decoration:none;">+1 (800) 287-2754</a></div>
							<div><strong style="color:var(--color-gold);"><?php esc_html_e( 'Email:', 'aura-skincare' ); ?></strong> <a href="mailto:<?php echo esc_attr( $email ); ?>" style="color:inherit; text-decoration:none;"><?php echo esc_html( $email ); ?></a></div>
							<div><strong style="color:var(--color-gold);"><?php esc_html_e( 'Hours:', 'aura-skincare' ); ?></strong> Mon-Sat 9AM – 8PM EST</div>
							<div><strong style="color:var(--color-gold);"><?php esc_html_e( 'Studio:', 'aura-skincare' ); ?></strong> SoHo, New York, NY</div>
						</div>
						<a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" class="aura-btn aura-btn-gold aura-btn-sm" style="width:100%; justify-content:center;">
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
					<a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>" style="color: inherit; text-decoration: none;">Terms of Service</a>
					<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>" style="color: inherit; text-decoration: none;">Privacy Policy</a>
					<a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>" style="color: inherit; text-decoration: none;">Help & FAQ</a>
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
