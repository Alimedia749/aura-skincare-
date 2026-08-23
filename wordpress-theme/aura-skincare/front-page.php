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

	<!-- 2. Category Section 1: Cleansers -->
	<?php aura_render_category_showcase_section( "CLEANSERS YOU'LL LOVE", array( 'cleansers' ), 'cleansers-showcase', '#ffffff' ); ?>

	<!-- 3. Category Section 2: Serums & Oils -->
	<?php aura_render_category_showcase_section( "SERUMS & OILS YOU'LL LOVE", array( 'serums', 'botanical-oils' ), 'serums-showcase', '#FAF7F2' ); ?>

	<!-- 4. Category Section 3: Moisturizers -->
	<?php aura_render_category_showcase_section( "MOISTURIZERS YOU'LL LOVE", array( 'moisturizers' ), 'moisturizers-showcase', '#ffffff' ); ?>

	<!-- 5. Category Section 4: Eye Care & Toners -->
	<?php aura_render_category_showcase_section( "EYE CARE & TONERS YOU'LL LOVE", array( 'eye-care', 'toners-mists', 'sun-protection' ), 'eyecare-showcase', '#FAF7F2' ); ?>

	<!-- 6. Category Section 5: Ritual Sets & Kits -->
	<?php aura_render_category_showcase_section( "RITUAL SETS & KITS YOU'LL LOVE", array( 'sets-kits' ), 'sets-showcase', '#ffffff' ); ?>

	<!-- 6. The Ritual & Clean Promise Story Banners -->
	<?php get_template_part( 'template-parts/sections/editorial-banners' ); ?>

	<!-- 5. Editorial Press & Recognition Strip -->
	<?php get_template_part( 'template-parts/sections/press-strip' ); ?>

	<!-- 6. Society VIP Newsletter Section -->
	<?php get_template_part( 'template-parts/sections/newsletter-bar' ); ?>

</main>

<?php
get_footer();
