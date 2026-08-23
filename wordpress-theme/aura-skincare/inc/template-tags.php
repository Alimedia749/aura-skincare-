<?php
/**
 * Custom template tags, helpers, and dynamic WooCommerce integration
 *
 * @package Aura_Skincare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render rating star glyphs with numeric score and review count.
 *
 * @param float $rating Numeric rating e.g. 4.9.
 * @param int   $count  Number of verified reviews.
 * @return string HTML output.
 */
function aura_get_rating_html( $rating = 5.0, $count = 0 ) {
	$full_stars = floor( $rating );
	$stars_html = str_repeat( '★', $full_stars );
	if ( $rating - $full_stars >= 0.5 ) {
		$stars_html .= '½';
	}
	$empty_stars = 5 - ceil( $rating );
	if ( $empty_stars > 0 ) {
		$stars_html .= str_repeat( '☆', $empty_stars );
	}

	ob_start();
	?>
	<div class="product-card-rating" aria-label="<?php printf( esc_attr__( 'Rated %s out of 5 stars based on %d reviews', 'aura-skincare' ), esc_attr( $rating ), esc_attr( $count ) ); ?>">
		<span class="aura-stars" aria-hidden="true"><?php echo esc_html( $stars_html ); ?></span>
		<span class="rating-score"><?php echo esc_html( number_format( $rating, 1 ) ); ?></span>
		<?php if ( $count > 0 ) : ?>
			<span class="rating-count">(<?php echo esc_html( $count ); ?>)</span>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Free Shipping Progress Meter calculation.
 *
 * @param float $cart_total Current cart subtotal.
 * @param float $threshold  Free shipping threshold amount. Default 75.00.
 * @return array Calculated progress percentage, remaining balance, and status text.
 */
function aura_calculate_shipping_progress( $cart_total = 0.0, $threshold = 75.00 ) {
	$percentage = ( $threshold > 0 ) ? min( 100, ( $cart_total / $threshold ) * 100 ) : 100;
	$remaining  = max( 0, $threshold - $cart_total );
	$unlocked   = $remaining <= 0;

	return array(
		'percentage' => round( $percentage, 1 ),
		'remaining'  => $remaining,
		'unlocked'   => $unlocked,
		'message'    => $unlocked ? esc_html__( 'Complimentary Express Delivery unlocked!', 'aura-skincare' ) : sprintf(
			/* translators: %s: remaining formatted price */
			esc_html__( 'Add %s more to unlock complimentary express delivery', 'aura-skincare' ),
			function_exists( 'wc_price' ) ? wc_price( $remaining ) : '$' . number_format( $remaining, 2 )
		),
	);
}

/**
 * Dynamic WooCommerce Products Query with graceful fallback.
 *
 * @param int $limit Number of products to retrieve. Default 10.
 * @return array Array of product data objects.
 */
function aura_get_mock_products( $limit = 10 ) {
	$theme_uri = get_template_directory_uri();
	$products  = array();

	// If WooCommerce is active, query real products from WP Database
	if ( class_exists( 'WooCommerce' ) ) {
		$wc_products = wc_get_products( array(
			'limit'   => $limit,
			'status'  => 'publish',
			'orderby' => 'menu_order title',
			'order'   => 'ASC',
		) );

		if ( ! empty( $wc_products ) ) {
			foreach ( $wc_products as $wc_p ) {
				$p_id         = $wc_p->get_id();
				$p_slug       = $wc_p->get_slug();
				$image_id     = $wc_p->get_image_id();
				
				$cat_names = array();
				$cat_slugs = array();
				$terms = get_the_terms( $p_id, 'product_cat' );
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					foreach ( $terms as $t ) {
						$cat_names[] = $t->name;
						$cat_slugs[] = $t->slug;
					}
				}
				$category_str = ! empty( $cat_names ) ? implode( ', ', $cat_names ) : 'Rituals';
				$primary_cat_slug = ! empty( $cat_slugs ) ? $cat_slugs[0] : 'serums';

				// Category-specific high quality luxury images
				$default_img = $theme_uri . '/assets/images/hero-slide-1.png';
				$default_alt = $theme_uri . '/assets/images/hero-products.webp';

				if ( in_array( 'cleansers', $cat_slugs, true ) ) {
					$default_img = $theme_uri . '/assets/images/hero-products.webp';
					$default_alt = $theme_uri . '/assets/images/ritual-banner.webp';
				} elseif ( in_array( 'moisturizers', $cat_slugs, true ) ) {
					$default_img = $theme_uri . '/assets/images/hero-slide-2.png';
					$default_alt = $theme_uri . '/assets/images/promise-model.webp';
				} elseif ( in_array( 'botanical-oils', $cat_slugs, true ) ) {
					$default_img = $theme_uri . '/assets/images/hero-slide-3.png';
					$default_alt = $theme_uri . '/assets/images/ritual-banner.webp';
				} elseif ( in_array( 'eye-care', $cat_slugs, true ) ) {
					$default_img = $theme_uri . '/assets/images/promise-model.webp';
					$default_alt = $theme_uri . '/assets/images/hero-slide-2.png';
				} elseif ( in_array( 'sun-protection', $cat_slugs, true ) ) {
					$default_img = $theme_uri . '/assets/images/hero-slide-3.png';
					$default_alt = $theme_uri . '/assets/images/hero-slide-1.png';
				} elseif ( in_array( 'sets-kits', $cat_slugs, true ) ) {
					$default_img = $theme_uri . '/assets/images/ritual-banner.webp';
					$default_alt = $theme_uri . '/assets/images/hero-products.webp';
				}

				$img_url     = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : $default_img;
				$gallery_ids = $wc_p->get_gallery_image_ids();
				$alt_img_url = ! empty( $gallery_ids ) ? wp_get_attachment_image_url( $gallery_ids[0], 'large' ) : $default_alt;

				$badge = get_post_meta( $p_id, '_aura_badge', true );
				if ( empty( $badge ) && $wc_p->is_featured() ) {
					$badge = 'Featured';
				}

				$is_new = get_post_meta( $p_id, '_aura_is_new', true );

				$volume = get_post_meta( $p_id, '_aura_volume', true );
				if ( empty( $volume ) ) {
					$volume = '50 ml / 1.7 fl. oz.';
				}

				$badge_type = 'award';
				if ( stripos( $badge, 'new' ) !== false ) {
					$badge_type = 'new';
				} elseif ( stripos( $badge, 'cult' ) !== false ) {
					$badge_type = 'cult';
				} elseif ( stripos( $badge, 'clinical' ) !== false ) {
					$badge_type = 'clinical';
				}

				$price         = (float) $wc_p->get_price();
				$regular_price = (float) $wc_p->get_regular_price();
				if ( $regular_price <= $price || $regular_price <= 0 ) {
					$regular_price = round( $price * 1.35 );
				}
				$discount_pct = round( ( ( $regular_price - $price ) / $regular_price ) * 100 );
				if ( $discount_pct <= 0 ) {
					$discount_pct = 25;
				}

				$products[] = array(
					'id'            => $p_id,
					'title'         => $wc_p->get_name(),
					'slug'          => $p_slug,
					'subtitle'      => $wc_p->get_short_description() ? wp_strip_all_tags( $wc_p->get_short_description() ) : 'Botanical Bio-Compatible Concentrate',
					'category'      => $category_str,
					'category_slug' => $primary_cat_slug,
					'price'         => $price,
					'regular_price' => $regular_price,
					'discount_pct'  => $discount_pct,
					'rating'        => (float) $wc_p->get_average_rating() > 0 ? (float) $wc_p->get_average_rating() : 4.9,
					'reviews'       => (int) $wc_p->get_review_count() > 0 ? (int) $wc_p->get_review_count() : 280,
					'badge'         => $badge ? $badge : 'Best Seller',
					'badge_type'    => $badge_type,
					'volume'        => $volume,
					'image'         => $img_url,
					'alt_image'     => $alt_img_url,
					'link'          => home_url( '/product-detail/?product=' . $p_slug ),
					'in_stock'      => $wc_p->is_in_stock(),
					'is_featured'   => $wc_p->is_featured(),
					'is_new'        => $is_new === 'yes',
					'tags'          => array_merge( array( 'Clean', 'Botanical' ), $cat_names ),
				);
			}

			if ( ! empty( $products ) ) {
				return $products;
			}
		}
	}

	// Fallback mock catalog if no products in DB
	return array(
		array(
			'id'          => 101,
			'title'       => 'Aurum Hydrating Serum',
			'subtitle'    => 'Multi-Molecular Hyaluronic Acid & Snow Mushroom',
			'category'    => 'Serums',
			'price'       => 68.00,
			'regular_price' => 78.00,
			'rating'      => 4.9,
			'reviews'     => 342,
			'badge'       => 'Best Seller',
			'badge_type'  => 'award',
			'volume'      => '50 ml / 1.7 fl. oz.',
			'image'       => $theme_uri . '/assets/images/hero-slide-1.png',
			'alt_image'   => $theme_uri . '/assets/images/promise-model.webp',
			'link'        => home_url( '/product-detail/?product=aurum-hydrating-serum' ),
			'in_stock'    => true,
			'tags'        => array( 'Hydrating', 'Plumping', 'Clean' ),
		),
		array(
			'id'          => 102,
			'title'       => 'Velvet Cloud Cleansing Balm',
			'subtitle'    => 'Fermented Camellia & Oat Lipid Complex',
			'category'    => 'Cleansers',
			'price'       => 46.00,
			'regular_price' => 46.00,
			'rating'      => 4.8,
			'reviews'     => 189,
			'badge'       => 'Award Winner',
			'badge_type'  => 'highlight',
			'volume'      => '100 ml / 3.4 fl. oz.',
			'image'       => $theme_uri . '/assets/images/hero-products.webp',
			'alt_image'   => $theme_uri . '/assets/images/ritual-banner.webp',
			'link'        => home_url( '/product-detail/?product=velvet-cloud-cleansing-balm' ),
			'in_stock'    => true,
			'tags'        => array( 'Melting', 'Sulfate-Free', 'Nourishing' ),
		),
		array(
			'id'          => 103,
			'title'       => 'Cellular Shield Botanical Elixir',
			'subtitle'    => 'Cold-Pressed Bakuchiol & Rosehip Seed',
			'category'    => 'Botanical Oils',
			'price'       => 84.00,
			'regular_price' => 92.00,
			'rating'      => 5.0,
			'reviews'     => 412,
			'badge'       => 'Cult Favorite',
			'badge_type'  => 'cult',
			'volume'      => '30 ml / 1.0 fl. oz.',
			'image'       => $theme_uri . '/assets/images/hero-slide-3.png',
			'alt_image'   => $theme_uri . '/assets/images/promise-model.webp',
			'link'        => home_url( '/product-detail/?product=cellular-shield-botanical-elixir' ),
			'in_stock'    => true,
			'tags'        => array( 'Retinol Alternative', 'Radiance' ),
		),
		array(
			'id'          => 104,
			'title'       => 'Barrier Repair Ceramide Cream',
			'subtitle'    => '5-Ceramide & Biomimetic Lipid Recovery Complex',
			'category'    => 'Moisturizers',
			'price'       => 78.00,
			'regular_price' => 78.00,
			'rating'      => 4.9,
			'reviews'     => 256,
			'badge'       => 'Clinical',
			'badge_type'  => 'clinical',
			'volume'      => '50 ml / 1.7 fl. oz.',
			'image'       => $theme_uri . '/assets/images/hero-slide-2.png',
			'alt_image'   => $theme_uri . '/assets/images/ritual-banner.webp',
			'link'        => home_url( '/product-detail/?product=barrier-repair-ceramide-cream' ),
			'in_stock'    => true,
			'tags'        => array( 'Barrier Repair', 'Firming' ),
		),
		array(
			'id'          => 105,
			'title'       => 'Silk Petal Brightening Essence',
			'subtitle'    => 'Damask Rose Hydrosol & 5% Niacinamide',
			'category'    => 'Toners & Mists',
			'price'       => 52.00,
			'regular_price' => 52.00,
			'rating'      => 4.7,
			'reviews'     => 144,
			'badge'       => 'New',
			'badge_type'  => 'new',
			'volume'      => '150 ml / 5.1 fl. oz.',
			'image'       => $theme_uri . '/assets/images/hero-slide-1.png',
			'alt_image'   => $theme_uri . '/assets/images/promise-model.webp',
			'link'        => home_url( '/product-detail/?product=silk-petal-brightening-essence' ),
			'in_stock'    => true,
			'tags'        => array( 'Tone Evening', 'Pore Refining' ),
		),
	);
}

