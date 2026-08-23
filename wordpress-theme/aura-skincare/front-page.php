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

	<!-- 2. Section 1: Bestsellers You'll Love Grid -->
	<?php get_template_part( 'template-parts/sections/bestsellers-grid' ); ?>

	<!-- 4. Section 2: New Arrivals You'll Love Grid -->
	<?php get_template_part( 'template-parts/sections/new-arrivals-grid' ); ?>

	<!-- 5. Section 3: Ritual Sets & Kits You'll Love Grid -->
	<?php get_template_part( 'template-parts/sections/ritual-kits-grid' ); ?>

	<!-- 6. The Ritual & Clean Promise Story Banners -->
	<?php get_template_part( 'template-parts/sections/editorial-banners' ); ?>

	<!-- 5. Editorial Press & Recognition Strip -->
	<?php get_template_part( 'template-parts/sections/press-strip' ); ?>

	<!-- 6. Society VIP Newsletter Section -->
	<?php get_template_part( 'template-parts/sections/newsletter-bar' ); ?>

</main>

<?php
get_footer();
