
<?php
  // simple router – default home
  $page = $_GET['page'] ?? 'home';
  $allowed = ['home','games','reviews','about','faq','support'];
  if (!in_array($page,$allowed)) { $page = 'home'; }
?><!DOCTYPE html><html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Battle OP</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
  <?php include __DIR__.'/partials/header.php'; ?>  <main id="content" class="page-wrap">
    <?php include __DIR__ . "/{$page}.php"; ?>
  </main>  <?php include __DIR__.'/partials/footer.php'; ?>  <script src="assets/js/app.js"></script></body>
</html>/* ========================= FILE: /partials/header.php ========================= */

<?php
  $active = $_GET['page'] ?? 'home';
?><header class="site-header">
  <canvas id="bg-stars"></canvas>
  <canvas id="bg-matrix"></canvas>
  <canvas id="bg-links"></canvas>
  <div class="header-inner">
    <a class="brand" href="index.php?page=home" aria-label="Battle OP Home">
      <span class="brand-mark">BO</span>
      <span class="brand-text">Battle <em>OP</em></span>
    </a>
    <button class="nav-toggle" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
    <nav class="nav">
      <a class="nav-link <?= $active==='home'?'active':'' ?>" href="index.php?page=home">Home</a>
      <a class="nav-link <?= $active==='games'?'active':'' ?>" href="index.php?page=games">Games</a>
      <a class="nav-link <?= $active==='reviews'?'active':'' ?>" href="index.php?page=reviews">Reviews</a>
      <a class="nav-link <?= $active==='about'?'active':'' ?>" href="index.php?page=about">About us</a>
      <a class="nav-link <?= $active==='faq'?'active':'' ?>" href="index.php?page=faq">FAQ's</a>
      <a class="nav-link <?= $active==='support'?'active':'' ?>" href="index.php?page=support">Support</a>
    </nav>
    <a class="cta" href="upload/app.apk">DOWNLOAD NOW</a>
  </div>
  <div class="hero">
    <h1 class="title">NEW <span>BATTLE</span> OP</h1>
    <p class="subtitle">Skill-based arenas. Neon speed. Zero lag.</p>
    <div class="cta-row">
      <a class="btn btn-primary" href="upload/app.apk">Download Now</a>
      <a class="btn btn-ghost" href="#features">Explore Features</a>
    </div>
  </div>
</header>/* ========================= FILE: /partials/footer.php ========================= */

<footer class="site-footer">
  <div class="grid">
    <section>
      <h4>Battle OP</h4>
      <p>Competitive, fair and blazing-fast skill games with a taste of neon.</p>
    </section>
    <section>
      <h4>Quick Links</h4>
      <ul>
        <li><a href="index.php?page=home">Home</a></li>
        <li><a href="index.php?page=games">Games</a></li>
        <li><a href="index.php?page=reviews">Reviews</a></li>
      </ul>
    </section>
    <section>
      <h4>Support</h4>
      <ul>
        <li><a href="index.php?page=faq">FAQ</a></li>
        <li><a href="index.php?page=support">Contact</a></li>
      </ul>
    </section>
  </div>
  <div class="copy">© 2025 Battle OP • All rights reserved.</div>
</footer>/* ========================= FILE: /home.php ========================= */

<section class="features" id="features">
  <h2 class="section-title">Features</h2>
  <div class="cards">
    <article class="card">
      <div class="icon">⚡</div>
      <h3>Ultra Performance</h3>
      <p>Engine tuned for 144+ FPS with neon-optimized shaders.</p>
    </article>
    <article class="card">
      <div class="icon">🎮</div>
      <h3>Smooth Gameplay</h3>
      <p>Low-latency rooms, auto-ping routing and smart matchmaking.</p>
    </article>
    <article class="card">
      <div class="icon">💰</div>
      <h3>Free Rewards</h3>
      <p>Daily scratch, quests and seasonal battle-pass bonuses.</p>
    </article>
    <article class="card">
      <div class="icon">🛡️</div>
      <h3>Safe & Secure</h3>
      <p>Client-side obfuscation & server-side fairness checks.</p>
    </article>
  </div>
</section><section class="banner">
  <div class="banner-inner">
    <h2>Only Real Players • Skill Based Games</h2>
    <p>Win with strategy, not luck. Every move counts.</p>
  </div>
</section>/* ========================= FILE: /games.php ========================= */

