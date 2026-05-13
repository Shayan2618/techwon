/* ============================================================
   TechWon — Content Page Reveal & Scroll-Snap Engine
   Adds cinematic section snap + staggered element animations
   ============================================================ */
(function () {
  'use strict';

  /* ── Inject CSS ───────────────────────────────────────────── */
  const style = document.createElement('style');
  style.textContent = `
    /* ── Section snap ── */
    html { scroll-snap-type: y proximity !important; scroll-behavior: smooth; }
    .snap-section {
      scroll-snap-align: start;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    /* hero always full viewport */
    .srv-hero, .ct-hero, .ab-hero {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      scroll-snap-align: start;
      padding-top: 120px;
      padding-bottom: 80px;
    }

    /* ── Keyframes ── */
    @keyframes rvLineUp {
      from { transform: translateY(110%); opacity: 0; }
      to   { transform: translateY(0);    opacity: 1; }
    }
    @keyframes rvFadeUp {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes rvFadeIn {
      from { opacity: 0; }
      to   { opacity: 1; }
    }

    /* ── Hero h1 clip-reveal ── */
    .rv-h1-line {
      display: block;
      overflow: hidden;
      line-height: 1.05;
    }
    .rv-h1-line > * {
      display: block;
      opacity: 0;
      transform: translateY(110%);
      animation: rvLineUp 0.82s cubic-bezier(0.16,1,0.3,1) forwards;
    }
    .rv-h1-line:nth-child(1) > * { animation-delay: 0.18s; }
    .rv-h1-line:nth-child(2) > * { animation-delay: 0.35s; }
    .rv-h1-line:nth-child(3) > * { animation-delay: 0.52s; }
    .rv-h1-line:nth-child(4) > * { animation-delay: 0.69s; }

    /* ── Hero sub-elements ── */
    .rv-hero-eyebrow {
      opacity: 0;
      animation: rvFadeUp 0.7s cubic-bezier(0.16,1,0.3,1) forwards 0.05s;
    }
    .rv-hero-p {
      opacity: 0;
      animation: rvFadeUp 0.75s cubic-bezier(0.16,1,0.3,1) forwards 0.72s;
    }
    .rv-hero-stats {
      opacity: 0;
      animation: rvFadeUp 0.7s cubic-bezier(0.16,1,0.3,1) forwards 0.92s;
    }
    .rv-hero-cta {
      opacity: 0;
      animation: rvFadeUp 0.65s cubic-bezier(0.16,1,0.3,1) forwards 0.88s;
    }

    /* ── Scroll-reveal elements (start hidden) ── */
    .rv {
      opacity: 0;
      transform: translateY(36px);
      transition:
        opacity 0.7s cubic-bezier(0.16,1,0.3,1),
        transform 0.7s cubic-bezier(0.16,1,0.3,1);
      will-change: opacity, transform;
    }
    .rv.rv-in {
      opacity: 1;
      transform: translateY(0);
    }
    /* section headings drop in from above */
    .rv.rv-drop { transform: translateY(-24px); }
    .rv.rv-drop.rv-in { transform: translateY(0); }

    /* stagger siblings */
    .rv.rv-d1 { transition-delay: 0.08s; }
    .rv.rv-d2 { transition-delay: 0.16s; }
    .rv.rv-d3 { transition-delay: 0.24s; }
    .rv.rv-d4 { transition-delay: 0.32s; }
    .rv.rv-d5 { transition-delay: 0.40s; }
    .rv.rv-d6 { transition-delay: 0.48s; }

    /* section label/title fast drop */
    .rv.rv-section-label { transition-duration: 0.5s; }

    /* ── Section entry: heading clip-reveal on intersection ── */
    .rv-section-h2 .rv-line {
      display: block;
      overflow: hidden;
      line-height: 1.08;
    }
    .rv-section-h2 .rv-line > span {
      display: block;
      opacity: 0;
      transform: translateY(100%);
      transition: transform 0.7s cubic-bezier(0.16,1,0.3,1), opacity 0.7s ease;
    }
    .rv-section-h2.rv-in .rv-line:nth-child(1) > span { opacity: 1; transform: translateY(0); transition-delay: 0.0s; }
    .rv-section-h2.rv-in .rv-line:nth-child(2) > span { opacity: 1; transform: translateY(0); transition-delay: 0.14s; }
    .rv-section-h2.rv-in .rv-line:nth-child(3) > span { opacity: 1; transform: translateY(0); transition-delay: 0.28s; }

    /* ── Page-in transition ── */
    body { animation: pageIn 0.55s cubic-bezier(0.16,1,0.3,1) both; }
    @keyframes pageIn {
      from { opacity: 0; transform: translateY(18px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Page-out transition ── */
    body.page-leaving {
      animation: pageOut 0.35s ease forwards !important;
      pointer-events: none;
    }
    @keyframes pageOut {
      to { opacity: 0; transform: translateY(-14px); }
    }
  `;
  document.head.appendChild(style);

  /* ── Hero setup ─────────────────────────────────────────────── */
  function setupHero() {
    const hero = document.querySelector('.srv-hero, .ct-hero, .ab-hero');
    if (!hero) return;

    // Eyebrow
    const eyebrow = hero.querySelector('.eyebrow');
    if (eyebrow) eyebrow.classList.add('rv-hero-eyebrow');

    // H1 — wrap each text node / child in clip-reveal line
    const h1 = hero.querySelector('h1');
    if (h1) {
      // Collect children (spans, brs) into lines
      const children = Array.from(h1.childNodes);
      h1.innerHTML = '';
      let line = null;
      let lineCount = 0;

      children.forEach(node => {
        if (node.nodeType === Node.ELEMENT_NODE && node.tagName === 'BR') {
          line = null; // next non-br starts new line
        } else if (node.nodeType === Node.ELEMENT_NODE || (node.nodeType === Node.TEXT_NODE && node.textContent.trim())) {
          if (!line) {
            lineCount++;
            line = document.createElement('span');
            line.className = 'rv-h1-line';
            h1.appendChild(line);
          }
          line.appendChild(node.cloneNode ? node.cloneNode(true) : node);
        }
      });
    }

    // Paragraph
    const p = hero.querySelector('p');
    if (p) p.classList.add('rv-hero-p');

    // Stats
    const stats = hero.querySelector('.ab-hero-stats');
    if (stats) stats.classList.add('rv-hero-stats');

    // CTAs
    hero.querySelectorAll('a.btn-primary, a.btn-outline, a.btn-nav').forEach(b => b.classList.add('rv-hero-cta'));
  }

  /* ── Add snap to major sections ─────────────────────────────── */
  function setupSnap() {
    // Sections that should snap + have breathing room
    const snapTargets = document.querySelectorAll(
      '.how-section, .pricing-section, .srv-cta, ' +
      '.ab-mission, .ab-values, .ab-stack, .ab-locations, .ab-automations, .ab-cta, ' +
      '.ct-grid'
    );
    snapTargets.forEach(s => s.classList.add('snap-section'));
  }

  /* ── Section headings: wrap words for clip-reveal ───────────── */
  function setupSectionHeadings() {
    document.querySelectorAll('.section-title').forEach(h2 => {
      // Split into up to 2 lines by splitting at middle space
      const text = h2.textContent.trim();
      const words = text.split(' ');
      if (words.length < 2) return;

      const mid = Math.ceil(words.length / 2);
      const line1 = words.slice(0, mid).join(' ');
      const line2 = words.slice(mid).join(' ');

      h2.classList.add('rv', 'rv-section-h2');
      h2.innerHTML = `
        <span class="rv-line"><span>${line1}</span></span>
        ${line2 ? `<span class="rv-line"><span>${line2}</span></span>` : ''}
      `;
    });
  }

  /* ── Auto-reveal targets ─────────────────────────────────────── */
  const AUTO_TARGETS = [
    '.section-label', '.section-sub',
    '.agent-card', '.pricing-card',
    '.value-card', '.auto-card', '.step',
    '.loc-card', '.stack-item',
    '.ct-info-block', '.ct-form-wrap', '.ct-availability',
    '.ab-quote-block', '.ab-hero-stats .ab-stat',
  ].join(', ');

  function setupReveal() {
    const els = document.querySelectorAll(AUTO_TARGETS);

    // Group by parent to stagger siblings
    const parentMap = new Map();
    els.forEach(el => {
      const key = el.parentElement;
      if (!parentMap.has(key)) parentMap.set(key, []);
      parentMap.get(key).push(el);
    });

    parentMap.forEach(siblings => {
      siblings.forEach((el, idx) => {
        el.classList.add('rv');
        if (idx > 0 && idx <= 6) el.classList.add(`rv-d${idx}`);
      });
    });

    // Section labels drop from above
    document.querySelectorAll('.section-label').forEach(el => el.classList.add('rv-drop'));
  }

  /* ── IntersectionObserver ────────────────────────────────────── */
  function observe() {
    const io = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('rv-in');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.06, rootMargin: '0px 0px -30px 0px' });

    document.querySelectorAll('.rv').forEach(el => io.observe(el));
  }

  /* ── Page transition on nav click ───────────────────────────── */
  function setupPageTransitions() {
    document.querySelectorAll('a[href]').forEach(a => {
      const href = a.getAttribute('href');
      // Internal links only
      if (!href || href.startsWith('#') || href.startsWith('http') || href.startsWith('mailto')) return;
      a.addEventListener('click', function (e) {
        e.preventDefault();
        document.body.classList.add('page-leaving');
        setTimeout(() => { window.location.href = href; }, 350);
      });
    });
  }

  /* ── Init ────────────────────────────────────────────────────── */
  function init() {
    setupHero();
    setupSnap();
    setupSectionHeadings();
    setupReveal();
    observe();
    setupPageTransitions();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
