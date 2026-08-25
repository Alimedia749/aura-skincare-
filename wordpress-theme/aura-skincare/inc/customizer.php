<?php
/**
 * Aura Skincare Theme Customizer Settings & Controls
 *
 * @package Aura_Skincare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers Theme Customizer options.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function aura_skincare_customize_register( $wp_customize ) {

	// ==========================================
	// Master Panel: Aura Skincare Options
	// ==========================================
	$wp_customize->add_panel(
		'aura_theme_panel',
		array(
			'title'       => esc_html__( '🌿 Aura Skincare Theme Settings', 'aura-skincare' ),
			'description' => esc_html__( 'Manage Announcement Bar, Hero Section, Banners, Press, Newsletter, and Footer.', 'aura-skincare' ),
			'priority'    => 20,
		)
	);

	// ──────────────────────────────────────────
	// 1. Section: Announcement Bar
	// ──────────────────────────────────────────
	$wp_customize->add_section(
		'aura_announcement_section',
		array(
			'title'    => esc_html__( '1. Announcement Bar & Ticker', 'aura-skincare' ),
			'panel'    => 'aura_theme_panel',
			'priority' => 10,
		)
	);

	$wp_customize->add_setting(
		'aura_show_announcement_bar',
		array(
			'default'           => true,
			'sanitize_callback' => 'aura_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'aura_show_announcement_bar',
		array(
			'label'    => esc_html__( 'Display Announcement Bar', 'aura-skincare' ),
			'section'  => 'aura_announcement_section',
			'type'     => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'aura_announcement_text_1',
		array(
			'default'           => '✦ COMPLIMENTARY EXPEDITED SHIPPING ON ALL ORDERS OVER $75 ✦',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aura_announcement_text_1',
		array(
			'label'    => esc_html__( 'Ticker Message 1', 'aura-skincare' ),
			'section'  => 'aura_announcement_section',
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		'aura_announcement_text_2',
		array(
			'default'           => 'RECEIVE A DELUXE 3-PIECE RITUAL SET WITH ANY ORDER OVER $120',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aura_announcement_text_2',
		array(
			'label'    => esc_html__( 'Ticker Message 2', 'aura-skincare' ),
			'section'  => 'aura_announcement_section',
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		'aura_free_shipping_threshold',
		array(
			'default'           => 75,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'aura_free_shipping_threshold',
		array(
			'label'       => esc_html__( 'Free Shipping Target Amount ($)', 'aura-skincare' ),
			'description' => esc_html__( 'Used dynamically in cart drawer shipping meter.', 'aura-skincare' ),
			'section'     => 'aura_announcement_section',
			'type'        => 'number',
		)
	);

	// ──────────────────────────────────────────
	// 2. Section: Hero Section
	// ──────────────────────────────────────────
	$wp_customize->add_section(
		'aura_hero_section',
		array(
			'title'    => esc_html__( '2. Hero Header & Top Banner', 'aura-skincare' ),
			'panel'    => 'aura_theme_panel',
			'priority' => 20,
		)
	);

	$wp_customize->add_setting(
		'aura_hero_badge_text',
		array(
			'default'           => 'Botanical Science Meets Clinical Purity',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aura_hero_badge_text',
		array(
			'label'    => esc_html__( 'Hero Badge Text', 'aura-skincare' ),
			'section'  => 'aura_hero_section',
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		'aura_hero_main_title',
		array(
			'default'           => 'Pure Ingredients. Visible Results.',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aura_hero_main_title',
		array(
			'label'    => esc_html__( 'Hero Main Headline', 'aura-skincare' ),
			'section'  => 'aura_hero_section',
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		'aura_hero_subtext',
		array(
			'default'           => 'Thoughtfully formulated skincare rituals that nourish, protect, and enhance your natural lit-from-within glow.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'aura_hero_subtext',
		array(
			'label'    => esc_html__( 'Hero Subtitle Description', 'aura-skincare' ),
			'section'  => 'aura_hero_section',
			'type'     => 'textarea',
		)
	);

	// ──────────────────────────────────────────
	// 3. Section: Bestsellers Section
	// ──────────────────────────────────────────
	$wp_customize->add_section(
		'aura_bestsellers_section',
		array(
			'title'    => esc_html__( '3. Bestsellers Showcase Grid', 'aura-skincare' ),
			'panel'    => 'aura_theme_panel',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'aura_bestsellers_eyebrow',
		array(
			'default'           => 'The Most Coveted Formulas',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aura_bestsellers_eyebrow',
		array(
			'label'    => esc_html__( 'Eyebrow Tag', 'aura-skincare' ),
			'section'  => 'aura_bestsellers_section',
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		'aura_bestsellers_title',
		array(
			'default'           => 'Sacred Botanical Bestsellers',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aura_bestsellers_title',
		array(
			'label'    => esc_html__( 'Section Title', 'aura-skincare' ),
			'section'  => 'aura_bestsellers_section',
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		'aura_bestsellers_desc',
		array(
			'default'           => 'Award-winning bio-compatible rituals formulated to nourish the skin barrier and reveal lit-from-within luminosity.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'aura_bestsellers_desc',
		array(
			'label'    => esc_html__( 'Section Subtitle', 'aura-skincare' ),
			'section'  => 'aura_bestsellers_section',
			'type'     => 'textarea',
		)
	);

	// ──────────────────────────────────────────
	// 4. Section: Dual Editorial Story Banners
	// ──────────────────────────────────────────
	$wp_customize->add_section(
		'aura_editorial_banners_section',
		array(
			'title'    => esc_html__( '4. Dual Editorial Story Banners', 'aura-skincare' ),
			'panel'    => 'aura_theme_panel',
			'priority' => 40,
		)
	);

	// Banner 1: The Ritual
	$wp_customize->add_setting(
		'aura_banner1_eyebrow',
		array(
			'default'           => 'The Sacred Ritual',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aura_banner1_eyebrow',
		array(
			'label'    => esc_html__( 'Banner 1 Eyebrow', 'aura-skincare' ),
			'section'  => 'aura_editorial_banners_section',
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		'aura_banner1_title',
		array(
			'default'           => 'Morning Dew & Evening Recovery',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aura_banner1_title',
		array(
			'label'    => esc_html__( 'Banner 1 Title', 'aura-skincare' ),
			'section'  => 'aura_editorial_banners_section',
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		'aura_banner1_desc',
		array(
			'default'           => 'Elevate your daily rhythm with bio-fermented botanical actives designed to sync with your skin\'s natural circadian cycle.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'aura_banner1_desc',
		array(
			'label'    => esc_html__( 'Banner 1 Description', 'aura-skincare' ),
			'section'  => 'aura_editorial_banners_section',
			'type'     => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'aura_banner1_btn_text',
		array(
			'default'           => 'Explore The Collection',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aura_banner1_btn_text',
		array(
			'label'    => esc_html__( 'Banner 1 Button Text', 'aura-skincare' ),
			'section'  => 'aura_editorial_banners_section',
			'type'     => 'text',
		)
	);

	// Banner 2: The Promise
	$wp_customize->add_setting(
		'aura_banner2_eyebrow',
		array(
			'default'           => 'Our Clean Standard',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aura_banner2_eyebrow',
		array(
			'label'    => esc_html__( 'Banner 2 Eyebrow', 'aura-skincare' ),
			'section'  => 'aura_editorial_banners_section',
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		'aura_banner2_title',
		array(
			'default'           => 'Zero Compromise on Purity',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aura_banner2_title',
		array(
			'label'    => esc_html__( 'Banner 2 Title', 'aura-skincare' ),
			'section'  => 'aura_editorial_banners_section',
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		'aura_banner2_desc',
		array(
			'default'           => 'Formulated without 2,700+ controversial ingredients. 100% vegan, cruelty-free, and bottled in sustainable infinity glass.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'aura_banner2_desc',
		array(
			'label'    => esc_html__( 'Banner 2 Description', 'aura-skincare' ),
			'section'  => 'aura_editorial_banners_section',
			'type'     => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'aura_banner2_btn_text',
		array(
			'default'           => 'Discover Our Promise',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aura_banner2_btn_text',
		array(
			'label'    => esc_html__( 'Banner 2 Button Text', 'aura-skincare' ),
			'section'  => 'aura_editorial_banners_section',
			'type'     => 'text',
		)
	);

	// ──────────────────────────────────────────
	// 5. Section: Society Newsletter & Discount
	// ──────────────────────────────────────────
	$wp_customize->add_section(
		'aura_newsletter_section',
		array(
			'title'    => esc_html__( '5. The Society Newsletter Strip', 'aura-skincare' ),
			'panel'    => 'aura_theme_panel',
			'priority' => 50,
		)
	);

	$wp_customize->add_setting(
		'aura_newsletter_title',
		array(
			'default'           => 'Join The Sacred Society',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aura_newsletter_title',
		array(
			'label'    => esc_html__( 'Newsletter Headline', 'aura-skincare' ),
			'section'  => 'aura_newsletter_section',
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		'aura_newsletter_subtitle',
		array(
			'default'           => 'Enjoy 15% off your initial ritual order, private seasonal drops, and skincare masterclasses.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'aura_newsletter_subtitle',
		array(
			'label'    => esc_html__( 'Newsletter Subtext', 'aura-skincare' ),
			'section'  => 'aura_newsletter_section',
			'type'     => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'aura_newsletter_discount',
		array(
			'default'           => '15% OFF',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aura_newsletter_discount',
		array(
			'label'    => esc_html__( 'Discount Callout Badge', 'aura-skincare' ),
			'section'  => 'aura_newsletter_section',
			'type'     => 'text',
		)
	);

	// ──────────────────────────────────────────
	// 6. Section: Footer & Brand Details
	// ──────────────────────────────────────────
	$wp_customize->add_section(
		'aura_footer_section',
		array(
			'title'    => esc_html__( '6. Footer & Brand Social Links', 'aura-skincare' ),
			'panel'    => 'aura_theme_panel',
			'priority' => 60,
		)
	);

	$wp_customize->add_setting(
		'aura_footer_brand_desc',
		array(
			'default'           => 'Elevated skincare made with clean ingredients and backed by science. Formulated in Switzerland & New York.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'aura_footer_brand_desc',
		array(
			'label'    => esc_html__( 'Footer Brand Description', 'aura-skincare' ),
			'section'  => 'aura_footer_section',
			'type'     => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'aura_social_instagram',
		array(
			'default'           => 'https://instagram.com',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'aura_social_instagram',
		array(
			'label'    => esc_html__( 'Instagram URL', 'aura-skincare' ),
			'section'  => 'aura_footer_section',
			'type'     => 'url',
		)
	);

	$wp_customize->add_setting(
		'aura_social_tiktok',
		array(
			'default'           => 'https://tiktok.com',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'aura_social_tiktok',
		array(
			'label'    => esc_html__( 'TikTok URL', 'aura-skincare' ),
			'section'  => 'aura_footer_section',
			'type'     => 'url',
		)
	);

	$wp_customize->add_setting(
		'aura_social_pinterest',
		array(
			'default'           => 'https://pinterest.com',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'aura_social_pinterest',
		array(
			'label'    => esc_html__( 'Pinterest URL', 'aura-skincare' ),
			'section'  => 'aura_footer_section',
			'type'     => 'url',
		)
	);

	$wp_customize->add_setting(
		'aura_concierge_phone',
		array(
			'default'           => '03283486855',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aura_concierge_phone',
		array(
			'label'    => esc_html__( 'Concierge Support Phone', 'aura-skincare' ),
			'section'  => 'aura_footer_section',
			'type'     => 'text',
		)
	);

	$wp_customize->add_setting(
		'aura_concierge_email',
		array(
			'default'           => 'inteligentboy021@gmail.com',
			'sanitize_callback' => 'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'aura_concierge_email',
		array(
			'label'    => esc_html__( 'Concierge Support Email', 'aura-skincare' ),
			'section'  => 'aura_footer_section',
			'type'     => 'email',
		)
	);

	$wp_customize->add_setting(
		'aura_footer_copyright',
		array(
			'default'           => 'AURA Skincare. All rights reserved.',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aura_footer_copyright',
		array(
			'label'    => esc_html__( 'Footer Copyright Notice', 'aura-skincare' ),
			'section'  => 'aura_footer_section',
			'type'     => 'text',
		)
	);
}
add_action( 'customize_register', 'aura_skincare_customize_register' );

/**
 * Checkbox sanitization helper.
 *
 * @param bool $checked Input state.
 * @return bool
 */
function aura_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === (bool) $checked ) ? true : false );
}
