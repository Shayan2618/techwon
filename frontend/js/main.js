/* =====================================================
   TechWon — Main site JS
   Cursor glow, contact form, newsletter, demo modal
   (Scroll-driver logic lives in scroll.js)
   ===================================================== */
'use strict';

const API = (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1')
  ? 'http://localhost:3002/api'
  : '/api';

// ── Cursor glow ─────────────────────────────────────────
const cursorGlow = document.querySelector('.cursor-glow');
if (cursorGlow) {
  window.addEventListener('mousemove', (e) => {
    cursorGlow.style.left = e.clientX + 'px';
    cursorGlow.style.top  = e.clientY + 'px';
  });
}

// ── Typing animation (Quill mock) ───────────────────────
const typingEl = document.querySelector('.quill-cursor');
if (typingEl) {
  const phrases = [
    'Boost Your Rankings With Proven SEO Tactics',
    'Turn First-Time Visitors Into Loyal Customers',
    'Why Your Competitors Are Already Using AI Content',
    'The SMB Guide to Dominating Local Search in 2025',
  ];
  let phraseIdx = 0;
  let charIdx = 0;
  let deleting = false;
  function typeLoop() {
    const phrase = phrases[phraseIdx];
    if (!deleting) {
      typingEl.textContent = phrase.slice(0, ++charIdx);
      if (charIdx === phrase.length) {
        deleting = true;
        setTimeout(typeLoop, 2200);
        return;
      }
    } else {
      typingEl.textContent = phrase.slice(0, --charIdx);
      if (charIdx === 0) {
        deleting = false;
        phraseIdx = (phraseIdx + 1) % phrases.length;
      }
    }
    setTimeout(typeLoop, deleting ? 30 : 55);
  }
  setTimeout(typeLoop, 1200);
}

// ── Contact form ────────────────────────────────────────
const contactForm = document.getElementById('contact-form');
const contactMsg  = document.getElementById('contact-msg');

if (contactForm) {
  contactForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = contactForm.querySelector('button[type=submit]');
    btn.disabled = true;
    btn.textContent = 'Sending...';
    contactMsg.className = 'form-msg';
    contactMsg.textContent = '';

    const data = Object.fromEntries(new FormData(contactForm).entries());

    try {
      const res = await fetch(`${API}/contact`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
      });
      const json = await res.json();
      if (json.success) {
        contactMsg.classList.add('success');
        contactMsg.textContent = json.message;
        contactForm.reset();
      } else {
        throw new Error(json.error || 'Submission failed');
      }
    } catch (err) {
      contactMsg.classList.add('error');
      contactMsg.textContent = err.message;
    } finally {
      btn.disabled = false;
      btn.textContent = 'Send Message';
    }
  });
}

// ── Newsletter form ──────────────────────────────────────
const nlForm = document.getElementById('nl-form');
const nlMsg  = document.getElementById('nl-msg');

if (nlForm) {
  nlForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = nlForm.querySelector('button[type=submit]');
    btn.disabled = true;
    if (nlMsg) { nlMsg.className = 'form-msg'; nlMsg.textContent = ''; }

    const email = nlForm.querySelector('input[type=email]').value;

    try {
      const res = await fetch(`${API}/newsletter/subscribe`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email }),
      });
      const json = await res.json();
      if (json.success) {
        if (nlMsg) { nlMsg.classList.add('success'); nlMsg.textContent = json.message; }
        nlForm.reset();
      } else {
        throw new Error(json.error || 'Subscription failed');
      }
    } catch (err) {
      if (nlMsg) { nlMsg.classList.add('error'); nlMsg.textContent = err.message; }
    } finally {
      btn.disabled = false;
    }
  });
}

// ── Demo booking modal ───────────────────────────────────
const demoBtns     = document.querySelectorAll('.open-demo');
const demoModal    = document.getElementById('demo-modal');
const demoClose    = document.getElementById('demo-close');
const demoForm     = document.getElementById('demo-form');
const demoMsg      = document.getElementById('demo-msg');
const slotsContainer = document.getElementById('demo-slots');

