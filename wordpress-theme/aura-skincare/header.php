<?php
/**
 * The header template for Aura Skincare Theme
 *
 * @package Aura_Skincare
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to content', 'aura-skincare' ); ?></a>

<header id="masthead" class="site-header" role="banner">
	<?php get_template_part( 'template-parts/header/announcement-bar' ); ?>
	<?php get_template_part( 'template-parts/header/site-nav' ); ?>
</header>
