<?php
/**
 * Lightweight AJAX endpoints backing the custom mini-cart drawer
 * (assets/js/mini-cart.js). Reads/writes the real WooCommerce cart —
 * no separate cart state is kept.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tk_cart_payload() {
	$items = [];
	foreach ( WC()->cart->get_cart() as $key => $item ) {
		/** @var WC_Product $product */
		$product = $item['data'];
		$items[] = [
			'key'   => $key,
			'id'    => $item['product_id'],
			'name'  => $product->get_name(),
			'price' => (float) $product->get_price(),
			'qty'   => $item['quantity'],
			'image' => wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' ) ?: '',
		];
	}

	return [
		'items'           => $items,
		'count'           => WC()->cart->get_cart_contents_count(),
		'total'           => WC()->cart->get_cart_contents_total(),
		'formatted_total' => wp_strip_all_tags( wc_price( WC()->cart->get_cart_contents_total() + WC()->cart->get_cart_contents_tax() ) ),
	];
}

function tk_ajax_get_cart() {
	check_ajax_referer( 'tk_cart_nonce', 'nonce' );
	wp_send_json_success( tk_cart_payload() );
}
add_action( 'wp_ajax_tk_get_cart', 'tk_ajax_get_cart' );
add_action( 'wp_ajax_nopriv_tk_get_cart', 'tk_ajax_get_cart' );

function tk_ajax_update_qty() {
	check_ajax_referer( 'tk_cart_nonce', 'nonce' );
	$key = isset( $_POST['key'] ) ? sanitize_text_field( wp_unslash( $_POST['key'] ) ) : '';
	$qty = isset( $_POST['qty'] ) ? max( 0, (int) $_POST['qty'] ) : 0;

	if ( $key ) {
		WC()->cart->set_quantity( $key, $qty, true );
	}

	wp_send_json_success( tk_cart_payload() );
}
add_action( 'wp_ajax_tk_update_qty', 'tk_ajax_update_qty' );
add_action( 'wp_ajax_nopriv_tk_update_qty', 'tk_ajax_update_qty' );

function tk_ajax_remove_item() {
	check_ajax_referer( 'tk_cart_nonce', 'nonce' );
	$key = isset( $_POST['key'] ) ? sanitize_text_field( wp_unslash( $_POST['key'] ) ) : '';

	if ( $key ) {
		WC()->cart->remove_cart_item( $key );
	}

	wp_send_json_success( tk_cart_payload() );
}
add_action( 'wp_ajax_tk_remove_item', 'tk_ajax_remove_item' );
add_action( 'wp_ajax_nopriv_tk_remove_item', 'tk_ajax_remove_item' );
