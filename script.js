// Mobile menu
const burgerBtn = document.getElementById('burgerBtn');
const mobileNav = document.getElementById('mobileNav');
const navBackdrop = document.getElementById('navBackdrop');

if (burgerBtn && mobileNav && navBackdrop) {
  const openMenu = () => {
    burgerBtn.classList.add('is-open');
    mobileNav.classList.add('is-open');
    navBackdrop.classList.add('is-open');
    document.body.style.overflow = 'hidden';
  };

  const closeMenu = () => {
    burgerBtn.classList.remove('is-open');
    mobileNav.classList.remove('is-open');
    navBackdrop.classList.remove('is-open');
    document.body.style.overflow = '';
  };

  burgerBtn.addEventListener('click', () => {
    mobileNav.classList.contains('is-open') ? closeMenu() : openMenu();
  });

  navBackdrop.addEventListener('click', closeMenu);

  mobileNav.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', closeMenu);
  });

  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeMenu();
  });
}

// Promo slider
const track = document.getElementById('sliderTrack');
const dotsWrap = document.getElementById('sliderDots');
const prevBtn = document.getElementById('sliderPrev');
const nextBtn = document.getElementById('sliderNext');

if (track) {
  const slides = Array.from(track.children);
  const dots = dotsWrap ? Array.from(dotsWrap.children) : [];
  let current = 0;
  let autoplayTimer = null;

  function goTo(index) {
    current = (index + slides.length) % slides.length;
    track.style.transform = `translateX(-${current * 100}%)`;
    dots.forEach((dot, i) => dot.classList.toggle('is-active', i === current));
  }

  function next() { goTo(current + 1); }
  function prev() { goTo(current - 1); }

  function startAutoplay() {
    stopAutoplay();
    autoplayTimer = setInterval(next, 5000);
  }

  function stopAutoplay() {
    if (autoplayTimer) clearInterval(autoplayTimer);
  }

  nextBtn?.addEventListener('click', () => { next(); startAutoplay(); });
  prevBtn?.addEventListener('click', () => { prev(); startAutoplay(); });

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => { goTo(i); startAutoplay(); });
  });

  const sliderEl = document.getElementById('slider');
  sliderEl?.addEventListener('mouseenter', stopAutoplay);
  sliderEl?.addEventListener('mouseleave', startAutoplay);

  goTo(0);
  startAutoplay();
}

// Cart
const CART_STORAGE_KEY = 'tk_cart_v1';
const CART_MODE_KEY = 'tk_cart_mode';
const CART_ADDRESS_KEY = 'tk_cart_address';

function loadCart() {
  try {
    return JSON.parse(localStorage.getItem(CART_STORAGE_KEY)) || [];
  } catch {
    return [];
  }
}

function saveCart(items) {
  try {
    localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(items));
  } catch {}
}

let cartItems = loadCart();
let deliveryMode = localStorage.getItem(CART_MODE_KEY) || 'delivery';

const cartBtn = document.getElementById('cartBtn');
const cartCount = document.getElementById('cartCount');
const cartDrawer = document.getElementById('cartDrawer');
const cartBackdrop = document.getElementById('cartBackdrop');
const cartCloseBtn = document.getElementById('cartCloseBtn');
const cartBody = document.getElementById('cartBody');
const cartFooter = document.getElementById('cartFooter');
const cartTotal = document.getElementById('cartTotal');
const cartCheckoutBtn = document.getElementById('cartCheckoutBtn');
const cartSuccess = document.getElementById('cartSuccess');
const cartSuccessText = document.getElementById('cartSuccessText');
const cartContinueBtn = document.getElementById('cartContinueBtn');
const deliveryToggle = document.getElementById('deliveryToggle');
const cartAddressWrap = document.getElementById('cartAddressWrap');
const cartAddress = document.getElementById('cartAddress');
const cartAddressError = document.getElementById('cartAddressError');
const cartPickupNote = document.getElementById('cartPickupNote');

