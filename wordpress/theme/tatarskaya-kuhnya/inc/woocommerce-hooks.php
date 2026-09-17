<?php
/**
 * WooCommerce integration: header cart-count fragment, a single unified
 * delivery/billing address (no separate "shipping address" concept), that
 * address hidden entirely for self-pickup orders, and a minimal
 * orders-only "Личный кабинет".
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WooCommerce Admin's onboarding wizard (and its "Launch Your Store" task)
 * silently resets store settings — currency, decimal formatting, and the
 * "coming soon" flag — back to onboarding defaults the first time an admin
 * opens wp-admin and its JS runs "skip guided setup". Since this store's
 * settings are already fully configured on purpose, disable those admin
 * features outright so nothing re-runs and clobbers them later.
 */
add_filter( 'woocommerce_admin_features', function ( $features ) {
	return array_values( array_diff( $features, [ 'onboarding', 'launch-your-store' ] ) );
} );

// Show "р." (matching the original static design) instead of the default ₽ symbol.
add_filter( 'woocommerce_currency_symbol', function ( $symbol, $currency ) {
	if ( 'RUB' === $currency ) {
		return 'р.';
	}
	return $symbol;
}, 10, 2 );

add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	ob_start();
	?>
	<span class="cart-btn__count" id="cartCount" <?php echo $count ? '' : 'hidden'; ?>><?php echo esc_html( $count ); ?></span>
	<?php
	$fragments['#cartCount'] = trim( ob_get_clean() );
	return $fragments;
} );

/**
 * There's no separate "shipping address" concept on this site at all — one
 * address (the billing one, see below) covers both invoicing and delivery.
 * Always reporting "no shipping address needed" removes WooCommerce's own
 * "Ship to a different address?" checkbox and shipping address fields,
 * which would otherwise reintroduce the two-address split we're removing.
 */
add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false' );

/**
 * With "ship to a different address" left unchecked (the common case), the
 * billing address doubles as the delivery address — so it's the *billing*
 * address field, not a separate shipping one, that needs to become optional
 * for self-pickup orders. Checked again server-side at submit time via the
 * session's chosen_shipping_methods, so this can't be bypassed by skipping
 * the client-side toggle.
 */
add_filter( 'woocommerce_billing_fields', function ( $fields ) {
	if ( isset( $fields['billing_address_1'] ) ) {
		$fields['billing_address_1']['label']       = 'Адрес доставки';
		$fields['billing_address_1']['placeholder'] = 'Улица, дом, квартира';
	}

	if ( ! WC()->session ) {
		return $fields;
	}
	$chosen = WC()->session->get( 'chosen_shipping_methods' );
	if ( empty( $chosen ) || strpos( $chosen[0], 'local_pickup' ) === false ) {
		return $fields;
	}
	if ( isset( $fields['billing_address_1'] ) ) {
		$fields['billing_address_1']['required'] = false;
	}
	return $fields;
} );

/**
 * This is a food-delivery checkout, not a general store that invoices a
 * separate billing party — one address (used both as the customer's contact
 * address and, per the filter above, the delivery address) is enough. Drop
 * the extra fields WooCommerce ships with by default; country is kept but
 * hidden since the whole store only serves one country (needed internally
 * for the shipping zone / tax lookups to still resolve).
 */
// The section is really just "contact + delivery info" now, not billing/invoicing — rename its heading.
add_filter( 'gettext', function ( $translated, $text, $domain ) {
	if ( 'woocommerce' === $domain && 'Billing details' === $text ) {
		return 'Данные для доставки';
	}
	return $translated;
}, 10, 3 );

add_filter( 'woocommerce_checkout_fields', function ( $fields ) {
	foreach ( [ 'billing_last_name', 'billing_company', 'billing_address_2', 'billing_city', 'billing_state', 'billing_postcode', 'billing_country' ] as $key ) {
		unset( $fields['billing'][ $key ] );
	}
	unset( $fields['shipping'] );
	if ( isset( $fields['billing']['billing_first_name'] ) ) {
		$fields['billing']['billing_first_name']['label'] = 'Имя';
	}
	if ( isset( $fields['billing']['billing_phone'] ) ) {
		$fields['billing']['billing_phone']['required'] = true;
	}
	return $fields;
} );

/**
 * "Личный кабинет" is intentionally minimal — just past orders, not the
 * full WooCommerce account area (no dashboard/downloads/addresses/account
 * details tabs, and no separate account editing since there's nothing left
 * to edit there once billing is reduced to one address collected at
 * checkout).
 */
add_filter( 'woocommerce_account_menu_items', function ( $items ) {
	return array_intersect_key( $items, array_flip( [ 'orders', 'customer-logout' ] ) );
} );

add_action( 'template_redirect', function () {
	if ( is_account_page() && is_user_logged_in() && ! is_wc_endpoint_url() ) {
		wp_safe_redirect( wc_get_account_endpoint_url( 'orders' ) );
		exit;
	}
} );
