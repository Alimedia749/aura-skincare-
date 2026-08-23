<?php
/**
 * Template Name: Luxury Careers & Opportunities
 * Template Post Type: page
 *
 * @package Aura_Skincare
 */

get_header();
?>
<div class="aura-page-wrapper" style="background: var(--color-bg); padding: clamp(4rem, 6vw, 6rem) 0;">
	<div class="aura-container-wide" style="max-width: 900px; margin: 0 auto; padding: 0 1.5rem;">
		
		<div style="text-align: center; margin-bottom: 3.5rem;">
			<span class="section-eyebrow" style="color: var(--color-gold); font-size: 0.78rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; display: block; margin-bottom: 0.5rem;"><?php esc_html_e( 'JOIN OUR FORMULATION LAB', 'aura-skincare' ); ?></span>
			<h1 class="section-title" style="font-family: var(--font-heading); font-size: clamp(2.2rem, 4vw, 3rem); color: var(--color-heading); margin-bottom: 1rem; font-weight: 400;"><?php esc_html_e( 'Careers at AURA', 'aura-skincare' ); ?></h1>
			<p style="color: var(--color-text-light); font-size: 1rem; line-height: 1.7; max-width: 600px; margin: 0 auto;"><?php esc_html_e( 'We are building the future of biocompatible luxury skincare. Join our team of botanists, cosmetic chemists, and aesthetic advisors.', 'aura-skincare' ); ?></p>
		</div>

		<div style="display: flex; flex-direction: column; gap: 1.5rem;">
			
			<div style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 16px; padding: 2rem 2.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
				<div>
					<span style="color: var(--color-gold); font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em;"><?php esc_html_e( 'R&D / FORMULATION LAB', 'aura-skincare' ); ?></span>
					<h3 style="font-family: var(--font-heading); font-size: 1.35rem; color: var(--color-heading); margin: 0.25rem 0;"><?php esc_html_e( 'Senior Botanical Cosmetic Chemist', 'aura-skincare' ); ?></h3>
					<span style="font-size: 0.88rem; color: var(--color-text-light);"><?php esc_html_e( 'New York, NY (Hybrid) · Full-Time', 'aura-skincare' ); ?></span>
				</div>
				<a href="mailto:careers@aura-skincare.local?subject=Application:%20Senior%20Cosmetic%20Chemist" class="aura-btn aura-btn-outline aura-btn-sm">
					<span><?php esc_html_e( 'Apply Now', 'aura-skincare' ); ?></span>
				</a>
			</div>

			<div style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 16px; padding: 2rem 2.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
				<div>
					<span style="color: var(--color-gold); font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em;"><?php esc_html_e( 'CLIENT EXPERIENCE', 'aura-skincare' ); ?></span>
					<h3 style="font-family: var(--font-heading); font-size: 1.35rem; color: var(--color-heading); margin: 0.25rem 0;"><?php esc_html_e( 'Senior Skin Concierge & Aesthetician', 'aura-skincare' ); ?></h3>
					<span style="font-size: 0.88rem; color: var(--color-text-light);"><?php esc_html_e( 'Remote / Worldwide · Full-Time', 'aura-skincare' ); ?></span>
				</div>
				<a href="mailto:careers@aura-skincare.local?subject=Application:%20Senior%20Skin%20Concierge" class="aura-btn aura-btn-outline aura-btn-sm">
					<span><?php esc_html_e( 'Apply Now', 'aura-skincare' ); ?></span>
				</a>
			</div>

		</div>

	</div>
</div>
<?php
get_footer();
