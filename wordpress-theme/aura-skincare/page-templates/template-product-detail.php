<?php
/**
 * Template Name: Product Detail Page
 * Template Post Type: page, product, post
 *
 * @package Aura_Skincare
 */

get_header();

$theme_uri = get_template_directory_uri();

// Dynamic product lookup based on query parameter or single product post
$product_slug = isset( $_GET['product'] ) ? sanitize_text_field( $_GET['product'] ) : '';

// Mock catalog details matching the user's design image
$products_db = array(
	'aurum-hydrating-serum' => array(
		'id'          => '101',
		'title'       => 'Aurum Hydrating Serum',
		'category'    => 'THE RITUAL / HYDRATING SERUM',
		'subtitle'    => 'Deep Hyaluronic Serum with Gold Peptides & Botanical Lipids',
		'price'       => '68.00',
		'volume'      => '50 ml / 1.7 fl. oz.',
		'image'       => $theme_uri . '/assets/images/hero-slide-1.png',
		'alt_image'   => $theme_uri . '/assets/images/hero-products.webp',
		'badge'       => 'Bestseller No. 1',
		'description' => 'A botanical blend of botanical purity and clinical precision. Formulated with multi-weight hyaluronic acid and cold-pressed bio-ferment for weightless deep penetration into skin layers to restore instant cellular vitality, leaving your complexion actively hydrated, luminous, and authentically breathable.',
		'benefits'    => array(
			'Deep cellular hydration across all dermal layers',
			'Restores and locks in the lipid moisture barrier',
			'Clinically proven 24H moisture retention',
			'Non-comedogenic, lightweight dewy absorption',
		),
		'actives'     => array(
			array(
				'title' => 'Hyaluronic Acid',
				'desc'  => 'Multi-molecular weights that pull moisture deep into the dermis for instant plumping.',
			),
			array(
				'title' => 'Gold Peptides',
				'desc'  => 'Actively formulated to firm and enhance the skin\'s natural radiant elasticity.',
			),
			array(
				'title' => 'Bio-Ferment',
				'desc'  => 'Ferment specifically to soothe inflammation and provide a delicate, balancing aroma.',
			),
		),
		'quotes'      => array(
			array(
				'text'   => 'The texture is like nothing else: it absorbs instantly and leaves the skin feeling dewy, plump, and calm.',
				'author' => 'Dr. Elena Vance, Board Dermatologist',
			),
			array(
				'text'   => 'Finally, a serum that delivers on both the luxury sensorial experience and real clinical hydration results.',
				'author' => 'VOGUE Beauty Editorial',
			),
		),
	),
	'barrier-repair-ceramide-cream' => array(
		'id'          => '104',
		'title'       => 'Barrier Repair Ceramide Cream',
		'category'    => 'THE RITUAL / MOISTURIZER',
		'subtitle'    => 'Rich Ceramide & Biomimetic Lipid Recovery Complex',
		'price'       => '78.00',
		'volume'      => '50 ml / 1.7 fl. oz.',
		'image'       => $theme_uri . '/assets/images/hero-slide-2.png',
		'alt_image'   => $theme_uri . '/assets/images/promise-model.webp',
		'badge'       => 'Clinical Defense',
		'description' => 'A velvety, deeply nourishing moisturizer that repairs compromised skin barriers and shields against environmental stressors with 5 bio-identical ceramides.',
		'benefits'    => array(
			'Rebuilds lipid barrier within 48 hours',
			'Soothes redness and barrier irritation',
			'Locks in active serums without greasiness',
			'Rich, cashmere finish suitable for sensitive skin',
		),
		'actives'     => array(
			array(
				'title' => '5-Ceramide Complex',
				'desc'  => 'Biomimetic ceramides EOP, NP, AP, AS, and NS to reconstruct cellular lipid matrices.',
			),
			array(
				'title' => 'Oat Beta-Glucan',
				'desc'  => 'Deeply penetrating polysaccharide that soothes visible irritation and strengthens skin immunity.',
			),
			array(
				'title' => 'Squalane & Shea',
				'desc'  => 'Plant-derived emollient shield to prevent trans-epidermal water loss all day.',
			),
		),
		'quotes'      => array(
			array(
				'text'   => 'This cream completely transformed my dry, irritated skin in less than a week.',
				'author' => 'Harper\'s BAZAAR',
			),
			array(
				'text'   => 'The ultimate holy grail moisturizer for repairing winter barrier damage.',
				'author' => 'ELLE Magazine',
			),
		),
	),
	'cellular-shield-botanical-elixir' => array(
		'id'          => '103',
		'title'       => 'Cellular Shield Botanical Elixir',
		'category'    => 'THE RITUAL / FACE OIL',
		'subtitle'    => 'Cold-Pressed Bakuchiol & Rosehip Antioxidant Shield',
		'price'       => '84.00',
		'volume'      => '30 ml / 1.0 fl. oz.',
		'image'       => $theme_uri . '/assets/images/hero-slide-3.png',
		'alt_image'   => $theme_uri . '/assets/images/ritual-banner.webp',
		'badge'       => 'Cult Favorite',
		'description' => 'A golden, antioxidant-rich botanical nectar that protects against pollution, free radicals, and blue light while promoting youthful skin renewal.',
		'benefits'    => array(
			'Gentle plant-derived alternative to retinol',
			'Infused with 14 active organic cold-pressed botanicals',
			'Protects against oxidative stress and environmental pollution',
			'Fast-absorbing golden glow without silicone or pore clogging',
		),
		'actives'     => array(
			array(
				'title' => '1% Pure Bakuchiol',
				'desc'  => 'Clinically proven botanical retinol alternative that smooths fine lines without peeling.',
			),
			array(
				'title' => 'Wild Rosehip Seed',
				'desc'  => 'Naturally rich in pro-vitamin A and omegas 3, 6, and 9 to enhance cellular radiance.',
			),
			array(
				'title' => 'CoQ10 & Astaxanthin',
				'desc'  => 'Supercharged antioxidant complex 6,000x stronger than Vitamin C at neutralizing free radicals.',
			),
		),
		'quotes'      => array(
			array(
				'text'   => 'The most luxurious face oil on the market — feels like pure silk on the skin.',
				'author' => 'Allure Best of Beauty',
			),
			array(
				'text'   => 'Gives that enviable glass-skin lit-from-within finish instantly.',
				'author' => 'Marie Claire UK',
			),
		),
	),
);

