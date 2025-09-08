<?php
// home.php
// Optional: block direct access if you only want to use index.php?page=home router
// if (!defined('APP_BOOT')) { header("Location: index.php?page=home"); exit; }

$title = "Home • Battle OP";
require __DIR__ . "/partials/header.php";
?>

<style>
/* ============ HOME PAGE ONLY (no external URLs) ============ */

/* Reset extras for this page */
:root{
  --accent:#ff1e3c;
  --accent2:#ff5a00;
  --bg0:#030308;
  --bg1:#0b0b13;
  --panel:#10101a;
  --text:#ffffff;
  --muted:#9fa3b5;
  --glow: 0 0 25px rgba(255,30,60,.55), 0 0 55px rgba(255,90,0,.25);
}

.home-wrap{
  position:relative;
  min-height:100vh;
  background: radial-gradient(1200px 600px at 20% 10%, rgba(255,30,60,.08), transparent 60%),
              radial-gradient(900px 700px at 80% 20%, rgba(255,90,0,.08), transparent 70%),
              radial-gradient(600px 800px at 50% 110%, rgba(94,0,255,.08), transparent 70%),
              linear-gradient(180deg, #05050a 0%, #05050a 30%, #070712 100%);
  overflow:hidden;
  isolation:isolate;
}

/* Triple canvas background sits under content */
.bg-stage{
  position:absolute; inset:0; z-index:-3;
}
.bg-stage canvas{ position:absolute; inset:0; width:100%; height:100%; display:block; }

/* SVG fx filter used by badges */
svg#fx-defs { position:absolute; width:0; height:0; }

/* Parallax nebula layers (pure CSS gradients) */
.parallax{
  pointer-events:none;
  position:absolute; inset:-10vh -10vw; z-index:-2;
  filter:saturate(110%) blur(0.3px);
}
.parallax .layer{
  position:absolute; inset:0;
  background-repeat:no-repeat;
  animation: drift 40s linear infinite;
  mix-blend-mode:screen;
}
.parallax .l1{
  background-image: radial-gradient(60vw 40vh at 20% 70%, rgba(255,30,60,.12), transparent 70%);
  animation-duration: 55s;
}
.parallax .l2{
  background-image: radial-gradient(40vw 35vh at 80% 30%, rgba(255,90,0,.10), transparent 65%);
  animation-duration: 70s;
}
.parallax .l3{
  background-image: radial-gradient(50vw 50vh at 60% 90%, rgba(94,0,255,.12), transparent 70%);
  animation-duration: 90s;
}
@keyframes drift{
  0%{ transform:translate3d(0,0,0) scale(1); }
  50%{ transform:translate3d(0,-2vh,0) scale(1.02); }
  100%{ transform:translate3d(0,0,0) scale(1); }
}

/* Thin scanlines + subtle noise overlay for “premium” feel */
.scanlines{
  position:absolute; inset:0; z-index:-1; pointer-events:none;
  background:
    linear-gradient(to bottom, rgba(255,255,255,.03) 1px, transparent 1px) 0 0/100% 3px,
    radial-gradient(ellipse at center, rgba(255,255,255,.015), rgba(0,0,0,0) 70%);
  mix-blend-mode:soft-light;
}

/* HERO */
.hero{
  min-height: 88vh;
  display:grid; place-items:center;
  padding: clamp(80px, 8vw, 140px) 24px 24px;
  position:relative;
}
.hero-inner{
  width:min(1200px, 94vw);
  display:grid; gap:28px; text-align:center;
}
.badge-row{
  display:flex; gap:12px; justify-content:center; flex-wrap:wrap;
}
.badge{
  position:relative;
  padding:10px 14px;
  border:1px solid rgba(255,255,255,.08);
  color:var(--muted);
  font-size:13px;
  letter-spacing:.4px;
  border-radius:999px;
  background:linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.02));
  backdrop-filter: blur(6px);
  box-shadow: inset 0 0 0 1px rgba(255,255,255,.06), 0 8px 30px rgba(0,0,0,.35);
  overflow:hidden;
}
.badge::after{
  content:"";
  position:absolute; inset:-2px;
  background:conic-gradient(from var(--a,0deg), rgba(255,30,60,.25), rgba(255,90,0,.25), rgba(94,0,255,.25), rgba(255,30,60,.25));
  filter:blur(18px); opacity:.25; z-index:-1;
  animation: sweep 14s linear infinite;
}
@keyframes sweep{ to{ --a:360deg; } }

