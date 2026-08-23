<?php
/**
 * Template Name: Luxury Shop Catalog
 * Template Post Type: page
 *
 * @package Aura_Skincare
 */

get_header();

$theme_uri  = get_template_directory_uri();
$products   = aura_get_mock_products();
$categories = aura_get_category_pills();
?>

<div class="shop-page-wrapper">

	<!-- Shop Hero Header -->
	<section class="shop-hero-header">
		<div class="aura-container-wide">
			<span class="section-eyebrow"><?php esc_html_e( 'THE BOTANICAL ARCHIVE', 'aura-skincare' ); ?></span>
			<h1 class="section-title"><?php esc_html_e( 'Sacred Skincare Catalog', 'aura-skincare' ); ?></h1>
			<p class="section-subtitle">
				<?php esc_html_e( 'Explore award-winning, clinically-proven botanical rituals formulated with wildcrafted bio-ferments to nourish and illuminate your skin.', 'aura-skincare' ); ?>
			</p>
		</div>
	</section>

	<!-- Filter Tabs & Sort Controls Bar -->
	<div class="shop-controls-bar">
		<div class="aura-container-wide">
			<div class="shop-controls-inner">
				
				<!-- Category Filter Pills -->
				<div class="shop-filter-tabs" id="shopFilterTabs">
					<button type="button" class="shop-tab-btn active" data-filter="all">
						<span><?php esc_html_e( 'All Formulas', 'aura-skincare' ); ?></span>
						<span class="tab-count">(<?php echo esc_html( count( $products ) ); ?>)</span>
					</button>
					<?php foreach ( $categories as $cat ) : ?>
						<button type="button" class="shop-tab-btn" data-filter="<?php echo esc_attr( $cat['slug'] ); ?>">
							<span><?php echo esc_html( $cat['name'] ); ?></span>
							<span class="tab-count">(<?php echo esc_html( $cat['count'] ); ?>)</span>
						</button>
					<?php endforeach; ?>
				</div>

				<!-- Right Toolbar: Counter & Sorter -->
				<div class="shop-toolbar-right">
					<span class="shop-results-count" id="shopResultsCount">
						<?php printf( esc_html__( 'Showing %d of %d rituals', 'aura-skincare' ), count( $products ), count( $products ) ); ?>
					</span>
					<select class="shop-sort-select" id="shopSortSelect" aria-label="<?php esc_attr_e( 'Sort products', 'aura-skincare' ); ?>">
						<option value="featured"><?php esc_html_e( 'Featured Rituals', 'aura-skincare' ); ?></option>
						<option value="price-asc"><?php esc_html_e( 'Price: Low to High', 'aura-skincare' ); ?></option>
						<option value="price-desc"><?php esc_html_e( 'Price: High to Low', 'aura-skincare' ); ?></option>
						<option value="rating"><?php esc_html_e( 'Top Rated', 'aura-skincare' ); ?></option>
					</select>
				</div>

			</div>
		</div>
	</div>

	<!-- Product Catalog Grid -->
	<section class="shop-catalog-section">
		<div class="aura-container-wide">
			<div class="shop-catalog-grid" id="shopGrid">
				
				<?php foreach ( $products as $product ) : 
					$p_slug = sanitize_title( $product['title'] );
					$p_url  = home_url( '/product-detail/?product=' . $p_slug );
					$cat_slug = sanitize_title( $product['category'] );
				?>
					<article class="shop-product-card" data-category="<?php echo esc_attr( $cat_slug ); ?>" data-price="<?php echo esc_attr( $product['price'] ); ?>" data-rating="<?php echo esc_attr( $product['rating'] ); ?>">
						
						<!-- Card Media -->
						<a href="<?php echo esc_url( $p_url ); ?>" class="shop-card-media">
							<?php if ( ! empty( $product['badge'] ) ) : ?>
								<span class="shop-badge-tag"><?php echo esc_html( $product['badge'] ); ?></span>
							<?php endif; ?>
							<img 
								src="<?php echo esc_url( $product['image'] ); ?>" 
								alt="<?php echo esc_attr( $product['title'] ); ?>" 
								loading="lazy"
							>
						</a>

						<!-- Card Content -->
						<div class="shop-card-content">
							<div>
								<div class="shop-card-cat"><?php echo esc_html( $product['category'] ); ?></div>
								<a href="<?php echo esc_url( $p_url ); ?>" class="shop-card-title"><?php echo esc_html( $product['title'] ); ?></a>
								<p class="shop-card-desc"><?php echo esc_html( $product['subtitle'] ); ?></p>
							</div>

							<div class="shop-card-footer">
								<div class="shop-price-box">
									<span class="shop-price-current">$<?php echo esc_html( number_format( $product['price'], 2 ) ); ?></span>
									<?php if ( ! empty( $product['regular_price'] ) && $product['regular_price'] > $product['price'] ) : ?>
										<span class="shop-price-old">$<?php echo esc_html( number_format( $product['regular_price'], 2 ) ); ?></span>
									<?php endif; ?>
								</div>

								<button 
									type="button" 
									class="shop-add-btn hero-add-to-bag-btn" 
									data-add-to-cart="<?php echo esc_attr( $product['id'] ); ?>"
									data-product-title="<?php echo esc_attr( $product['title'] ); ?>"
									data-product-price="<?php echo esc_attr( $product['price'] ); ?>"
									data-product-img="<?php echo esc_url( $product['image'] ); ?>"
									data-product-vol="<?php echo esc_attr( $product['volume'] ); ?>"
									aria-label="<?php printf( esc_attr__( 'Add %s to bag', 'aura-skincare' ), esc_attr( $product['title'] ) ); ?>"
								>
									<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									<span><?php esc_html_e( 'Add', 'aura-skincare' ); ?></span>
								</button>
							</div>
						</div>

					</article>
				<?php endforeach; ?>

			</div>
		</div>
	</section>

	<!-- Clinical Standard Guarantee Strip -->
	<section style="background: #ffffff; border-top: 1px solid var(--color-border); border-bottom: 1px solid var(--color-border); padding: 3rem 0;">
		<div class="aura-container-wide">
			<div class="hero-features-strip" style="border-top: none; padding-top: 0;">
				<div class="hero-feature-card">
					<div class="hero-feature-icon">
						<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
					</div>
					<div class="hero-feature-text">
						<span class="hero-feature-title"><?php esc_html_e( 'Clean & Biocompatible', 'aura-skincare' ); ?></span>
						<span class="hero-feature-desc"><?php esc_html_e( 'Zero toxins, synthetic dyes, or sulfates.', 'aura-skincare' ); ?></span>
					</div>
				</div>

				<div class="hero-feature-card">
					<div class="hero-feature-icon">
						<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
					</div>
					<div class="hero-feature-text">
						<span class="hero-feature-title"><?php esc_html_e( 'Complimentary Global Express', 'aura-skincare' ); ?></span>
						<span class="hero-feature-desc"><?php esc_html_e( 'Free insured delivery on orders over $75.', 'aura-skincare' ); ?></span>
					</div>
				</div>

				<div class="hero-feature-card">
					<div class="hero-feature-icon">
						<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
					</div>
					<div class="hero-feature-text">
						<span class="hero-feature-title"><?php esc_html_e( '30-Day Ritual Guarantee', 'aura-skincare' ); ?></span>
						<span class="hero-feature-desc"><?php esc_html_e( 'Love the results or receive a full refund.', 'aura-skincare' ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</section>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var tabs = document.querySelectorAll('.shop-tab-btn');
	var cards = document.querySelectorAll('.shop-product-card');
	var counter = document.getElementById('shopResultsCount');
	var sortSelect = document.getElementById('shopSortSelect');
	var grid = document.getElementById('shopGrid');

	// Filter Tabs Handler
	tabs.forEach(function(tab) {
		tab.addEventListener('click', function() {
			tabs.forEach(function(t) { t.classList.remove('active'); });
			this.classList.add('active');
			var filter = this.getAttribute('data-filter');
			var visibleCount = 0;

			cards.forEach(function(card) {
				var cardCat = card.getAttribute('data-category');
				if (filter === 'all' || cardCat === filter || cardCat.indexOf(filter) !== -1) {
					card.style.display = 'flex';
					visibleCount++;
				} else {
					card.style.display = 'none';
				}
			});

			if (counter) {
				counter.textContent = 'Showing ' + visibleCount + ' of ' + cards.length + ' rituals';
			}
		});
	});

	// Sorter Handler
	if (sortSelect && grid) {
		sortSelect.addEventListener('change', function() {
			var val = this.value;
			var cardsArr = Array.prototype.slice.call(cards);

			cardsArr.sort(function(a, b) {
				var priceA = parseFloat(a.getAttribute('data-price')) || 0;
				var priceB = parseFloat(b.getAttribute('data-price')) || 0;
				var ratingA = parseFloat(a.getAttribute('data-rating')) || 0;
				var ratingB = parseFloat(b.getAttribute('data-rating')) || 0;

				if (val === 'price-asc') return priceA - priceB;
				if (val === 'price-desc') return priceB - priceA;
				if (val === 'rating') return ratingB - ratingA;
				return 0;
			});

			cardsArr.forEach(function(card) {
				grid.appendChild(card);
			});
		});
	}
});
</script>

<?php
get_footer();
