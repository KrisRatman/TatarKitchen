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
