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
				$image_id     = $wc_p->get_image_id();
				$img_url      = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : $theme_uri . '/assets/images/hero-products.webp';
				$gallery_ids  = $wc_p->get_gallery_image_ids();
				$alt_img_url  = ! empty( $gallery_ids ) ? wp_get_attachment_image_url( $gallery_ids[0], 'large' ) : $img_url;

				$cat_names = array();
				$terms = get_the_terms( $p_id, 'product_cat' );
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					foreach ( $terms as $t ) {
						$cat_names[] = $t->name;
					}
				}
				$category_str = ! empty( $cat_names ) ? implode( ', ', $cat_names ) : 'Rituals';

				$badge = get_post_meta( $p_id, '_aura_badge', true );
				if ( empty( $badge ) && $wc_p->is_featured() ) {
					$badge = 'Featured';
				}

				$volume = get_post_meta( $p_id, '_aura_volume', true );
				if ( empty( $volume ) ) {
					$volume = '50 ml / 1.7 fl. oz.';
				}

				$products[] = array(
					'id'            => $p_id,
					'title'         => $wc_p->get_name(),
					'subtitle'      => $wc_p->get_short_description() ? wp_strip_all_tags( $wc_p->get_short_description() ) : 'Botanical Bio-Compatible Concentrate',
					'category'      => $category_str,
					'price'         => (float) $wc_p->get_price(),
					'regular_price' => (float) $wc_p->get_regular_price(),
					'rating'        => (float) $wc_p->get_average_rating() > 0 ? (float) $wc_p->get_average_rating() : 4.9,
					'reviews'       => (int) $wc_p->get_review_count() > 0 ? (int) $wc_p->get_review_count() : 280,
					'badge'         => $badge ? $badge : 'Best Seller',
					'badge_type'    => 'award',
					'volume'        => $volume,
					'image'         => $img_url,
					'alt_image'     => $alt_img_url,
					'link'          => home_url( '/product-detail/?product=' . $wc_p->get_slug() ),
					'in_stock'      => $wc_p->is_in_stock(),
					'tags'          => array( 'Clean', 'Botanical' ),
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
