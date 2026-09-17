<?php
/**
 * Creates one shipping zone with two methods: Flat Rate ("Доставка")
 * and Local Pickup ("Самовывоз"). Safe to re-run — skips creation if
 * a zone with this name already exists, and re-applies titles either way.
 *
 * Note: shipping method instance settings must be written via
 * update_option($method->get_instance_option_key(), $instance_settings) —
 * WC_Settings_API::update_option() writes to the non-instance global key
 * and is the wrong call for per-zone method instances.
 */

$zone_name = 'Москва';
$zone_id   = null;

foreach ( WC_Shipping_Zones::get_zones() as $z ) {
	if ( $z['zone_name'] === $zone_name ) {
		$zone_id = $z['zone_id'];
		break;
	}
}

if ( $zone_id ) {
	$zone = new WC_Shipping_Zone( $zone_id );
	WP_CLI::log( "Zone '$zone_name' already exists (id $zone_id), reusing." );
} else {
	$zone = new WC_Shipping_Zone();
	$zone->set_zone_name( $zone_name );
	$zone->add_location( 'RU', 'country' );
	$zone_id = $zone->save();
}

$existing_methods = [];
foreach ( $zone->get_shipping_methods() as $m ) {
	$existing_methods[ $m->id ] = $m->instance_id;
}

$flat_instance_id   = $existing_methods['flat_rate'] ?? $zone->add_shipping_method( 'flat_rate' );
$pickup_instance_id = $existing_methods['local_pickup'] ?? $zone->add_shipping_method( 'local_pickup' );

function tk_set_instance_settings( $instance_id, array $overrides ) {
	$method = WC_Shipping_Zones::get_shipping_method( $instance_id );
	$method->init_instance_settings();
	$settings = array_merge( $method->instance_settings, $overrides );
	update_option( $method->get_instance_option_key(), $settings );
}

tk_set_instance_settings( $flat_instance_id, [ 'title' => 'Доставка', 'cost' => '0' ] );
tk_set_instance_settings( $pickup_instance_id, [ 'title' => 'Самовывоз' ] );

WP_CLI::success( "Zone '$zone_name' (id $zone_id) ready with Доставка (flat_rate #$flat_instance_id) + Самовывоз (local_pickup #$pickup_instance_id)." );
