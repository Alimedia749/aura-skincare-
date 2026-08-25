<?php
/**
 * Template Name: Luxury Shipping & Returns Policy
 * Template Post Type: page
 *
 * @package Aura_Skincare
 */

get_header();
?>
<div class="aura-page-wrapper" style="background: var(--color-bg); padding: clamp(4rem, 6vw, 6rem) 0;">
	<div class="aura-container-wide" style="max-width: 900px; margin: 0 auto; padding: 0 1.5rem;">
		
		<div style="text-align: center; margin-bottom: 3.5rem;">
			<span class="section-eyebrow" style="color: var(--color-gold); font-size: 0.78rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; display: block; margin-bottom: 0.5rem;"><?php esc_html_e( 'DISPATCH & DELIVERY', 'aura-skincare' ); ?></span>
			<h1 class="section-title" style="font-family: var(--font-heading); font-size: clamp(2.2rem, 4vw, 3rem); color: var(--color-heading); margin-bottom: 1rem; font-weight: 400;"><?php esc_html_e( 'Shipping & Returns Policy', 'aura-skincare' ); ?></h1>
			<p style="color: var(--color-text-light); font-size: 1rem; line-height: 1.7; max-width: 600px; margin: 0 auto;"><?php esc_html_e( 'Transparent, insured global fulfillment in temperature-controlled sustainable packaging.', 'aura-skincare' ); ?></p>
		</div>

		<div style="display: flex; flex-direction: column; gap: 2rem;">
			
			<div style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 16px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
				<h2 style="font-family: var(--font-heading); font-size: 1.5rem; color: var(--color-heading); margin-bottom: 1rem;"><?php esc_html_e( '1. Global Express Delivery', 'aura-skincare' ); ?></h2>
				<p style="color: var(--color-text-main); font-size: 0.95rem; line-height: 1.8; margin-bottom: 1rem;"><?php esc_html_e( 'All orders are handcrafted and packaged inside climate-controlled insulated boxes to protect bioactive vitality. Orders placed before 2:00 PM EST ship same-day.', 'aura-skincare' ); ?></p>
				<table style="width: 100%; border-collapse: collapse; margin-top: 1rem; font-size: 0.9rem;">
					<thead>
						<tr style="background: #FAF7F2; text-align: left;">
							<th style="padding: 0.75rem 1rem; border-bottom: 1px solid var(--color-border);"><?php esc_html_e( 'Destination', 'aura-skincare' ); ?></th>
							<th style="padding: 0.75rem 1rem; border-bottom: 1px solid var(--color-border);"><?php esc_html_e( 'Standard (3-5 Days)', 'aura-skincare' ); ?></th>
							<th style="padding: 0.75rem 1rem; border-bottom: 1px solid var(--color-border);"><?php esc_html_e( 'Express (1-2 Days)', 'aura-skincare' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="padding: 0.75rem 1rem; border-bottom: 1px solid #FAF7F2;"><?php esc_html_e( 'United States (Orders $75+)', 'aura-skincare' ); ?></td>
							<td style="padding: 0.75rem 1rem; border-bottom: 1px solid #FAF7F2; color: var(--color-gold); font-weight: 600;"><?php esc_html_e( 'COMPLIMENTARY', 'aura-skincare' ); ?></td>
							<td style="padding: 0.75rem 1rem; border-bottom: 1px solid #FAF7F2;">$12.00</td>
						</tr>
						<tr>
							<td style="padding: 0.75rem 1rem; border-bottom: 1px solid #FAF7F2;"><?php esc_html_e( 'United States (Orders Under $75)', 'aura-skincare' ); ?></td>
							<td style="padding: 0.75rem 1rem; border-bottom: 1px solid #FAF7F2;">$5.95</td>
							<td style="padding: 0.75rem 1rem; border-bottom: 1px solid #FAF7F2;">$14.00</td>
						</tr>
						<tr>
							<td style="padding: 0.75rem 1rem; border-bottom: 1px solid #FAF7F2;"><?php esc_html_e( 'International Express', 'aura-skincare' ); ?></td>
							<td style="padding: 0.75rem 1rem; border-bottom: 1px solid #FAF7F2;">$18.00</td>
							<td style="padding: 0.75rem 1rem; border-bottom: 1px solid #FAF7F2;">$28.00</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 16px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
				<h2 style="font-family: var(--font-heading); font-size: 1.5rem; color: var(--color-heading); margin-bottom: 1rem;"><?php esc_html_e( '2. 30-Day Ritual Return Guarantee', 'aura-skincare' ); ?></h2>
				<p style="color: var(--color-text-main); font-size: 0.95rem; line-height: 1.8; margin-bottom: 1rem;"><?php esc_html_e( 'We stand completely behind the transformative results of our botanical formulations. If your skin does not love an Aura formula, return it within 30 days of receipt for a 100% refund, no questions asked.', 'aura-skincare' ); ?></p>
				<p style="color: var(--color-text-main); font-size: 0.95rem; line-height: 1.8;"><?php esc_html_e( 'To start a return, email inteligentboy021@gmail.com with your order number. A pre-paid return label will be provided instantly.', 'aura-skincare' ); ?></p>
			</div>

		</div>

	</div>
</div>
<?php
get_footer();