// Check if real WooCommerce product exists in database
$curr = null;
if ( class_exists( 'WooCommerce' ) ) {
	$wc_p = null;
	if ( is_singular( 'product' ) ) {
		$wc_p = wc_get_product( get_the_ID() );
	} elseif ( ! empty( $product_slug ) ) {
		$post_obj = get_page_by_path( $product_slug, OBJECT, 'product' );
		if ( $post_obj ) {
			$wc_p = wc_get_product( $post_obj->ID );
		}
	}

	if ( $wc_p ) {
		$image_id    = $wc_p->get_image_id();
		$gallery_ids = $wc_p->get_gallery_image_ids();
		$img_url     = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : $theme_uri . '/assets/images/hero-slide-1.png';
		$alt_url     = ! empty( $gallery_ids ) ? wp_get_attachment_image_url( $gallery_ids[0], 'large' ) : $theme_uri . '/assets/images/hero-products.webp';

		$cat_str = 'THE RITUAL / ' . ( $wc_p->get_categories() ? strtoupper( wp_strip_all_tags( $wc_p->get_categories() ) ) : 'SKINCARE' );
		$badge   = get_post_meta( $wc_p->get_id(), '_aura_badge', true ) ?: 'Best Seller';
		$volume  = get_post_meta( $wc_p->get_id(), '_aura_volume', true ) ?: '50 ml / 1.7 fl. oz.';

		$curr = array(
			'id'          => $wc_p->get_id(),
			'title'       => $wc_p->get_name(),
			'category'    => $cat_str,
			'subtitle'    => $wc_p->get_short_description() ? wp_strip_all_tags( $wc_p->get_short_description() ) : 'Botanical Bio-Compatible Concentrate',
			'price'       => number_format( (float) $wc_p->get_price(), 2 ),
			'volume'      => $volume,
			'image'       => $img_url,
			'alt_image'   => $alt_url,
			'badge'       => $badge,
			'description' => $wc_p->get_description() ? wp_strip_all_tags( $wc_p->get_description() ) : $products_db['aurum-hydrating-serum']['description'],
			'benefits'    => array(
				'Deep cellular hydration across all dermal layers',
				'Restores and locks in the lipid moisture barrier',
				'Clinically proven 24H moisture retention',
				'Non-comedogenic, lightweight dewy absorption',
			),
			'actives'     => $products_db['aurum-hydrating-serum']['actives'],
			'quotes'      => $products_db['aurum-hydrating-serum']['quotes'],
		);
	}
}