<section class="page">
  <h2 class="section-title">Games</h2>
  <div class="game-grid">
    <?php for($i=1;$i<=8;$i++): ?>
      <article class="game">
        <div class="thumb">
          <div class="thumb-layer"></div>
          <div class="thumb-layer second"></div>
          <div class="thumb-glow"></div>
        </div>
        <h3>Neon Arena <?= $i ?></h3>
        <p>Fast 5v5 tactical fights with map rotation.</p>
        <div class="row">
          <button class="btn btn-primary">Play</button>
          <button class="btn btn-ghost">Details</button>
        </div>
      </article>
    <?php endfor; ?>
  </div>
</section>/* ========================= FILE: /reviews.php ========================= */

<section class="page">
  <h2 class="section-title">Reviews</h2>
  <div class="reviews">
    <?php
      $items = [
        ['ApexWolf','Absolutely cracked movement. Netcode feels clean.'],
        ['Mira','UI is 🔥 and the frames stay high even on my old laptop.'],
        ['Neo','Ranked feels fair. Love the custom crosshair and FOV options.'],
      ];
      foreach($items as $r): ?>
      <blockquote class="review">
        <p>“<?= htmlspecialchars($r[1]) ?>”</p>
        <footer>— <?= htmlspecialchars($r[0]) ?></footer>
      </blockquote>
    <?php endforeach; ?>
  </div>
</section>/* ========================= FILE: /about.php ========================= */

<section class="page">
  <h2 class="section-title">About Us</h2>
  <p class="lead">We build competitive games that celebrate skill, precision and style. Small team, big heart, pixel-perfect obsession.</p>
  <div class="about-grid">
    <div class="about-card">
      <h3>Mission</h3>
      <p>To craft zero-friction competitive arenas where every player feels powerful and respected.</p>
    </div>
    <div class="about-card">
      <h3>Tech</h3>
      <p>Custom netcode, prediction smoothing, GPU neon shaders and anti-tilt UX.</p>
    </div>
    <div class="about-card">
      <h3>Community</h3>
      <p>Moderation that protects, tournaments that excite, and feedback that shapes our roadmap.</p>
    </div>
  </div>
</section>/* ========================= FILE: /faq.php ========================= */

<section class="page">
  <h2 class="section-title">FAQ</h2>
  <div class="faq">
    <?php
      $faqs = [
        ['Is this pay-to-win?','No. Cosmetics only. All gameplay is skill-based.'],
        ['Minimum specs?','Dual-core CPU, 4GB RAM, iGPU OK. 1GB free storage.'],
        ['How do ranks work?','TrueSkill-like system with decay protection and placement matches.'],
        ['Is cross-platform support available?','Yes, PC + Android with input-based matchmaking.'],
      ];
      foreach($faqs as $i => $f): ?>
      <details class="accordion" <?= $i===0? 'open':'' ?>>
        <summary><?= htmlspecialchars($f[0]) ?></summary>
        <div class="panel"><?= htmlspecialchars($f[1]) ?></div>
      </details>
    <?php endforeach; ?>
  </div>
</section>/* ========================= FILE: /support.php ========================= */

<section class="page">
  <h2 class="section-title">Support</h2>
  <form class="support-form" method="post" action="#" onsubmit="return window.BO.submitSupport(this)">
    <div class="row">
      <label>
        <span>Name</span>
        <input type="text" name="name" required />
      </label>
      <label>
        <span>Email</span>
        <input type="email" name="email" required />
      </label>
    </div>
    <label>
      <span>Topic</span>
      <select name="topic" required>
        <option value="account">Account</option>
        <option value="payment">Payment</option>
        <option value="bug">Bug Report</option>
      </select>
    </label>
    <label>
      <span>Message</span>
      <textarea name="message" rows="6" required></textarea>
    </label>
    <button class="btn btn-primary" type="submit">Send</button>
  </form>
  <div id="support-toast" class="toast" role="status" aria-live="polite"></div>
