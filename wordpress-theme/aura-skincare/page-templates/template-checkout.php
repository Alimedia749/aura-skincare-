<?php
/**
 * Template Name: Checkout Page
 *
 * @package Aura_Skincare
 */

get_header();

$theme_uri = get_template_directory_uri();
?>

<main id="main-content" class="checkout-page-section">
	<div class="aura-container">

		<!-- Minimalist Checkout Header Branding -->
		<div class="checkout-header-branding">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="checkout-logo-link">
				AURA
			</a>
		</div>

		<form id="auraCheckoutForm" onsubmit="event.preventDefault(); handleAuraCheckoutSubmit();">
			<div class="checkout-grid-layout">
				
				<!-- Left Column: Express & Checkout Information -->
				<div class="checkout-form-column">
					
					<!-- Express Checkout -->
					<div class="express-checkout-box">
						<span class="express-title"><?php esc_html_e( 'Express Checkout', 'aura-skincare' ); ?></span>
						<div class="express-buttons-grid">
							<button type="button" class="express-btn express-btn-apple" onclick="showAuraToast('Apple Pay Express connected');">
								<span> Pay</span>
							</button>
							<button type="button" class="express-btn express-btn-paypal" onclick="showAuraToast('PayPal Express connected');">
								<span>PayPal</span>
							</button>
						</div>
						<div class="checkout-divider">
							<span><?php esc_html_e( 'Or continue with standard checkout', 'aura-skincare' ); ?></span>
						</div>
					</div>

					<!-- Shipping Information -->
					<div class="checkout-section-card">
						<h2 class="checkout-section-title">
							<span>1. <?php esc_html_e( 'Shipping Information', 'aura-skincare' ); ?></span>
						</h2>

						<div class="checkout-fields-stack">
							
							<div class="checkout-field-group">
								<label for="chk-email" class="checkout-label"><?php esc_html_e( 'Email Address for Order Confirmation', 'aura-skincare' ); ?></label>
								<input type="email" id="chk-email" class="checkout-input" placeholder="you@example.com" required value="client@aura-rituals.com">
							</div>

							<div class="checkout-fields-row">
								<div class="checkout-field-group">
									<label for="chk-fname" class="checkout-label"><?php esc_html_e( 'First Name', 'aura-skincare' ); ?></label>
									<input type="text" id="chk-fname" class="checkout-input" placeholder="First Name" required value="Sarah">
								</div>
								<div class="checkout-field-group">
									<label for="chk-lname" class="checkout-label"><?php esc_html_e( 'Last Name', 'aura-skincare' ); ?></label>
									<input type="text" id="chk-lname" class="checkout-input" placeholder="Last Name" required value="Mitchell">
								</div>
							</div>

							<div class="checkout-field-group">
								<label for="chk-address" class="checkout-label"><?php esc_html_e( 'Street Address', 'aura-skincare' ); ?></label>
								<input type="text" id="chk-address" class="checkout-input" placeholder="123 Fifth Avenue" required value="742 Evergreen Terrace">
							</div>

							<div class="checkout-field-group">
								<label for="chk-apt" class="checkout-label"><?php esc_html_e( 'Apartment, suite, unit (optional)', 'aura-skincare' ); ?></label>
								<input type="text" id="chk-apt" class="checkout-input" placeholder="Suite 4B">
							</div>

							<div class="checkout-fields-row-3">
								<div class="checkout-field-group">
									<label for="chk-city" class="checkout-label"><?php esc_html_e( 'City', 'aura-skincare' ); ?></label>
									<input type="text" id="chk-city" class="checkout-input" placeholder="New York" required value="New York">
								</div>
								<div class="checkout-field-group">
									<label for="chk-state" class="checkout-label"><?php esc_html_e( 'State / Region', 'aura-skincare' ); ?></label>
									<select id="chk-state" class="checkout-select">
										<option value="NY">New York (NY)</option>
										<option value="CA">California (CA)</option>
										<option value="TX">Texas (TX)</option>
										<option value="FL">Florida (FL)</option>
										<option value="IL">Illinois (IL)</option>
										<option value="OTHER">International / Other</option>
									</select>
								</div>
								<div class="checkout-field-group">
									<label for="chk-zip" class="checkout-label"><?php esc_html_e( 'ZIP / Postal Code', 'aura-skincare' ); ?></label>
									<input type="text" id="chk-zip" class="checkout-input" placeholder="10001" required value="10001">
								</div>
							</div>

						</div>
					</div>

					<!-- Shipping Method -->
					<div class="checkout-section-card">
						<h2 class="checkout-section-title">
							<span>2. <?php esc_html_e( 'Shipping Method', 'aura-skincare' ); ?></span>
						</h2>

						<div class="shipping-options-grid">
							<label class="shipping-option-card selected" id="shipOptStandard">
								<div class="shipping-radio-label">
									<input type="radio" name="shipping_method" value="0.00" checked onchange="updateCheckoutCalculations();">
									<div>
										<div class="shipping-title"><?php esc_html_e( 'Standard Insured Delivery', 'aura-skincare' ); ?></div>
										<div class="shipping-time"><?php esc_html_e( '3-5 business days via Carbon-Neutral Courier', 'aura-skincare' ); ?></div>
									</div>
								</div>
								<span class="shipping-cost" style="color:var(--color-sage); font-weight:700;"><?php esc_html_e( 'FREE', 'aura-skincare' ); ?></span>
							</label>

							<label class="shipping-option-card" id="shipOptExpress">
								<div class="shipping-radio-label">
									<input type="radio" name="shipping_method" value="15.00" onchange="updateCheckoutCalculations();">
									<div>
										<div class="shipping-title"><?php esc_html_e( 'Expedited Express Delivery', 'aura-skincare' ); ?></div>
										<div class="shipping-time"><?php esc_html_e( '1-2 business days with Priority Tracking', 'aura-skincare' ); ?></div>
									</div>
								</div>
								<span class="shipping-cost">$15.00</span>
							</label>
						</div>
					</div>

					<!-- Payment Details -->
					<div class="checkout-section-card">
						<h2 class="checkout-section-title">
							<span>3. <?php esc_html_e( 'Payment Details', 'aura-skincare' ); ?></span>
						</h2>

						<div class="checkout-fields-stack">
							
							<div class="checkout-field-group">
								<label for="chk-cardnum" class="checkout-label"><?php esc_html_e( 'Card Number', 'aura-skincare' ); ?></label>
								<input type="text" id="chk-cardnum" class="checkout-input" placeholder="4242 •••• •••• 4242" required value="4242 •••• •••• 4242">
							</div>

							<div class="checkout-fields-row">
								<div class="checkout-field-group">
									<label for="chk-exp" class="checkout-label"><?php esc_html_e( 'Expiration Date', 'aura-skincare' ); ?></label>
									<input type="text" id="chk-exp" class="checkout-input" placeholder="MM / YY" required value="12 / 28">
								</div>
								<div class="checkout-field-group">
									<label for="chk-cvc" class="checkout-label"><?php esc_html_e( 'Security Code (CVC)', 'aura-skincare' ); ?></label>
									<input type="text" id="chk-cvc" class="checkout-input" placeholder="123" required value="888">
								</div>
							</div>

							<div class="checkout-field-group">
								<label for="chk-cardname" class="checkout-label"><?php esc_html_e( 'Name on Card', 'aura-skincare' ); ?></label>
								<input type="text" id="chk-cardname" class="checkout-input" placeholder="Full Name on Card" required value="Sarah Mitchell">
							</div>

						</div>
					</div>

				</div>

				<!-- Right Column: Sticky Order Summary -->
				<div class="checkout-summary-sticky">
					<div class="order-summary-card">
						<h3 class="summary-card-title"><?php esc_html_e( 'Order Summary', 'aura-skincare' ); ?></h3>

						<!-- Items in Cart List -->
						<div class="summary-items-list" id="checkoutItemsList">
							
							<!-- Item 1 (Default Aurum Hydrating Serum) -->
							<div class="summary-product-item">
								<div class="summary-product-thumb">
									<img src="<?php echo esc_url( $theme_uri . '/assets/images/hero-slide-1.png' ); ?>" alt="Aurum Serum">
									<span class="summary-product-qty-badge">1</span>
								</div>
								<div class="summary-product-info">
									<div class="title">Aurum Hydrating Serum</div>
									<div class="variant">50 ml / 1.7 fl. oz.</div>
								</div>
								<div class="summary-product-price">$68.00</div>
							</div>

						</div>

						<!-- Promo Code Box -->
						<div class="summary-promo-row">
							<input type="text" id="promoCodeInput" class="checkout-input promo-input" placeholder="Gift card or discount code (AURA15)">
							<button type="button" class="aura-btn aura-btn-outline promo-apply-btn" onclick="applyPromoCode();">
								<span>Apply</span>
							</button>
						</div>

						<!-- Cost Calculations -->
						<div class="summary-cost-breakdown">
							<div class="summary-cost-line">
								<span><?php esc_html_e( 'Subtotal', 'aura-skincare' ); ?></span>
								<span id="chkSubtotal">$68.00</span>
							</div>

							<div class="summary-cost-line" id="chkDiscountLine" style="display:none; color:var(--color-sage);">
								<span><?php esc_html_e( 'Discount (AURA15 - 15%)', 'aura-skincare' ); ?></span>
								<span id="chkDiscount">-$10.20</span>
							</div>

							<div class="summary-cost-line">
								<span><?php esc_html_e( 'Shipping', 'aura-skincare' ); ?></span>
								<span id="chkShipping" style="color:var(--color-sage); font-weight:600;">FREE</span>
							</div>

							<div class="summary-cost-line">
								<span><?php esc_html_e( 'Estimated Tax (8%)', 'aura-skincare' ); ?></span>
								<span id="chkTax">$5.44</span>
							</div>

							<div class="summary-cost-line total-line">
								<span><?php esc_html_e( 'Total', 'aura-skincare' ); ?></span>
								<span class="summary-total-amount" id="chkTotal">$73.44</span>
							</div>
						</div>

						<!-- Complete Purchase CTA -->
						<button type="submit" class="aura-btn aura-btn-primary complete-purchase-btn" id="completePurchaseBtn">
							<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:4px;">
								<rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
								<path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
							</svg>
							<span><?php esc_html_e( 'Complete Purchase', 'aura-skincare' ); ?></span>
						</button>

						<div class="checkout-ssl-trust">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
							<span>Encrypted 256-Bit SSL Navigation &amp; Guaranteed Privacy</span>
						</div>

					</div>
				</div>

			</div>
		</form>

	</div>
