<?php
/**
 * Ultra-Smooth Infinite Loop Hero Carousel Showcase
 *
 * @package Aura_Skincare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_uri = get_template_directory_uri();

$hero_slides = array(
	array(
		'number'      => '01',
		'title'       => 'HYDRA INFUSION',
		'subtitle'    => 'Deep Hyaluronic Serum',
		'description' => 'Penetrates multi-depth skin layers to deliver intense 24H hydration and instant dewy plumpness.',
		'image'       => $theme_uri . '/assets/images/hero-slide-1.png',
		'price'       => '$68.00',
		'product_id'  => '101',
		'badge'       => 'Bestseller No. 1',
	),
	array(
		'number'      => '02',
		'title'       => 'BARRIER REPAIR',
		'subtitle'    => 'Rich Ceramide Cream',
		'description' => 'Locks in vital moisture while strengthening the lipid barrier for a soft, luminous finish.',
		'image'       => $theme_uri . '/assets/images/hero-slide-2.png',
		'price'       => '$78.00',
		'product_id'  => '104',
		'badge'       => 'Clinical Barrier Defense',
	),
	array(
		'number'      => '03',
		'title'       => 'CELLULAR SHIELD',
		'subtitle'    => 'Botanical Face Elixir',
		'description' => 'Infused with antioxidant actives to protect against daily environmental stress.',
		'image'       => $theme_uri . '/assets/images/hero-slide-3.png',
		'price'       => '$84.00',
		'product_id'  => '103',
		'badge'       => 'Antioxidant Elixir',
	),
);
?>

<section class="hero-editorial-section" aria-label="<?php esc_attr_e( 'Hero Showcase Slider', 'aura-skincare' ); ?>">
	<div class="aura-container-wide">

		<!-- Top Hero Header -->
		<?php
		$hero_badge = get_theme_mod( 'aura_hero_badge_text', 'Botanical Science Meets Clinical Purity' );
		$hero_title = get_theme_mod( 'aura_hero_main_title', 'Pure Ingredients. Visible Results.' );
		$hero_sub   = get_theme_mod( 'aura_hero_subtext', 'Thoughtfully formulated skincare rituals that nourish, protect, and enhance your natural lit-from-within glow.' );
		?>
		<div class="hero-top-bar">
			<?php if ( ! empty( $hero_badge ) ) : ?>
				<div class="hero-badge-strip">
					<span class="badge-dot" aria-hidden="true"></span>
					<span><?php echo esc_html( $hero_badge ); ?></span>
				</div>
			<?php endif; ?>
			<div class="hero-header-content">
				<h1 class="hero-main-title">
					<?php echo esc_html( $hero_title ); ?>
				</h1>
				<p class="hero-subtext">
					<?php echo esc_html( $hero_sub ); ?>
				</p>
			</div>
		</div>

		<!-- ── LUXURY INFINITE SLIDER WRAPPER ───────────────── -->
		<div class="aura-hero-slider-wrap" id="auraHeroSlider">
			
			<!-- Slider Viewport -->
			<div class="aura-hero-slider-viewport">
				<div class="aura-hero-slider-track" id="auraHeroTrack">
					<?php foreach ( $hero_slides as $index => $slide ) : 
						$slug_map = array(
							'01' => 'aurum-hydrating-serum',
							'02' => 'barrier-repair-cream',
							'03' => 'cellular-shield-elixir',
						);
						$p_slug = isset( $slug_map[ $slide['number'] ] ) ? $slug_map[ $slide['number'] ] : 'aurum-hydrating-serum';
						$p_url  = home_url( '/product-detail/?product=' . $p_slug );
					?>
						<div class="aura-hero-slide" data-slide-index="<?php echo esc_attr( $index ); ?>">
							<div class="hero-slide-card">
								<a href="<?php echo esc_url( $p_url ); ?>" class="hero-slide-link" style="display:block; width:100%; height:100%;">
									<img 
										src="<?php echo esc_url( $slide['image'] ); ?>" 
										alt="<?php echo esc_attr( $slide['number'] . '. ' . $slide['title'] . ' — ' . $slide['subtitle'] ); ?>" 
										class="hero-slide-img"
										loading="<?php echo ( $index === 0 ) ? 'eager' : 'lazy'; ?>"
									>
								</a>
								
								<!-- Interactive Slide Overlay Elements -->
								<div class="hero-slide-overlay-info">
									<a href="<?php echo esc_url( $p_url ); ?>" class="slide-overlay-pill" style="text-decoration:none;">
										<span class="pill-dot"></span>
										<span><?php echo esc_html( $slide['badge'] ); ?></span>
									</a>
									<div class="slide-overlay-actions">
										<button 
											type="button" 
											class="aura-btn aura-btn-primary aura-btn-sm hero-add-to-bag-btn" 
											onclick="event.stopPropagation();"
											data-add-to-cart="<?php echo esc_attr( $slide['product_id'] ); ?>"
											data-product-title="<?php echo esc_attr( $slide['number'] . '. ' . $slide['title'] ); ?>"
											data-product-price="<?php echo esc_attr( str_replace( '$', '', $slide['price'] ) ); ?>"
											data-product-img="<?php echo esc_url( $slide['image'] ); ?>"
											data-product-vol="<?php echo esc_attr( $slide['subtitle'] ); ?>"
											aria-label="<?php printf( esc_attr__( 'Add %s to bag', 'aura-skincare' ), esc_attr( $slide['title'] ) ); ?>"
										>
											<span><?php esc_html_e( 'Quick Add to Bag', 'aura-skincare' ); ?></span>
											<span class="slide-price-tag"><?php echo esc_html( $slide['price'] ); ?></span>
										</button>
										<a href="<?php echo esc_url( $p_url ); ?>" class="aura-btn aura-btn-outline aura-btn-sm slide-explore-btn">
											<span><?php esc_html_e( 'Explore Ritual', 'aura-skincare' ); ?></span>
										</a>
									</div>
								</div>

							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Navigation Controls (Prev / Next & Progress Bar) -->
			<div class="aura-slider-nav-controls">
				
				<!-- Arrow Buttons -->
				<button class="aura-slider-arrow arrow-prev" id="heroPrevBtn" aria-label="<?php esc_attr_e( 'Previous ritual slide', 'aura-skincare' ); ?>">
					<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<line x1="19" y1="12" x2="5" y2="12"></line>
						<polyline points="12 19 5 12 12 5"></polyline>
					</svg>
				</button>

				<!-- Numbered Indicators with Progress Bars -->
				<div class="aura-slider-indicators" id="heroIndicators">
					<?php foreach ( $hero_slides as $i => $s ) : ?>
						<button 
							class="aura-indicator-item <?php echo ( $i === 0 ) ? 'active' : ''; ?>" 
							data-goto-slide="<?php echo esc_attr( $i ); ?>"
							aria-label="<?php printf( esc_attr__( 'Go to slide %s', 'aura-skincare' ), esc_attr( $s['number'] ) ); ?>"
						>
							<span class="indicator-num"><?php echo esc_html( $s['number'] ); ?></span>
							<span class="indicator-name"><?php echo esc_html( $s['title'] ); ?></span>
							<div class="indicator-progress-track">
								<div class="indicator-progress-fill"></div>
							</div>
						</button>
					<?php endforeach; ?>
				</div>

				<button class="aura-slider-arrow arrow-next" id="heroNextBtn" aria-label="<?php esc_attr_e( 'Next ritual slide', 'aura-skincare' ); ?>">
					<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<line x1="5" y1="12" x2="19" y2="12"></line>
						<polyline points="12 5 19 12 12 19"></polyline>
					</svg>
				</button>

			</div>

		</div>

		<!-- 3 Purity Feature Cards Strip Below Slider -->
		<div class="hero-features-strip">
			<div class="hero-feature-card">
				<div class="hero-feature-icon">
					<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8">
						<path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
					</svg>
				</div>
				<div class="hero-feature-text">
					<span class="hero-feature-title"><?php esc_html_e( '100% Clean Ingredients', 'aura-skincare' ); ?></span>
					<span class="hero-feature-desc"><?php esc_html_e( 'Bio-fermented & cold-pressed purity', 'aura-skincare' ); ?></span>
				</div>
			</div>

			<div class="hero-feature-card">
				<div class="hero-feature-icon">
					<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8">
						<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
						<polyline points="22 4 12 14.01 9 11.01"/>
					</svg>
				</div>
				<div class="hero-feature-text">
					<span class="hero-feature-title"><?php esc_html_e( 'Clinically Tested', 'aura-skincare' ); ?></span>
					<span class="hero-feature-desc"><?php esc_html_e( 'Proven 24H deep moisture retention', 'aura-skincare' ); ?></span>
				</div>
			</div>

			<div class="hero-feature-card">
				<div class="hero-feature-icon">
					<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8">
						<circle cx="12" cy="12" r="10"/>
						<path d="M12 6v6l4 2"/>
					</svg>
				</div>
				<div class="hero-feature-text">
					<span class="hero-feature-title"><?php esc_html_e( 'Suitable for Sensitive Skin', 'aura-skincare' ); ?></span>
					<span class="hero-feature-desc"><?php esc_html_e( 'Dermatologist tested & hypoallergenic', 'aura-skincare' ); ?></span>
				</div>
			</div>
		</div>

	</div>
</section>
