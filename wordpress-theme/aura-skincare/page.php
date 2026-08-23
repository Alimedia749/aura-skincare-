<?php
/**
 * The template for displaying all pages
 *
 * @package Aura_Skincare
 */

$page_slug = get_post_field( 'post_name', get_post() );

if ( 'shop' === $page_slug || is_page( 'shop' ) || ( function_exists( 'is_shop' ) && is_shop() ) || is_post_type_archive( 'product' ) ) {
	require get_template_directory() . '/page-templates/template-shop.php';
	return;
}

if ( 'about-us' === $page_slug || 'about' === $page_slug || is_page( 'about-us' ) || is_page( 'about' ) ) {
	require get_template_directory() . '/page-templates/template-about.php';
	return;
}

if ( 'checkout' === $page_slug || is_page( 'checkout' ) ) {
	require get_template_directory() . '/page-templates/template-checkout.php';
	return;
}

if ( 'product-detail' === $page_slug || is_page( 'product-detail' ) ) {
	require get_template_directory() . '/page-templates/template-product-detail.php';
	return;
}

get_header();
?>
<main id="main-content" class="site-main" style="padding: clamp(4rem, 7vw, 7rem) 1.5rem; max-width: 1200px; margin: 0 auto; min-height: 60vh;">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h1 class="section-title" style="margin-bottom: 2rem;"><?php the_title(); ?></h1>
			<div class="entry-content" style="line-height: 1.8; color: var(--color-text-main); font-size: 1rem;">
				<?php the_content(); ?>
			</div>
		</article>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