if (cartBtn && cartDrawer) {
  cartAddress.value = localStorage.getItem(CART_ADDRESS_KEY) || '';

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

  const formatPrice = (value) => `${value} р.`;

  function renderCart() {
    const totalQty = cartItems.reduce((sum, i) => sum + i.qty, 0);
    cartCount.textContent = totalQty;
    cartCount.hidden = totalQty === 0;

    if (cartItems.length === 0) {
      cartBody.innerHTML = `
        <div class="cart__empty">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M7 4h-2l-1 2v1h2l3.6 7.6-1.3 2.4c-.6 1.1.2 2.5 1.5 2.5h9.2v-2h-9.2l.9-1.6h6.8c.8 0 1.4-.4 1.7-1.1l3.3-6.4c.4-.7-.1-1.6-.9-1.6h-13.4l-.6-1.2c-.2-.4-.6-.6-1-.6ZM8 20a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Zm9 0a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z"/></svg>
          <p>Ваша корзина пуста</p>
        </div>`;
      cartFooter.hidden = true;
      return;
    }

    cartFooter.hidden = false;
    cartBody.innerHTML = cartItems.map((item) => `
      <div class="cart-item" data-id="${item.id}">
        <div class="cart-item__image"><img src="${item.image}" alt="${item.name}"></div>
        <div>
          <p class="cart-item__name">${item.name}</p>
          <p class="cart-item__price">${formatPrice(item.price)}</p>
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

    const total = cartItems.reduce((sum, i) => sum + i.qty * i.price, 0);
    cartTotal.textContent = formatPrice(total);
  }

  function addToCart(product) {
    const existing = cartItems.find((i) => i.id === product.id);
    if (existing) {
      existing.qty += 1;
    } else {
      cartItems.push({ ...product, qty: 1 });
    }
    saveCart(cartItems);
    renderCart();
  }

  function changeQty(id, delta) {
    const item = cartItems.find((i) => i.id === id);
    if (!item) return;
    item.qty += delta;
    if (item.qty <= 0) {
      cartItems = cartItems.filter((i) => i.id !== id);
    }
    saveCart(cartItems);
    renderCart();
  }

  function removeFromCart(id) {
    cartItems = cartItems.filter((i) => i.id !== id);
    saveCart(cartItems);
    renderCart();
  }

  function setDeliveryMode(mode) {
    deliveryMode = mode;
    localStorage.setItem(CART_MODE_KEY, mode);
    deliveryToggle.querySelectorAll('.delivery-toggle__btn').forEach((btn) => {
      btn.classList.toggle('is-active', btn.dataset.mode === mode);
    });
    cartAddressWrap.hidden = mode !== 'delivery';
    cartPickupNote.hidden = mode !== 'pickup';
    cartAddressWrap.classList.remove('has-error');
    cartAddressError.hidden = true;
  }

  cartBtn.addEventListener('click', openCart);
  cartCloseBtn.addEventListener('click', closeCart);
  cartBackdrop.addEventListener('click', closeCart);
  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeCart();
  });

  document.querySelectorAll('.card .btn[data-id]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const card = btn.closest('.card');
      const image = card?.querySelector('img')?.getAttribute('src') || '';

      addToCart({
        id: btn.dataset.id,
        name: btn.dataset.name,
        price: Number(btn.dataset.price),
        image,
      });

      const original = btn.textContent;
      btn.textContent = 'Добавлено ✓';
      btn.disabled = true;
      setTimeout(() => {
        btn.textContent = original;
        btn.disabled = false;
      }, 1200);
    });
  });

  cartBody.addEventListener('click', (e) => {
    const actionBtn = e.target.closest('[data-action]');
    if (!actionBtn) return;
    const itemEl = actionBtn.closest('.cart-item');
    const id = itemEl?.dataset.id;
    if (!id) return;

    if (actionBtn.dataset.action === 'inc') changeQty(id, 1);
    if (actionBtn.dataset.action === 'dec') changeQty(id, -1);
    if (actionBtn.dataset.action === 'remove') removeFromCart(id);
  });

  deliveryToggle.addEventListener('click', (e) => {
    const btn = e.target.closest('.delivery-toggle__btn');
    if (btn) setDeliveryMode(btn.dataset.mode);
  });

  cartAddress.addEventListener('input', () => {
    localStorage.setItem(CART_ADDRESS_KEY, cartAddress.value);
    if (cartAddress.value.trim()) {
      cartAddressWrap.classList.remove('has-error');
      cartAddressError.hidden = true;
    }
  });

  cartCheckoutBtn.addEventListener('click', () => {
    if (deliveryMode === 'delivery' && !cartAddress.value.trim()) {
      cartAddressWrap.classList.add('has-error');
      cartAddressError.hidden = false;
      cartAddress.focus();
      return;
    }

    const message = deliveryMode === 'delivery'
      ? `Курьер привезёт заказ по адресу: ${cartAddress.value.trim()}.`
      : 'Ждём вас за самовывозом по адресу: г. Москва, Биляшевский 1к.';
    cartSuccessText.textContent = `${message} Мы свяжемся с вами для подтверждения.`;

    cartBody.hidden = true;
    cartFooter.hidden = true;
    cartSuccess.hidden = false;

    cartItems = [];
    saveCart(cartItems);
  });

  cartContinueBtn.addEventListener('click', () => {
    cartSuccess.hidden = true;
    cartBody.hidden = false;
    renderCart();
    closeCart();
  });

  setDeliveryMode(deliveryMode);
  renderCart();
}