/**
 * Dynamic Category Navigation Pills from WooCommerce / WP Taxonomy.
 *
 * @return array Array of category items.
 */
function aura_get_category_pills() {
	$icon_map = array(
		'cleansers'      => 'cleanser.svg',
		'serums'         => 'serum.svg',
		'moisturizers'   => 'moisturizer.svg',
		'eye-care'       => 'eye-cream.svg',
		'toners-mists'   => 'toner.svg',
		'sun-protection' => 'sunscreen.svg',
		'botanical-oils' => 'oil.svg',
	);

	if ( taxonomy_exists( 'product_cat' ) ) {
		$terms = get_terms( array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
		) );

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			$categories = array();
			foreach ( $terms as $term ) {
				// Ignore default unassigned category if empty
				if ( $term->slug === 'uncategorized' && $term->count === 0 ) {
					continue;
				}

				$icon = isset( $icon_map[ $term->slug ] ) ? $icon_map[ $term->slug ] : 'serum.svg';
				$categories[] = array(
					'slug'  => $term->slug,
					'name'  => $term->name,
					'count' => $term->count,
					'icon'  => $icon,
					'desc'  => $term->description,
				);
			}

			if ( ! empty( $categories ) ) {
				return $categories;
			}
		}
	}

	// Default fallback
	return array(
		array( 'slug' => 'cleansers', 'name' => 'Cleansers', 'count' => 6, 'icon' => 'cleanser.svg', 'desc' => 'Purifying balms & gels' ),
		array( 'slug' => 'serums', 'name' => 'Serums', 'count' => 9, 'icon' => 'serum.svg', 'desc' => 'Concentrated clinical actives' ),
		array( 'slug' => 'moisturizers', 'name' => 'Moisturizers', 'count' => 7, 'icon' => 'moisturizer.svg', 'desc' => 'Barrier-nourishing creams' ),
		array( 'slug' => 'eye-care', 'name' => 'Eye Care', 'count' => 4, 'icon' => 'eye-cream.svg', 'desc' => 'Illuminating & de-puffing' ),
		array( 'slug' => 'toners-mists', 'name' => 'Toners & Mists', 'count' => 5, 'icon' => 'toner.svg', 'desc' => 'Hydrosols & balancing waters' ),
		array( 'slug' => 'sun-protection', 'name' => 'Sun Protection', 'count' => 4, 'icon' => 'sunscreen.svg', 'desc' => 'Invisible mineral SPF 50+' ),
		array( 'slug' => 'botanical-oils', 'name' => 'Botanical Oils', 'count' => 6, 'icon' => 'oil.svg', 'desc' => 'Cold-pressed elixirs' ),
	);
}

