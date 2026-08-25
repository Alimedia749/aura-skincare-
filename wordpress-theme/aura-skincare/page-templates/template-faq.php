<?php
/**
 * Template Name: Luxury FAQ & Client Support
 * Template Post Type: page
 *
 * @package Aura_Skincare
 */

get_header();
?>

<div class="aura-page-wrapper" style="background: var(--color-bg); padding: clamp(4rem, 6vw, 6rem) 0;">
	<div class="aura-container-wide" style="max-width: 900px; margin: 0 auto; padding: 0 1.5rem;">
		
		<!-- Page Header -->
		<div style="text-align: center; margin-bottom: 3.5rem;">
			<span class="section-eyebrow" style="color: var(--color-gold); font-size: 0.78rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; display: block; margin-bottom: 0.5rem;"><?php esc_html_e( 'HELP & CLIENT CARE', 'aura-skincare' ); ?></span>
			<h1 class="section-title" style="font-family: var(--font-heading); font-size: clamp(2.2rem, 4vw, 3rem); color: var(--color-heading); margin-bottom: 1rem; font-weight: 400;"><?php esc_html_e( 'Frequently Asked Questions', 'aura-skincare' ); ?></h1>
			<p style="color: var(--color-text-light); font-size: 1rem; line-height: 1.7; max-width: 600px; margin: 0 auto;"><?php esc_html_e( 'Everything you need to know about our biocompatible formulations, ritual pairing, shipping, and returns.', 'aura-skincare' ); ?></p>
		</div>

		<!-- Accordion Groups -->
		<div class="faq-container" style="display: flex; flex-direction: column; gap: 1.25rem;">
			
			<!-- Item 1 -->
			<div class="faq-item" style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
				<button type="button" class="faq-question" style="width: 100%; padding: 1.5rem 1.75rem; display: flex; justify-content: space-between; align-items: center; background: none; border: none; text-align: left; font-family: var(--font-heading); font-size: 1.15rem; color: var(--color-heading); cursor: pointer;" onclick="this.parentElement.classList.toggle('active'); var a=this.nextElementSibling; a.style.display = a.style.display === 'block' ? 'none' : 'block';">
					<span><?php esc_html_e( 'What makes Aura botanical formulas unique?', 'aura-skincare' ); ?></span>
					<span style="font-size: 1.5rem; line-height: 1; color: var(--color-gold); font-weight: 300;">+</span>
				</button>
				<div class="faq-answer" style="display: none; padding: 0 1.75rem 1.5rem; color: var(--color-text-main); font-size: 0.95rem; line-height: 1.8; border-top: 1px solid #FAF7F2;">
					<p><?php esc_html_e( 'Aura formulas are created through wildcrafted micro-fermentation. By cold-fermenting our botanical actives over 28 days, we break molecular weights down by 65%, allowing nutrients to penetrate deeply into the dermis rather than sitting on top of the skin.', 'aura-skincare' ); ?></p>
				</div>
			</div>

			<!-- Item 2 -->
			<div class="faq-item" style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
				<button type="button" class="faq-question" style="width: 100%; padding: 1.5rem 1.75rem; display: flex; justify-content: space-between; align-items: center; background: none; border: none; text-align: left; font-family: var(--font-heading); font-size: 1.15rem; color: var(--color-heading); cursor: pointer;" onclick="this.parentElement.classList.toggle('active'); var a=this.nextElementSibling; a.style.display = a.style.display === 'block' ? 'none' : 'block';">
					<span><?php esc_html_e( 'Are Aura products suitable for sensitive or acne-prone skin?', 'aura-skincare' ); ?></span>
					<span style="font-size: 1.5rem; line-height: 1; color: var(--color-gold); font-weight: 300;">+</span>
				</button>
				<div class="faq-answer" style="display: none; padding: 0 1.75rem 1.5rem; color: var(--color-text-main); font-size: 0.95rem; line-height: 1.8; border-top: 1px solid #FAF7F2;">
					<p><?php esc_html_e( 'Yes. 100% of our products are dermatologist tested, non-comedogenic, and hypoallergenic. We exclude over 2,700 questionable ingredients including synthetic fragrance, parabens, sulfates, and drying alcohols.', 'aura-skincare' ); ?></p>
				</div>
			</div>

			<!-- Item 3 -->
			<div class="faq-item" style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
				<button type="button" class="faq-question" style="width: 100%; padding: 1.5rem 1.75rem; display: flex; justify-content: space-between; align-items: center; background: none; border: none; text-align: left; font-family: var(--font-heading); font-size: 1.15rem; color: var(--color-heading); cursor: pointer;" onclick="this.parentElement.classList.toggle('active'); var a=this.nextElementSibling; a.style.display = a.style.display === 'block' ? 'none' : 'block';">
					<span><?php esc_html_e( 'What is your shipping and delivery timeline?', 'aura-skincare' ); ?></span>
					<span style="font-size: 1.5rem; line-height: 1; color: var(--color-gold); font-weight: 300;">+</span>
				</button>
				<div class="faq-answer" style="display: none; padding: 0 1.75rem 1.5rem; color: var(--color-text-main); font-size: 0.95rem; line-height: 1.8; border-top: 1px solid #FAF7F2;">
					<p><?php esc_html_e( 'We provide complimentary Express Insured shipping on all orders over $75. Domestic orders typically arrive within 2-4 business days. International express orders are delivered within 4-7 business days.', 'aura-skincare' ); ?></p>
				</div>
			</div>

			<!-- Item 4 -->
			<div class="faq-item" style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
				<button type="button" class="faq-question" style="width: 100%; padding: 1.5rem 1.75rem; display: flex; justify-content: space-between; align-items: center; background: none; border: none; text-align: left; font-family: var(--font-heading); font-size: 1.15rem; color: var(--color-heading); cursor: pointer;" onclick="this.parentElement.classList.toggle('active'); var a=this.nextElementSibling; a.style.display = a.style.display === 'block' ? 'none' : 'block';">
					<span><?php esc_html_e( 'What is the 30-Day Ritual Guarantee?', 'aura-skincare' ); ?></span>
					<span style="font-size: 1.5rem; line-height: 1; color: var(--color-gold); font-weight: 300;">+</span>
				</button>
				<div class="faq-answer" style="display: none; padding: 0 1.75rem 1.5rem; color: var(--color-text-main); font-size: 0.95rem; line-height: 1.8; border-top: 1px solid #FAF7F2;">
					<p><?php esc_html_e( 'We want you to experience genuine skin transformation. If you are not completely delighted with your formula within 30 days of receiving your order, contact our concierge for a full refund or complimentary custom product match.', 'aura-skincare' ); ?></p>
				</div>
			</div>

			<!-- Item 5 -->
			<div class="faq-item" style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
				<button type="button" class="faq-question" style="width: 100%; padding: 1.5rem 1.75rem; display: flex; justify-content: space-between; align-items: center; background: none; border: none; text-align: left; font-family: var(--font-heading); font-size: 1.15rem; color: var(--color-heading); cursor: pointer;" onclick="this.parentElement.classList.toggle('active'); var a=this.nextElementSibling; a.style.display = a.style.display === 'block' ? 'none' : 'block';">
					<span><?php esc_html_e( 'How do I consult a botanical skincare expert?', 'aura-skincare' ); ?></span>
					<span style="font-size: 1.5rem; line-height: 1; color: var(--color-gold); font-weight: 300;">+</span>
				</button>
				<div class="faq-answer" style="display: none; padding: 0 1.75rem 1.5rem; color: var(--color-text-main); font-size: 0.95rem; line-height: 1.8; border-top: 1px solid #FAF7F2;">
					<p><?php esc_html_e( 'You can email our concierge team directly at inteligentboy021@gmail.com or call 03283486855 Mon-Sat from 9am to 8pm EST.', 'aura-skincare' ); ?></p>
				</div>
			</div>

		</div>

		<!-- Need more help CTA -->
		<div style="margin-top: 3.5rem; text-align: center; background: #ffffff; border: 1px solid var(--color-border); border-radius: 16px; padding: 2.5rem; box-shadow: 0 6px 25px rgba(0,0,0,0.03);">
			<h3 style="font-family: var(--font-heading); font-size: 1.4rem; color: var(--color-heading); margin-bottom: 0.5rem;"><?php esc_html_e( 'Still have questions?', 'aura-skincare' ); ?></h3>
			<p style="color: var(--color-text-light); font-size: 0.92rem; margin-bottom: 1.5rem;"><?php esc_html_e( 'Our dedicated aesthetic advisors are ready to craft a personalized regimen for you.', 'aura-skincare' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" class="aura-btn aura-btn-primary">
				<span><?php esc_html_e( 'Contact Skin Concierge', 'aura-skincare' ); ?></span>
			</a>
		</div>

	</div>
</div>

<?php
get_footer();
