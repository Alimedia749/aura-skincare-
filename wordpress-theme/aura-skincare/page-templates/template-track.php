<?php
/**
 * Template Name: Luxury Order Tracking
 * Template Post Type: page
 *
 * @package Aura_Skincare
 */

get_header();
?>
<div class="aura-page-wrapper" style="background: var(--color-bg); padding: clamp(4rem, 6vw, 6rem) 0; min-height: 70vh;">
	<div class="aura-container-wide" style="max-width: 720px; margin: 0 auto; padding: 0 1.5rem;">
		
		<div style="text-align: center; margin-bottom: 3.5rem;">
			<span class="section-eyebrow" style="color: var(--color-gold); font-size: 0.78rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; display: block; margin-bottom: 0.5rem;"><?php esc_html_e( 'LIVE FULFILLMENT STATUS', 'aura-skincare' ); ?></span>
			<h1 class="section-title" style="font-family: var(--font-heading); font-size: clamp(2.2rem, 4vw, 3rem); color: var(--color-heading); margin-bottom: 1rem; font-weight: 400;"><?php esc_html_e( 'Track Your Ritual Shipment', 'aura-skincare' ); ?></h1>
			<p style="color: var(--color-text-light); font-size: 1rem; line-height: 1.7;"><?php esc_html_e( 'Enter your order number and billing email to view real-time laboratory dispatch and courier milestones.', 'aura-skincare' ); ?></p>
		</div>

		<div style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 16px; padding: clamp(2rem, 4vw, 3rem); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
			<form id="trackOrderForm" onsubmit="event.preventDefault(); document.getElementById('trackingResults').style.display='block'; showAuraToast('Shipment record located.');" style="display: grid; gap: 1.25rem;">
				<div>
					<label style="display: block; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--color-heading); margin-bottom: 0.4rem;"><?php esc_html_e( 'Order Number / ID', 'aura-skincare' ); ?></label>
					<input type="text" required placeholder="e.g. AUR-98241" style="width: 100%; padding: 0.85rem 1rem; border: 1px solid var(--color-border); border-radius: 6px; font-family: inherit; font-size: 0.9rem; background: #FAF7F2; outline: none;">
				</div>
				<div>
					<label style="display: block; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--color-heading); margin-bottom: 0.4rem;"><?php esc_html_e( 'Billing Email Address', 'aura-skincare' ); ?></label>
					<input type="email" required placeholder="jane@example.com" style="width: 100%; padding: 0.85rem 1rem; border: 1px solid var(--color-border); border-radius: 6px; font-family: inherit; font-size: 0.9rem; background: #FAF7F2; outline: none;">
				</div>
				<button type="submit" class="aura-btn aura-btn-primary" style="justify-content: center; padding: 1rem;">
					<span><?php esc_html_e( 'Track Shipment', 'aura-skincare' ); ?></span>
					<svg viewBox="0 0 20 20" width="16" height="16" fill="currentColor"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
				</button>
			</form>

			<!-- Tracking Result Box -->
			<div id="trackingResults" style="display: none; margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid var(--color-border);">
				<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
					<div>
						<span style="font-size: 0.8rem; color: var(--color-text-light); text-transform: uppercase; letter-spacing: 0.06em;"><?php esc_html_e( 'Shipment Status', 'aura-skincare' ); ?></span>
						<h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: #2e7d32; margin-top: 0.2rem;"><?php esc_html_e( 'In Transit — On Schedule', 'aura-skincare' ); ?></h3>
					</div>
					<span style="background: #e8f5e9; color: #2e7d32; padding: 0.35rem 0.85rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600;"><?php esc_html_e( 'FedEx Express', 'aura-skincare' ); ?></span>
				</div>
				<div style="display: grid; gap: 1rem; font-size: 0.9rem; color: var(--color-text-main); border-left: 2px solid var(--color-gold); padding-left: 1.25rem;">
					<div><strong><?php esc_html_e( 'Today, 8:30 AM', 'aura-skincare' ); ?></strong> — <?php esc_html_e( 'Out for delivery in local distribution facility.', 'aura-skincare' ); ?></div>
					<div style="color: var(--color-text-light);"><strong><?php esc_html_e( 'Yesterday, 4:15 PM', 'aura-skincare' ); ?></strong> — <?php esc_html_e( 'Departed SoHo formulation lab dispatch center.', 'aura-skincare' ); ?></div>
				</div>
			</div>

		</div>

	</div>
</div>
<?php
get_footer();
