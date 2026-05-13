/* =====================================================
   TechWon — Three.js Interactive Intro Scene
   Inspired by bruno-simon.com: 3D world, orbiting nodes,
   particle field, mouse-reactive camera
   ===================================================== */

(function () {
  'use strict';

  // ── Enter button — always works, even without Three.js ──
  const enterBtn = document.getElementById('enter-btn');
  const introEl  = document.getElementById('intro');
  if (enterBtn) {
    enterBtn.addEventListener('click', () => {
      if (introEl) introEl.classList.add('hidden');
      document.body.style.overflow = 'auto';
      setTimeout(() => { if (introEl) introEl.remove(); }, 1400);
    });
  }

  const canvas = document.getElementById('intro-canvas');
  if (!canvas || typeof THREE === 'undefined') return;

  // ── Renderer ──────────────────────────────────────────
  const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.setSize(window.innerWidth, window.innerHeight);
  renderer.setClearColor(0x00030e, 1);
  renderer.shadowMap.enabled = true;
  renderer.shadowMap.type = THREE.PCFSoftShadowMap;

  // ── Scene & Camera ────────────────────────────────────
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(65, window.innerWidth / window.innerHeight, 0.1, 200);
  camera.position.set(0, 2, 14);

  // ── Clock ─────────────────────────────────────────────
  const clock = new THREE.Clock();

  // ── Mouse tracking ────────────────────────────────────
  const mouse = new THREE.Vector2();
  const targetCamOffset = new THREE.Vector2();
  const currentCamOffset = new THREE.Vector2();
  window.addEventListener('mousemove', (e) => {
    mouse.x = (e.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(e.clientY / window.innerHeight) * 2 + 1;
    targetCamOffset.set(mouse.x * 1.6, mouse.y * 0.8);
  });

  // ── Ambient & directional light ───────────────────────
  const ambientLight = new THREE.AmbientLight(0x1a2a6a, 1.2);
  scene.add(ambientLight);

  const dirLight = new THREE.DirectionalLight(0x4fd2ff, 2.5);
  dirLight.position.set(6, 10, 8);
  scene.add(dirLight);

  const rimLight = new THREE.DirectionalLight(0x2d9cff, 1.5);
  rimLight.position.set(-8, 4, -6);
  scene.add(rimLight);

  // ── Fog ───────────────────────────────────────────────
  scene.fog = new THREE.FogExp2(0x00030e, 0.028);

  // ── Grid floor ────────────────────────────────────────
  const gridHelper = new THREE.GridHelper(40, 40, 0x1e3a6e, 0x0a1640);
  gridHelper.position.y = -4;
  scene.add(gridHelper);

  // ── Central glowing sphere (the "brain") ─────────────
  const brainGeo = new THREE.IcosahedronGeometry(1.6, 4);
  const brainMat = new THREE.MeshStandardMaterial({
    color: 0x0a1e5e,
    emissive: 0x1a4daa,
    emissiveIntensity: 0.6,
    metalness: 0.8,
    roughness: 0.2,
    wireframe: false,
  });
  const brain = new THREE.Mesh(brainGeo, brainMat);
  scene.add(brain);

  // Wireframe overlay
  const wireMat = new THREE.MeshBasicMaterial({ color: 0x4fd2ff, wireframe: true, transparent: true, opacity: 0.12 });
  const wire = new THREE.Mesh(brainGeo, wireMat);
  scene.add(wire);

  // Glow sprite
  const glowTex = makeGlowTexture();
  const glowMat = new THREE.SpriteMaterial({ map: glowTex, color: 0x4fd2ff, transparent: true, opacity: 0.35, depthWrite: false });
  const glow = new THREE.Sprite(glowMat);
  glow.scale.set(10, 10, 1);
  scene.add(glow);

  // ── Orbit rings ───────────────────────────────────────
  const rings = [];
  const ringConfigs = [
    { r: 3.8, tube: 0.015, color: 0x4fd2ff, tiltX: 72, tiltY: 0, speed: 0.3 },
    { r: 5.2, tube: 0.012, color: 0x7bb8ff, tiltX: 55, tiltY: 20, speed: -0.18 },
    { r: 6.8, tube: 0.008, color: 0x2d9cff, tiltX: 78, tiltY: -15, speed: 0.12 },
  ];
  ringConfigs.forEach((cfg) => {
    const geo = new THREE.TorusGeometry(cfg.r, cfg.tube, 8, 120);
    const mat = new THREE.MeshBasicMaterial({ color: cfg.color, transparent: true, opacity: 0.6 });
    const mesh = new THREE.Mesh(geo, mat);
    mesh.rotation.x = THREE.MathUtils.degToRad(cfg.tiltX);
    mesh.rotation.y = THREE.MathUtils.degToRad(cfg.tiltY);
    scene.add(mesh);
    rings.push({ mesh, speed: cfg.speed });
  });

  // ── Orbit nodes (agent spheres) ───────────────────────
  const agents = [
    { name: 'R', color: 0x4fd2ff, radius: 3.8, angle: 0,    tiltX: 72, tiltY: 0,   speed: 0.3 },
    { name: 'Q', color: 0x7bb8ff, radius: 5.2, angle: 2.5,  tiltX: 55, tiltY: 20,  speed: -0.18 },
    { name: 'V', color: 0x2d9cff, radius: 3.8, angle: 1.2,  tiltX: 72, tiltY: 0,   speed: 0.3 },
    { name: 'I', color: 0x4fd2ff, radius: 6.8, angle: 4.0,  tiltX: 78, tiltY: -15, speed: 0.12 },
    { name: 'O', color: 0x1e5bd6, radius: 5.2, angle: 0.8,  tiltX: 55, tiltY: 20,  speed: -0.18 },
  ];
  const agentMeshes = agents.map((a) => {
    const geo = new THREE.SphereGeometry(0.18, 16, 16);
    const mat = new THREE.MeshStandardMaterial({
      color: a.color,
      emissive: a.color,
      emissiveIntensity: 0.8,
      metalness: 0.3,
      roughness: 0.4,
    });
    const mesh = new THREE.Mesh(geo, mat);
    scene.add(mesh);

    const haloMat = new THREE.SpriteMaterial({ map: glowTex, color: a.color, transparent: true, opacity: 0.5, depthWrite: false });
    const halo = new THREE.Sprite(haloMat);
    halo.scale.set(1.4, 1.4, 1);
    mesh.add(halo);

    return { mesh, ...a };
  });

  // ── Particle field ────────────────────────────────────
  const PARTICLE_COUNT = 1800;
  const particleGeo = new THREE.BufferGeometry();
  const positions = new Float32Array(PARTICLE_COUNT * 3);
  const particleSpeeds = new Float32Array(PARTICLE_COUNT);
  const particleSizes = new Float32Array(PARTICLE_COUNT);
  for (let i = 0; i < PARTICLE_COUNT; i++) {
    const theta = Math.random() * Math.PI * 2;
    const phi   = Math.acos(Math.random() * 2 - 1);
    const r     = 5 + Math.random() * 30;
    positions[i * 3]     = r * Math.sin(phi) * Math.cos(theta);
    positions[i * 3 + 1] = r * Math.sin(phi) * Math.sin(theta);
    positions[i * 3 + 2] = r * Math.cos(phi);
    particleSpeeds[i]    = 0.001 + Math.random() * 0.002;
    particleSizes[i]     = Math.random() * 2.5 + 0.5;
  }
  particleGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
  particleGeo.setAttribute('aSize', new THREE.BufferAttribute(particleSizes, 1));
  const particleMat = new THREE.PointsMaterial({
    color: 0x4fd2ff, size: 0.06, transparent: true, opacity: 0.55,
    sizeAttenuation: true, depthWrite: false,
  });
  const particles = new THREE.Points(particleGeo, particleMat);
  scene.add(particles);

  // ── Floating connection lines ─────────────────────────
  const lineMat = new THREE.LineBasicMaterial({ color: 0x4fd2ff, transparent: true, opacity: 0.12 });
  const lineGroup = new THREE.Group();
  for (let i = 0; i < 28; i++) {
    const pts = [
      new THREE.Vector3((Math.random() - 0.5) * 16, (Math.random() - 0.5) * 8, (Math.random() - 0.5) * 12),
      new THREE.Vector3((Math.random() - 0.5) * 16, (Math.random() - 0.5) * 8, (Math.random() - 0.5) * 12),
    ];
    const geo = new THREE.BufferGeometry().setFromPoints(pts);
    lineGroup.add(new THREE.Line(geo, lineMat));
  }
  scene.add(lineGroup);

  // ── Loading progress bar ──────────────────────────────
  const progressFill = document.getElementById('intro-progress');
  let loadProgress = 0;
  const loadInterval = setInterval(() => {
    loadProgress += Math.random() * 12;
    if (loadProgress >= 100) {
      loadProgress = 100;
      clearInterval(loadInterval);
    }
    if (progressFill) progressFill.style.width = loadProgress + '%';
  }, 80);

  // ── Resize ────────────────────────────────────────────
  window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
  });

  // ── Animate ───────────────────────────────────────────
  let frame = 0;
  function animate() {
    requestAnimationFrame(animate);
    const t = clock.getElapsedTime();
    frame++;

    // Brain pulse
    const pulse = 1 + Math.sin(t * 1.4) * 0.04;
    brain.scale.setScalar(pulse);
    wire.scale.setScalar(pulse * 1.002);
    brain.rotation.y = t * 0.08;
    brain.rotation.x = Math.sin(t * 0.12) * 0.15;
    wire.rotation.y  = t * 0.06;
    glow.material.opacity = 0.25 + Math.sin(t * 1.2) * 0.1;

    // Rings
    rings.forEach((r) => {
      r.mesh.rotation.z += r.speed * 0.01;
    });

    // Agent nodes orbit
    agentMeshes.forEach((a) => {
      a.angle += a.speed * 0.012;
      const tiltXRad = THREE.MathUtils.degToRad(a.tiltX);
      const tiltYRad = THREE.MathUtils.degToRad(a.tiltY);
      const x = a.radius * Math.cos(a.angle);
      const y = a.radius * Math.sin(a.angle) * Math.cos(tiltXRad);
      const z = a.radius * Math.sin(a.angle) * Math.sin(tiltXRad);
      a.mesh.position.set(x, y, z);
      a.mesh.rotation.y = tiltYRad;
    });

    // Particles drift
    particles.rotation.y = t * 0.018;
    particles.rotation.x = t * 0.006;

    // Line group slow rotate
    lineGroup.rotation.y = t * 0.012;

    // Camera follows mouse
    currentCamOffset.x += (targetCamOffset.x - currentCamOffset.x) * 0.04;
    currentCamOffset.y += (targetCamOffset.y - currentCamOffset.y) * 0.04;
    camera.position.x = currentCamOffset.x;
    camera.position.y = 2 + currentCamOffset.y * 0.5;
    camera.lookAt(0, 0, 0);

    renderer.render(scene, camera);
  }
  animate();

  // ── Glow texture helper ───────────────────────────────
  function makeGlowTexture() {
    const size = 128;
    const cvs = document.createElement('canvas');
    cvs.width = size; cvs.height = size;
    const ctx = cvs.getContext('2d');
    const grad = ctx.createRadialGradient(size / 2, size / 2, 0, size / 2, size / 2, size / 2);
    grad.addColorStop(0, 'rgba(79,210,255,1)');
    grad.addColorStop(0.3, 'rgba(45,156,255,0.5)');
    grad.addColorStop(1, 'rgba(0,3,14,0)');
    ctx.fillStyle = grad;
    ctx.fillRect(0, 0, size, size);
    return new THREE.CanvasTexture(cvs);
  }
})();
