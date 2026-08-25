<?php
/**
 * Theme Setup, Support Declarations, Menus and Sidebars
 *
 * @package Aura_Skincare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'aura_skincare_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function aura_skincare_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'aura-skincare', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 600, 750, true );
		add_image_size( 'aura-product-card', 540, 680, true );
		add_image_size( 'aura-hero-thumb', 900, 1100, true );
		add_image_size( 'aura-editorial-banner', 1200, 700, true );

		// Register Navigation Menus.
		register_nav_menus(
			array(
				'primary'            => esc_html__( 'Primary Navigation Menu', 'aura-skincare' ),
				'footer_shop'        => esc_html__( 'Footer: Shop Menu', 'aura-skincare' ),
				'footer_collections' => esc_html__( 'Footer: Collections Menu', 'aura-skincare' ),
				'footer_about'       => esc_html__( 'Footer: About Menu', 'aura-skincare' ),
				'footer_help'        => esc_html__( 'Footer: Help Menu', 'aura-skincare' ),
				'footer_legal'       => esc_html__( 'Footer: Legal Menu', 'aura-skincare' ),
			)
		);

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Custom logo support.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 80,
				'width'       => 260,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Selective refresh for widgets in Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// WooCommerce Support.
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
endif;
add_action( 'after_setup_theme', 'aura_skincare_setup' );

/**
 * Register Widget Areas / Sidebars.
 */
function aura_skincare_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Column 1 (Brand Info)', 'aura-skincare' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here to appear in footer column 1.', 'aura-skincare' ),
			'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title footer-col-title">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Column 2 (Shop)', 'aura-skincare' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets here to appear in footer column 2.', 'aura-skincare' ),
			'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title footer-col-title">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Column 3 (About)', 'aura-skincare' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add widgets here to appear in footer column 3.', 'aura-skincare' ),
			'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title footer-col-title">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Column 4 (Help / Concierge)', 'aura-skincare' ),
			'id'            => 'footer-4',
			'description'   => esc_html__( 'Add widgets here to appear in footer column 4.', 'aura-skincare' ),
			'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title footer-col-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'aura_skincare_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function aura_skincare_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'aura_skincare_content_width', 1280 );
}
add_action( 'after_setup_theme', 'aura_skincare_content_width', 0 );

/**
 * Ensure category navigation menu items have direct anchor links to dedicated sections.
 */
function aura_filter_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
	$title = trim( wp_strip_all_tags( $item->title ) );
	$title_lower = strtolower( html_entity_decode( $title ) );

	$category_map = array(
		'all categories'  => array( 'slug' => 'all',            'anchor' => 'cleansers-section' ),
		'cleansers'       => array( 'slug' => 'cleansers',      'anchor' => 'cleansers-section' ),
		'serums & oils'   => array( 'slug' => 'serums',         'anchor' => 'serums-section' ),
		'serums and oils' => array( 'slug' => 'serums',         'anchor' => 'serums-section' ),
		'serums'          => array( 'slug' => 'serums',         'anchor' => 'serums-section' ),
		'moisturizers'    => array( 'slug' => 'moisturizers',   'anchor' => 'moisturizers-section' ),
		'eye care'        => array( 'slug' => 'eye-care',       'anchor' => 'eyecare-section' ),
		'toners & mists'  => array( 'slug' => 'toners-mists',   'anchor' => 'toners-section' ),
		'toners and mists'=> array( 'slug' => 'toners-mists',   'anchor' => 'toners-section' ),
		'toners'          => array( 'slug' => 'toners-mists',   'anchor' => 'toners-section' ),
		'sun protection'  => array( 'slug' => 'sun-protection', 'anchor' => 'sunprotection-section' ),
		'botanical oils'  => array( 'slug' => 'botanical-oils', 'anchor' => 'botanicaloils-section' ),
	);

	if ( isset( $category_map[ $title_lower ] ) ) {
		$info = $category_map[ $title_lower ];
		$atts['data-nav-category']  = $info['slug'];
		$atts['data-category-name'] = $title;
		$atts['data-target-anchor'] = $info['anchor'];
		$atts['href']               = home_url( '/#' . $info['anchor'] );
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'aura_filter_nav_menu_link_attributes', 10, 4 );
