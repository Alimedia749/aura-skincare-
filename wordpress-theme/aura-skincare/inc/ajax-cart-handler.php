<?php
/**
 * Asynchronous AJAX Cart Handler & Nonce Validation
 *
 * @package Aura_Skincare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle AJAX Add to Cart
 */
function aura_ajax_add_to_cart() {
	check_ajax_referer( 'aura_cart_nonce', 'security' );

	$product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
	$quantity   = isset( $_POST['quantity'] ) ? max( 1, absint( $_POST['quantity'] ) ) : 1;
	$variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;

	if ( ! $product_id ) {
		wp_send_json_error( array( 'message' => esc_html__( 'Invalid product identifier.', 'aura-skincare' ) ) );
	}

	// If WooCommerce is active
	if ( function_exists( 'WC' ) && WC()->cart ) {
		$cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id );

		if ( $cart_item_key ) {
			aura_send_cart_response( true, esc_html__( 'Added to your ritual bag.', 'aura-skincare' ) );
		} else {
			wp_send_json_error( array( 'message' => esc_html__( 'Could not add item to bag. Please try again.', 'aura-skincare' ) ) );
		}
	} else {
		// Mock response for preview / development mode
		$mock_data = aura_get_mock_cart_data( $product_id, $quantity );
		wp_send_json_success( $mock_data );
	}
}
add_action( 'wp_ajax_aura_add_to_cart', 'aura_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_aura_add_to_cart', 'aura_ajax_add_to_cart' );

/**
 * Handle AJAX Cart Item Quantity Update
 */
function aura_ajax_update_cart_item() {
	check_ajax_referer( 'aura_cart_nonce', 'security' );

	$cart_item_key = isset( $_POST['cart_key'] ) ? sanitize_text_field( wp_unslash( $_POST['cart_key'] ) ) : '';
	$quantity      = isset( $_POST['quantity'] ) ? intval( $_POST['quantity'] ) : 1;

	if ( empty( $cart_item_key ) ) {
		wp_send_json_error( array( 'message' => esc_html__( 'Missing cart key.', 'aura-skincare' ) ) );
	}

	if ( function_exists( 'WC' ) && WC()->cart ) {
		if ( $quantity <= 0 ) {
			WC()->cart->remove_cart_item( $cart_item_key );
		} else {
			WC()->cart->set_quantity( $cart_item_key, $quantity, true );
		}

		aura_send_cart_response( true, esc_html__( 'Bag updated.', 'aura-skincare' ) );
	} else {
		// Mock update
		wp_send_json_success( array(
			'success' => true,
			'message' => esc_html__( 'Quantity updated (preview mode).', 'aura-skincare' ),
		) );
	}
}
add_action( 'wp_ajax_aura_update_cart_item', 'aura_ajax_update_cart_item' );
add_action( 'wp_ajax_nopriv_aura_update_cart_item', 'aura_ajax_update_cart_item' );

/**
 * Handle AJAX Cart Item Removal
 */
function aura_ajax_remove_cart_item() {
	check_ajax_referer( 'aura_cart_nonce', 'security' );

	$cart_item_key = isset( $_POST['cart_key'] ) ? sanitize_text_field( wp_unslash( $_POST['cart_key'] ) ) : '';

	if ( empty( $cart_item_key ) ) {
		wp_send_json_error( array( 'message' => esc_html__( 'Missing item key.', 'aura-skincare' ) ) );
	}

	if ( function_exists( 'WC' ) && WC()->cart ) {
		WC()->cart->remove_cart_item( $cart_item_key );
		aura_send_cart_response( true, esc_html__( 'Item removed from your bag.', 'aura-skincare' ) );
	} else {
		wp_send_json_success( array(
			'success' => true,
			'message' => esc_html__( 'Item removed (preview mode).', 'aura-skincare' ),
		) );
	}
}
add_action( 'wp_ajax_aura_remove_cart_item', 'aura_ajax_remove_cart_item' );
add_action( 'wp_ajax_nopriv_aura_remove_cart_item', 'aura_ajax_remove_cart_item' );

/**
 * Helper to build and send JSON cart payload
 */
function aura_send_cart_response( $success = true, $message = '' ) {
	ob_start();
	if ( function_exists( 'woocommerce_mini_cart' ) ) {
		woocommerce_mini_cart();
	}
	$mini_cart_html = ob_get_clean();

	$cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	$subtotal   = WC()->cart ? WC()->cart->get_cart_subtotal() : '$0.00';
	$raw_subtotal = WC()->cart ? WC()->cart->get_subtotal() : 0;
	$shipping_status = aura_get_free_shipping_status( $raw_subtotal );

	wp_send_json_success( array(
		'success'         => $success,
		'message'         => $message,
		'cart_count'      => $cart_count,
		'subtotal'        => $subtotal,
		'raw_subtotal'    => $raw_subtotal,
		'shipping_status' => $shipping_status,
		'mini_cart_html'  => $mini_cart_html,
	) );
}

/**
 * Generates mock cart response for sandbox preview
 */
function aura_get_mock_cart_data( $product_id, $quantity ) {
	$products = aura_get_mock_products();
	$found = null;
	foreach ( $products as $p ) {
		if ( $p['id'] == $product_id ) {
			$found = $p;
			break;
		}
	}

	if ( ! $found ) {
		$found = $products[0];
	}

	$total = $found['price'] * $quantity;
	$shipping_status = aura_get_free_shipping_status( $total );

	return array(
		'success'         => true,
		'message'         => sprintf( esc_html__( 'Added %s to your bag.', 'aura-skincare' ), $found['title'] ),
		'cart_count'      => $quantity,
		'subtotal'        => '$' . number_format( $total, 2 ),
		'raw_subtotal'    => $total,
		'shipping_status' => $shipping_status,
		'item'            => $found,
	);
}