async function loadSlots() {
  if (!slotsContainer) return;
  slotsContainer.innerHTML = '<p style="color:var(--muted);font-size:13px">Loading slots…</p>';
  try {
    const res  = await fetch(`${API}/demo/slots`);
    const json = await res.json();
    if (!json.success) throw new Error();
    const available = json.data.filter(s => s.available).slice(0, 12);
    if (!available.length) {
      slotsContainer.innerHTML = '<p style="color:var(--muted);font-size:13px">No slots available right now.</p>';
      return;
    }
    slotsContainer.innerHTML = '';
    available.forEach(slot => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'slot-btn';
      btn.dataset.date = slot.date;
      btn.dataset.time = slot.time;
      const d = new Date(slot.date + 'T12:00:00');
      btn.textContent = `${d.toLocaleDateString('en', { weekday: 'short', month: 'short', day: 'numeric' })} · ${slot.time}`;
      btn.addEventListener('click', () => {
        slotsContainer.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        document.getElementById('demo-date').value = slot.date;
        document.getElementById('demo-time').value = slot.time;
      });
      slotsContainer.appendChild(btn);
    });
  } catch {
    slotsContainer.innerHTML = '<p style="color:var(--muted);font-size:13px">Could not load slots.</p>';
  }
}

function openModal() {
  if (!demoModal) return;
  demoModal.classList.add('open');
  document.body.style.overflow = 'hidden';
  loadSlots();
}

function closeModal() {
  if (!demoModal) return;
  demoModal.classList.remove('open');
  document.body.style.overflow = '';
}

demoBtns.forEach(b => b.addEventListener('click', openModal));
if (demoClose) demoClose.addEventListener('click', closeModal);
if (demoModal) demoModal.addEventListener('click', (e) => { if (e.target === demoModal) closeModal(); });

if (demoForm) {
  demoForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = demoForm.querySelector('button[type=submit]');
    btn.disabled = true;
    btn.textContent = 'Booking…';
    if (demoMsg) { demoMsg.className = 'form-msg'; demoMsg.textContent = ''; }

    const data = Object.fromEntries(new FormData(demoForm).entries());
    if (!data.date || !data.time) {
      if (demoMsg) { demoMsg.classList.add('error'); demoMsg.textContent = 'Please select a time slot.'; }
      btn.disabled = false;
      btn.textContent = 'Book Demo';
      return;
    }

    try {
      const res  = await fetch(`${API}/demo/book`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
      });
      const json = await res.json();
      if (json.success) {
        if (demoMsg) { demoMsg.classList.add('success'); demoMsg.textContent = json.message; }
        demoForm.reset();
        slotsContainer && slotsContainer.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
      } else {
        throw new Error(json.error || 'Booking failed');
      }
    } catch (err) {
      if (demoMsg) { demoMsg.classList.add('error'); demoMsg.textContent = err.message; }
    } finally {
      btn.disabled = false;
      btn.textContent = 'Book Demo';
    }
  });
}

// ── Feat-strip drag-to-scroll ────────────────────────────
document.querySelectorAll('.feat-strip').forEach(strip => {
  let isDown = false, startX, scrollLeft;
  strip.addEventListener('mousedown', e => {
    isDown = true;
    strip.classList.add('is-dragging');
    startX = e.pageX - strip.offsetLeft;
    scrollLeft = strip.scrollLeft;
  });
  strip.addEventListener('mouseleave', () => { isDown = false; strip.classList.remove('is-dragging'); });
  strip.addEventListener('mouseup',    () => { isDown = false; strip.classList.remove('is-dragging'); });
  strip.addEventListener('mousemove',  e => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - strip.offsetLeft;
    strip.scrollLeft = scrollLeft - (x - startX) * 1.4;
  });
});
