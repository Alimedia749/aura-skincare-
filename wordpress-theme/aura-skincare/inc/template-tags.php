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
					'is_new'        => $is_new === 'yes',
					'tags'          => array_merge( array( 'Clean', 'Botanical' ), $cat_names ),
				);
			}
			wp_reset_postdata();

			if ( ! empty( $products ) ) {
				// Supplement categories that have fewer than 4 products so catalog and counters match perfectly
				$fallback        = aura_get_fallback_catalog();
				$existing_titles = array_map( function( $p ) {
					return str_replace( array( '&amp;', '&#038;', '  ' ), array( '&', '&', ' ' ), strtolower( trim( $p['title'] ) ) );
				}, $products );

				$cat_counts = array();
				foreach ( $products as $p ) {
					$c_slug = $p['category_slug'] ?? 'rituals';
					$cat_counts[ $c_slug ] = ( $cat_counts[ $c_slug ] ?? 0 ) + 1;
				}

				foreach ( $fallback as $f_p ) {
					$f_slug       = $f_p['category_slug'] ?? 'rituals';
					$f_title_norm = str_replace( array( '&amp;', '&#038;', '  ' ), array( '&', '&', ' ' ), strtolower( trim( $f_p['title'] ) ) );

					if ( in_array( $f_title_norm, $existing_titles, true ) ) {
						continue;
					}

					$current_count = isset( $cat_counts[ $f_slug ] ) ? $cat_counts[ $f_slug ] : 0;
					if ( $current_count < 4 ) {
						$products[]        = $f_p;
						$existing_titles[] = $f_title_norm;
						$cat_counts[ $f_slug ] = $current_count + 1;
					}
				}

				return $products;
			}
		}
	}

	// Fallback mock catalog if no products in DB
	return aura_get_fallback_catalog();
}

/**
 * Clean isolated fallback catalog with 4 products per category.
 */
