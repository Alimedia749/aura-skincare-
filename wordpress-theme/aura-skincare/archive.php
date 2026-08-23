<?php
/**
 * The template for displaying archive pages
 *
 * @package Aura_Skincare
 */

if ( is_post_type_archive( 'product' ) || ( function_exists( 'is_shop' ) && is_shop() ) ) {
	require get_template_directory() . '/page-templates/template-shop.php';
	return;
}

get_header();
?>
<main id="main-content" class="site-main" style="padding: clamp(3rem, 6vw, 6rem) var(--container-max); margin: 0 auto; max-width: 1200px;">
	<header class="page-header" style="margin-bottom: 2rem;">
		<?php
		the_archive_title( '<h1 class="section-title">', '</h1>' );
		the_archive_description( '<div class="archive-description">', '</div>' );
		?>
	</header>
</main>
<?php
get_footer();