// Fallback to array match if not loaded from WC
if ( ! $curr ) {
	$curr = isset( $products_db[ $product_slug ] ) ? $products_db[ $product_slug ] : $products_db['aurum-hydrating-serum'];
}
?>

<main id="main-content" class="product-detail-page">
	<div class="aura-container-wide">

		<!-- Breadcrumb -->
		<nav class="product-detail-breadcrumb" aria-label="Breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'aura-skincare' ); ?></a>
			<span>/</span>
			<a href="<?php echo esc_url( home_url( '/#bestsellers' ) ); ?>"><?php esc_html_e( 'Rituals', 'aura-skincare' ); ?></a>
			<span>/</span>
			<span style="color: var(--color-heading); font-weight: 600;"><?php echo esc_html( $curr['title'] ); ?></span>
		</nav>

		<!-- 2-Column Product Detail Showcase -->
		<div class="product-detail-grid">
			
			<!-- Left: Sticky Gallery -->
			<div class="product-gallery-sticky">
				<div class="product-main-gallery-frame">
					<img 
						src="<?php echo esc_url( $curr['image'] ); ?>" 
						alt="<?php echo esc_attr( $curr['title'] ); ?>" 
						class="product-gallery-img"
						id="mainProductImg"
					>
					<span class="aura-badge badge-award gallery-floating-badge"><?php echo esc_html( $curr['badge'] ); ?></span>
				</div>
				<div class="gallery-thumbs-row">
					<button type="button" class="gallery-thumb-btn active" onclick="document.getElementById('mainProductImg').src='<?php echo esc_url( $curr['image'] ); ?>'; this.parentElement.querySelectorAll('button').forEach(b => b.classList.remove('active')); this.classList.add('active');">
						<img src="<?php echo esc_url( $curr['image'] ); ?>" alt="View 1">
					</button>
					<button type="button" class="gallery-thumb-btn" onclick="document.getElementById('mainProductImg').src='<?php echo esc_url( $curr['alt_image'] ); ?>'; this.parentElement.querySelectorAll('button').forEach(b => b.classList.remove('active')); this.classList.add('active');">
						<img src="<?php echo esc_url( $curr['alt_image'] ); ?>" alt="View 2">
					</button>
				</div>
			</div>

			<!-- Right: Information & Action Panel -->
			<div class="product-info-panel">
				<span class="product-eyebrow-tag"><?php echo esc_html( $curr['category'] ); ?></span>
				<h1 class="product-hero-title"><?php echo esc_html( $curr['title'] ); ?></h1>
				
				<div class="product-rating-row">
					<div class="aura-stars">
						<span>★★★★★</span>
					</div>
					<span style="font-size:0.85rem; font-weight:600; color:var(--color-heading);">4.9 / 5</span>
					<span style="font-size:0.75rem; color:var(--color-text-subtle);">(342 reviews)</span>
				</div>

				<div class="product-price-display">
					<span class="product-current-price">$<?php echo esc_html( $curr['price'] ); ?></span>
					<span class="product-volume-pill"><?php echo esc_html( $curr['volume'] ); ?></span>
				</div>

				<p class="product-narrative-text">
					<?php echo esc_html( $curr['description'] ); ?>
				</p>

				<!-- Key Benefits Checklist -->
				<div class="product-benefits-checklist">
					<?php foreach ( $curr['benefits'] as $benefit ) : ?>
						<div class="benefit-check-item">
							<div class="benefit-check-icon">
								<svg viewBox="0 0 20 20" fill="currentColor">
									<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
								</svg>
							</div>
							<span><?php echo esc_html( $benefit ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>

				<!-- Purchase Controls -->
				<div class="product-purchase-box">
					<div class="product-qty-selector">
						<button type="button" class="product-qty-btn" onclick="var q=document.getElementById('productDetailQty'); q.value=Math.max(1, parseInt(q.value)-1);">−</button>
						<input type="number" class="product-qty-input" id="productDetailQty" value="1" min="1" readonly>
						<button type="button" class="product-qty-btn" onclick="var q=document.getElementById('productDetailQty'); q.value=parseInt(q.value)+1;">+</button>
					</div>

					<button 
						type="button" 
						class="aura-btn aura-btn-primary product-add-to-bag-btn quick-add-btn" 
						data-add-to-cart="<?php echo esc_attr( $curr['id'] ); ?>"
						data-product-title="<?php echo esc_attr( $curr['title'] ); ?>"
						data-product-price="<?php echo esc_attr( $curr['price'] ); ?>"
						data-product-img="<?php echo esc_url( $curr['image'] ); ?>"
						data-product-vol="<?php echo esc_attr( $curr['volume'] ); ?>"
					>
						<span><?php esc_html_e( 'Add to Bag', 'aura-skincare' ); ?></span>
						<span>— $<?php echo esc_html( $curr['price'] ); ?></span>
					</button>
				</div>

				<!-- Guarantee Strip -->
				<div class="product-guarantee-strip">
					<div class="guarantee-item">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
						<span>30-Day Ritual Guarantee</span>
					</div>
					<div class="guarantee-item">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon></svg>
						<span>Complimentary Shipping over $75</span>
					</div>
					<div class="guarantee-item">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
						<span>100% Clean &amp; Cruelty Free</span>
					</div>
				</div>

			</div>

		</div>

	</div>
</main>

<!-- ── THE SCIENCE OF INGREDIENTS SECTION ───────────── -->
<section class="science-ingredients-section">
	<div class="aura-container-wide">
		<div class="section-header">
			<span class="section-eyebrow"><?php esc_html_e( 'THE SCIENCE OF ACTIVES', 'aura-skincare' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Formulated for Cellular Harmony', 'aura-skincare' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'Targeted bio-compatible compounds engineered to nourish and renew at microscopic depth.', 'aura-skincare' ); ?></p>
		</div>

		<div class="science-ingredients-grid">
			<?php foreach ( $curr['actives'] as $active ) : ?>
				<div class="science-card">
					<div class="science-card-icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
							<circle cx="12" cy="12" r="9"/>
							<path d="M12 3v18M3 12h18"/>
						</svg>
					</div>
					<h3 class="science-card-title"><?php echo esc_html( $active['title'] ); ?></h3>
					<p class="science-card-desc"><?php echo esc_html( $active['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ── EDITORIAL TESTIMONIAL QUOTES ────────────────── -->
<section class="product-reviews-quote-section">
	<div class="aura-container-wide">
		<div class="quote-split-grid">
			<?php foreach ( $curr['quotes'] as $quote ) : ?>
				<div class="editorial-quote-card">
					<p class="quote-text">"<?php echo esc_html( $quote['text'] ); ?>"</p>
					<span class="quote-author"><?php echo esc_html( $quote['author'] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ── RELATED BESTSELLERS SHOWCASE ────────────────── -->
<?php get_template_part( 'template-parts/sections/bestsellers-grid' ); ?>

<?php
get_footer();
