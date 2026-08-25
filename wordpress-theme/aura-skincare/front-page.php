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

	<!-- 2. Category Section: Cleansers -->
	<?php aura_render_category_showcase_section( "CLEANSERS YOU'LL LOVE", 'cleansers', 'cleansers-section', '#ffffff' ); ?>

	<!-- 3. Category Section: Serums & Oils -->
	<?php aura_render_category_showcase_section( "SERUMS & OILS YOU'LL LOVE", 'serums', 'serums-section', '#FAF7F2' ); ?>

	<!-- 4. Category Section: Moisturizers -->
	<?php aura_render_category_showcase_section( "MOISTURIZERS YOU'LL LOVE", 'moisturizers', 'moisturizers-section', '#ffffff' ); ?>

	<!-- 5. Category Section: Eye Care -->
	<?php aura_render_category_showcase_section( "EYE CARE YOU'LL LOVE", 'eye-care', 'eyecare-section', '#FAF7F2' ); ?>

	<!-- 6. Category Section: Toners & Mists -->
	<?php aura_render_category_showcase_section( "TONERS & MISTS YOU'LL LOVE", 'toners-mists', 'toners-section', '#ffffff' ); ?>

	<!-- 7. Category Section: Sun Protection -->
	<?php aura_render_category_showcase_section( "SUN PROTECTION YOU'LL LOVE", 'sun-protection', 'sunprotection-section', '#FAF7F2' ); ?>

	<!-- 8. Category Section: Botanical Oils -->
	<?php aura_render_category_showcase_section( "BOTANICAL OILS YOU'LL LOVE", 'botanical-oils', 'botanicaloils-section', '#ffffff' ); ?>

	<!-- 6. The Ritual & Clean Promise Story Banners -->
	<?php get_template_part( 'template-parts/sections/editorial-banners' ); ?>

	<!-- 5. Editorial Press & Recognition Strip -->
	<?php get_template_part( 'template-parts/sections/press-strip' ); ?>

	<!-- 6. Society VIP Newsletter Section -->
	<?php get_template_part( 'template-parts/sections/newsletter-bar' ); ?>

</main>

<?php
get_footer();
