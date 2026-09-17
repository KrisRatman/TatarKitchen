<?php
/**
 * Front page: hero + product catalog (pulled live from WooCommerce
 * products in the vypechka/goryachee categories) + promo slider + footer.
 */

get_header();

/**
 * Renders one product category as the existing `.cards-grid` markup,
 * with a real WooCommerce AJAX add-to-cart button.
 */
function tk_render_product_grid( $category_slug ) {
	$products = wc_get_products( [
		'category' => [ $category_slug ],
		'limit'    => -1,
		'status'   => 'publish',
		'orderby'  => 'menu_order',
		'order'    => 'ASC',
	] );

	foreach ( $products as $product ) {
		$regular = $product->get_regular_price();
		$current = $product->get_price();
		?>
		<article class="card">
			<div class="card__image">
				<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
					<?php echo $product->get_image( 'medium' ); ?>
				</a>
			</div>
			<h3 class="card__title"><?php echo esc_html( $product->get_name() ); ?></h3>
			<p class="card__desc"><?php echo esc_html( wp_strip_all_tags( $product->get_short_description() ) ); ?></p>
			<div class="card__price">
				<span class="price"><?php echo wp_strip_all_tags( wc_price( $current ) ); ?></span>
				<?php if ( $regular && $regular != $current ) : ?>
					<span class="price price--old"><?php echo wp_strip_all_tags( wc_price( $regular ) ); ?></span>
				<?php endif; ?>
			</div>
			<?php
			echo apply_filters(
				'woocommerce_loop_add_to_cart_link',
				sprintf(
					'<a href="%s" data-quantity="1" class="btn ajax_add_to_cart add_to_cart_button" data-product_id="%d" data-product_sku="%s" aria-label="%s" rel="nofollow">%s</a>',
					esc_url( $product->add_to_cart_url() ),
					esc_attr( $product->get_id() ),
					esc_attr( $product->get_sku() ),
					esc_attr( $product->get_name() ),
					esc_html__( 'Заказать', 'tatarskaya-kuhnya' )
				),
				$product,
				[]
			);
			?>
		</article>
		<?php
	}
}
?>

<section class="hero" id="hero">
  <div class="hero__bg">
    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/hero-bg-crop.png' ); ?>" alt="Татарская выпечка на столе">
  </div>
  <div class="hero__content">
    <h1>Доставка Татарской кухни</h1>
    <p>Вкуснейшие беляши и чак чак с доставкой по Москве<br>в течение 60 минут!</p>
  </div>
  <a href="#pastry" class="hero__scroll" aria-label="Пролистать вниз">
    <svg viewBox="0 0 24 24"><path d="M6 9l6 6 6-6" stroke="#fff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
  </a>
</section>

<section class="section section--gray" id="pastry">
  <div class="container">
    <h2 class="section__title">Выпечка</h2>
    <p class="section__subtitle">Только свежие продукты и оригинальные рецепты от лучших поваров</p>
    <div class="cards-grid">
      <?php tk_render_product_grid( 'vypechka' ); ?>
    </div>
  </div>
</section>

<section class="section" id="hot">
  <div class="container">
    <h2 class="section__title">Горячее</h2>
    <p class="section__subtitle">У нас уникальные рецепты горячих татарских блюд, приготовленных с любовью. Попробуйте и окунитесь в мир вкусов.</p>
    <div class="cards-grid cards-grid--single">
      <?php tk_render_product_grid( 'goryachee' ); ?>
    </div>
  </div>
</section>

<section class="section section--gray" id="promo">
  <div class="container">
    <h2 class="section__title">Акции</h2>
    <p class="section__subtitle">Постоянные и сезонные акции со скидками от 7 до 50 %.<br>Следите за обновлениями!</p>

    <div class="slider" id="slider">
      <button class="slider__arrow slider__arrow--prev" id="sliderPrev" aria-label="Предыдущий слайд">
        <svg viewBox="0 0 24 24"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>

      <div class="slider__viewport">
        <div class="slider__track" id="sliderTrack">
          <div class="slide">
            <div class="slide__image"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/promo/promo-1-photo.png' ); ?>" alt="Скидка 10% при заказе от 2000 рублей"></div>
            <div class="slide__text">
              <h3>Скидка 10 % при заказе от 2000 рублей!</h3>
              <p>Скидка распространяется на все меню и действует с 9.00 до 20.00 каждый день.</p>
            </div>
          </div>
          <div class="slide">
            <div class="slide__image"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/promo/promo-2-photo.png' ); ?>" alt="Кыстыбый в подарок при заказе от 3-х блюд"></div>
            <div class="slide__text">
              <h3>Кыстыбый в качестве подарка при заказе от 3-х блюд</h3>
              <p>Заказывайте любые кушанья из нашего меню и получите подарок в виде аппетитного кыстыбый</p>
            </div>
          </div>
        </div>
      </div>

      <button class="slider__arrow slider__arrow--next" id="sliderNext" aria-label="Следующий слайд">
        <svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
    </div>

    <div class="slider__dots" id="sliderDots">
      <button class="dot is-active" data-index="0" aria-label="Слайд 1"></button>
      <button class="dot" data-index="1" aria-label="Слайд 2"></button>
    </div>
  </div>
</section>

<?php get_footer(); ?>
