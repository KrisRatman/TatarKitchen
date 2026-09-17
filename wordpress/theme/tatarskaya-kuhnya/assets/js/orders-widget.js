(function ($) {
  const ordersBtn = document.getElementById('ordersBtn');
  const dropdown = document.getElementById('ordersDropdown');

  if (!ordersBtn || !dropdown || typeof tkCart === 'undefined') {
    return;
  }

  function renderOrders(orders) {
    if (!orders.length) {
      dropdown.innerHTML = '<div class="orders-dropdown__empty">Заказов пока нет</div>';
      return;
    }
    dropdown.innerHTML = orders.map((o) => `
      <div class="orders-dropdown__item">
        <div>
          <div class="orders-dropdown__id">Заказ №${o.id}</div>
          <div class="orders-dropdown__date">${o.date} · ${o.total}</div>
        </div>
        <span class="orders-dropdown__status">${o.status}</span>
      </div>
    `).join('');
  }

  function loadOrders() {
    dropdown.innerHTML = '<div class="orders-dropdown__empty">Загрузка…</div>';
    $.post(tkCart.ajax_url, { action: 'tk_get_orders', nonce: tkCart.nonce })
      .done((res) => { if (res.success) renderOrders(res.data.orders); });
  }

  ordersBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    const isHidden = dropdown.hasAttribute('hidden');
    if (isHidden) {
      dropdown.removeAttribute('hidden');
      loadOrders();
    } else {
      dropdown.setAttribute('hidden', '');
    }
  });

  document.addEventListener('click', (e) => {
    if (!dropdown.hasAttribute('hidden') && !dropdown.contains(e.target) && e.target !== ordersBtn) {
      dropdown.setAttribute('hidden', '');
    }
  });

  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') dropdown.setAttribute('hidden', '');
  });
})(jQuery);
