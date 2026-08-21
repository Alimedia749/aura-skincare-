<?php
/**
 * Editorial Press Quotes & Media Recognition Strip
 *
 * @package Aura_Skincare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="press-section" aria-label="<?php esc_attr_e( 'Press Recognition', 'aura-skincare' ); ?>">
	<div class="aura-container-wide">
		<div class="press-header">
			<span class="press-eyebrow"><?php esc_html_e( 'AS SEEN & CELEBRATED IN', 'aura-skincare' ); ?></span>
		</div>
		
		<div class="press-grid">
			<div class="press-card">
				<div class="press-logo">VOGUE</div>
				<p class="press-quote">"The gold standard for botanical cellular hydration."</p>
			</div>

			<div class="press-card">
				<div class="press-logo">BAZAAR</div>
				<p class="press-quote">"Transformative, quiet luxury skincare that actually delivers."</p>
			</div>

			<div class="press-card">
				<div class="press-logo">allure</div>
				<p class="press-quote">"Best of Beauty winner — unmatched barrier restoration."</p>
			</div>

			<div class="press-card">
				<div class="press-logo">ELLE</div>
				<p class="press-quote">"The clean ritual taking over the modern vanity table."</p>
			</div>
		</div>
	</div>
</section>

<style>
@media (max-width: 992px) {
	.press-grid {
		grid-template-columns: repeat(2, 1fr) !important;
		gap: 1.5rem !important;
	}
	.press-card {
		border-right: none !important;
	}
}
@media (max-width: 540px) {
	.press-grid {
		grid-template-columns: 1fr !important;
	}
}
</style>
