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
			
			<!-- Live Card Preview -->
			<div style="background: linear-gradient(135deg, #141311 0%, #2a2824 100%); color: #FAF7F2; border-radius: 16px; padding: 2.5rem; margin-bottom: 2.5rem; position: relative; overflow: hidden; border: 1px solid rgba(197,168,128,0.3); box-shadow: 0 12px 35px rgba(0,0,0,0.18);">
				<div style="display: flex; justify-content: space-between; align-items: center;">
					<span style="font-size: 0.8rem; letter-spacing: 0.15em; text-transform: uppercase; color: var(--color-gold); font-weight: 600;"><?php esc_html_e( 'AURA BOTANICAL RITUAL CARD', 'aura-skincare' ); ?></span>
					<span style="font-size: 0.78rem; letter-spacing: 0.1em; color: rgba(255,255,255,0.45);"><?php esc_html_e( 'DIGITAL EDITION', 'aura-skincare' ); ?></span>
				</div>
				<div id="cardAmountDisplay" style="font-family: var(--font-heading); font-size: clamp(2.5rem, 5vw, 3.2rem); margin: 1.5rem 0 0.5rem; color: #ffffff; transition: transform 0.2s ease, opacity 0.2s ease;">$100.00</div>
				<div id="cardRecipientPreview" style="font-size: 0.88rem; color: var(--color-gold); margin-bottom: 0.5rem; min-height: 1.2rem;"></div>
				<div style="font-size: 0.82rem; color: rgba(255,255,255,0.55);"><?php esc_html_e( 'Valid for all custom formulations, bio-ferment serums & rituals.', 'aura-skincare' ); ?></div>
			</div>

			<form id="giftCardForm" onsubmit="event.preventDefault(); var val=document.getElementById('selectedCardAmount').value; showAuraToast('$' + val + ' Gift Card added to your ritual bag!');" style="display: grid; gap: 1.5rem;">
				<input type="hidden" id="selectedCardAmount" value="100">

				<div>
					<label style="display: block; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--color-heading); margin-bottom: 0.6rem;"><?php esc_html_e( 'Select Value Amount', 'aura-skincare' ); ?></label>
					<div class="gift-card-amounts-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.85rem;">
						<button type="button" class="aura-btn aura-btn-outline gc-val-btn" data-value="50" style="padding: 0.85rem 0; justify-content: center; font-weight: 600; border-radius: 8px;">$50</button>
						<button type="button" class="aura-btn aura-btn-primary gc-val-btn" data-value="100" style="padding: 0.85rem 0; justify-content: center; font-weight: 600; border-radius: 8px;">$100</button>
						<button type="button" class="aura-btn aura-btn-outline gc-val-btn" data-value="150" style="padding: 0.85rem 0; justify-content: center; font-weight: 600; border-radius: 8px;">$150</button>
						<button type="button" class="aura-btn aura-btn-outline gc-val-btn" data-value="250" style="padding: 0.85rem 0; justify-content: center; font-weight: 600; border-radius: 8px;">$250</button>
					</div>
				</div>

				<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.25rem;">
					<div>
						<label style="display: block; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--color-heading); margin-bottom: 0.4rem;"><?php esc_html_e( 'Recipient Name', 'aura-skincare' ); ?></label>
						<input type="text" id="recipientNameInput" placeholder="Recipient's Name" style="width: 100%; padding: 0.85rem 1rem; border: 1px solid var(--color-border); border-radius: 6px; font-family: inherit; font-size: 0.9rem; background: #FAF7F2; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--color-gold)'" onblur="this.style.borderColor='var(--color-border)'">
					</div>
					<div>
						<label style="display: block; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--color-heading); margin-bottom: 0.4rem;"><?php esc_html_e( 'Recipient Email Address', 'aura-skincare' ); ?></label>
						<input type="email" required placeholder="recipient@example.com" style="width: 100%; padding: 0.85rem 1rem; border: 1px solid var(--color-border); border-radius: 6px; font-family: inherit; font-size: 0.9rem; background: #FAF7F2; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--color-gold)'" onblur="this.style.borderColor='var(--color-border)'">
					</div>
				</div>

				<div>
					<label style="display: block; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--color-heading); margin-bottom: 0.4rem;"><?php esc_html_e( 'Personal Note / Message (Optional)', 'aura-skincare' ); ?></label>
					<textarea rows="3" placeholder="Wishing you luminous radiance and sacred skin moments..." style="width: 100%; padding: 0.85rem 1rem; border: 1px solid var(--color-border); border-radius: 6px; font-family: inherit; font-size: 0.9rem; background: #FAF7F2; outline: none; resize: vertical; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--color-gold)'" onblur="this.style.borderColor='var(--color-border)'"></textarea>
				</div>

				<button type="submit" class="aura-btn aura-btn-primary" style="justify-content: center; padding: 1rem; width: 100%; font-size: 0.95rem;">
					<span><?php esc_html_e( 'Add Gift Card to Bag', 'aura-skincare' ); ?></span>
					<svg viewBox="0 0 20 20" width="16" height="16" fill="currentColor"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
				</button>
			</form>

		</div>

	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var buttons = document.querySelectorAll('.gc-val-btn');
	var amountDisplay = document.getElementById('cardAmountDisplay');
	var hiddenAmount = document.getElementById('selectedCardAmount');
	var recipientInput = document.getElementById('recipientNameInput');
	var recipientPreview = document.getElementById('cardRecipientPreview');

	// Amount Selector Click Listener
	buttons.forEach(function(btn) {
		btn.addEventListener('click', function() {
			// Update Button States
			buttons.forEach(function(b) {
				b.classList.remove('aura-btn-primary');
				b.classList.add('aura-btn-outline');
			});
			this.classList.remove('aura-btn-outline');
			this.classList.add('aura-btn-primary');

			// Get and Update Amount
			var val = this.getAttribute('data-value');
			if (hiddenAmount) hiddenAmount.value = val;

			if (amountDisplay) {
				amountDisplay.style.opacity = '0';
				amountDisplay.style.transform = 'translateY(-6px)';
				setTimeout(function() {
					amountDisplay.textContent = '$' + parseFloat(val).toFixed(2);
					amountDisplay.style.opacity = '1';
					amountDisplay.style.transform = 'translateY(0)';
				}, 150);
			}
		});
	});

	// Recipient Name Live Preview
	if (recipientInput && recipientPreview) {
		recipientInput.addEventListener('input', function() {
			if (this.value.trim() !== '') {
				recipientPreview.textContent = 'For: ' + this.value.trim();
			} else {
				recipientPreview.textContent = '';
			}
		});
	}
});
</script>

<?php
get_footer();
