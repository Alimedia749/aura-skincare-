<?php
/**
 * 6-Column New Arrivals Showcase Grid Template Part
 *
 * @package Aura_Skincare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$all_products = aura_get_mock_products();
// Curated 6 New Arrivals
$new_products = array_filter( $all_products, function( $p ) {
	return ! empty( $p['is_new'] ) || stripos( $p['badge'], 'new' ) !== false;
} );

if ( count( $new_products ) < 6 ) {
	$new_products = array_slice( $all_products, 6, 6 );
}
?>

<section id="new-arrivals" class="new-arrivals-section" style="padding: clamp(3.5rem, 6vw, 5.5rem) 0; background: #ffffff; border-top: 1px solid var(--color-border);" aria-label="<?php esc_attr_e( 'New Arrivals You\'ll Love', 'aura-skincare' ); ?>">
	<div class="aura-container-wide">
		
		<!-- Section Header -->
		<div class="section-header" style="text-align: center; margin-bottom: 2.5rem;">
			<h2 class="showcase-section-title">NEW ARRIVALS YOU’LL LOVE</h2>
		</div>

		<!-- 6-Column Product Grid -->
		<div class="bestsellers-grid">
			<?php foreach ( $new_products as $product ) : 
				$reg_price = isset( $product['regular_price'] ) ? (float) $product['regular_price'] : 0;
				$has_sale  = ( $reg_price > $product['price'] );
			?>
				<article 
					class="aura-product-card" 
					data-product-id="<?php echo esc_attr( $product['id'] ); ?>"
					style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 8px; overflow: hidden; padding-bottom: 0.85rem;"
				>
					<!-- Product Image Box -->
					<div class="product-thumbnail-box" style="position: relative; aspect-ratio: 1/1; background: #F8F5F0; border-bottom: 1px solid var(--color-border); display: flex; align-items: center; justify-content: center; overflow: hidden;">
						
						<a href="<?php echo esc_url( $product['link'] ); ?>" class="product-card-img-link" style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;">
							<img 
								src="<?php echo esc_url( $product['image'] ); ?>" 
								alt="<?php echo esc_attr( $product['title'] ); ?>" 
								class="product-card-img primary-img"
								loading="lazy"
								style="max-height: 82%; width: auto; object-fit: contain; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.12));"
							>
							<img 
								src="<?php echo esc_url( $product['alt_image'] ); ?>" 
								alt="<?php echo esc_attr( $product['title'] ); ?>" 
								class="product-card-img alt-img"
								loading="lazy"
								style="max-height: 82%; width: auto; object-fit: contain; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.12));"
							>
						</a>

						<!-- Floating Quick Add Button -->
						<button 
							type="button" 
							class="quick-add-btn" 
							onclick="event.stopPropagation();"
							data-add-to-cart="<?php echo esc_attr( $product['id'] ); ?>"
							data-product-title="<?php echo esc_attr( $product['title'] ); ?>"
							data-product-price="<?php echo esc_attr( $product['price'] ); ?>"
							data-product-img="<?php echo esc_url( $product['image'] ); ?>"
							data-product-vol="<?php echo esc_attr( $product['volume'] ); ?>"
							aria-label="<?php printf( esc_attr__( 'Add %s to ritual bag', 'aura-skincare' ), esc_attr( $product['title'] ) ); ?>"
							style="width: 32px; height: 32px; bottom: 8px; right: 8px;"
						>
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14">
								<line x1="12" y1="5" x2="12" y2="19"></line>
								<line x1="5" y1="12" x2="19" y2="12"></line>
							</svg>
						</button>
					</div>

					<!-- Centered Product Title & Price Details -->
					<div class="product-card-details" style="padding: 0.75rem 0.6rem 0.2rem 0.6rem; text-align: center;">
						<h3 class="card-title-centered">
							<a href="<?php echo esc_url( $product['link'] ); ?>" style="color: var(--color-heading); text-decoration: none;">
								<?php echo esc_html( $product['title'] ); ?>
							</a>
						</h3>

						<div class="card-price-centered">
							<?php if ( $has_sale ) : ?>
								<span class="price-strikethrough-red">$<?php echo esc_html( number_format( $reg_price, 2 ) ); ?></span>
							<?php endif; ?>
							<span class="price-active-bold" style="color: var(--color-heading); font-weight: 700;">$<?php echo esc_html( number_format( $product['price'], 2 ) ); ?></span>
						</div>
					</div>

				</article>
			<?php endforeach; ?>
		</div>

	</div>
</section>