/**
 * Render a 6-column category product showcase section.
 *
 * @param string       $title          Section header title (e.g. "CLEANSERS YOU'LL LOVE").
 * @param string|array $category_slugs Category slug(s) to pull products from.
 * @param string       $section_id     HTML ID attribute.
 * @param string       $bg_color       Background color CSS.
 */
function aura_render_category_showcase_section( $title, $category_slugs, $section_id = '', $bg_color = '#ffffff' ) {
	$all_products = aura_get_mock_products( 50 );
	$slugs_array  = (array) $category_slugs;

	// STRICT Category Filter
	$filtered = array();
	foreach ( $all_products as $p ) {
		$p_cat_slug = isset( $p['category_slug'] ) ? strtolower( trim( $p['category_slug'] ) ) : '';
		$p_cat_name = isset( $p['category'] ) ? strtolower( trim( $p['category'] ) ) : '';
		
		$matches = false;
		foreach ( $slugs_array as $slug ) {
			$slug = strtolower( trim( $slug ) );
			if ( $p_cat_slug === $slug || stripos( $p_cat_slug, $slug ) !== false || stripos( $p_cat_name, $slug ) !== false ) {
				$matches = true;
				break;
			}
		}

		if ( $matches ) {
			$filtered[] = $p;
		}
	}

	if ( empty( $filtered ) ) {
		return;
	}

	$section_id_attr = ! empty( $section_id ) ? 'id="' . esc_attr( $section_id ) . '"' : '';
	?>
	<section <?php echo $section_id_attr; ?> class="category-showcase-section" style="padding: clamp(3.5rem, 6vw, 5.5rem) 0; background: <?php echo esc_attr( $bg_color ); ?>; border-top: 1px solid #EBE7DF;" aria-label="<?php echo esc_attr( $title ); ?>">
		<div class="aura-container-wide">
			
			<!-- Section Header Title -->
			<div class="section-header" style="text-align: center; margin-bottom: 2.5rem;">
				<h2 class="showcase-section-title"><?php echo esc_html( $title ); ?></h2>
			</div>

			<!-- 6-Column Product Grid -->
			<div class="bestsellers-grid">
				<?php foreach ( $filtered as $product ) : 
					$reg_price = isset( $product['regular_price'] ) && (float) $product['regular_price'] > 0 ? (float) $product['regular_price'] : round( $product['price'] * 1.35 );
					$has_sale  = ( $reg_price > $product['price'] );
				?>
					<article 
						class="aura-product-card" 
						data-product-id="<?php echo esc_attr( $product['id'] ); ?>"
						style="background: #ffffff; border: 1px solid #EBE7DF; border-radius: 8px; overflow: hidden; padding-bottom: 0.85rem;"
					>
						<!-- Product Image Frame -->
						<div class="product-thumbnail-box" style="position: relative; aspect-ratio: 1/1; background: #F8F6F2; border-bottom: 1px solid #EBE7DF; display: flex; align-items: center; justify-content: center; overflow: hidden;">
							
							<a href="<?php echo esc_url( $product['link'] ); ?>" class="product-card-img-link" style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;">
								<img 
									src="<?php echo esc_url( $product['image'] ); ?>" 
									alt="<?php echo esc_attr( $product['title'] ); ?>" 
									class="product-card-img primary-img"
									loading="lazy"
									style="max-height: 82%; width: auto; object-fit: contain; filter: drop-shadow(0 6px 12px rgba(0,0,0,0.1)); margin: auto;"
								>
								<img 
									src="<?php echo esc_url( $product['alt_image'] ); ?>" 
									alt="<?php echo esc_attr( $product['title'] ); ?>" 
									class="product-card-img alt-img"
									loading="lazy"
									style="max-height: 82%; width: auto; object-fit: contain; filter: drop-shadow(0 6px 12px rgba(0,0,0,0.1)); margin: auto;"
								>
							</a>

							<!-- Quick Add (+) Button -->
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

						<!-- Centered Title & Price -->
						<div class="product-card-details" style="padding: 0.85rem 0.65rem 0.2rem 0.65rem; text-align: center;">
							<h3 class="card-title-centered">
								<a href="<?php echo esc_url( $product['link'] ); ?>">
									<?php echo esc_html( $product['title'] ); ?>
								</a>
							</h3>

							<div class="card-price-centered">
								<?php if ( $has_sale ) : ?>
									<span class="price-strikethrough-red">$<?php echo esc_html( number_format( $reg_price, 2 ) ); ?></span>
								<?php endif; ?>
								<span class="price-active-bold">$<?php echo esc_html( number_format( $product['price'], 2 ) ); ?></span>
							</div>
						</div>

					</article>
				<?php endforeach; ?>
			</div>

		</div>
	</section>
	<?php
}
