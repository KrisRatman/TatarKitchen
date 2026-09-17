<?php
/**
 * Backs the header "orders" dropdown — a quick order id/status glance next
 * to the cart icon, in place of a full account dashboard.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tk_ajax_get_orders() {
	check_ajax_referer( 'tk_cart_nonce', 'nonce' );

	if ( ! is_user_logged_in() ) {
		wp_send_json_success( [ 'orders' => [] ] );
	}

	$orders = wc_get_orders( [
		'customer' => get_current_user_id(),
		'limit'    => 10,
		'orderby'  => 'date',
		'order'    => 'DESC',
	] );

	$data = array_map( function ( $order ) {
		return [
			'id'     => $order->get_order_number(),
			'date'   => wc_format_datetime( $order->get_date_created(), 'd.m.Y' ),
			'status' => wc_get_order_status_name( $order->get_status() ),
			'total'  => wp_strip_all_tags( wc_price( $order->get_total() ) ),
		];
	}, $orders );

	wp_send_json_success( [ 'orders' => $data ] );
}
add_action( 'wp_ajax_tk_get_orders', 'tk_ajax_get_orders' );
add_action( 'wp_ajax_nopriv_tk_get_orders', 'tk_ajax_get_orders' );
