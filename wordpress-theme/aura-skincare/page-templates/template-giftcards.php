<?php
/**
 * Template Name: Luxury Digital Gift Cards
 * Template Post Type: page
 *
 * @package Aura_Skincare
 */

get_header();
?>
<div class="aura-page-wrapper" style="background: var(--color-bg); padding: clamp(4rem, 6vw, 6rem) 0; min-height: 75vh;">
	<div class="aura-container-wide" style="max-width: 800px; margin: 0 auto; padding: 0 1.5rem;">
		
		<div style="text-align: center; margin-bottom: 3.5rem;">
			<span class="section-eyebrow" style="color: var(--color-gold); font-size: 0.78rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; display: block; margin-bottom: 0.5rem;"><?php esc_html_e( 'THE GIFT OF RADIANCE', 'aura-skincare' ); ?></span>
			<h1 class="section-title" style="font-family: var(--font-heading); font-size: clamp(2.2rem, 4vw, 3rem); color: var(--color-heading); margin-bottom: 1rem; font-weight: 400;"><?php esc_html_e( 'Aura Digital Gift Cards', 'aura-skincare' ); ?></h1>
			<p style="color: var(--color-text-light); font-size: 1rem; line-height: 1.7; max-width: 550px; margin: 0 auto;"><?php esc_html_e( 'Delivered instantly via email with personalized notes and no expiration date.', 'aura-skincare' ); ?></p>
		</div>

		<div style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 16px; padding: clamp(2rem, 4vw, 3rem); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
			
			<div style="background: linear-gradient(135deg, #141311 0%, #2a2824 100%); color: #FAF7F2; border-radius: 12px; padding: 2.5rem; margin-bottom: 2rem; position: relative; overflow: hidden; border: 1px solid rgba(197,168,128,0.3);">
				<div style="font-size: 0.8rem; letter-spacing: 0.15em; text-transform: uppercase; color: var(--color-gold);"><?php esc_html_e( 'AURA BOTANICAL RITUAL CARD', 'aura-skincare' ); ?></div>
				<div style="font-family: var(--font-heading); font-size: 2.5rem; margin: 1.5rem 0 0.5rem; color: #ffffff;">$100.00</div>
				<div style="font-size: 0.85rem; color: rgba(255,255,255,0.6);"><?php esc_html_e( 'Valid for all custom formulations & rituals', 'aura-skincare' ); ?></div>
			</div>

			<form onsubmit="event.preventDefault(); showAuraToast('Gift card added to your ritual bag!');" style="display: grid; gap: 1.25rem;">
				<div>
					<label style="display: block; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--color-heading); margin-bottom: 0.5rem;"><?php esc_html_e( 'Select Value Amount', 'aura-skincare' ); ?></label>
					<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.75rem;">
						<button type="button" class="aura-btn aura-btn-outline" style="padding: 0.75rem 0; justify-content: center; font-weight: 600;" onclick="document.querySelectorAll('.gc-val').forEach(b=>b.classList.remove('aura-btn-primary')); this.classList.add('aura-btn-primary');">$50</button>
						<button type="button" class="aura-btn aura-btn-primary gc-val" style="padding: 0.75rem 0; justify-content: center; font-weight: 600;" onclick="document.querySelectorAll('.gc-val').forEach(b=>b.classList.remove('aura-btn-primary')); this.classList.add('aura-btn-primary');">$100</button>
						<button type="button" class="aura-btn aura-btn-outline gc-val" style="padding: 0.75rem 0; justify-content: center; font-weight: 600;" onclick="document.querySelectorAll('.gc-val').forEach(b=>b.classList.remove('aura-btn-primary')); this.classList.add('aura-btn-primary');">$150</button>
						<button type="button" class="aura-btn aura-btn-outline gc-val" style="padding: 0.75rem 0; justify-content: center; font-weight: 600;" onclick="document.querySelectorAll('.gc-val').forEach(b=>b.classList.remove('aura-btn-primary')); this.classList.add('aura-btn-primary');">$250</button>
					</div>
				</div>

				<div>
					<label style="display: block; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--color-heading); margin-bottom: 0.4rem;"><?php esc_html_e( 'Recipient Email', 'aura-skincare' ); ?></label>
					<input type="email" required placeholder="recipient@example.com" style="width: 100%; padding: 0.85rem 1rem; border: 1px solid var(--color-border); border-radius: 6px; font-family: inherit; font-size: 0.9rem; background: #FAF7F2; outline: none;">
				</div>

				<button type="submit" class="aura-btn aura-btn-primary" style="justify-content: center; padding: 1rem; width: 100%;">
					<span><?php esc_html_e( 'Send Gift Card', 'aura-skincare' ); ?></span>
					<svg viewBox="0 0 20 20" width="16" height="16" fill="currentColor"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
				</button>
			</form>

		</div>

	</div>
</div>
<?php
get_footer();
