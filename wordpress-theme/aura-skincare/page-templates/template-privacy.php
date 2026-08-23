<?php
/**
 * Template Name: Luxury Privacy Policy
 * Template Post Type: page
 *
 * @package Aura_Skincare
 */

get_header();
?>
<div class="aura-page-wrapper" style="background: var(--color-bg); padding: clamp(4rem, 6vw, 6rem) 0;">
	<div class="aura-container-wide" style="max-width: 860px; margin: 0 auto; padding: 0 1.5rem;">
		
		<div style="text-align: center; margin-bottom: 3.5rem;">
			<span class="section-eyebrow" style="color: var(--color-gold); font-size: 0.78rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; display: block; margin-bottom: 0.5rem;"><?php esc_html_e( 'LEGAL & DATA COMPLIANCE', 'aura-skincare' ); ?></span>
			<h1 class="section-title" style="font-family: var(--font-heading); font-size: clamp(2.2rem, 4vw, 3rem); color: var(--color-heading); margin-bottom: 1rem; font-weight: 400;"><?php esc_html_e( 'Privacy Notice & Data Policy', 'aura-skincare' ); ?></h1>
			<p style="color: var(--color-text-light); font-size: 0.95rem;"><?php esc_html_e( 'Last updated: August 2026', 'aura-skincare' ); ?></p>
		</div>

		<div style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 16px; padding: clamp(2rem, 4vw, 3rem); line-height: 1.9; color: var(--color-text-main); font-size: 0.95rem; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
			<h2 style="font-family: var(--font-heading); font-size: 1.35rem; color: var(--color-heading); margin-bottom: 0.75rem;"><?php esc_html_e( '1. Commitment to Privacy', 'aura-skincare' ); ?></h2>
			<p style="margin-bottom: 1.5rem;"><?php esc_html_e( 'At AURA Botanical Skincare, we honor your personal privacy just as we honor your skin. We will never sell, rent, or monetize your private contact or browsing information to third-party data brokers.', 'aura-skincare' ); ?></p>

			<h2 style="font-family: var(--font-heading); font-size: 1.35rem; color: var(--color-heading); margin-bottom: 0.75rem;"><?php esc_html_e( '2. Information We Collect', 'aura-skincare' ); ?></h2>
			<p style="margin-bottom: 1.5rem;"><?php esc_html_e( 'We collect only the essential details necessary to fulfill your orders and offer personalized skincare advice: name, shipping address, contact email, and payment tokens encrypted via 256-bit SSL protocols.', 'aura-skincare' ); ?></p>

			<h2 style="font-family: var(--font-heading); font-size: 1.35rem; color: var(--color-heading); margin-bottom: 0.75rem;"><?php esc_html_e( '3. Cookie Policy & Security', 'aura-skincare' ); ?></h2>
			<p style="margin-bottom: 1.5rem;"><?php esc_html_e( 'Cookies are utilized solely to preserve your active shopping bag contents and deliver seamless page load acceleration.', 'aura-skincare' ); ?></p>

			<h2 style="font-family: var(--font-heading); font-size: 1.35rem; color: var(--color-heading); margin-bottom: 0.75rem;"><?php esc_html_e( '4. Contact Our Privacy Officer', 'aura-skincare' ); ?></h2>
			<p><?php esc_html_e( 'For data access or erasure requests, contact privacy@aura-skincare.local.', 'aura-skincare' ); ?></p>
		</div>

	</div>
</div>
<?php
get_footer();
