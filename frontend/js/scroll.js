/* =====================================================
   TechWon — Scroll Driver
   Maps scrollY → frame opacity/transform for 8 frames
   inside the sticky #stage / #driver pattern
   ===================================================== */
'use strict';

(function () {
  const driver  = document.getElementById('driver');
  const stage   = document.getElementById('stage');
  const frames  = document.querySelectorAll('#stage .frame');
  const dots    = document.querySelectorAll('.scrubber-dot');
  const chapter = document.getElementById('chapter-label');
  const progBar = document.getElementById('progress-fill');

  if (!driver || !frames.length) return;

  /* ── Mobile: disable cinematic engine, show all frames as normal scroll ── */
  if (window.innerWidth <= 860) {
    frames.forEach(f => {
      f.style.opacity = '1';
      f.style.transform = 'none';
      f.style.pointerEvents = 'auto';
      f.classList.add('is-active'); // so CSS animations still fire
    });
    return; // skip scroll-driver entirely
  }

  const FRAME_COUNT = frames.length;

  const CHAPTER_NAMES = [
    'Welcome',
    'The Problem',
    'Ranko — SEO Agent',
    'Quill — Content Agent',
    'Vega — Commerce Agent',
    'Iris — Voice Agent',
    'Otto — Listings Agent',
    'Get Started',
  ];

  let activeFrame = -1;

  function ease(x) {
    return x < 0.5 ? 2 * x * x : 1 - Math.pow(-2 * x + 2, 2) / 2;
  }

  function updateFrames() {
    if (!driver) return;

    const maxScroll = driver.offsetHeight - window.innerHeight;
    const rawProgress = maxScroll > 0 ? Math.min(Math.max(window.scrollY / maxScroll, 0), 1) : 0;
    const fp = rawProgress * FRAME_COUNT;

    // progress bar
    if (progBar) progBar.style.width = (rawProgress * 100) + '%';

    let newActive = Math.floor(fp);
    if (newActive >= FRAME_COUNT) newActive = FRAME_COUNT - 1;

    frames.forEach((frame, i) => {
      const local = fp - i; // 0→1 while this frame is "active"

      let opacity = 0;
      let ty = 0;

      if (local >= -0.15 && local < 1.15) {
        if (local < 0) {
          // pre-entry fade in (local: -0.15 → 0)
          const t = ease((local + 0.15) / 0.15);
          opacity = t;
          ty = (1 - t) * 40;
        } else if (local <= 0.85) {
          // fully visible — includes local=0 so frame 0 starts solid
          opacity = 1;
          ty = 0;
        } else if (local < 1.0) {
          // exit fade out (local: 0.85 → 1.0)
          const t = ease((local - 0.85) / 0.15);
          opacity = 1 - t;
          ty = -t * 40;
        } else {
          opacity = 0;
          ty = -40;
        }
      }

      frame.style.opacity = opacity;
      frame.style.transform = `translateY(${ty}px)`;
      frame.style.pointerEvents = opacity > 0.4 ? 'auto' : 'none';

      // Toggle is-active so CSS stagger animations fire when frame enters
      const wasActive = frame.classList.contains('is-active');
      const isNowActive = (i === newActive && opacity > 0.5);
      if (isNowActive && !wasActive) {
        // Reset animation by briefly removing & re-adding the class
        frame.classList.remove('is-active');
        // Force reflow so animation restarts cleanly
        void frame.offsetWidth;
        frame.classList.add('is-active');
      } else if (!isNowActive && wasActive) {
        frame.classList.remove('is-active');
      }
    });

    // scrubber dots
    dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === newActive);
      dot.classList.toggle('past', i < newActive);
    });

    // chapter label
    if (chapter && newActive !== activeFrame) {
      chapter.textContent = `${String(newActive + 1).padStart(2, '0')} / ${String(FRAME_COUNT).padStart(2, '0')} — ${CHAPTER_NAMES[newActive] || ''}`;
      activeFrame = newActive;

      // trigger counter animations when stats frame becomes visible
      if (newActive === 0) triggerCounters();
    }
  }

  // ── Scrubber dot click navigation ──────────────────────
  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      const maxScroll = driver.offsetHeight - window.innerHeight;
      const targetProgress = (i + 0.5) / FRAME_COUNT;
      window.scrollTo({ top: targetProgress * maxScroll, behavior: 'smooth' });
    });
  });

  // ── Animated counters ───────────────────────────────────
  const countedEls = new Set();

  function animateCount(el, target, suffix, duration) {
    if (countedEls.has(el)) return;
    countedEls.add(el);
    const start = performance.now();
    function step(now) {
      const p = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - p, 3);
      el.textContent = Math.round(target * eased).toLocaleString() + suffix;
      if (p < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }

  function triggerCounters() {
    document.querySelectorAll('[data-count]').forEach(el => {
      animateCount(el, parseFloat(el.dataset.count), el.dataset.suffix || '', 1800);
    });
  }

  // ── Vega step cycling ───────────────────────────────────
  const vegaSteps = document.querySelectorAll('.vega-step');
  if (vegaSteps.length) {
    let vegaActive = 0;
    setInterval(() => {
      vegaSteps.forEach((s, i) => s.classList.toggle('active', i === vegaActive));
      vegaActive = (vegaActive + 1) % vegaSteps.length;
    }, 1400);
  }

  // ── Generate scrubber dots if missing ──────────────────
  const scrubberEl = document.querySelector('.scrubber');
  if (scrubberEl && scrubberEl.children.length === 0) {
    for (let i = 0; i < FRAME_COUNT; i++) {
      const dot = document.createElement('button');
      dot.className = 'scrubber-dot';
      dot.dataset.idx = i;
      dot.title = CHAPTER_NAMES[i] || `Frame ${i + 1}`;
      scrubberEl.appendChild(dot);
    }
    // re-bind after generation
    scrubberEl.querySelectorAll('.scrubber-dot').forEach((dot, i) => {
      dot.addEventListener('click', () => {
        const maxScroll = driver.offsetHeight - window.innerHeight;
        const targetProgress = (i + 0.5) / FRAME_COUNT;
        window.scrollTo({ top: targetProgress * maxScroll, behavior: 'smooth' });
      });
    });
  }

  // ── Network node canvas for frame 1 ────────────────────
  (function buildNetworkBg() {
    const container = document.querySelector('.sbg-network');
    if (!container) return;

    const cvs = document.createElement('canvas');
    cvs.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;opacity:0.18;';
    container.prepend(cvs);

    function resize() {
      cvs.width  = container.offsetWidth  || window.innerWidth;
      cvs.height = container.offsetHeight || window.innerHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    const ctx = cvs.getContext('2d');
    const NODE_COUNT = 55;
    const nodes = Array.from({ length: NODE_COUNT }, () => ({
      x: Math.random() * cvs.width,
      y: Math.random() * cvs.height,
      vx: (Math.random() - 0.5) * 0.35,
      vy: (Math.random() - 0.5) * 0.35,
      r: Math.random() * 2.5 + 1,
    }));

    function drawNetwork() {
      ctx.clearRect(0, 0, cvs.width, cvs.height);

      nodes.forEach(n => {
        n.x += n.vx;
        n.y += n.vy;
        if (n.x < 0 || n.x > cvs.width)  n.vx *= -1;
        if (n.y < 0 || n.y > cvs.height) n.vy *= -1;
      });

      ctx.strokeStyle = '#4FD2FF';
      ctx.lineWidth = 0.5;
      for (let i = 0; i < nodes.length; i++) {
        for (let j = i + 1; j < nodes.length; j++) {
          const dx = nodes[i].x - nodes[j].x;
          const dy = nodes[i].y - nodes[j].y;
          const dist = Math.sqrt(dx * dx + dy * dy);
          if (dist < 130) {
            ctx.globalAlpha = (1 - dist / 130) * 0.6;
            ctx.beginPath();
            ctx.moveTo(nodes[i].x, nodes[i].y);
            ctx.lineTo(nodes[j].x, nodes[j].y);
            ctx.stroke();
          }
        }
      }

      ctx.fillStyle = '#4FD2FF';
      ctx.globalAlpha = 0.9;
      nodes.forEach(n => {
        ctx.beginPath();
        ctx.arc(n.x, n.y, n.r, 0, Math.PI * 2);
        ctx.fill();
      });

      ctx.globalAlpha = 1;
      requestAnimationFrame(drawNetwork);
    }
    drawNetwork();
  })();

  // ── Init ───────────────────────────────────────────────
  // Prevent browser scroll restoration so frame 0 always starts visible
  if ('scrollRestoration' in history) history.scrollRestoration = 'manual';
  window.scrollTo(0, 0);

  window.addEventListener('scroll', updateFrames, { passive: true });
  updateFrames();
  setTimeout(updateFrames, 100);
})();