.hero h1{
  font-size: clamp(40px, 7vw, 92px);
  line-height: .95;
  letter-spacing:-.02em;
  font-weight:900;
  color:var(--text);
  text-shadow: 0 0 25px rgba(255,30,60,.45), 0 0 70px rgba(255,90,0,.2);
}
.hero .sub{
  color:var(--muted);
  font-size: clamp(15px, 2.1vw, 20px);
  max-width: min(900px, 95vw);
  margin: 0 auto;
}

/* CTA row */
.cta-row{
  margin-top:20px;
  display:flex; gap:14px; justify-content:center; flex-wrap:wrap;
}
.btn{
  --padX: 22px; --padY: 14px;
  display:inline-flex; align-items:center; gap:10px;
  padding: var(--padY) var(--padX);
  border-radius:14px;
  font-weight:800; letter-spacing:.4px;
  text-decoration:none; color:#fff;
  position:relative; overflow:hidden;
  background: linear-gradient(90deg, var(--accent), var(--accent2));
  box-shadow: var(--glow);
  transform: translateZ(0);
}
.btn::before{
  content:"";
  position:absolute; inset:1px;
  border-radius:12px;
  background:linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.0));
}
.btn .dot{
  width:8px; height:8px; border-radius:50%;
  background:#fff; box-shadow:0 0 14px #fff;
}
.btn.secondary{
  background: linear-gradient(90deg, #353545, #191926);
  border:1px solid rgba(255,255,255,.08);
  box-shadow: inset 0 0 0 1px rgba(255,255,255,.04);
}

/* Marquee feature strip */
.marquee{
  margin-top: 36px;
  --h:42px;
  height:var(--h);
  overflow:hidden;
  position:relative;
  mask-image: linear-gradient(90deg, transparent, #000 10%, #000 90%, transparent);
}
.marquee-track{
  display:flex; gap:28px; align-items:center;
  position:absolute; white-space:nowrap;
  will-change:transform;
  animation: run 22s linear infinite;
}
.marquee .chip{
  padding:8px 14px; border-radius:999px;
  border:1px solid rgba(255,255,255,.08);
  background:linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.02));
  color:#d8d9e1; font-size:14px; letter-spacing:.3px;
}
@keyframes run{ from{ transform:translateX(0); } to{ transform:translateX(-50%);} }

