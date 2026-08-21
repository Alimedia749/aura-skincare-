<?php
/**
 * The template for displaying the Aura Skincare luxury front page
 *
 * @package Aura_Skincare
 */

get_header();
?>

<main id="main-content" class="site-main" role="main">

	<!-- 1. Split Editorial Hero Showcase -->
	<?php get_template_part( 'template-parts/hero/editorial-hero' ); ?>

	<!-- 2. Category Navigation Pills -->
	<?php get_template_part( 'template-parts/sections/category-pills' ); ?>

	<!-- 3. 5-Column Bestsellers Showcase Grid -->
	<?php get_template_part( 'template-parts/sections/bestsellers-grid' ); ?>

	<!-- 4. The Ritual & Clean Promise Story Banners -->
	<?php get_template_part( 'template-parts/sections/editorial-banners' ); ?>

	<!-- 5. Editorial Press & Recognition Strip -->
	<?php get_template_part( 'template-parts/sections/press-strip' ); ?>

	<!-- 6. Society VIP Newsletter Section -->
	<?php get_template_part( 'template-parts/sections/newsletter-bar' ); ?>

</main>

<?php
get_footer();
