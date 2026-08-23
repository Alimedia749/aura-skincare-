<?php
/**
 * Main Template File for Aura Skincare Theme
 *
 * @package Aura_Skincare
 */

if ( is_front_page() || is_home() ) {
	include get_template_directory() . '/front-page.php';
	return;
}

if ( is_page( 'shop' ) || ( function_exists( 'is_shop' ) && is_shop() ) || is_post_type_archive( 'product' ) ) {
	require get_template_directory() . '/page-templates/template-shop.php';
	return;
}

if ( is_page( 'about-us' ) || is_page( 'about' ) ) {
	require get_template_directory() . '/page-templates/template-about.php';
	return;
}

get_header();
?>
<main id="main-content" class="site-main" style="padding: clamp(3rem, 6vw, 6rem) var(--container-max); margin: 0 auto; max-width: 1200px;">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1 class="section-title" style="margin-bottom: 1.5rem;"><?php the_title(); ?></h1>
				<div class="entry-content" style="line-height: 1.8; color: var(--color-text-main);">
					<?php the_content(); ?>
				</div>
			</article>
			<?php
		endwhile;
	endif;
	?>
</main>
<?php
get_footer();
