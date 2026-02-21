<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Spin to Login</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;600&display=swap" rel="stylesheet">
<style>
  :root {
    --bg: #0d0d0f;
    --surface: #18181c;
    --border: #2a2a30;
    --accent: #f5c842;
    --accent2: #ff6b35;
    --text: #f0f0f0;
    --muted: #666;
    --success: #22c55e;
    --error: #ef4444;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    background: var(--bg);
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    gap: 1.5rem;
    background-image:
      radial-gradient(ellipse at 15% 15%, #1a1a2e 0%, transparent 55%),
      radial-gradient(ellipse at 85% 85%, #1c1208 0%, transparent 55%);
  }

  h1 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 2.6rem;
    letter-spacing: 0.2em;
    color: var(--accent);
    text-shadow: 0 0 30px rgba(245,200,66,0.3);
  }

  /* ── LAYOUT ── */
  .layout {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    justify-content: center;
    align-items: flex-start;
    width: 100%;
    max-width: 860px;
  }

  /* ── WHEEL ── */
  .wheel-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
  }

  .wheel-container {
    position: relative;
    width: 300px;
    height: 300px;
  }

  canvas {
    border-radius: 50%;
    box-shadow: 0 0 50px rgba(245,200,66,0.12), 0 0 0 4px #222;
  }

  .pointer {
    position: absolute;
    top: -16px;
    left: 50%;
    transform: translateX(-50%);
    width: 0; height: 0;
    border-left: 12px solid transparent;
    border-right: 12px solid transparent;
    border-top: 26px solid var(--accent);
    filter: drop-shadow(0 2px 8px rgba(245,200,66,0.7));
    z-index: 10;
  }

  .landed-char {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 3rem;
    color: var(--accent);
    letter-spacing: 0.1em;
    min-height: 3.5rem;
    text-shadow: 0 0 20px rgba(245,200,66,0.5);
    text-align: center;
  }

  /* wheel action buttons */
  .wheel-btns {
    display: flex;
    gap: 0.7rem;
  }

  /* ── LOGIN PANEL ── */
  .login-panel {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: 16px;
    padding: 2rem 1.8rem;
    width: 300px;
    display: flex;
    flex-direction: column;
    gap: 1.2rem;
  }

  .panel-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.6rem;
    letter-spacing: 0.15em;
    color: var(--text);
    text-align: center;
  }

  .field-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 0.35rem;
  }

  .field-wrap {
    position: relative;
  }

  .field-input {
    width: 100%;
    background: #111113;
    border: 1.5px solid var(--border);
    border-radius: 8px;
    padding: 0.7rem 2.8rem 0.7rem 1rem;
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    font-size: 1rem;
    outline: none;
    cursor: default;
    caret-color: var(--accent);
    letter-spacing: 0.05em;
    transition: border-color 0.2s;
  }

  .field-input.active {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(245,200,66,0.1);
  }

  .field-active-dot {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 8px; height: 8px;
    border-radius: 50%;
    background: var(--accent);
    display: none;
  }

  .field-input.active + .field-active-dot { display: block; }

  /* field selector tabs */
  .field-tabs {
    display: flex;
    gap: 0.5rem;
  }

  .field-tab {
    flex: 1;
    padding: 0.5rem;
    border-radius: 7px;
    border: 1.5px solid var(--border);
    background: transparent;
    color: var(--muted);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    transition: all 0.15s;
  }

  .field-tab.active {
    background: rgba(245,200,66,0.1);
    border-color: var(--accent);
    color: var(--accent);
  }

  .hint {
    font-size: 0.75rem;
    color: var(--muted);
    text-align: center;
    line-height: 1.5;
  }

  /* message */
  .msg {
    padding: 0.6rem 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    text-align: center;
    display: none;
  }
  .msg.success { background: rgba(34,197,94,0.12); border: 1px solid var(--success); color: var(--success); display: block; }
  .msg.error   { background: rgba(239,68,68,0.12);  border: 1px solid var(--error);   color: var(--error);   display: block; }

  /* ── BUTTONS ── */
  .btn {
    padding: 0.65rem 1.3rem;
    border: none;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: opacity 0.2s, transform 0.1s;
    letter-spacing: 0.03em;
  }
  .btn:active { transform: scale(0.95); }
  .btn:disabled { opacity: 0.3; cursor: not-allowed; transform: none; }

  .btn-spin  { background: var(--accent); color: #000; font-family: 'Bebas Neue', sans-serif; font-size: 1.05rem; letter-spacing: 0.1em; padding: 0.65rem 1.8rem; }
  .btn-add   { background: #22221a; border: 1.5px solid #3a3820; color: var(--accent); }
  .btn-bs    { background: #1c1010; border: 1.5px solid #3a1f10; color: var(--accent2); }
  .btn-login { width: 100%; background: var(--accent); color: #000; font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem; letter-spacing: 0.15em; padding: 0.8rem; }
  .btn-reset { width: 100%; background: transparent; border: 1px solid var(--border); color: var(--muted); margin-top: -0.5rem; }
</style>
</head>
<body>

<div class="layout">

  <!-- Wheel -->
  <div class="wheel-section">
    <div class="wheel-container">
      <div class="pointer"></div>
      <canvas id="wheel" width="300" height="300"></canvas>
    </div>

    <div class="landed-char" id="landedChar">?</div>

    <div class="wheel-btns">
      <button class="btn btn-spin" id="spinBtn">SPIN</button>
      <button class="btn btn-add"  id="addBtn"  disabled>+ Add</button>
      <button class="btn btn-bs"   id="bsBtn"> ⌫</button>
    </div>
  </div>

  <!-- Login Panel -->
  <div class="login-panel">
    <div class="panel-title">Login</div>

    <!-- Field selector -->
    <div>
      <div class="field-tabs">
        <button class="field-tab active" id="tab-user" onclick="setActive('username')">Username</button>
        <button class="field-tab"        id="tab-pass" onclick="setActive('password')">Password</button>
      </div>
    </div>

    <!-- Username -->
    <div>
      <div class="field-label">Username</div>
      <div class="field-wrap">
        <input class="field-input active" id="usernameInput">
        <span class="field-active-dot"></span>
      </div>
    </div>

    <!-- Password -->
    <div>
      <div class="field-label">Password</div>
      <div class="field-wrap">
        <input class="field-input" id="passwordInput" type="password">
        <span class="field-active-dot"></span>
      </div>
    </div>

    <div class="msg" id="msg"></div>

    <button class="btn btn-login" id="loginBtn">LOGIN</button>
    <button class="btn btn-reset" id="resetBtn">Reset Fields</button>
  </div>

</div>

<script>
  // ── Demo credentials ──
  const VALID_USER = 'admin';
  const VALID_PASS = 'pass123';

  // ── State ──
  const CHARS = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.split('');
  let spinning    = false;
  let currentAngle = 0;
  let landedChar  = null;
  let activeField = 'username'; // 'username' | 'password'

  // actual stored values (since password input masks)
  const fieldValues = { username: '', password: '' };

  const canvas    = document.getElementById('wheel');
  const ctx       = canvas.getContext('2d');
  const landedEl  = document.getElementById('landedChar');
  const addBtn    = document.getElementById('addBtn');
  const spinBtn   = document.getElementById('spinBtn');
  const bsBtn     = document.getElementById('bsBtn');
  const loginBtn  = document.getElementById('loginBtn');
  const resetBtn  = document.getElementById('resetBtn');
  const msgEl     = document.getElementById('msg');

  // Block physical keyboard
  document.addEventListener('keydown', e => e.preventDefault());

  // ── Field switching ──
  function setActive(field) {
    activeField = field;
    document.getElementById('usernameInput').classList.toggle('active', field === 'username');
    document.getElementById('passwordInput').classList.toggle('active', field === 'password');
    document.getElementById('tab-user').classList.toggle('active', field === 'username');
    document.getElementById('tab-pass').classList.toggle('active', field === 'password');
    hideMsg();
  }

  // ── Draw wheel ──
  const COLORS = [
    '#f5c842','#ff6b35','#7c3aed','#059669','#e11d48','#0284c7',
    '#d97706','#16a34a','#9333ea','#dc2626','#0891b2','#b45309'
  ];

  function drawWheel(highlightIdx = -1) {
    const cx = 150, cy = 150, r = 142;
    const n = CHARS.length;
    const slice = (Math.PI * 2) / n;

    ctx.clearRect(0, 0, 300, 300);

    CHARS.forEach((ch, i) => {
      const start = currentAngle + i * slice;
      const end   = start + slice;

      ctx.beginPath();
      ctx.moveTo(cx, cy);
      ctx.arc(cx, cy, r, start, end);
      ctx.closePath();
      ctx.fillStyle = highlightIdx === i ? '#fff' : COLORS[i % COLORS.length];
      ctx.fill();
      ctx.strokeStyle = '#0d0d0f';
      ctx.lineWidth = 1.5;
      ctx.stroke();

      // label
      ctx.save();
      ctx.translate(cx, cy);
      ctx.rotate(start + slice / 2);
      ctx.textAlign = 'right';
      ctx.fillStyle = highlightIdx === i ? '#000' : 'rgba(0,0,0,0.85)';
      ctx.font = 'bold 11px DM Sans';
      ctx.fillText(ch, r - 6, 4);
      ctx.restore();
    });

    // center cap
    ctx.beginPath();
    ctx.arc(cx, cy, 18, 0, Math.PI * 2);
    ctx.fillStyle = '#0d0d0f';
    ctx.fill();
    ctx.strokeStyle = '#f5c842';
    ctx.lineWidth = 2;
    ctx.stroke();
  }

  // ── Spin ──
  spinBtn.addEventListener('click', () => {
    if (spinning) return;
    spinning = true;
    landedChar = null;
    addBtn.disabled = true;
    landedEl.textContent = '…';
    hideMsg();

    const extra = Math.PI * 2 * (10 + Math.floor(Math.random() * 8));
    const landOffset = Math.random() * Math.PI * 2;
    const total = extra + landOffset;
    const duration = 3000 + Math.random() * 1200;
    const startAngle = currentAngle;
    const startTime = performance.now();

    function ease(t) { return 1 - Math.pow(1 - t, 4); }

    function animate(now) {
      const t = Math.min((now - startTime) / duration, 1);
      currentAngle = startAngle + total * ease(t);
      drawWheel();

      if (t < 1) {
        requestAnimationFrame(animate);
      } else {
        currentAngle = startAngle + total;
        const slice = (Math.PI * 2) / CHARS.length;
        // pointer at top = -π/2
        const norm = (((-currentAngle - Math.PI / 2) % (Math.PI * 2)) + Math.PI * 2) % (Math.PI * 2);
        const idx = Math.floor(norm / slice) % CHARS.length;
        drawWheel(idx);
        landedChar = CHARS[idx];
        landedEl.textContent = landedChar;
        addBtn.disabled = false;
        spinning = false;
      }
    }

    requestAnimationFrame(animate);
  });

  // ── Add char to active field ──
  addBtn.addEventListener('click', () => {
    if (!landedChar) return;
    if (fieldValues[activeField].length >= 30) return;
    fieldValues[activeField] += landedChar;
    updateFieldDisplay();
    // reset so user must spin again
    landedChar = null;
    landedEl.textContent = '?';
    addBtn.disabled = true;
  });

  // ── Backspace ──
  bsBtn.addEventListener('click', () => {
    fieldValues[activeField] = fieldValues[activeField].slice(0, -1);
    updateFieldDisplay();
    hideMsg();
  });

  function updateFieldDisplay() {
    document.getElementById('usernameInput').value = fieldValues.username;
    // password field shows masked automatically via type="password"
    document.getElementById('passwordInput').value = fieldValues.password;
  }

  // ── Login ──
  loginBtn.addEventListener('click', () => {
    const u = fieldValues.username;
    const p = fieldValues.password;
    if (!u || !p) {
      showMsg('Fill in both fields first.', 'error'); return;
    }
    if (u.toLowerCase() === VALID_USER && p.toLowerCase() === VALID_PASS) {
      showMsg('Login successful! Welcome, ' + u + '!', 'success');
    } else {
      showMsg('❌ Invalid username or password.', 'error');
    }
  });

  // ── Reset ──
  resetBtn.addEventListener('click', () => {
    fieldValues.username = '';
    fieldValues.password = '';
    updateFieldDisplay();
    landedChar = null;
    landedEl.textContent = '?';
    addBtn.disabled = true;
    hideMsg();
  });

  function showMsg(text, type) {
    msgEl.textContent = text;
    msgEl.className = 'msg ' + type;
  }
  function hideMsg() { msgEl.className = 'msg'; }

  // ── Init ──
  drawWheel();
</script>
</body>
</html>
