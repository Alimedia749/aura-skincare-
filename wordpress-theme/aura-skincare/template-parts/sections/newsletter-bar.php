<?php
/**
 * The Society VIP Newsletter Section
 *
 * @package Aura_Skincare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section id="newsletter" class="newsletter-section" aria-label="<?php esc_attr_e( 'Newsletter Subscription', 'aura-skincare' ); ?>">
	<div class="aura-container">
		<div class="newsletter-card">
			<span class="section-eyebrow"><?php esc_html_e( 'JOIN THE AURA SOCIETY', 'aura-skincare' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Receive 15% Off Your First Ritual', 'aura-skincare' ); ?></h2>
			<p class="section-subtitle">
				<?php esc_html_e( 'Subscribe to receive private masterclasses, early botanical batch access, and seasonal ritual gifts.', 'aura-skincare' ); ?>
			</p>

			<form class="newsletter-form" onsubmit="event.preventDefault(); alert('Welcome to The Aura Society! Your 15% code is AURA15');">
				<div class="newsletter-input-group">
					<input 
						type="email" 
						class="newsletter-input" 
						placeholder="<?php esc_attr_e( 'Enter your personal email address...', 'aura-skincare' ); ?>" 
						required 
					/>
					<button type="submit" class="aura-btn aura-btn-gold aura-btn-sm">
						<span><?php esc_html_e( 'Unlock 15% Off', 'aura-skincare' ); ?></span>
					</button>
				</div>
				<p class="newsletter-consent">
					<?php esc_html_e( 'By subscribing, you agree to our Privacy Policy. Unsubscribe anytime.', 'aura-skincare' ); ?>
				</p>
			</form>
		</div>
	</div>
</section>
