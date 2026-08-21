<?php
/**
 * Dual Editorial Story Banners: The Ritual & Clean Promise
 * Fully connected to WordPress Customizer
 *
 * @package Aura_Skincare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_uri = get_template_directory_uri();

$banner1_eyebrow = get_theme_mod( 'aura_banner1_eyebrow', 'The Sacred Ritual' );
$banner1_title   = get_theme_mod( 'aura_banner1_title', 'Morning Dew & Evening Recovery' );
$banner1_desc    = get_theme_mod( 'aura_banner1_desc', 'Elevate your daily rhythm with bio-fermented botanical actives designed to sync with your skin\'s natural circadian cycle.' );
$banner1_btn     = get_theme_mod( 'aura_banner1_btn_text', 'Explore The Collection' );

$banner2_eyebrow = get_theme_mod( 'aura_banner2_eyebrow', 'Our Clean Standard' );
$banner2_title   = get_theme_mod( 'aura_banner2_title', 'Zero Compromise on Purity' );
$banner2_desc    = get_theme_mod( 'aura_banner2_desc', 'Formulated without 2,700+ controversial ingredients. 100% vegan, cruelty-free, and bottled in sustainable infinity glass.' );
$banner2_btn     = get_theme_mod( 'aura_banner2_btn_text', 'Discover Our Promise' );
?>

<section id="ritual" class="editorial-banners-section" style="padding: clamp(3rem, 6vw, 6rem) 0; background-color: var(--color-bg-subtle);">
	<div class="aura-container-wide">
		<div style="display: grid; grid-template-columns: 1fr 1fr; gap: clamp(1.5rem, 3vw, 2.5rem);" class="editorial-dual-grid">
			
			<!-- Left Banner: The Ritual -->
			<div style="background-color: #ffffff; border-radius: var(--radius-lg); border: 1px solid var(--color-border); overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; position: relative;">
				<div style="padding: clamp(2rem, 4vw, 3.5rem); position: relative; z-index: 2;">
					<span class="section-eyebrow" style="margin-bottom: 0.5rem;"><?php echo esc_html( $banner1_eyebrow ); ?></span>
					<h3 style="font-family: var(--font-heading); font-size: clamp(2rem, 3.2vw, 2.8rem); font-weight: 400; line-height: 1.15; color: var(--color-heading); margin-bottom: 1rem;">
						<?php echo esc_html( $banner1_title ); ?>
					</h3>
					<p style="color: var(--color-text-muted); font-size: var(--text-base); line-height: 1.6; max-width: 440px; margin-bottom: 2rem;">
						<?php echo esc_html( $banner1_desc ); ?>
					</p>
					<a href="<?php echo esc_url( home_url( '/#bestsellers' ) ); ?>" class="aura-btn aura-btn-outline">
						<span><?php echo esc_html( $banner1_btn ); ?></span>
						<svg viewBox="0 0 20 20" width="16" height="16" fill="currentColor">
							<path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
						</svg>
					</a>
				</div>
				<div style="width: 100%; aspect-ratio: 16/9; overflow: hidden; background: #f0ebe1;">
					<img 
						src="<?php echo esc_url( $theme_uri . '/assets/images/ritual-banner.webp' ); ?>" 
						alt="<?php esc_attr_e( 'Aura Skincare botanical ritual bottles', 'aura-skincare' ); ?>"
						style="width: 100%; height: 100%; object-fit: cover;"
						loading="lazy"
					>
				</div>
			</div>

			<!-- Right Banner: Our Clean Promise -->
			<div id="promise" style="background-color: #ffffff; border-radius: var(--radius-lg); border: 1px solid var(--color-border); overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; position: relative;">
				<div style="padding: clamp(2rem, 4vw, 3.5rem); position: relative; z-index: 2;">
					<span class="section-eyebrow" style="margin-bottom: 0.5rem;"><?php echo esc_html( $banner2_eyebrow ); ?></span>
					<h3 style="font-family: var(--font-heading); font-size: clamp(2rem, 3.2vw, 2.8rem); font-weight: 400; line-height: 1.15; color: var(--color-heading); margin-bottom: 1.5rem;">
						<?php echo esc_html( $banner2_title ); ?>
					</h3>

					<div style="display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 1.5rem;">
						<div style="display: flex; align-items: flex-start; gap: 1rem;">
							<div style="width: 38px; height: 38px; border-radius: 50%; background: var(--color-sage-light); color: var(--color-sage); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
								<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
							</div>
							<div>
								<div style="font-weight: 600; font-size: 0.95rem; color: var(--color-heading);"><?php esc_html_e( 'Clean & Safe', 'aura-skincare' ); ?></div>
								<div style="font-size: 0.85rem; color: var(--color-text-muted);"><?php echo esc_html( $banner2_desc ); ?></div>
							</div>
						</div>

						<div style="display: flex; align-items: flex-start; gap: 1rem;">
							<div style="width: 38px; height: 38px; border-radius: 50%; background: var(--color-gold-light); color: var(--color-gold); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
								<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
							</div>
							<div>
								<div style="font-weight: 600; font-size: 0.95rem; color: var(--color-heading);"><?php esc_html_e( 'Sustainable Packaging', 'aura-skincare' ); ?></div>
								<div style="font-size: 0.85rem; color: var(--color-text-muted);"><?php esc_html_e( '100% recyclable infinity glass & FSC certified bamboo caps.', 'aura-skincare' ); ?></div>
							</div>
						</div>

						<div style="display: flex; align-items: flex-start; gap: 1rem;">
							<div style="width: 38px; height: 38px; border-radius: 50%; background: var(--color-rose-light); color: var(--color-rose); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
								<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
							</div>
							<div>
								<div style="font-weight: 600; font-size: 0.95rem; color: var(--color-heading);"><?php esc_html_e( '100% Cruelty Free & Leaping Bunny', 'aura-skincare' ); ?></div>
								<div style="font-size: 0.85rem; color: var(--color-text-muted);"><?php esc_html_e( 'Never tested on animals at any stage of formulation.', 'aura-skincare' ); ?></div>
							</div>
						</div>
					</div>
				</div>

				<div style="width: 100%; aspect-ratio: 16/9; overflow: hidden; background: #f0ebe1;">
					<img 
						src="<?php echo esc_url( $theme_uri . '/assets/images/promise-model.webp' ); ?>" 
						alt="<?php esc_attr_e( 'Aura Skincare glowing complexion model', 'aura-skincare' ); ?>"
						style="width: 100%; height: 100%; object-fit: cover;"
						loading="lazy"
					>
				</div>
			</div>

		</div>
	</div>
</section>

<style>
@media (max-width: 900px) {
	.editorial-dual-grid {
		grid-template-columns: 1fr !important;
	}
}
</style>
