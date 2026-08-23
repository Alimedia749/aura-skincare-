<?php
/**
 * Category Navigation Pills Section Template Part
 *
 * @package Aura_Skincare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$categories = aura_get_category_pills();
$theme_uri  = get_template_directory_uri();
?>

<section id="categories" class="category-pills-section" aria-label="<?php esc_attr_e( 'Product Categories', 'aura-skincare' ); ?>">
	<div class="aura-container-wide">
		<div class="category-pills-container" role="tablist">
			
			<!-- All Rituals Pill -->
			<a href="#all-products" class="category-pill-item active" data-category="all" role="tab" aria-selected="true">
				<svg class="category-pill-icon" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6">
					<circle cx="12" cy="12" r="9"/>
					<path d="M12 3v18M3 12h18"/>
				</svg>
				<span class="category-pill-name"><?php esc_html_e( 'All Rituals', 'aura-skincare' ); ?></span>
			</a>

			<?php foreach ( $categories as $cat ) : ?>
				<a 
					href="#all-products" 
					class="category-pill-item" 
					data-category="<?php echo esc_attr( $cat['slug'] ); ?>"
					role="tab"
					aria-selected="false"
				>
					<img 
						src="<?php echo esc_url( $theme_uri . '/assets/images/icons/' . $cat['icon'] ); ?>" 
						alt="" 
						class="category-pill-icon" 
						aria-hidden="true"
						width="22" 
						height="22"
					>
					<span class="category-pill-name"><?php echo esc_html( $cat['name'] ); ?></span>
					<span class="category-pill-count">(<?php echo esc_html( $cat['count'] ); ?>)</span>
				</a>
			<?php endforeach; ?>

		</div>
	</div>
</section>
