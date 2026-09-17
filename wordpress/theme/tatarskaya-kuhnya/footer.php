  <footer class="footer" id="contacts">
    <div class="container">
      <h2 class="section__title section__title--light">Контакты</h2>
      <p class="section__subtitle section__subtitle--light">Постоянные и сезонные акции со скидками от 7 до 50 %.<br>Следите за обновлениями!</p>

      <div class="footer__grid">
        <div class="footer__block">
          <h4>Телефон</h4>
          <a href="tel:+79999909900">+7 (999) 990-99-00</a>
        </div>
        <div class="footer__block">
          <h4>Адрес</h4>
          <p>г. Москва, Биляшевский 1к</p>
          <p class="footer__hours">Ежедневно с 9:00 до 21:00</p>
        </div>
        <div class="footer__block">
          <h4>Мы в соцсетях</h4>
          <div class="social social--footer">
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
      </div>

      <p class="footer__copy">© <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. Все права защищены.</p>
    </div>
  </footer>

  <div class="map">
    <iframe
      src="https://yandex.ru/map-widget/v1/?ll=37.617698%2C55.755864&z=15&l=map&pt=37.617698,55.755864,pm2rdm"
      width="100%" height="420" frameborder="0" loading="lazy"
      title="Карта расположения"></iframe>
  </div>

  <aside class="cart" id="cartDrawer" aria-label="Корзина">
    <div class="cart__header">
      <h3>Корзина</h3>
      <button class="cart__close" id="cartCloseBtn" aria-label="Закрыть корзину">
        <svg viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </button>
    </div>

    <div class="cart__body" id="cartBody"></div>

    <div class="cart__footer" id="cartFooter">
      <div class="cart__total">
        <span>Итого</span>
        <span id="cartTotal">0 р.</span>
      </div>
      <button type="button" class="btn btn--full" id="cartCheckoutBtn">Оформить заказ</button>
    </div>
  </aside>
  <div class="cart-backdrop" id="cartBackdrop"></div>

<?php wp_footer(); ?>
</body>
</html>
