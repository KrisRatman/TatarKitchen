<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header">
  <div class="container header__inner">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
      <span class="logo__badge">
        <svg viewBox="0 0 60 60" class="logo__icon" aria-hidden="true">
          <path d="M30 8c-5 6-9 10-9 16a9 9 0 0 0 18 0c0-6-4-10-9-16Z" fill="#fff"/>
          <path d="M14 34c4-3 8-4 16-4s12 1 16 4c-2 8-9 14-16 14s-14-6-16-14Z" fill="#fff"/>
        </svg>
      </span>
      <span class="logo__text">
        <span class="logo__title"><?php bloginfo( 'name' ); ?></span>
        <span class="logo__subtitle">домашние рецепты</span>
      </span>
    </a>

    <?php
    wp_nav_menu( [
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'nav',
        'fallback_cb'    => function () {
            echo '<nav class="nav">
                <a href="' . esc_url( home_url( '/#pastry' ) ) . '">Выпечка</a>
                <a href="' . esc_url( home_url( '/#hot' ) ) . '">Горячее</a>
                <a href="' . esc_url( home_url( '/#promo' ) ) . '">Акции</a>
                <a href="' . esc_url( home_url( '/#contacts' ) ) . '">Контакты</a>
            </nav>';
        },
    ] );
    ?>

    <div class="header__contacts">
      <div class="header__phone">
        <a href="tel:+79999909900">+7(999)-990-99-00</a>
        <span class="header__address">Биляшевский 1к</span>
      </div>
      <div class="social">
        <a href="#" aria-label="ВКонтакте" class="social__link">
          <svg viewBox="0 0 24 24"><path d="M13.16 17.2c-4.86 0-7.85-3.33-7.97-8.87h2.5c.09 4.03 1.85 5.74 3.24 6.09V8.33h2.36v3.5c1.37-.15 2.81-1.74 3.3-3.5h2.36c-.37 2.16-1.95 3.75-3.06 4.4 1.11.53 2.9 1.92 3.58 4.47h-2.6c-.53-1.68-1.8-2.98-3.58-3.16v3.16h-.13Z"/></svg>
        </a>
        <a href="#" aria-label="Telegram" class="social__link">
          <svg viewBox="0 0 24 24"><path d="M21.05 4.2 2.87 11.3c-1.24.5-1.24 1.2-.23 1.5l4.66 1.46 1.8 5.56c.22.6.4.85.83.85.4 0 .58-.19.8-.4l1.94-1.9 4.03 2.98c.74.42 1.28.2 1.47-.68l2.66-12.65c.28-1.1-.4-1.6-1.78-1.3Z"/></svg>
        </a>
        <a href="#" aria-label="Instagram" class="social__link">
          <svg viewBox="0 0 24 24"><path d="M12 2.2c2.7 0 3 0 4.1.06 1.1.05 1.85.23 2.5.48.68.27 1.26.62 1.83 1.19.57.57.92 1.15 1.19 1.83.25.65.43 1.4.48 2.5.06 1.1.06 1.4.06 4.1s0 3-.06 4.1c-.05 1.1-.23 1.85-.48 2.5a4.94 4.94 0 0 1-1.19 1.83 4.94 4.94 0 0 1-1.83 1.19c-.65.25-1.4.43-2.5.48-1.1.06-1.4.06-4.1.06s-3 0-4.1-.06c-1.1-.05-1.85-.23-2.5-.48a4.94 4.94 0 0 1-1.83-1.19 4.94 4.94 0 0 1-1.19-1.83c-.25-.65-.43-1.4-.48-2.5C2.2 15 2.2 14.7 2.2 12s0-3 .06-4.1c.05-1.1.23-1.85.48-2.5.27-.68.62-1.26 1.19-1.83a4.94 4.94 0 0 1 1.83-1.19c.65-.25 1.4-.43 2.5-.48C9.3 2.2 9.6 2.2 12 2.2Zm0 1.8c-2.66 0-2.97 0-4.02.06-.96.04-1.48.2-1.83.34-.46.18-.79.39-1.13.74-.35.34-.56.67-.74 1.13-.14.35-.3.87-.34 1.83C3.88 9.03 3.88 9.34 3.88 12s0 2.97.06 4.02c.04.96.2 1.48.34 1.83.18.46.39.79.74 1.13.34.35.67.56 1.13.74.35.14.87.3 1.83.34 1.05.06 1.36.06 4.02.06s2.97 0 4.02-.06c.96-.04 1.48-.2 1.83-.34.46-.18.79-.39 1.13-.74.35-.34.56-.67.74-1.13.14-.35.3-.87.34-1.83.06-1.05.06-1.36.06-4.02s0-2.97-.06-4.02c-.04-.96-.2-1.48-.34-1.83a2.98 2.98 0 0 0-.74-1.13 2.98 2.98 0 0 0-1.13-.74c-.35-.14-.87-.3-1.83-.34C14.97 4 14.66 4 12 4Zm0 3.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9Zm0 1.8a2.7 2.7 0 1 0 0 5.4 2.7 2.7 0 0 0 0-5.4Zm4.7-1.98a1.05 1.05 0 1 1 0 2.1 1.05 1.05 0 0 1 0-2.1Z"/></svg>
        </a>
      </div>
    </div>

    <div class="header__actions">
      <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="cart-btn" aria-label="Аккаунт">
        <svg viewBox="0 0 24 24" class="cart-btn__icon"><path fill="currentColor" d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-4.42 0-9 2.24-9 5v3h18v-3c0-2.76-4.58-5-9-5Z"/></svg>
      </a>

      <?php
      $tk_orders_count = 0;
      if ( is_user_logged_in() && function_exists( 'wc_get_orders' ) ) {
          $tk_orders_count = count( wc_get_orders( [ 'customer' => get_current_user_id(), 'limit' => 1, 'return' => 'ids' ] ) );
      }
      ?>
      <div class="orders-widget">
        <button class="cart-btn" id="ordersBtn" aria-label="Мои заказы" <?php echo $tk_orders_count ? '' : 'hidden'; ?>>
          <svg viewBox="0 0 24 24" class="cart-btn__icon"><path fill="currentColor" d="M7 2a2 2 0 0 0-2 2v16.5a.5.5 0 0 0 .74.44L8 19.7l2.26 1.24a.5.5 0 0 0 .48 0L13 19.7l2.26 1.24a.5.5 0 0 0 .48 0L18 19.7l2.26 1.24A.5.5 0 0 0 21 20.5V4a2 2 0 0 0-2-2H7Zm1 6h8v2H8V8Zm0 4h8v2H8v-2Z"/></svg>
        </button>
        <div class="orders-dropdown" id="ordersDropdown" hidden></div>
      </div>

      <button class="cart-btn" id="cartBtn" aria-label="Корзина">
        <svg viewBox="0 0 24 24" class="cart-btn__icon"><path d="M7 4h-2l-1 2v1h2l3.6 7.6-1.3 2.4c-.6 1.1.2 2.5 1.5 2.5h9.2v-2h-9.2l.9-1.6h6.8c.8 0 1.4-.4 1.7-1.1l3.3-6.4c.4-.7-.1-1.6-.9-1.6h-13.4l-.6-1.2c-.2-.4-.6-.6-1-.6ZM8 20a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Zm9 0a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" fill="currentColor"/></svg>
        <?php
        $count = function_exists( 'WC' ) && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
        ?>
        <span class="cart-btn__count" id="cartCount" <?php echo $count ? '' : 'hidden'; ?>><?php echo esc_html( $count ); ?></span>
      </button>

      <button class="burger" aria-label="Меню" id="burgerBtn">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>

  <nav class="nav nav--mobile" id="mobileNav">
    <a href="<?php echo esc_url( home_url( '/#pastry' ) ); ?>">Выпечка</a>
    <a href="<?php echo esc_url( home_url( '/#hot' ) ); ?>">Горячее</a>
    <a href="<?php echo esc_url( home_url( '/#promo' ) ); ?>">Акции</a>
    <a href="<?php echo esc_url( home_url( '/#contacts' ) ); ?>">Контакты</a>
  </nav>
  <div class="nav-backdrop" id="navBackdrop"></div>
</header>
