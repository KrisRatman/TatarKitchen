(function ($) {
  const cartBtn = document.getElementById('cartBtn');
  const cartDrawer = document.getElementById('cartDrawer');
  const cartBackdrop = document.getElementById('cartBackdrop');
  const cartCloseBtn = document.getElementById('cartCloseBtn');
  const cartBody = document.getElementById('cartBody');
  const cartFooter = document.getElementById('cartFooter');
  const cartTotal = document.getElementById('cartTotal');
  const cartCheckoutBtn = document.getElementById('cartCheckoutBtn');

  if (!cartBtn || !cartDrawer || typeof tkCart === 'undefined') {
    return;
  }

  const openCart = () => {
    cartDrawer.classList.add('is-open');
    cartBackdrop.classList.add('is-open');
    document.body.style.overflow = 'hidden';
  };

  const closeCart = () => {
    cartDrawer.classList.remove('is-open');
    cartBackdrop.classList.remove('is-open');
    document.body.style.overflow = '';
  };

  function renderEmpty() {
    cartBody.innerHTML = `
      <div class="cart__empty">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M7 4h-2l-1 2v1h2l3.6 7.6-1.3 2.4c-.6 1.1.2 2.5 1.5 2.5h9.2v-2h-9.2l.9-1.6h6.8c.8 0 1.4-.4 1.7-1.1l3.3-6.4c.4-.7-.1-1.6-.9-1.6h-13.4l-.6-1.2c-.2-.4-.6-.6-1-.6ZM8 20a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Zm9 0a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z"/></svg>
        <p>Ваша корзина пуста</p>
      </div>`;
    cartFooter.hidden = true;
  }

  function renderCart(data) {
    if (!data.items.length) {
      renderEmpty();
      return;
    }

    cartFooter.hidden = false;
    cartBody.innerHTML = data.items.map((item) => `
      <div class="cart-item" data-key="${item.key}">
        <div class="cart-item__image"><img src="${item.image}" alt="${item.name}"></div>
        <div>
          <p class="cart-item__name">${item.name}</p>
          <p class="cart-item__price">${item.price} р.</p>
        </div>
        <div class="cart-item__controls">
          <div class="cart-item__qty">
            <button type="button" class="cart-item__qty-btn" data-action="dec" aria-label="Уменьшить количество">−</button>
            <span class="cart-item__qty-value">${item.qty}</span>
            <button type="button" class="cart-item__qty-btn" data-action="inc" aria-label="Увеличить количество">+</button>
          </div>
          <button type="button" class="cart-item__remove" data-action="remove" aria-label="Удалить из корзины">
            <svg viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
          </button>
        </div>
      </div>
    `).join('');

    cartTotal.innerHTML = data.formatted_total;
  }

  function refreshCart(openAfter) {
    $.post(tkCart.ajax_url, { action: 'tk_get_cart', nonce: tkCart.nonce })
      .done((res) => {
        if (res.success) {
          renderCart(res.data);
          if (openAfter) openCart();
        }
      });
  }

  function updateQty(key, qty) {
    $.post(tkCart.ajax_url, { action: 'tk_update_qty', nonce: tkCart.nonce, key, qty })
      .done((res) => { if (res.success) renderCart(res.data); });
  }

  function removeItem(key) {
    $.post(tkCart.ajax_url, { action: 'tk_remove_item', nonce: tkCart.nonce, key })
      .done((res) => { if (res.success) renderCart(res.data); });
  }

  cartBtn.addEventListener('click', () => { openCart(); refreshCart(false); });
  cartCloseBtn.addEventListener('click', closeCart);
  cartBackdrop.addEventListener('click', closeCart);
  window.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeCart(); });

  cartBody.addEventListener('click', (e) => {
    const actionBtn = e.target.closest('[data-action]');
    if (!actionBtn) return;
    const itemEl = actionBtn.closest('.cart-item');
    const key = itemEl?.dataset.key;
    if (!key) return;

    if (actionBtn.dataset.action === 'remove') {
      removeItem(key);
      return;
    }

    const valueEl = itemEl.querySelector('.cart-item__qty-value');
    let qty = parseInt(valueEl.textContent, 10) || 1;
    qty += actionBtn.dataset.action === 'inc' ? 1 : -1;
    updateQty(key, Math.max(0, qty));
  });

  cartCheckoutBtn.addEventListener('click', () => {
    window.location.href = tkCart.checkout_url;
  });

  // WooCommerce's own ajax-add-to-cart fires this after a successful add.
  // Keep the drawer contents in sync in the background without popping it
  // open, so shoppers can keep adding items from the catalog uninterrupted.
  $(document.body).on('added_to_cart', () => refreshCart(false));

  refreshCart(false);
})(jQuery);
