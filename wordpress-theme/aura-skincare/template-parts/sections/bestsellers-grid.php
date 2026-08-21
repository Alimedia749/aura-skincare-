<?php
/**
 * 5-Column Bestsellers Showcase Grid Template Part
 *
 * @package Aura_Skincare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$products = aura_get_mock_products();
?>

<section id="bestsellers" class="bestsellers-section" aria-label="<?php esc_attr_e( 'Bestselling Formulas', 'aura-skincare' ); ?>">
	<div class="aura-container-wide">
		
		<!-- Section Header -->
		<?php
		$bs_eyebrow = get_theme_mod( 'aura_bestsellers_eyebrow', 'The Most Coveted Formulas' );
		$bs_title   = get_theme_mod( 'aura_bestsellers_title', 'Sacred Botanical Bestsellers' );
		$bs_desc    = get_theme_mod( 'aura_bestsellers_desc', 'Award-winning bio-compatible rituals formulated to nourish the skin barrier and reveal lit-from-within luminosity.' );
		?>
		<div class="section-header">
			<?php if ( ! empty( $bs_eyebrow ) ) : ?>
				<span class="section-eyebrow"><?php echo esc_html( $bs_eyebrow ); ?></span>
			<?php endif; ?>
			<h2 class="section-title"><?php echo esc_html( $bs_title ); ?></h2>
			<?php if ( ! empty( $bs_desc ) ) : ?>
				<p class="section-subtitle"><?php echo esc_html( $bs_desc ); ?></p>
			<?php endif; ?>
		</div>

		<!-- 5-Column Product Grid -->
		<div class="bestsellers-grid">
			<?php foreach ( $products as $product ) : ?>
				<article class="aura-product-card" data-product-id="<?php echo esc_attr( $product['id'] ); ?>">
					
					<!-- Product Image Box -->
					<div class="product-thumbnail-box">
						<a href="<?php echo esc_url( $product['link'] ); ?>" class="product-card-img-link" style="display:block; width:100%; height:100%;">
							<img 
								src="<?php echo esc_url( $product['image'] ); ?>" 
								alt="<?php echo esc_attr( $product['title'] ); ?>" 
								class="product-card-img primary-img"
								loading="lazy"
							>
							<img 
								src="<?php echo esc_url( $product['alt_image'] ); ?>" 
								alt="<?php echo esc_attr( $product['title'] ); ?>" 
								class="product-card-img alt-img"
								loading="lazy"
							>
						</a>

						<!-- Floating Badges -->
						<?php if ( ! empty( $product['badge'] ) ) : ?>
							<div class="card-badge-container">
								<span class="aura-badge badge-<?php echo esc_attr( $product['badge_type'] ); ?>">
									<?php echo esc_html( $product['badge'] ); ?>
								</span>
							</div>
						<?php endif; ?>

						<!-- Floating Quick Add (+) Button -->
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
						>
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
								<line x1="12" y1="5" x2="12" y2="19"></line>
								<line x1="5" y1="12" x2="19" y2="12"></line>
							</svg>
						</button>
					</div>

					<!-- Product Details -->
					<div class="product-card-details">
						<span class="product-card-category"><?php echo esc_html( $product['category'] ); ?></span>
						
						<h3 class="product-card-title">
							<a href="<?php echo esc_url( $product['link'] ); ?>">
								<?php echo esc_html( $product['title'] ); ?>
							</a>
						</h3>

						<p class="product-card-subtitle"><?php echo esc_html( $product['subtitle'] ); ?></p>

						<div class="product-card-rating">
							<?php echo aura_get_rating_html( $product['rating'], $product['reviews'] ); ?>
						</div>

						<div class="product-card-footer">
							<div class="product-card-price">
								<span class="price-current">$<?php echo esc_html( number_format( $product['price'], 2 ) ); ?></span>
								<?php if ( $product['regular_price'] > $product['price'] ) : ?>
									<span class="price-regular">$<?php echo esc_html( number_format( $product['regular_price'], 2 ) ); ?></span>
								<?php endif; ?>
							</div>
							<span class="product-card-volume"><?php echo esc_html( $product['volume'] ); ?></span>
						</div>
					</div>

				</article>
			<?php endforeach; ?>
		</div>

	</div>
</section>