function aura_get_fallback_catalog() {
	$theme_uri = get_template_directory_uri();
	return array(
		// 1. CLEANSER PRODUCTS
		array(
			'id'            => 101,
			'title'         => 'Velvet Cloud Cleansing Balm',
			'subtitle'      => 'Fermented Camellia & Oat Lipid Complex',
			'category'      => 'Cleansers',
			'category_slug' => 'cleansers',
			'price'         => 46.00,
			'regular_price' => 46.00,
			'rating'        => 4.8,
			'reviews'       => 189,
			'badge'         => 'Award Winner',
			'badge_type'    => 'highlight',
			'volume'        => '100 ml / 3.4 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-products.webp',
			'alt_image'     => $theme_uri . '/assets/images/ritual-banner.webp',
			'link'          => home_url( '/product-detail/?product=velvet-cloud-cleansing-balm' ),
			'in_stock'      => true,
			'tags'          => array( 'Melting', 'Sulfate-Free', 'Nourishing', 'Cleansers' ),
		),
		array(
			'id'            => 102,
			'title'         => 'Clarifying Enzyme Powder Wash',
			'subtitle'      => 'Water-activated micro-exfoliating botanical enzyme powder with Papaya and Rice Ferment',
			'category'      => 'Cleansers',
			'category_slug' => 'cleansers',
			'price'         => 52.00,
			'regular_price' => 70.00,
			'rating'        => 4.9,
			'reviews'       => 280,
			'badge'         => 'Best Seller',
			'badge_type'    => 'award',
			'volume'        => '75 g / 2.6 oz.',
			'image'         => $theme_uri . '/assets/images/hero-products.webp',
			'alt_image'     => $theme_uri . '/assets/images/ritual-banner.webp',
			'link'          => home_url( '/product-detail/?product=clarifying-enzyme-powder-wash' ),
			'in_stock'      => true,
			'tags'          => array( 'Enzyme', 'Gentle', 'Cleansers' ),
		),
		array(
			'id'            => 103,
			'title'         => 'Gentle Hydrating Milky Cleanser',
			'subtitle'      => 'Comforting milky emulsion with Rice Bran and colloidal oatmeal for sensitive skin',
			'category'      => 'Cleansers',
			'category_slug' => 'cleansers',
			'price'         => 55.00,
			'regular_price' => 74.00,
			'rating'        => 4.9,
			'reviews'       => 210,
			'badge'         => 'Best Seller',
			'badge_type'    => 'award',
			'volume'        => '120 ml / 4.0 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-products.webp',
			'alt_image'     => $theme_uri . '/assets/images/ritual-banner.webp',
			'link'          => home_url( '/product-detail/?product=gentle-hydrating-milky-cleanser' ),
			'in_stock'      => true,
			'tags'          => array( 'Milky', 'Soothing', 'Cleansers' ),
		),
		array(
			'id'            => 104,
			'title'         => 'Purifying Botanical Gel Cleanser',
			'subtitle'      => 'Deep pore purification with Willow Bark and Green Tea bio-actives',
			'category'      => 'Cleansers',
			'category_slug' => 'cleansers',
			'price'         => 42.00,
			'regular_price' => 54.00,
			'rating'        => 4.8,
			'reviews'       => 165,
			'badge'         => 'Pure Cleanse',
			'badge_type'    => 'clinical',
			'volume'        => '150 ml / 5.1 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-products.webp',
			'alt_image'     => $theme_uri . '/assets/images/ritual-banner.webp',
			'link'          => home_url( '/product-detail/?product=purifying-botanical-gel-cleanser' ),
			'in_stock'      => true,
			'tags'          => array( 'Pore Clarifying', 'Gel', 'Cleansers' ),
		),

		// 2. SERUMS & OILS PRODUCTS
		array(
			'id'            => 201,
			'title'         => 'Aurum Hydrating Serum',
			'subtitle'      => 'Multi-Molecular Hyaluronic Acid & Snow Mushroom for intense deep plumpness',
			'category'      => 'Serums & Oils',
			'category_slug' => 'serums',
			'price'         => 68.00,
			'regular_price' => 78.00,
			'rating'        => 4.9,
			'reviews'       => 342,
			'badge'         => 'Best Seller',
			'badge_type'    => 'award',
			'volume'        => '50 ml / 1.7 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-1.png',
			'alt_image'     => $theme_uri . '/assets/images/promise-model.webp',
			'link'          => home_url( '/product-detail/?product=aurum-hydrating-serum' ),
			'in_stock'      => true,
			'tags'          => array( 'Hydrating', 'Plumping', 'Clean', 'Serums' ),
		),
		array(
			'id'            => 202,
			'title'         => 'Phyto-Retinol Night Renewal Serum',
			'subtitle'      => 'Gentle overnight plant-based retinol serum that smooths fine lines and restores youthfulness',
			'category'      => 'Serums & Oils',
			'category_slug' => 'serums',
			'price'         => 110.00,
			'regular_price' => 149.00,
			'rating'        => 4.9,
			'reviews'       => 280,
			'badge'         => 'Best Seller',
			'badge_type'    => 'award',
			'volume'        => '30 ml / 1.0 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-1.png',
			'alt_image'     => $theme_uri . '/assets/images/hero-products.webp',
			'link'          => home_url( '/product-detail/?product=phyto-retinol-night-renewal-serum' ),
			'in_stock'      => true,
			'tags'          => array( 'Night Repair', 'Phyto-Retinol', 'Serums' ),
		),
		array(
			'id'            => 203,
			'title'         => 'Botanical Bio-Ferment Radiance Serum',
			'subtitle'      => '15% Stabilized Vitamin C with Ferulic Acid & Swiss Alpine Edelweiss',
			'category'      => 'Serums & Oils',
			'category_slug' => 'serums',
			'price'         => 88.00,
			'regular_price' => 110.00,
			'rating'        => 4.9,
			'reviews'       => 194,
			'badge'         => 'Radiance Boost',
			'badge_type'    => 'clinical',
			'volume'        => '30 ml / 1.0 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-1.png',
			'alt_image'     => $theme_uri . '/assets/images/promise-model.webp',
			'link'          => home_url( '/product-detail/?product=botanical-bio-ferment-radiance-serum' ),
			'in_stock'      => true,
			'tags'          => array( 'Vitamin C', 'Glow', 'Serums' ),
		),
		array(
			'id'            => 204,
			'title'         => 'Cellular Renewal Peptide Complex',
			'subtitle'      => 'Multi-peptide concentrated booster for dermal elasticity and collagen architecture',
			'category'      => 'Serums & Oils',
			'category_slug' => 'serums',
			'price'         => 94.00,
			'regular_price' => 120.00,
			'rating'        => 5.0,
			'reviews'       => 225,
			'badge'         => 'Clinical',
			'badge_type'    => 'clinical',
			'volume'        => '30 ml / 1.0 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-1.png',
			'alt_image'     => $theme_uri . '/assets/images/ritual-banner.webp',
			'link'          => home_url( '/product-detail/?product=cellular-renewal-peptide-complex' ),
			'in_stock'      => true,
			'tags'          => array( 'Peptides', 'Firming', 'Serums' ),
		),

		// 3. MOISTURIZERS PRODUCTS
		array(
			'id'            => 301,
			'title'         => 'Barrier Repair Ceramide Cream',
			'subtitle'      => '5-Ceramide & Biomimetic Lipid Recovery Complex for deep skin barrier reinforcement',
			'category'      => 'Moisturizers',
			'category_slug' => 'moisturizers',
			'price'         => 78.00,
			'regular_price' => 78.00,
			'rating'        => 4.9,
			'reviews'       => 256,
			'badge'         => 'Clinical',
			'badge_type'    => 'clinical',
			'volume'        => '50 ml / 1.7 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-2.png',
			'alt_image'     => $theme_uri . '/assets/images/ritual-banner.webp',
			'link'          => home_url( '/product-detail/?product=barrier-repair-ceramide-cream' ),
			'in_stock'      => true,
			'tags'          => array( 'Barrier Repair', 'Firming', 'Moisturizers' ),
		),
		array(
			'id'            => 302,
			'title'         => 'Peptide Firming Day Cream SPF 20',
			'subtitle'      => 'Daily defending anti-aging cream with copper peptides and broad spectrum mineral filters',
			'category'      => 'Moisturizers',
			'category_slug' => 'moisturizers',
			'price'         => 95.00,
			'regular_price' => 128.00,
			'rating'        => 4.9,
			'reviews'       => 280,
			'badge'         => 'Best Seller',
			'badge_type'    => 'award',
			'volume'        => '50 ml / 1.7 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-2.png',
			'alt_image'     => $theme_uri . '/assets/images/promise-model.webp',
			'link'          => home_url( '/product-detail/?product=peptide-firming-day-cream' ),
			'in_stock'      => true,
			'tags'          => array( 'Clean', 'Botanical', 'Moisturizers' ),
		),
		array(
			'id'            => 303,
			'title'         => 'Deep Moisture Recovery Balm',
			'subtitle'      => 'Intense overnight nourishing balm with Wild Shea Butter and Squalane',
			'category'      => 'Moisturizers',
			'category_slug' => 'moisturizers',
			'price'         => 82.00,
			'regular_price' => 98.00,
			'rating'        => 4.8,
			'reviews'       => 160,
			'badge'         => 'Overnight Recovery',
			'badge_type'    => 'cult',
			'volume'        => '60 ml / 2.0 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-2.png',
			'alt_image'     => $theme_uri . '/assets/images/ritual-banner.webp',
			'link'          => home_url( '/product-detail/?product=deep-moisture-recovery-balm' ),
			'in_stock'      => true,
			'tags'          => array( 'Balm', 'Nourishing', 'Moisturizers' ),
		),
		array(
			'id'            => 304,
			'title'         => 'Botanical Water Infusion Gel-Cream',
			'subtitle'      => 'Weightless electrolyte-infused water cream for 72-hour continuous hydration',
			'category'      => 'Moisturizers',
			'category_slug' => 'moisturizers',
			'price'         => 64.00,
			'regular_price' => 76.00,
			'rating'        => 4.9,
			'reviews'       => 215,
			'badge'         => 'Weightless Hydration',
			'badge_type'    => 'award',
			'volume'        => '50 ml / 1.7 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-2.png',
			'alt_image'     => $theme_uri . '/assets/images/promise-model.webp',
			'link'          => home_url( '/product-detail/?product=botanical-water-infusion-cream' ),
			'in_stock'      => true,
			'tags'          => array( 'Gel Cream', 'Hydration', 'Moisturizers' ),
		),

		// 4. EYE CARE PRODUCTS
		array(
			'id'            => 401,
			'title'         => 'Caffeine & Green Tea Awakening Gel',
			'subtitle'      => 'De-puffing cooling gel with organic caffeine, matcha extract, and cucumber hydrosol',
			'category'      => 'Eye Care',
			'category_slug' => 'eye-care',
			'price'         => 72.00,
			'regular_price' => 97.00,
			'rating'        => 4.9,
			'reviews'       => 280,
			'badge'         => 'Instant Depuff',
			'badge_type'    => 'award',
			'volume'        => '15 ml / 0.5 fl. oz.',
			'image'         => $theme_uri . '/assets/images/promise-model.webp',
			'alt_image'     => $theme_uri . '/assets/images/hero-slide-2.png',
			'link'          => home_url( '/product-detail/?product=caffeine-green-tea-awakening-gel' ),
			'in_stock'      => true,
			'tags'          => array( 'Clean', 'Botanical', 'Eye Care' ),
		),
		array(
			'id'            => 402,
			'title'         => 'Lumina Peptide Eye Contour Elixir',
			'subtitle'      => 'Bio-Marine Peptides & Caffeine Micro-Infusion targeting under-eye dark circles',
			'category'      => 'Eye Care',
			'category_slug' => 'eye-care',
			'price'         => 62.00,
			'regular_price' => 70.00,
			'rating'        => 4.9,
			'reviews'       => 198,
			'badge'         => 'Award Winner',
			'badge_type'    => 'award',
			'volume'        => '15 ml / 0.5 fl. oz.',
			'image'         => $theme_uri . '/assets/images/promise-model.webp',
			'alt_image'     => $theme_uri . '/assets/images/hero-slide-2.png',
			'link'          => home_url( '/product-detail/?product=lumina-peptide-eye-contour-elixir' ),
			'in_stock'      => true,
			'tags'          => array( 'De-puffing', 'Fine Lines', 'Eye Care' ),
		),
		array(
			'id'            => 403,
			'title'         => 'Restorative Eye Peptide Elixir',
			'subtitle'      => 'Targeted lifting peptide solution that firms delicate eye contour and crow\'s feet',
			'category'      => 'Eye Care',
			'category_slug' => 'eye-care',
			'price'         => 85.00,
			'regular_price' => 115.00,
			'rating'        => 5.0,
			'reviews'       => 178,
			'badge'         => 'Clinical Lift',
			'badge_type'    => 'clinical',
			'volume'        => '15 ml / 0.5 fl. oz.',
			'image'         => $theme_uri . '/assets/images/promise-model.webp',
			'alt_image'     => $theme_uri . '/assets/images/hero-slide-2.png',
			'link'          => home_url( '/product-detail/?product=restorative-eye-peptide-elixir' ),
			'in_stock'      => true,
			'tags'          => array( 'Firming', 'Peptides', 'Eye Care' ),
		),
		array(
			'id'            => 404,
			'title'         => 'Botanical Youth Eye Recovery Balm',
			'subtitle'      => 'Velvety peptide rich eye balm infused with botanical ceramides for overnight replenishment',
			'category'      => 'Eye Care',
			'category_slug' => 'eye-care',
			'price'         => 68.00,
			'regular_price' => 84.00,
			'rating'        => 4.8,
			'reviews'       => 142,
			'badge'         => 'Youth Restoring',
			'badge_type'    => 'award',
			'volume'        => '15 ml / 0.5 fl. oz.',
			'image'         => $theme_uri . '/assets/images/promise-model.webp',
			'alt_image'     => $theme_uri . '/assets/images/hero-slide-2.png',
			'link'          => home_url( '/product-detail/?product=botanical-youth-eye-recovery-balm' ),
			'in_stock'      => true,
			'tags'          => array( 'Overnight', 'Smoothing', 'Eye Care' ),
		),

		// 5. TONERS & MISTS PRODUCTS
		array(
			'id'            => 501,
			'title'         => 'Silk Petal Brightening Essence',
			'subtitle'      => 'Damask Rose Hydrosol & 5% Niacinamide to tone and refine pores',
			'category'      => 'Toners & Mists',
			'category_slug' => 'toners-mists',
			'price'         => 52.00,
			'regular_price' => 52.00,
			'rating'        => 4.7,
			'reviews'       => 144,
			'badge'         => 'New',
			'badge_type'    => 'new',
			'volume'        => '150 ml / 5.1 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-1.png',
			'alt_image'     => $theme_uri . '/assets/images/promise-model.webp',
			'link'          => home_url( '/product-detail/?product=silk-petal-brightening-essence' ),
			'in_stock'      => true,
			'tags'          => array( 'Tone Evening', 'Pore Refining', 'Toners & Mists' ),
		),
		array(
			'id'            => 502,
			'title'         => 'Rosewater & Centella Calming Mist',
			'subtitle'      => 'Ultra-fine hydrating botanical face mist with pure Bulgarian rose water and Centella Asiatica',
			'category'      => 'Toners & Mists',
			'category_slug' => 'toners-mists',
			'price'         => 48.00,
			'regular_price' => 65.00,
			'rating'        => 4.9,
			'reviews'       => 230,
			'badge'         => 'Calming Mist',
			'badge_type'    => 'award',
			'volume'        => '100 ml / 3.4 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-1.png',
			'alt_image'     => $theme_uri . '/assets/images/hero-products.webp',
			'link'          => home_url( '/product-detail/?product=rosewater-centella-calming-mist' ),
			'in_stock'      => true,
			'tags'          => array( 'Centella', 'Mist', 'Toners & Mists' ),
		),
		array(
			'id'            => 503,
			'title'         => 'Clarifying Botanical Balancing Toner',
			'subtitle'      => 'AHA / BHA exfoliating flower acids to sweep away dull skin cells and restore pH harmony',
			'category'      => 'Toners & Mists',
			'category_slug' => 'toners-mists',
			'price'         => 44.00,
			'regular_price' => 58.00,
			'rating'        => 4.8,
			'reviews'       => 156,
			'badge'         => 'pH Balancing',
			'badge_type'    => 'clinical',
			'volume'        => '150 ml / 5.1 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-1.png',
			'alt_image'     => $theme_uri . '/assets/images/ritual-banner.webp',
			'link'          => home_url( '/product-detail/?product=clarifying-botanical-balancing-toner' ),
			'in_stock'      => true,
			'tags'          => array( 'AHA BHA', 'Balancing', 'Toners & Mists' ),
		),
		array(
			'id'            => 504,
			'title'         => 'Alpine Floral Hydrosol Infusion',
			'subtitle'      => 'Pure wildcrafted floral water blend with Elderflower, Chamomile, and Peony bio-waters',
			'category'      => 'Toners & Mists',
			'category_slug' => 'toners-mists',
			'price'         => 50.00,
			'regular_price' => 62.00,
			'rating'        => 4.9,
			'reviews'       => 175,
			'badge'         => 'Floral Water',
			'badge_type'    => 'award',
			'volume'        => '120 ml / 4.0 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-1.png',
			'alt_image'     => $theme_uri . '/assets/images/promise-model.webp',
			'link'          => home_url( '/product-detail/?product=alpine-floral-hydrosol-infusion' ),
			'in_stock'      => true,
			'tags'          => array( 'Hydrosol', 'Hydration', 'Toners & Mists' ),
		),

		// 6. SUN PROTECTION PRODUCTS
		array(
			'id'            => 601,
			'title'         => 'Cellular Defense SPF 50 Mineral Veil',
			'subtitle'      => '100% non-nano zinc oxide mineral sun protection with transparent silky matte finish',
			'category'      => 'Sun Protection',
			'category_slug' => 'sun-protection',
			'price'         => 65.00,
			'regular_price' => 88.00,
			'rating'        => 4.9,
			'reviews'       => 280,
			'badge'         => 'Broad Spectrum',
			'badge_type'    => 'award',
			'volume'        => '50 ml / 1.7 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-3.png',
			'alt_image'     => $theme_uri . '/assets/images/hero-slide-1.png',
			'link'          => home_url( '/product-detail/?product=cellular-defense-spf-50-mineral-veil' ),
			'in_stock'      => true,
			'tags'          => array( 'Clean', 'Botanical', 'Sun Protection' ),
		),
		array(
			'id'            => 602,
			'title'         => 'Solar Veil Invisible Shield SPF 50',
			'subtitle'      => 'Broad Spectrum Zinc Oxide & Alpine Edelweiss weightless daily defense',
			'category'      => 'Sun Protection',
			'category_slug' => 'sun-protection',
			'price'         => 56.00,
			'regular_price' => 56.00,
			'rating'        => 4.8,
			'reviews'       => 230,
			'badge'         => 'Essential',
			'badge_type'    => 'clinical',
			'volume'        => '60 ml / 2.0 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-3.png',
			'alt_image'     => $theme_uri . '/assets/images/hero-slide-1.png',
			'link'          => home_url( '/product-detail/?product=solar-veil-invisible-shield-spf-50' ),
			'in_stock'      => true,
			'tags'          => array( 'Mineral SPF', 'Non-Greasy', 'Sun Protection' ),
		),
		array(
			'id'            => 603,
			'title'         => 'Daily Invisible UV Mineral Drops SPF 50',
			'subtitle'      => 'Ultralight mineral fluid sunscreen with antioxidant protection against HEV blue light',
			'category'      => 'Sun Protection',
			'category_slug' => 'sun-protection',
			'price'         => 58.00,
			'regular_price' => 72.00,
			'rating'        => 4.9,
			'reviews'       => 188,
			'badge'         => 'Blue Light Defense',
			'badge_type'    => 'clinical',
			'volume'        => '50 ml / 1.7 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-3.png',
			'alt_image'     => $theme_uri . '/assets/images/promise-model.webp',
			'link'          => home_url( '/product-detail/?product=daily-invisible-uv-mineral-drops' ),
			'in_stock'      => true,
			'tags'          => array( 'Fluid Drops', 'SPF 50', 'Sun Protection' ),
		),
		array(
			'id'            => 604,
			'title'         => 'Botanical Broad Spectrum Defense Cream',
			'subtitle'      => 'Nourishing botanical mineral cream protecting against photoaging with Sea Buckthorn',
			'category'      => 'Sun Protection',
			'category_slug' => 'sun-protection',
			'price'         => 60.00,
			'regular_price' => 75.00,
			'rating'        => 4.8,
			'reviews'       => 160,
			'badge'         => 'Broad Spectrum',
			'badge_type'    => 'award',
			'volume'        => '50 ml / 1.7 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-3.png',
			'alt_image'     => $theme_uri . '/assets/images/hero-slide-2.png',
			'link'          => home_url( '/product-detail/?product=botanical-broad-spectrum-defense-cream' ),
			'in_stock'      => true,
			'tags'          => array( 'Cream', 'UVA UVB', 'Sun Protection' ),
		),

		// 7. BOTANICAL OILS PRODUCTS
		array(
			'id'            => 701,
			'title'         => 'Cellular Shield Botanical Elixir',
			'subtitle'      => '100% natural bakuchiol, cold-pressed rosehip seed, and blue tansy lipid barrier treatment oil',
			'category'      => 'Botanical Oils',
			'category_slug' => 'botanical-oils',
			'price'         => 84.00,
			'regular_price' => 92.00,
			'rating'        => 5.0,
			'reviews'       => 412,
			'badge'         => 'Cult Favorite',
			'badge_type'    => 'cult',
			'volume'        => '30 ml / 1.0 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-3.png',
			'alt_image'     => $theme_uri . '/assets/images/promise-model.webp',
			'link'          => home_url( '/product-detail/?product=cellular-shield-botanical-elixir' ),
			'in_stock'      => true,
			'tags'          => array( 'Clean', 'Botanical', 'Botanical Oils' ),
		),
		array(
			'id'            => 702,
			'title'         => 'Wildcrafted Rosehip & Bakuchiol Oil',
			'subtitle'      => 'Unrefined cold-pressed bio-retinol facial oil for supreme cellular regeneration and deep glow',
			'category'      => 'Botanical Oils',
			'category_slug' => 'botanical-oils',
			'price'         => 78.00,
			'regular_price' => 95.00,
			'rating'        => 4.9,
			'reviews'       => 260,
			'badge'         => 'Glow Elixir',
			'badge_type'    => 'award',
			'volume'        => '30 ml / 1.0 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-3.png',
			'alt_image'     => $theme_uri . '/assets/images/ritual-banner.webp',
			'link'          => home_url( '/product-detail/?product=wildcrafted-rosehip-bakuchiol-oil' ),
			'in_stock'      => true,
			'tags'          => array( 'Rosehip', 'Bakuchiol', 'Botanical Oils' ),
		),
		array(
			'id'            => 703,
			'title'         => 'Sacred Marula & Squalane Facial Nectar',
			'subtitle'      => 'Antioxidant-dense virgin cold-pressed Marula oil combined with sugarcane-derived squalane',
			'category'      => 'Botanical Oils',
			'category_slug' => 'botanical-oils',
			'price'         => 86.00,
			'regular_price' => 105.00,
			'rating'        => 5.0,
			'reviews'       => 195,
			'badge'         => 'Precious Nectar',
			'badge_type'    => 'cult',
			'volume'        => '30 ml / 1.0 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-3.png',
			'alt_image'     => $theme_uri . '/assets/images/promise-model.webp',
			'link'          => home_url( '/product-detail/?product=sacred-marula-squalane-facial-nectar' ),
			'in_stock'      => true,
			'tags'          => array( 'Marula', 'Squalane', 'Botanical Oils' ),
		),
		array(
			'id'            => 704,
			'title'         => 'Golden Camellia Illuminating Oil',
			'subtitle'      => 'Silky lightweight Japanese Camellia seed oil enriched with Vitamin E for soft radiant luminosity',
			'category'      => 'Botanical Oils',
			'category_slug' => 'botanical-oils',
			'price'         => 74.00,
			'regular_price' => 90.00,
			'rating'        => 4.8,
			'reviews'       => 170,
			'badge'         => 'Illuminating',
			'badge_type'    => 'award',
			'volume'        => '30 ml / 1.0 fl. oz.',
			'image'         => $theme_uri . '/assets/images/hero-slide-3.png',
			'alt_image'     => $theme_uri . '/assets/images/hero-slide-1.png',
			'link'          => home_url( '/product-detail/?product=golden-camellia-illuminating-oil' ),
			'in_stock'      => true,
			'tags'          => array( 'Camellia', 'Luminosity', 'Botanical Oils' ),
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
				if ( $term->slug === 'uncategorized' && $term->count === 0 ) {
					continue;
				}

				$icon = isset( $icon_map[ $term->slug ] ) ? $icon_map[ $term->slug ] : 'serum.svg';
				$categories[] = array(
					'slug'  => $term->slug,
					'name'  => $term->name,
					'count' => $term->count > 0 ? $term->count : 4,
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
		array( 'slug' => 'cleansers', 'name' => 'Cleansers', 'count' => 4, 'icon' => 'cleanser.svg', 'desc' => 'Purifying balms & gels' ),
		array( 'slug' => 'serums', 'name' => 'Serums & Oils', 'count' => 4, 'icon' => 'serum.svg', 'desc' => 'Concentrated clinical actives' ),
		array( 'slug' => 'moisturizers', 'name' => 'Moisturizers', 'count' => 4, 'icon' => 'moisturizer.svg', 'desc' => 'Barrier-nourishing creams' ),
		array( 'slug' => 'eye-care', 'name' => 'Eye Care', 'count' => 4, 'icon' => 'eye-cream.svg', 'desc' => 'Illuminating & de-puffing' ),
		array( 'slug' => 'toners-mists', 'name' => 'Toners & Mists', 'count' => 4, 'icon' => 'toner.svg', 'desc' => 'Hydrosols & balancing waters' ),
		array( 'slug' => 'sun-protection', 'name' => 'Sun Protection', 'count' => 4, 'icon' => 'sunscreen.svg', 'desc' => 'Invisible mineral SPF 50+' ),
		array( 'slug' => 'botanical-oils', 'name' => 'Botanical Oils', 'count' => 4, 'icon' => 'oil.svg', 'desc' => 'Cold-pressed elixirs' ),
	);
}

/**
 * Render a dedicated, isolated 4-column category product showcase section.
 *
 * @param string       $title          Section header title (e.g. "CLEANSERS YOU'LL LOVE").
 * @param string|array $category_slugs Category slug(s) to strictly pull products from.
 * @param string       $section_id     HTML ID attribute for smooth anchor scrolling.
 * @param string       $bg_color       Background color CSS.
 * @param int          $limit          Number of products to render (default 4 for 4-col grid).
 */
function aura_render_category_showcase_section( $title, $category_slugs, $section_id = '', $bg_color = '#ffffff', $limit = 4 ) {
	$theme_uri    = get_template_directory_uri();
	$slugs_array  = (array) $category_slugs;
	$products     = array();

	// 1. If WooCommerce is active, query strictly matching products via WP_Query with tax_query
	if ( class_exists( 'WooCommerce' ) && class_exists( 'WP_Query' ) ) {
		$wc_query = new WP_Query( array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
			'tax_query'      => array(
				array(
					'taxonomy'         => 'product_cat',
					'field'            => 'slug',
					'terms'            => $slugs_array,
					'operator'         => 'IN',
					'include_children' => false,
				),
			),
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
		) );

		if ( $wc_query->have_posts() ) {
			while ( $wc_query->have_posts() ) {
				$wc_query->the_post();
				$wc_p = wc_get_product( get_the_ID() );
				if ( ! $wc_p ) {
					continue;
				}

				$p_id     = $wc_p->get_id();
				$p_slug   = $wc_p->get_slug();
				$image_id = $wc_p->get_image_id();

				$cat_names = array();
				$cat_slugs = array();
				$terms     = get_the_terms( $p_id, 'product_cat' );
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					foreach ( $terms as $t ) {
						$cat_names[] = $t->name;
						$cat_slugs[] = $t->slug;
					}
				}
				$category_str     = ! empty( $cat_names ) ? implode( ', ', $cat_names ) : $title;
				$primary_cat_slug = ! empty( $cat_slugs ) ? $cat_slugs[0] : ( $slugs_array[0] ?? 'rituals' );

				$default_img = $theme_uri . '/assets/images/hero-slide-1.png';
				$default_alt = $theme_uri . '/assets/images/promise-model.webp';
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
				}

				$img_url     = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : $default_img;
				$gallery_ids = $wc_p->get_gallery_image_ids();
				$alt_img_url = ! empty( $gallery_ids ) ? wp_get_attachment_image_url( $gallery_ids[0], 'large' ) : $default_alt;

				$price         = (float) $wc_p->get_price();
				$regular_price = (float) $wc_p->get_regular_price();
				if ( $regular_price <= $price || $regular_price <= 0 ) {
					$regular_price = round( $price * 1.35 );
				}

				$volume = get_post_meta( $p_id, '_aura_volume', true );
				if ( empty( $volume ) ) {
					$volume = '50 ml / 1.7 fl. oz.';
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
					'volume'        => $volume,
					'image'         => $img_url,
					'alt_image'     => $alt_img_url,
					'link'          => home_url( '/product-detail/?product=' . $p_slug ),
				);
			}
			wp_reset_postdata();
		}
	}

	// 2. Strict Fallback Supplementing with NO Category Cross-over
	if ( count( $products ) < $limit ) {
		$fallback_catalog = aura_get_fallback_catalog();
		$existing_ids     = array_map( function( $p ) { return $p['id']; }, $products );
		$existing_titles  = array_map( function( $p ) {
			return str_replace( array( '&amp;', '&#038;', '  ' ), array( '&', '&', ' ' ), strtolower( trim( $p['title'] ) ) );
		}, $products );

		foreach ( $fallback_catalog as $m_p ) {
			$p_slug_check = strtolower( trim( $m_p['category_slug'] ?? '' ) );
			$m_title_norm = str_replace( array( '&amp;', '&#038;', '  ' ), array( '&', '&', ' ' ), strtolower( trim( $m_p['title'] ) ) );

			if ( in_array( $m_p['id'], $existing_ids, true ) || in_array( $m_title_norm, $existing_titles, true ) ) {
				continue;
			}

			foreach ( $slugs_array as $target_slug ) {
				$target_slug = strtolower( trim( $target_slug ) );
				if ( $p_slug_check === $target_slug ) {
					$products[]        = $m_p;
					$existing_titles[] = $m_title_norm;
					break;
				}
			}
			if ( count( $products ) >= $limit ) {
				break;
			}
		}
	}

	if ( empty( $products ) ) {
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

			<!-- Responsive 4-Column Product Grid -->
			<div class="category-4col-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: clamp(1.25rem, 2vw, 2rem); width: 100%;">
				<?php foreach ( $products as $product ) : 
					$reg_price = isset( $product['regular_price'] ) && (float) $product['regular_price'] > 0 ? (float) $product['regular_price'] : round( $product['price'] * 1.35 );
					$has_sale  = ( $reg_price > $product['price'] );
					$cat_slug  = ! empty( $product['category_slug'] ) ? $product['category_slug'] : sanitize_title( $product['category'] );
				?>
					<article 
						class="aura-product-card" 
						data-product-id="<?php echo esc_attr( $product['id'] ); ?>"
						data-category="<?php echo esc_attr( $cat_slug ); ?>"
						data-category-name="<?php echo esc_attr( $product['category'] ); ?>"
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
