'use strict';
/* ── Mobile hamburger menu ───────────────────────────── */
(function () {
  const btn = document.getElementById('hamburger');
  const menu = document.getElementById('mobile-menu');
  if (!btn || !menu) return;

  btn.addEventListener('click', () => {
    const open = btn.classList.toggle('is-open');
    menu.classList.toggle('is-open', open);
    document.body.style.overflow = open ? 'hidden' : '';
    btn.setAttribute('aria-expanded', open);
  });

  /* Close when any link is tapped */
  menu.querySelectorAll('a').forEach(a => {
    a.addEventListener('click', () => {
      btn.classList.remove('is-open');
      menu.classList.remove('is-open');
      document.body.style.overflow = '';
    });
  });

  /* Close on Escape */
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && menu.classList.contains('is-open')) {
      btn.classList.remove('is-open');
      menu.classList.remove('is-open');
      document.body.style.overflow = '';
    }
  });
})();
