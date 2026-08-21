<?php
/**
 * Offcanvas Cart Drawer Template Part
 *
 * @package Aura_Skincare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$threshold = get_theme_mod( 'aura_free_shipping_threshold', 75.00 );
?>

<div id="aura-cart-drawer" class="aura-cart-drawer" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Your Shopping Bag', 'aura-skincare' ); ?>">
	<!-- Backdrop -->
	<div class="aura-cart-overlay" data-cart-close="true"></div>

	<!-- Slide-out Container -->
	<div class="aura-cart-panel">
		
		<!-- Header -->
		<div class="aura-cart-header">
			<div class="aura-cart-title">
				<span><?php esc_html_e( 'Your Ritual Bag', 'aura-skincare' ); ?></span>
				<span class="aura-cart-count-pill" id="aura-drawer-count">1</span>
			</div>
			<button class="aura-cart-close-btn" data-cart-close="true" aria-label="<?php esc_attr_e( 'Close cart', 'aura-skincare' ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<line x1="18" y1="6" x2="6" y2="18"></line>
					<line x1="6" y1="6" x2="18" y2="18"></line>
				</svg>
			</button>
		</div>

		<!-- Free Shipping Meter -->
		<div class="aura-shipping-meter" id="aura-shipping-meter">
			<div class="shipping-meter-message">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<path d="M5 18h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2z"></path>
					<polyline points="15 3 21 8 21 14"></polyline>
				</svg>
				<span class="shipping-msg-text" id="aura-shipping-msg">
					<?php printf( esc_html__( 'Add %s more to unlock complimentary shipping', 'aura-skincare' ), '$7.00' ); ?>
				</span>
			</div>
			<div class="shipping-progress-track">
				<div class="shipping-progress-bar" id="aura-shipping-bar" style="width: 90%;"></div>
			</div>
		</div>

		<!-- Cart Body Items List -->
		<div class="aura-cart-body" id="aura-cart-body">
			<div class="aura-cart-items-list" id="aura-cart-items">
				
				<!-- Sample Item in Drawer -->
				<div class="aura-cart-item" data-product-id="101">
					<div class="cart-item-thumb">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-products.webp' ); ?>" alt="Celestial Serum">
					</div>
					<div class="cart-item-info">
						<div class="cart-item-top">
							<div>
								<div class="cart-item-title">Celestial Hydration Serum</div>
								<div class="cart-item-meta">50 ml / 1.7 fl. oz.</div>
							</div>
							<button class="cart-item-remove-btn" data-remove-id="101" aria-label="Remove item">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<line x1="18" y1="6" x2="6" y2="18"></line>
									<line x1="6" y1="6" x2="18" y2="18"></line>
								</svg>
							</button>
						</div>
						<div class="cart-item-bottom">
							<div class="cart-quantity-control">
								<button class="qty-btn qty-minus" aria-label="Decrease quantity">−</button>
								<span class="qty-val">1</span>
								<button class="qty-btn qty-plus" aria-label="Increase quantity">+</button>
							</div>
							<span class="cart-item-price">$68.00</span>
						</div>
					</div>
				</div>

			</div>
		</div>

		<!-- Cart Footer & Checkout -->
		<div class="aura-cart-footer">
			<div class="cart-subtotal-row">
				<span class="subtotal-label"><?php esc_html_e( 'Subtotal', 'aura-skincare' ); ?></span>
				<span class="subtotal-amount" id="aura-drawer-subtotal">$68.00</span>
			</div>
			<div class="cart-tax-notice">
				<?php esc_html_e( 'Taxes, duties & shipping calculated at checkout.', 'aura-skincare' ); ?>
			</div>
			<a href="<?php echo esc_url( home_url( '/checkout/' ) ); ?>" class="aura-btn aura-btn-primary checkout-btn">
				<span><?php esc_html_e( 'Proceed to Checkout', 'aura-skincare' ); ?></span>
				<svg viewBox="0 0 20 20" width="16" height="16" fill="currentColor">
					<path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
				</svg>
			</a>
			<div class="cart-trust-badges">
				<div class="cart-trust-item">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
					<span>Secure 256-bit SSL</span>
				</div>
				<div class="cart-trust-item">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
					<span>30-Day Ritual Guarantee</span>
				</div>
			</div>
		</div>

	</div>
</div>