/* Stats grid */
.stats{
  margin: clamp(40px,6vw,80px) auto 0;
  width:min(1100px, 94vw);
  display:grid; gap:14px;
  grid-template-columns: repeat(4, 1fr);
}
.stat{
  background: linear-gradient(180deg, #0a0a14, #0d0d18);
  border:1px solid rgba(255,255,255,.08);
  border-radius:16px;
  padding:20px 18px;
  display:grid; gap:2px; place-items:center;
  position:relative; overflow:hidden;
}
.stat::after{
  content:"";
  position:absolute; inset:-30%;
  background: conic-gradient(from var(--rot,0deg),
              rgba(255,30,60,.12), rgba(255,90,0,.1), rgba(94,0,255,.12), rgba(255,30,60,.12));
  filter:blur(24px); z-index:-1; opacity:.28;
  animation: spin 18s linear infinite;
}
@keyframes spin{ to{ --rot:360deg; } }

.stat .num{
  font-size: clamp(28px, 4.5vw, 44px);
  font-weight:900; letter-spacing:.5px; color:#fff;
  text-shadow: var(--glow);
}
.stat .label{
  color:#a9adbf; font-size:13px; letter-spacing:.4px;
}

/* Feature cards row */
.section{
  padding: clamp(60px, 9vw, 120px) 24px;
}
.section h2{
  width:min(1100px, 94vw); margin:0 auto 18px;
  font-size: clamp(28px, 3.8vw, 42px);
  letter-spacing:-.01em; line-height:1.05;
}
.section .lead{
  width:min(900px, 94vw); margin:0 auto 40px; color:#aeb2c5;
}

.cards{
  width:min(1100px, 94vw); margin:0 auto;
  display:grid; gap:18px;
  grid-template-columns: repeat(3, 1fr);
}
.card{
  position:relative; overflow:hidden; border-radius:18px;
  background: linear-gradient(180deg, #0c0c16, #101020);
  border:1px solid rgba(255,255,255,.08);
  min-height:240px;
  box-shadow: 0 20px 80px rgba(0,0,0,.45);
  transition: transform .35s ease, box-shadow .35s ease;
}
.card:hover{ transform: translateY(-6px); box-shadow: 0 30px 120px rgba(0,0,0,.55); }
.card .glow{
  position:absolute; inset:-40%;
  background: radial-gradient(40% 40% at var(--x,50%) var(--y,50%), rgba(255,30,60,.2), transparent 50%),
              radial-gradient(35% 35% at calc(100% - var(--x,50%)) var(--y,50%), rgba(94,0,255,.2), transparent 52%);
  filter: blur(30px); pointer-events:none;
  transition: opacity .3s; opacity:.4;
}
.card-content{
  position:relative; padding:24px; display:grid; gap:12px;
}
.card h3{ font-size:22px; }
.card p { color:#aeb2c5; }

/* CTA band */
.cta-band{
  width:min(1100px,94vw); margin: clamp(40px, 7vw, 80px) auto 0;
  padding: 20px; border-radius:18px;
  background:
    linear-gradient(180deg, rgba(255,255,255,.065), rgba(255,255,255,.02));
  border:1px solid rgba(255,255,255,.09);
  display:flex; gap:16px; flex-wrap:wrap; align-items:center; justify-content:space-between;
}
.cta-band p{ color:#e8e9f4; font-weight:700; letter-spacing:.3px; }
.cta-actions{ display:flex; gap:12px; flex-wrap:wrap; }

/* Responsive */
@media (max-width: 1024px){
  .stats{ grid-template-columns: repeat(2, 1fr); }
  .cards{ grid-template-columns: 1fr 1fr; }
}
@media (max-width: 640px){
  .stats{ grid-template-columns: 1fr 1fr; }
  .cards{ grid-template-columns: 1fr; }
  .hero h1{ font-size: clamp(36px, 10vw, 60px); }
}

/* Toast for download */
.toast{
  position:fixed; right:18px; bottom:18px; z-index:9999;
  padding:14px 16px; border-radius:12px;
  background:#131320; color:#fff; border:1px solid rgba(255,255,255,.1);
  box-shadow:0 10px 40px rgba(0,0,0,.35);
  display:flex; gap:10px; align-items:center; transform: translateY(20px);
  opacity:0; pointer-events:none; transition: .35s ease;
}
.toast.show{ transform: translateY(0); opacity:1; pointer-events:auto; }
.toast .dot{ width:10px; height:10px; border-radius:50%; background:var(--accent); box-shadow:0 0 12px var(--accent); }

/* Confetti canvas */
#confetti{ position: fixed; inset:0; pointer-events:none; z-index:999; }
</style>

<svg id="fx-defs" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <filter id="goo">
      <feGaussianBlur in="SourceGraphic" stdDeviation="6" result="blur"/>
      <feColorMatrix in="blur" mode="matrix"
        values="1 0 0 0 0
                0 1 0 0 0
                0 0 1 0 0
                0 0 0 18 -8" result="goo"/>
      <feBlend in="SourceGraphic" in2="goo"/>
    </filter>
  </defs>
</svg>

<div class="home-wrap">

  <!-- animated canvases -->
  <div class="bg-stage">
    <canvas id="stars"></canvas>
    <canvas id="matrix"></canvas>
    <canvas id="links"></canvas>
  </div>

  <div class="parallax">
    <div class="layer l1"></div>
    <div class="layer l2"></div>
    <div class="layer l3"></div>
  </div>
  <div class="scanlines"></div>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-inner">
      <div class="badge-row" style="filter:url(#goo);">
        <span class="badge">Real Players • Skill Based</span>
        <span class="badge">Lag-free • Anti-Cheat</span>
        <span class="badge">Daily Rewards • 24×7 Support</span>
      </div>

      <h1>BATTLE&nbsp;OP — Enter, <span style="color:var(--accent)">Dominate</span>, Win.</h1>
      <p class="sub">Esports-grade tournaments, instant withdrawals, and a thrilling arena built for champions. A brand-new neon universe that reacts to your moves.</p>

      <div class="cta-row">
        <a href="upload/app.apk" class="btn" id="downloadBtn">
          <span class="dot"></span>*
          DOWNLOAD NOW
        </a>
        <a href="?page=games" class="btn secondary">Explore Games</a>
      </div>

      <div class="marquee" aria-hidden="true">
        <div class="marquee-track" id="marqueeTrack">
          <span class="chip">⚡ Fast Performance</span>
          <span class="chip">🎮 Smooth Gameplay</span>
          <span class="chip">🛡️ Secure & Safe</span>
          <span class="chip">🌍 Global Community</span>
          <span class="chip">💰 Instant Withdraw</span>
          <span class="chip">🎟️ Tournaments Daily</span>

          <!-- duplicate for seamless loop -->
          <span class="chip">⚡ Fast Performance</span>
          <span class="chip">🎮 Smooth Gameplay</span>
          <span class="chip">🛡️ Secure & Safe</span>
          <span class="chip">🌍 Global Community</span>
          <span class="chip">💰 Instant Withdraw</span>
          <span class="chip">🎟️ Tournaments Daily</span>
        </div>
      </div>

      <!-- Live stats -->
      <div class="stats">
        <div class="stat">
          <div class="num" data-count="300000">0</div>
          <div class="label">Registered Players</div>
        </div>
        <div class="stat">
          <div class="num" data-count="9800000">0</div>
          <div class="label">Matches Played</div>
        </div>
        <div class="stat">
          <div class="num" data-count="12000000">0</div>
          <div class="label">Rewards Paid</div>
        </div>
        <div class="stat">
          <div class="num" data-count="24">0</div>
          <div class="label">Support (hrs/day)</div>
        </div>
      </div>
    </div>
  </section>

  <!-- FEATURES GRID -->
  <section class="section">
    <h2>Built for Competitive Glory</h2>
    <p class="lead">Everything you touch responds — lighting, particles, matrices, and a living network of connections. This isn't a template; it's a playground.</p>

    <div class="cards">
      <article class="card">
        <div class="glow"></div>
        <div class="card-content">
          <h3>Elite Tournaments</h3>
          <p>High-stakes brackets, fair matchmaking, and anti-cheat baked into the engine.</p>
        </div>
      </article>

      <article class="card">
        <div class="glow"></div>
        <div class="card-content">
          <h3>Instant Withdraw</h3>
          <p>Skill in. Rewards out. Transparent ledgers, no hidden delays — ever.</p>
        </div>
      </article>

      <article class="card">
        <div class="glow"></div>
        <div class="card-content">
          <h3>Global Community</h3>
          <p>Form squads, climb leaderboards, and make your name echo across the arena.</p>
        </div>
      </article>
    </div>

    <div class="cta-band">
      <p>Ready to claim the arena?</p>
      <div class="cta-actions">
        <a class="btn" href="upload/app.apk" id="downloadBtn2"><span class="dot"></span>DOWNLOAD</a>
        <a class="btn secondary" href="?page=support">Get Support</a>
      </div>
    </div>
  </section>

</div>

<canvas id="confetti"></canvas>

<script>
/* ================== HOME PAGE JS — pure vanilla, no CDNs ================== */

/* Utility */
const clamp = (n, min, max) => Math.max(min, Math.min(max, n));

/* ---------- Canvas 1: Stars + Orbs parallax ---------- */
(function starsScene(){
  const c = document.getElementById('stars');
  const ctx = c.getContext('2d');
  let w, h, dpr;
  let stars = [];
  let orbs = [];
  const STAR_CT = 350, ORB_CT = 22;

  function resize(){
    dpr = Math.min(window.devicePixelRatio||1, 2);
    w = c.width = innerWidth * dpr;
    h = c.height = innerHeight * dpr;
    c.style.width = innerWidth+'px'; c.style.height = innerHeight+'px';
    init();
  }

  function init(){
    stars = []; orbs = [];
    for(let i=0;i<STAR_CT;i++){
      stars.push({
        x: Math.random()*w, y: Math.random()*h,
        r: Math.random()*1.4+0.3, a: Math.random()*1,
        s: Math.random()*0.3+0.05
      });
    }
    for(let i=0;i<ORB_CT;i++){
      orbs.push({
        x: Math.random()*w, y: Math.random()*h,
        r: Math.random()*80+30,
        hue: 350 + Math.random()*40,
        alpha: Math.random()*0.08+0.04,
        vx: (Math.random()-0.5)*0.25, vy:(Math.random()-0.5)*0.25
      });
    }
  }

  function step(t){
    ctx.clearRect(0,0,w,h);

    // softly colored orbs
    for(const o of orbs){
      o.x+=o.vx; o.y+=o.vy;
      if(o.x<-200||o.x>w+200) o.vx*=-1;
      if(o.y<-200||o.y>h+200) o.vy*=-1;
      const g = ctx.createRadialGradient(o.x,o.y,0,o.x,o.y,o.r);
      g.addColorStop(0, `hsla(${o.hue},100%,60%,${o.alpha})`);
      g.addColorStop(1, `hsla(${o.hue},100%,60%,0)`);
      ctx.fillStyle = g;
      ctx.beginPath(); ctx.arc(o.x,o.y,o.r,0,Math.PI*2); ctx.fill();
    }

    // glitter stars
    for(const s of stars){
      s.a += s.s; const tw = (Math.sin(s.a)+1)/2;
      ctx.fillStyle = `rgba(255,255,255,${0.25+tw*0.6})`;
      ctx.beginPath(); ctx.arc(s.x,s.y,s.r,0,Math.PI*2); ctx.fill();
    }

    requestAnimationFrame(step);
  }

  resize(); window.addEventListener('resize', resize);
  requestAnimationFrame(step);
})();

/* ---------- Canvas 2: Matrix rain (diagonal neon) ---------- */
(function matrixScene(){
  const c = document.getElementById('matrix');
  const ctx = c.getContext('2d');
  let w,h,dpr, cols, drops;

  const CHARS = "BATTLEOP0123456789⚡★▲▶◆◼";
  function resize(){
    dpr = Math.min(devicePixelRatio||1, 2);
    w = c.width = innerWidth * dpr;
    h = c.height = innerHeight * dpr;
    c.style.width = innerWidth+'px'; c.style.height = innerHeight+'px';
    const fontSize = 14 * dpr;
    ctx.font = `${fontSize}px monospace`;
    cols = Math.floor(w / (fontSize*0.9));
    drops = Array(cols).fill(0).map(()=> Math.random()*h);
  }
  function step(){
    ctx.fillStyle = "rgba(3,3,10,0.12)";
    ctx.fillRect(0,0,w,h);

    for(let i=0;i<drops.length;i++){
      const text = CHARS[Math.floor(Math.random()*CHARS.length)];
      const x = i*14*dpr, y = drops[i];
      const hue = 5 + (i % 36)*10;
      ctx.fillStyle = `hsla(${hue},100%,60%,0.65)`;
      ctx.fillText(text, x, y);
      drops[i] = y + (10 + (i%3)*2);
      if (y > h + 100) drops[i] = -100;
    }
    requestAnimationFrame(step);
  }

  resize(); addEventListener('resize', resize);
  requestAnimationFrame(step);
})();

/* ---------- Canvas 3: Reactive links network ---------- */
(function linkNet(){
  const c = document.getElementById('links');
  const ctx = c.getContext('2d');
  let w,h,dpr, pts=[];
  const N = 120;

  function resize(){
    dpr = Math.min(devicePixelRatio||1, 2);
    w = c.width = innerWidth*dpr; h = c.height = innerHeight*dpr;
    c.style.width = innerWidth+'px'; c.style.height = innerHeight+'px';
    pts = [];
    for(let i=0;i<N;i++){
      pts.push({
        x: Math.random()*w, y: Math.random()*h,
        vx:(Math.random()-0.5)*0.4, vy:(Math.random()-0.5)*0.4
      });
    }
  }

  let mx = -9999, my = -9999;
  addEventListener('mousemove', e=>{
    const rect = c.getBoundingClientRect();
    mx = (e.clientX - rect.left) * (w/rect.width);
    my = (e.clientY - rect.top)  * (h/rect.height);
  });
  addEventListener('mouseleave', ()=>{ mx=-9999; my=-9999; });

  function step(){
    ctx.clearRect(0,0,w,h);
    for(const p of pts){
      // slight attraction/repulsion to mouse
      const dx = p.x - mx, dy = p.y - my, dist = Math.hypot(dx,dy);
      if(dist < 250){
        const f = (250 - dist)/250;
        p.vx += (dx/dist)*f*0.05;
        p.vy += (dy/dist)*f*0.05;
      }
      p.x += p.vx; p.y += p.vy;
      if(p.x<0||p.x>w) p.vx*=-1;
      if(p.y<0||p.y>h) p.vy*=-1;
    }

    // draw links
    for(let i=0;i<N;i++){
      for(let j=i+1;j<N;j++){
        const a=pts[i], b=pts[j];
        const dx=a.x-b.x, dy=a.y-b.y, d=dx*dx+dy*dy;
        if(d< (180*180)){
          const op = 1 - d/(180*180);
          ctx.strokeStyle = `rgba(255,90,0,${op*0.25})`;
          ctx.lineWidth = 1;
          ctx.beginPath(); ctx.moveTo(a.x, a.y); ctx.lineTo(b.x, b.y); ctx.stroke();
        }
      }
    }
    // nodes
    for(const p of pts){
      ctx.fillStyle = "rgba(255,30,60,.8)";
      ctx.beginPath(); ctx.arc(p.x,p.y,2.2,0,Math.PI*2); ctx.fill();
    }

    requestAnimationFrame(step);
  }

  resize(); addEventListener('resize', resize);
  requestAnimationFrame(step);
})();

/* ---------- Card interactive glow follows cursor ---------- */
document.querySelectorAll('.card').forEach(card=>{
  const glow = card.querySelector('.glow');
  card.addEventListener('pointermove', e=>{
    const r = card.getBoundingClientRect();
    const x = (e.clientX - r.left) / r.width * 100;
    const y = (e.clientY - r.top)  / r.height * 100;
    glow.style.setProperty('--x', x+'%');
    glow.style.setProperty('--y', y+'%');
  });
});

/* ---------- Live number counters ---------- */
(function counters(){
  const nums = [...document.querySelectorAll('.stat .num')];
  let started = false;
  function run(){
    if(started) return;
    const top = document.querySelector('.stats').getBoundingClientRect().top;
    if(top < innerHeight - 80){
      started = true;
      nums.forEach(n=>{
        const target = +n.dataset.count;
        const dur = 1600 + Math.random()*800;
        const t0 = performance.now();
        function tick(t){
          const k = clamp((t - t0)/dur, 0, 1);
          const v = Math.floor(target * (1 - Math.pow(1-k, 3)));
          n.textContent = v.toLocaleString();
          if(k<1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
      });
    }
  }
  addEventListener('scroll', run, {passive:true});
  run();
})();

/* ---------- Marquee speed adjusts to mouse position ---------- */
(function dynamicMarquee(){
  const track = document.getElementById('marqueeTrack');
  let speed = 1;
  addEventListener('mousemove', e=>{
    const r = track.parentElement.getBoundingClientRect();
    const rel = clamp((e.clientX - r.left)/r.width, 0,1);
    speed = 0.5 + rel*1.5;
    track.style.animationDuration = (22/speed)+'s';
  });
})();

/* ---------- Confetti on Download + Toast ---------- */
(function downloads(){
  const confetti = document.getElementById('confetti');
  const ctx = confetti.getContext('2d');
  let w,h,dpr, bits=[];
  function resize(){
    dpr = Math.min(devicePixelRatio||1,2);
    w = confetti.width = innerWidth*dpr; h = confetti.height = innerHeight*dpr;
    confetti.style.width = innerWidth+'px'; confetti.style.height = innerHeight+'px';
  }
  function burst(x,y){
    bits = [];
    const N = 160;
    for(let i=0;i<N;i++){
      const ang = Math.random()*Math.PI*2;
      const sp  = Math.random()*6+2;
      bits.push({
        x:x*dpr, y:y*dpr, vx:Math.cos(ang)*sp, vy:Math.sin(ang)*sp,
        g: .15, life: 80+Math.random()*60,
        col: i%3===0?'#ff1e3c':(i%3===1?'#ff5a00':'#ffffff')
      });
    }
  }
  function step(){
    ctx.clearRect(0,0,w,h);
    bits.forEach(b=>{
      b.vy += b.g; b.x += b.vx; b.y += b.vy; b.life--;
      ctx.fillStyle = b.col;
      ctx.fillRect(b.x, b.y, 3, 8);
    });
    bits = bits.filter(b=>b.life>0);
    requestAnimationFrame(step);
  }

  function toast(msg){
    let t = document.querySelector('.toast');
    if(!t){
      t = document.createElement('div');
      t.className = 'toast';
      t.innerHTML = `<span class="dot"></span><span class="txt"></span>`;
      document.body.appendChild(t);
    }
    t.querySelector('.txt').textContent = msg;
    t.classList.add('show');
    setTimeout(()=> t.classList.remove('show'), 2500);
  }

  function wire(btn){
    btn?.addEventListener('click', (e)=>{
      const r = btn.getBoundingClientRect();
      burst(r.left + r.width/2, r.top + r.height/2);
      toast('Your download is starting…');
      // Let the anchor navigate normally (it already has href)
    });
  }

  resize(); addEventListener('resize', resize);
  requestAnimationFrame(step);

  wire(document.getElementById('downloadBtn'));
  wire(document.getElementById('downloadBtn2'));
})();

</script>

<?php require __DIR__ . "/partials/footer.php"; ?>
```0