</main>

<!-- ── ORDER SUCCESS CONFIRMATION MODAL ───────────── -->
<div id="orderSuccessModal" class="order-success-modal" role="dialog" aria-modal="true" aria-label="Order Confirmed">
	<div class="order-modal-card">
		<div class="order-success-icon">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
				<polyline points="20 6 9 17 4 12"></polyline>
			</svg>
		</div>
		<h3 class="order-modal-title"><?php esc_html_e( 'Thank You For Your Order!', 'aura-skincare' ); ?></h3>
		<div class="order-modal-number" id="orderConfirmNumber">ORDER #AUR-88294</div>
		<p class="order-modal-text">
			Your sacred skincare ritual is being carefully prepared and packaged in our sustainable infinity glass. A confirmation email with tracking details has been sent to your address.
		</p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="aura-btn aura-btn-primary" style="width:100%; justify-content:center;">
			<span><?php esc_html_e( 'Return to Homepage', 'aura-skincare' ); ?></span>
		</a>
	</div>
</div>

<script>
var baseSubtotal = 68.00;
var isDiscounted = false;

function updateCheckoutCalculations() {
	var shipVal = parseFloat(document.querySelector('input[name="shipping_method"]:checked').value) || 0;
	
	// Update styles on shipping cards
	document.getElementById('shipOptStandard').classList.toggle('selected', shipVal === 0);
	document.getElementById('shipOptExpress').classList.toggle('selected', shipVal > 0);

	var shipText = shipVal === 0 ? 'FREE' : '$' + shipVal.toFixed(2);
	document.getElementById('chkShipping').textContent = shipText;
	document.getElementById('chkShipping').style.color = shipVal === 0 ? 'var(--color-sage)' : 'var(--color-heading)';

	var effectiveSubtotal = isDiscounted ? (baseSubtotal * 0.85) : baseSubtotal;
	var tax = effectiveSubtotal * 0.08;
	var total = effectiveSubtotal + shipVal + tax;

	document.getElementById('chkSubtotal').textContent = '$' + baseSubtotal.toFixed(2);
	document.getElementById('chkTax').textContent = '$' + tax.toFixed(2);
	document.getElementById('chkTotal').textContent = '$' + total.toFixed(2);
}

