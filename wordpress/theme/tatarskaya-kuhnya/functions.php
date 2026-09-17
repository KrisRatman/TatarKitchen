<?php
/**
 * Tatarskaya Kuhnya theme functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	register_nav_menus( [ 'primary' => 'Главное меню' ] );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'tk-style', get_stylesheet_uri(), [], '1.0.0' );

	wp_enqueue_script( 'tk-ui', get_template_directory_uri() . '/assets/js/script.js', [], '1.0.0', true );

	wp_enqueue_script(
		'tk-mini-cart',
		get_template_directory_uri() . '/assets/js/mini-cart.js',
		[ 'jquery' ],
		'1.0.0',
		true
	);
	wp_localize_script( 'tk-mini-cart', 'tkCart', [
		'ajax_url'     => admin_url( 'admin-ajax.php' ),
		'nonce'        => wp_create_nonce( 'tk_cart_nonce' ),
		'checkout_url' => wc_get_checkout_url(),
	] );

	wp_enqueue_script(
		'tk-orders-widget',
		get_template_directory_uri() . '/assets/js/orders-widget.js',
		[ 'jquery' ],
		'1.0.0',
		true
	);

	if ( function_exists( 'is_checkout' ) && is_checkout() ) {
		wp_enqueue_script(
			'tk-checkout-shipping',
			get_template_directory_uri() . '/assets/js/checkout-shipping-toggle.js',
			[ 'jquery', 'wc-checkout' ],
			'1.0.0',
			true
		);
	}
} );

require get_template_directory() . '/inc/woocommerce-hooks.php';
require get_template_directory() . '/inc/mini-cart-ajax.php';
require get_template_directory() . '/inc/orders-widget-ajax.php';
