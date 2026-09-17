<?php
/**
 * Imports the 9 Tatar Kitchen products with categories, prices (regular +
 * sale price = the old/current price pair from the static site) and images.
 * Idempotent: matched by SKU, so re-running updates instead of duplicating.
 *
 * Usage: php wp-cli.phar eval-file scripts/import-products.php -- <path-to-food-images-dir>
 * (falls back to TK_IMAGES_DIR constant or the path below if no arg given)
 */

if ( isset( $args[0] ) ) {
	$images_dir = rtrim( $args[0], '/\\' );
} elseif ( is_dir( __DIR__ . '/../assets/food' ) ) {
	// Handoff package layout: scripts/import-products.php + assets/food/*.png next to it.
	$images_dir = __DIR__ . '/../assets/food';
} else {
	// Local dev fallback: the static site's own image folder.
	$images_dir = 'C:\\Users\\glago\\OneDrive\\Рабочий стол\\Musor\\Worked worker\\2nd work\\Site\\assets\\img\\food';
}

$categories = [
	'vypechka'  => 'Выпечка',
	'goryachee' => 'Горячее',
];

foreach ( $categories as $slug => $label ) {
	if ( ! term_exists( $slug, 'product_cat' ) ) {
		wp_insert_term( $label, 'product_cat', [ 'slug' => $slug ] );
	}
}

$products = [
	[ 'id' => 'belyash', 'name' => 'Беляш', 'price' => 90, 'old' => 120, 'cat' => 'vypechka',
		'desc' => 'Мука, мясо, лук, соль, перец, масло, дрожжи, вода' ],
	[ 'id' => 'echpochmak', 'name' => 'Эчпочмак', 'price' => 80, 'old' => 160, 'cat' => 'vypechka',
		'desc' => 'Мука, масло, кефир, яйцо, сода, соль; начинка: говядина, картофель, лук, соль, перец' ],
	[ 'id' => 'baursak', 'name' => 'Баурсак', 'price' => 150, 'old' => 200, 'cat' => 'vypechka',
		'desc' => 'Мука, молоко, яйца, масло, дрожжи, соль' ],
	[ 'id' => 'gubadiya', 'name' => 'Губадия', 'price' => 120, 'old' => 200, 'cat' => 'vypechka',
		'desc' => 'Пшено, яйца, масло, творог, рис, мясо, лук, изюм, курага, мед' ],
	[ 'id' => 'chakchak', 'name' => 'Чак Чак', 'price' => 70, 'old' => 120, 'cat' => 'vypechka',
		'desc' => 'Пшеничная мука, яйца, мед, сахар, масло, ваниль, соль' ],
	[ 'id' => 'kort', 'name' => 'Корт', 'price' => 150, 'old' => 200, 'cat' => 'vypechka',
		'desc' => 'Сливки, мед, ваниль, ягоды, миндаль' ],
	[ 'id' => 'azu', 'name' => 'Азу', 'price' => 150, 'old' => 200, 'cat' => 'goryachee',
		'desc' => 'Свинина, Огурцы, Картофель, Соль' ],
	[ 'id' => 'tokmach', 'name' => 'Токмач', 'price' => 150, 'old' => 200, 'cat' => 'goryachee',
		'desc' => 'Говядина, мука, яйца, вода, лук, морковь, масло' ],
	[ 'id' => 'beshbarmak', 'name' => 'Бешбармак', 'price' => 180, 'old' => 300, 'cat' => 'goryachee',
		'desc' => 'Говядина, домашняя лапша, лук, морковь, перец, соль, зелень' ],
];

require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$created = 0;
$updated = 0;

foreach ( $products as $p ) {
	$existing_id = wc_get_product_id_by_sku( $p['id'] );
	$product     = $existing_id ? new WC_Product_Simple( $existing_id ) : new WC_Product_Simple();

	$product->set_sku( $p['id'] );
	$product->set_name( $p['name'] );
	$product->set_short_description( $p['desc'] );
	$product->set_description( $p['desc'] );
	$product->set_regular_price( (string) $p['old'] );
	$product->set_sale_price( (string) $p['price'] );
	$product->set_status( 'publish' );
	$product->set_catalog_visibility( 'visible' );
	$product->set_manage_stock( false );
	$product->set_stock_status( 'instock' );

	$cat_term = get_term_by( 'slug', $p['cat'], 'product_cat' );
	if ( $cat_term ) {
		$product->set_category_ids( [ $cat_term->term_id ] );
	}

	if ( ! $product->get_image_id() ) {
		$img_path = $images_dir . DIRECTORY_SEPARATOR . $p['id'] . '.png';
		if ( file_exists( $img_path ) ) {
			$upload = wp_upload_bits( $p['id'] . '.png', null, file_get_contents( $img_path ) );
			if ( empty( $upload['error'] ) ) {
				$attach_id = wp_insert_attachment( [
					'post_mime_type' => 'image/png',
					'post_title'     => $p['name'],
					'post_status'    => 'inherit',
				], $upload['file'] );
				wp_update_attachment_metadata( $attach_id, wp_generate_attachment_metadata( $attach_id, $upload['file'] ) );
				$product->set_image_id( $attach_id );
			}
		} else {
			WP_CLI::warning( "Image not found for {$p['id']}: $img_path" );
		}
	}

	$product->save();
	$existing_id ? $updated++ : $created++;
}

WP_CLI::success( "Products import done: $created created, $updated updated." );