function applyPromoCode() {
	var input = document.getElementById('promoCodeInput');
	var code = input.value.trim().toUpperCase();
	if (code === 'AURA15' || code === 'AURA') {
		isDiscounted = true;
		document.getElementById('chkDiscountLine').style.display = 'flex';
		var discountAmount = (baseSubtotal * 0.15).toFixed(2);
		document.getElementById('chkDiscount').textContent = '-$' + discountAmount;
		updateCheckoutCalculations();
		showAuraToast('Promo code AURA15 applied! 15% discount saved.');
	} else if (code.length > 0) {
		showAuraToast('Invalid promo code. Use code AURA15 for 15% off.');
	}
}

function handleAuraCheckoutSubmit() {
	var btn = document.getElementById('completePurchaseBtn');
	btn.disabled = true;
	btn.innerHTML = '<span>Processing Order...</span>';

	setTimeout(function() {
		btn.disabled = false;
		btn.innerHTML = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:4px;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg><span>Complete Purchase</span>';
		
		var randomOrder = 'ORDER #AUR-' + Math.floor(10000 + Math.random() * 90000);
		document.getElementById('orderConfirmNumber').textContent = randomOrder;
		document.getElementById('orderSuccessModal').classList.add('is-active');
	}, 1200);
}

// Sync with live AuraCart items if present
document.addEventListener('DOMContentLoaded', function() {
	if (window.AuraCart && window.AuraCart.items && window.AuraCart.items.length > 0) {
		var list = document.getElementById('checkoutItemsList');
		if (list) {
			var html = '';
			var total = 0;
			window.AuraCart.items.forEach(function(item) {
				total += (item.price * item.quantity);
				html += '\
					<div class="summary-product-item">\
						<div class="summary-product-thumb">\
							<img src="' + item.image + '" alt="' + item.title + '">\
							<span class="summary-product-qty-badge">' + item.quantity + '</span>\
						</div>\
						<div class="summary-product-info">\
							<div class="title">' + item.title + '</div>\
							<div class="variant">' + item.volume + '</div>\
						</div>\
						<div class="summary-product-price">$' + (item.price * item.quantity).toFixed(2) + '</div>\
					</div>\
				';
			});
			list.innerHTML = html;
			baseSubtotal = total;
			updateCheckoutCalculations();
		}
	}
});
</script>

<?php
get_footer();
