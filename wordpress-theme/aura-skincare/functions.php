<?php
/**
 * Aura Skincare Theme Functions and Definitions
 *
 * @package Aura_Skincare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AURA_VERSION', '1.1.3' );
define( 'AURA_THEME_DIR', get_template_directory() );
define( 'AURA_THEME_URI', get_template_directory_uri() );

/**
 * Require modular include files
 */
require_once AURA_THEME_DIR . '/inc/setup.php';
require_once AURA_THEME_DIR . '/inc/template-tags.php';
require_once AURA_THEME_DIR . '/inc/customizer.php';
require_once AURA_THEME_DIR . '/inc/ajax-cart-handler.php';

/**
 * Enqueue scripts and styles.
 */
function aura_skincare_scripts() {
	// Google Fonts: Cormorant Garamond (Editorial Serif) + Plus Jakarta Sans (Clean Modern Sans)
	wp_enqueue_style(
		'aura-google-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap',
		array(),
		null
	);

	// Core Design System & Tokens
	wp_enqueue_style(
		'aura-core-styles',
		AURA_THEME_URI . '/assets/css/core.css',
		array(),
		AURA_VERSION
	);

	// Hero Banner & Category Pills Styles
	wp_enqueue_style(
		'aura-hero-banner',
		AURA_THEME_URI . '/assets/css/hero-banner.css',
		array( 'aura-core-styles' ),
		AURA_VERSION
	);

	// Product Grid & Cards Styles
	wp_enqueue_style(
		'aura-product-grid',
		AURA_THEME_URI . '/assets/css/product-grid.css',
		array( 'aura-core-styles' ),
		AURA_VERSION
	);

	// Slide-out Offcanvas Cart Drawer Styles
	wp_enqueue_style(
		'aura-cart-drawer',
		AURA_THEME_URI . '/assets/css/cart-drawer.css',
		array( 'aura-core-styles' ),
		AURA_VERSION
	);

	// Product Detail Page Styles
	wp_enqueue_style(
		'aura-product-detail',
		AURA_THEME_URI . '/assets/css/product-detail.css',
		array( 'aura-core-styles' ),
		AURA_VERSION
	);

	// Checkout Page Styles
	wp_enqueue_style(
		'aura-checkout',
		AURA_THEME_URI . '/assets/css/checkout.css',
		array( 'aura-core-styles' ),
		AURA_VERSION
	);

	// Dedicated Shop Catalog Styles
	wp_enqueue_style(
		'aura-shop',
		AURA_THEME_URI . '/assets/css/shop.css',
		array( 'aura-core-styles' ),
		AURA_VERSION
	);

	// Dedicated About Us / Story Styles
	wp_enqueue_style(
		'aura-about',
		AURA_THEME_URI . '/assets/css/about.css',
		array( 'aura-core-styles' ),
		AURA_VERSION
	);

	// Main Theme Stylesheet
	wp_enqueue_style(
		'aura-main-style',
		get_stylesheet_uri(),
		array( 'aura-core-styles' ),
		AURA_VERSION
	);

	// GSAP Animation Engine
	wp_enqueue_script(
		'aura-gsap',
		AURA_THEME_URI . '/assets/js/gsap.min.js',
		array(),
		'3.12.5',
		true
	);

	// Main UI Controller (Sticky Header, Blur, Carousel, Ticker)
	wp_enqueue_script(
		'aura-main-js',
		AURA_THEME_URI . '/assets/js/main.js',
		array( 'aura-gsap' ),
		AURA_VERSION,
		true
	);

	// AJAX Cart & Dynamic Drawer Handler
	wp_enqueue_script(
		'aura-ajax-cart',
		AURA_THEME_URI . '/assets/js/ajax-cart.js',
		array( 'jquery', 'aura-main-js' ),
		AURA_VERSION,
		true
	);

	// Localize Cart Parameters for Javascript
	$free_threshold = get_theme_mod( 'aura_free_shipping_threshold', 75 );
	$cart_count     = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
	$subtotal       = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_subtotal() : '$0.00';
	$raw_subtotal   = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_subtotal() : 0;

	wp_localize_script(
		'aura-ajax-cart',
		'auraCartParams',
		array(
			'ajaxUrl'               => admin_url( 'admin-ajax.php' ),
			'nonce'                 => wp_create_nonce( 'aura_cart_nonce' ),
			'wc_ajax_url'           => class_exists( 'WC_AJAX' ) ? WC_AJAX::get_endpoint( '%%endpoint%%' ) : '',
			'cartUrl'               => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#',
			'checkoutUrl'           => function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : '#',
			'freeShippingThreshold' => floatval( $free_threshold ),
			'currencySymbol'        => function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '$',
			'cartCount'             => intval( $cart_count ),
			'subtotal'              => $subtotal,
			'rawSubtotal'           => floatval( $raw_subtotal ),
			'strings'               => array(
				'added'             => esc_html__( 'Added to Bag', 'aura-skincare' ),
				'adding'            => esc_html__( 'Adding...', 'aura-skincare' ),
				'error'             => esc_html__( 'Could not update bag', 'aura-skincare' ),
				'freeShippingGoal'  => esc_html__( 'Free shipping unlocked!', 'aura-skincare' ),
				'freeShippingAway'  => esc_html__( 'away from free express shipping', 'aura-skincare' ),
			),
		)
	);

	// Pass general site settings to main.js
	wp_localize_script(
		'aura-main-js',
		'auraSiteData',
		array(
			'siteUrl'   => home_url( '/' ),
			'themeUri'  => AURA_THEME_URI,
			'isHome'    => is_front_page(),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'aura_skincare_scripts' );

/**
 * Update WooCommerce Cart Fragment via AJAX
 */
function aura_cart_count_fragments( $fragments ) {
	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	$fragments['span.aura-cart-count-badge'] = '<span class="aura-cart-count-badge' . ( $count > 0 ? ' has-items' : '' ) . '">' . esc_html( $count ) . '</span>';
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'aura_cart_count_fragments' );

/**
 * Add dropdown chevron icon to menu items with children
 */
function aura_add_dropdown_icon_to_menu_items( $title, $item, $args, $depth ) {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location && in_array( 'menu-item-has-children', (array) $item->classes, true ) ) {
		$title .= ' <svg class="dropdown-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="12" height="12"><polyline points="6 9 12 15 18 9"></polyline></svg>';
	}
	return $title;
}
add_filter( 'nav_menu_item_title', 'aura_add_dropdown_icon_to_menu_items', 10, 4 );

/**
 * Route custom templates for Shop and About Us
 */
function aura_custom_page_templates( $template ) {
	$page_id = get_queried_object_id();
	$req_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';

	if ( 14 === $page_id || is_page( 'shop' ) || ( function_exists( 'is_shop' ) && is_shop() ) || is_post_type_archive( 'product' ) || strpos( $req_uri, '/shop' ) !== false ) {
		$shop_file = get_template_directory() . '/page-templates/template-shop.php';
		if ( file_exists( $shop_file ) ) {
			return $shop_file;
		}
	}
	if ( 70 === $page_id || is_page( 'about-us' ) || is_page( 'about' ) || strpos( $req_uri, '/about-us' ) !== false || strpos( $req_uri, '/about' ) !== false ) {
		$about_file = get_template_directory() . '/page-templates/template-about.php';
		if ( file_exists( $about_file ) ) {
			return $about_file;
		}
	}
	return $template;
}
add_filter( 'template_include', 'aura_custom_page_templates', 9999 );

/**
 * Filter WooCommerce template loader for archive-product.php
 */
function aura_woocommerce_locate_template( $template, $template_name, $template_path ) {
	if ( 'archive-product.php' === $template_name ) {
		$custom = get_template_directory() . '/page-templates/template-shop.php';
		if ( file_exists( $custom ) ) {
			return $custom;
		}
	}
	return $template;
}
add_filter( 'woocommerce_locate_template', 'aura_woocommerce_locate_template', 999, 3 );

/**
 * Add custom body classes
 */
function aura_body_classes( $classes ) {
	$classes[] = 'aura-luxury-theme';
	if ( get_theme_mod( 'aura_show_announcement_bar', true ) ) {
		$classes[] = 'has-announcement-bar';
	}
	return $classes;
}
add_filter( 'body_class', 'aura_body_classes' );
