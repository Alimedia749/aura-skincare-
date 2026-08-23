<?php
/**
 * Template Name: Luxury Terms of Service
 * Template Post Type: page
 *
 * @package Aura_Skincare
 */

get_header();
?>
<div class="aura-page-wrapper" style="background: var(--color-bg); padding: clamp(4rem, 6vw, 6rem) 0;">
	<div class="aura-container-wide" style="max-width: 860px; margin: 0 auto; padding: 0 1.5rem;">
		
		<div style="text-align: center; margin-bottom: 3.5rem;">
			<span class="section-eyebrow" style="color: var(--color-gold); font-size: 0.78rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; display: block; margin-bottom: 0.5rem;"><?php esc_html_e( 'LEGAL FRAMEWORK', 'aura-skincare' ); ?></span>
			<h1 class="section-title" style="font-family: var(--font-heading); font-size: clamp(2.2rem, 4vw, 3rem); color: var(--color-heading); margin-bottom: 1rem; font-weight: 400;"><?php esc_html_e( 'Terms of Service', 'aura-skincare' ); ?></h1>
			<p style="color: var(--color-text-light); font-size: 0.95rem;"><?php esc_html_e( 'Last updated: August 2026', 'aura-skincare' ); ?></p>
		</div>

		<div style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 16px; padding: clamp(2rem, 4vw, 3rem); line-height: 1.9; color: var(--color-text-main); font-size: 0.95rem; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
			<h2 style="font-family: var(--font-heading); font-size: 1.35rem; color: var(--color-heading); margin-bottom: 0.75rem;"><?php esc_html_e( '1. Botanical Efficacy & General Use', 'aura-skincare' ); ?></h2>
			<p style="margin-bottom: 1.5rem;"><?php esc_html_e( 'All products, formulations, and skincare guidance provided by AURA are intended for cosmetic wellness purposes. Patch testing is always recommended prior to adopting new botanical actives.', 'aura-skincare' ); ?></p>

			<h2 style="font-family: var(--font-heading); font-size: 1.35rem; color: var(--color-heading); margin-bottom: 0.75rem;"><?php esc_html_e( '2. Purchases & Currency', 'aura-skincare' ); ?></h2>
			<p style="margin-bottom: 1.5rem;"><?php esc_html_e( 'All prices are quoted in USD unless localized otherwise. Orders are confirmed upon successful credit card authorization or digital wallet clearance.', 'aura-skincare' ); ?></p>

			<h2 style="font-family: var(--font-heading); font-size: 1.35rem; color: var(--color-heading); margin-bottom: 0.75rem;"><?php esc_html_e( '3. Intellectual Property', 'aura-skincare' ); ?></h2>
			<p><?php esc_html_e( 'All trademarks, formulations, imagery, and written ritual descriptions are the sole intellectual property of AURA Skincare Collective.', 'aura-skincare' ); ?></p>
		</div>

	</div>
</div>
<?php
get_footer();