</section>/* ========================= FILE: /assets/css/style.css ========================= */ :root{ --bg:#000; --txt:#eaeaea; --muted:#9aa0a6; --red:#ff1a3d; --red2:#ff004c; --card:#0b0b0f; --card2:#111218; --glass:rgba(255,255,255,.06); } *{box-sizing:border-box} html,body{height:100%} body{margin:0;font-family:'Poppins',system-ui,Arial,sans-serif;background:var(--bg);color:var(--txt);}

/* ===== Canvas background layers ===== */ #bg-stars,#bg-matrix,#bg-links{position:fixed;inset:0;z-index:-1;display:block;background:transparent} #bg-stars{filter:brightness(0.8)} #bg-links{mix-blend-mode:screen}

/* ===== Header / Hero ===== */ .site-header{position:relative;min-height:88vh;display:grid;grid-template-rows:auto 1fr;} .header-inner{position:sticky;top:0;display:flex;align-items:center;gap:20px;justify-content:space-between;padding:14px 24px;background:linear-gradient( to bottom, rgba(0,0,0,.6), rgba(0,0,0,.2) );backdrop-filter:blur(8px);border-bottom:1px solid #150008;box-shadow:0 8px 30px rgba(255,0,60,.15)} .brand{display:flex;align-items:center;gap:12px;text-decoration:none;color:var(--txt)} .brand-mark{width:38px;height:38px;display:grid;place-items:center;background:radial-gradient(circle at 30% 30%,#ff6a6a,#9b0000 60%,#3b000f 100%);border-radius:12px;box-shadow:0 0 24px #ff0033 inset, 0 0 18px rgba(255,0,64,.6)} .brand-text{font-weight:700;letter-spacing:.5px} .brand-text em{color:var(--red);font-style:normal}

.nav{display:flex;gap:18px} .nav a{color:#d5d5d5;text-decoration:none;font-weight:600;opacity:.9;padding:10px 12px;border-radius:10px;transition:.25s} .nav a:hover{color:#fff;box-shadow:0 0 0 2px rgba(255,0,64,.2),0 0 24px rgba(255,0,64,.25) inset} .nav a.active{color:#fff;background:linear-gradient(180deg,rgba(255,0,64,.18),rgba(255,0,64,.06));box-shadow:0 0 0 1px rgba(255,0,64,.35)}

.nav-toggle{display:none;flex-direction:column;gap:4px;background:transparent;border:0;cursor:pointer} .nav-toggle span{width:26px;height:2px;background:#fff;display:block}

.cta{padding:10px 16px;border-radius:12px;text-decoration:none;color:#fff;background:linear-gradient(90deg,var(--red),var(--red2));box-shadow:0 10px 24px rgba(255,0,64,.35)} .cta:hover{filter:brightness(1.1)}

.hero{display:grid;place-items:center;padding:48px 18px 64px} .title{font-size:clamp(36px,9vw,96px);font-weight:800;letter-spacing:2px;text-align:center;line-height:1.05;text-shadow:0 0 22px rgba(255,0,64,.45)} .title span{color:var(--red)} .subtitle{text-align:center;margin-top:10px;color:#d7d7d7;opacity:.9} .cta-row{display:flex;gap:16px;margin-top:22px} .btn{--pad:14px 20px;--bg:#15151d;border:1px solid #2c2c39;background:var(--bg);padding:var(--pad);border-radius:12px;color:#fff;text-decoration:none;font-weight:700;letter-spacing:.4px;transition:.25s} .btn:hover{box-shadow:0 8px 24px rgba(0,0,0,.45),0 0 0 2px rgba(255,255,255,.05) inset} .btn-primary{--bg:linear-gradient(90deg,var(--red),var(--red2));border-color:#5b0016;box-shadow:0 10px 22px rgba(255,0,64,.35)} .btn-ghost{background:rgba(255,255,255,.02)}

/* ===== Sections ===== */ .section-title{text-align:center;font-size:clamp(28px,5vw,44px);margin:48px auto 22px;color:#fff;text-shadow:0 0 12px rgba(255,0,64,.2)} .page-wrap{isolation:isolate}

.features{padding:20px 16px 80px} .cards{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:22px} .card{background:linear-gradient(180deg,#0b0b12,#0f0f16);border:1px solid #1f1f2a;border-radius:16px;padding:24px;min-height:180px;display:grid;align-content:start;gap:8px;box-shadow:0 10px 40px rgba(0,0,0,.35)} .card .icon{font-size:34px;filter:drop-shadow(0 0 12px rgba(255,0,64,.3))} .card h3{margin:6px 0 2px} .card p{color:#c9c9cf} .card:hover{transform:translateY(-4px);box-shadow:0 18px 50px rgba(255,0,64,.15)}

.banner{margin:36px 0 60px} .banner-inner{max-width:1100px;margin:0 auto;background:radial-gradient( 1200px 200px at 50% -100px, rgba(255,0,64,.35), transparent 60% ), linear-gradient(180deg,#0c0c12,#0b0b12);border:1px solid #2a0a18;padding:40px 28px;border-radius:20px;text-align:center;box-shadow:0 20px 80px rgba(255,0,64,.1)} .banner-inner h2{margin:0 0 6px;color:#fff} .banner-inner p{color:#d1d1d6}

/* Games grid */ .page{padding:28px 16px 80px;max-width:1200px;margin:0 auto} .game-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:22px} .game{background:linear-gradient(180deg,#0b0b12,#0f0f16);border:1px solid #1f1f2a;border-radius:16px;padding:18px;display:grid;gap:10px} .thumb{height:150px;border-radius:12px;position:relative;overflow:hidden;background:#0d0d14;border:1px solid #221} .thumb-layer{position:absolute;inset:-25% -25% -25% -25%;background:repeating-linear-gradient(45deg,rgba(255,0,64,.22) 0 2px, transparent 2px 18px);filter:blur(8px);animation:slide 16s linear infinite} .thumb-layer.second{animation-direction:reverse;opacity:.6} .thumb-glow{position:absolute;inset:-60%;background:radial-gradient(circle at var(--x,30%) var(--y,70%), rgba(255,0,64,.35), transparent 40%)} @keyframes slide{to{transform:translateY(-30% ) rotate(15deg)}} .game .row{display:flex;gap:10px}

/* Reviews */ .reviews{display:grid;grid-template-columns:repeat(3,1fr);gap:18px} .review{background:linear-gradient(180deg,#0b0b12,#0f0f16);border:1px solid #1f1f2a;border-radius:16px;padding:18px;font-size:18px;box-shadow:0 10px 40px rgba(0,0,0,.35)} .review footer{opacity:.8;margin-top:8px;color:#d1d1d6}

/* About */ .lead{max-width:900px;margin:0 auto 26px;text-align:center;color:#d1d1d6} .about-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px} .about-card{background:linear-gradient(180deg,#0b0b12,#0f0f16);border:1px solid #1f1f2a;border-radius:16px;padding:18px;color:#d1d1d6}

/* FAQ */ .accordion{background:linear-gradient(180deg,#0b0b12,#0f0f16);border:1px solid #1f1f2a;border-radius:14px;margin:10px 0;overflow:hidden} .accordion>summary{cursor:pointer;list-style:none;padding:16px 18px;font-weight:700} .accordion>summary::-webkit-details-marker{display:none} .accordion .panel{padding:0 18px 16px;color:#cfcfd5}

/* Support form */ .support-form{max-width:900px;margin:0 auto;display:grid;gap:14px} .support-form .row{display:grid;grid-template-columns:1fr 1fr;gap:14px} .support-form input,.support-form textarea,.support-form select{width:100%;padding:12px 14px;border-radius:12px;border:1px solid #282838;background:#0c0c12;color:#fff;outline:0} .support-form input:focus,.support-form textarea:focus,.support-form select:focus{box-shadow:0 0 0 2px rgba(255,0,64,.35)} .toast{position:fixed;right:18px;bottom:18px;background:linear-gradient(90deg,#101016,#181826);border:1px solid #2a2a3a;color:#fff;padding:14px 16px;border-radius:12px;opacity:0;pointer-events:none;transform:translateY(8px);transition:.3s} .toast.show{opacity:1;transform:translateY(0)}

/* Footer */ .site-footer{border-top:1px solid #1a0a12;margin-top:40px;background:linear-gradient(180deg,#09090c,#0b0b0f)} .site-footer .grid{max-width:1100px;margin:0 auto;display:grid;grid-template-columns:2fr 1fr 1fr;gap:18px;padding:28px 16px} .site-footer a{color:#d6d6da;text-decoration:none} .copy{text-align:center;color:#a9a9b2;padding:12px 16px;border-top:1px solid #120812}

/* Responsive */ @media (max-width: 1024px){ .cards,.game-grid,.reviews,.about-grid{grid-template-columns:repeat(2,1fr)} } @media (max-width: 720px){ .nav{display:none;position:absolute;top:60px;right:16px;flex-direction:column;background:#0d0d14;border:1px solid #221;border-radius:12px;padding:10px;box-shadow:0 10px 40px rgba(0,0,0,.45)} .nav.show{display:flex} .nav-toggle{display:flex} .cards,.game-grid,.reviews,.about-grid{grid-template-columns:1fr} .support-form .row{grid-template-columns:1fr} }

/* ========================= FILE: /assets/js/app.js ========================= */ window.BO = (function(){ const $$ = (sel, root=document) => root.querySelector(sel); const $$$ = (sel, root=document) => Array.from(root.querySelectorAll(sel));

// Mobile nav const toggle = $$('.nav-toggle'); const nav = $$('.nav'); if(toggle){ toggle.addEventListener('click', ()=>{ const open = nav.classList.toggle('show'); toggle.setAttribute('aria-expanded', open); }); }

// Active nav highlighting handled in PHP; but also handle client-side scroll to features $$$('a[href^="#"]').forEach(a=>{ a.addEventListener('click', e=>{ const id = a.getAttribute('href'); if(id.startsWith('#')){ e.preventDefault(); document.querySelector(id)?.scrollIntoView({behavior:'smooth'}); } }); });

// ====== Backgrounds ====== // Stars/orbs const stars = document.getElementById('bg-stars'); const sctx = stars.getContext('2d'); const matrix = document.getElementById('bg-matrix'); const mctx = matrix.getContext('2d'); const links = document.getElementById('bg-links'); const lctx = links.getContext('2d');

function sizeCanvases(){ [stars,matrix,links].forEach(c=>{c.width = window.innerWidth; c.height = window.innerHeight;}); } sizeCanvases(); window.addEventListener('resize', sizeCanvases);

// Orbs + stars let dots = []; const DOTS = 120; function makeDots(){ dots = Array.from({length: DOTS}, ()=>({ x: Math.random()*stars.width, y: Math.random()*stars.height, r: Math.random()*2+0.4, vx: (Math.random()-.5)*0.3, vy: (Math.random()-.5)*0.3, glow: Math.random()*0.6+0.2 })); } makeDots();

// Matrix rain const letters = 'アカサタナハマヤラワ0123456789ABCDEFXYZ'; let columns, drops; function initMatrix(){ columns = Math.floor(matrix.width/14); drops = Array(columns).fill(1); } initMatrix();

// Link network let nodes = []; function makeNodes(){ nodes = Array.from({length: 60}, ()=>({ x: Math.random()*links.width, y: Math.random()*links.height, vx: (Math.random()-.5)*0.6, vy: (Math.random()-.5)*0.6 })); } makeNodes();

function draw(){ // Stars layer sctx.clearRect(0,0,stars.width,stars.height); dots.forEach(d=>{ d.x += d.vx; d.y += d.vy; if(d.x<0||d.x>stars.width) d.vx*=-1; if(d.y<0||d.y>stars.height) d.vy*=-1; sctx.beginPath(); sctx.arc(d.x,d.y,d.r,0,Math.PI*2); sctx.fillStyle = rgba(255,255,255,${0.5+d.glow}); sctx.shadowBlur = 12; sctx.shadowColor = 'rgba(255,0,64,0.45)'; sctx.fill(); });

// Matrix layer
mctx.fillStyle = 'rgba(0,0,0,0.08)';
mctx.fillRect(0,0,matrix.width,matrix.height);
mctx.fillStyle = 'rgba(255,0,80,0.75)';
mctx.font = '14px monospace';
for(let i=0;i<drops.length;i++){
  const txt = letters[Math.floor(Math.random()*letters.length)];
  mctx.fillText(txt, i*14, drops[i]*14);
  if(drops[i]*14 > matrix.height && Math.random()>0.975) drops[i]=0;
  drops[i]++;
}

// Links layer
lctx.clearRect(0,0,links.width,links.height);
for(let i=0;i<nodes.length;i++){
  const n = nodes[i];
  n.x += n.vx; n.y += n.vy;
  if(n.x<0||n.x>links.width) n.vx*=-1;
  if(n.y<0||n.y>links.height) n.vy*=-1;
  for(let j=i+1;j<nodes.length;j++){
    const m = nodes[j];
    const dx=n.x-m.x, dy=n.y-m.y; const d=Math.hypot(dx,dy);
    if(d<140){
      lctx.strokeStyle = `rgba(255,0,64,${1 - d/140})`;
      lctx.lineWidth = 1;
      lctx.beginPath(); lctx.moveTo(n.x,n.y); lctx.lineTo(m.x,m.y); lctx.stroke();
    }
  }
}

requestAnimationFrame(draw);

} draw();

// Parallax glow on game thumbs $$$('.thumb').forEach(t=>{ t.addEventListener('mousemove', e=>{ const r = t.getBoundingClientRect(); const x = ((e.clientX - r.left)/r.width100).toFixed(2); const y = ((e.clientY - r.top)/r.height100).toFixed(2); t.style.setProperty('--x', x+'%'); t.style.setProperty('--y', y+'%'); }); });

// Support form fake submit function submitSupport(form){ const toast = document.getElementById('support-toast'); toast.textContent = 'Thanks! Your message has been received. We'll reply within 24h.'; toast.classList.add('show'); setTimeout(()=>toast.classList.remove('show'), 3000); form.reset(); return false; // prevent navigation }

return { submitSupport }; })();

