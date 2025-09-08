<?php
// about.php
$title = "About • Battle OP";
require __DIR__ . "/partials/header.php";
?>

<style>
/* ===================== ABOUT PAGE (Unique) ===================== */
:root{
  --bg:#07070c;
  --panel:#0e0f17;
  --panel2:#131422;
  --text:#eef1ff;
  --muted:#9aa0b5;
  --accent:#ff1744;
  --accent2:#ff6a00;
  --line:#23253a;
}
*{box-sizing:border-box}
.about-root{
  position:relative; color:var(--text); overflow:hidden;
  background: radial-gradient(60% 120% at 50% 0%, #0b0b16 0%, #06060a 60%);
}
.back-canvas{ position:fixed; inset:0; z-index:-3; }
.back-canvas canvas{ width:100%; height:100%; display:block; }
.grid-overlay{
  position:fixed; inset:0; background:
   linear-gradient(transparent 31px,#0a0b14 32px),
   linear-gradient(90deg,transparent 31px,#0a0b14 32px);
  background-size:32px 32px;
  opacity:.12; z-index:-2;
}

/* -------------------- HERO -------------------- */
.hero-wrap{
  min-height:78vh; display:grid; grid-template-columns:1.2fr .8fr; gap:28px;
  width:min(1200px,94vw); margin:0 auto; align-items:center; padding:100px 0 40px;
}
.hero-left h1{
  font-size: clamp(42px, 6vw, 78px);
  line-height:1.02; letter-spacing:-.5px; margin:0 0 16px 0;
  text-shadow:0 0 24px rgba(255,23,68,.25), 0 0 60px rgba(255,23,68,.12);
}
.hero-left p{ color:var(--muted); font-size:18px; max-width:700px }
.hero-cta{ margin-top:22px; display:flex; gap:12px; flex-wrap:wrap }
.btn{
  background:linear-gradient(135deg,var(--accent),var(--accent2));
  border:none; color:#fff; padding:13px 20px; border-radius:12px; font-weight:700; cursor:pointer;
  box-shadow:0 6px 24px rgba(255,40,40,.35);
  transition:transform .18s ease, box-shadow .18s ease, filter .18s ease;
}
.btn:hover{ transform:translateY(-2px); filter:saturate(1.15); box-shadow:0 10px 34px rgba(255,40,40,.45) }
.btn.ghost{ background:#15172a; border:1px solid #2b2e47; box-shadow:none }
.hero-right{
  position:relative; height:480px; display:flex; align-items:center; justify-content:center;
}
.blob{
  width: 420px; height:420px; filter: drop-shadow(0 10px 50px rgba(255,23,68,.25));
}
.hero-ring{
  position:absolute; width:520px; height:520px; border:1px dashed #2b2d48; border-radius:50%;
  animation:spin 24s linear infinite; opacity:.5;
}
.hero-ring.r2{ width:580px; height:580px; animation-duration: 32s; opacity:.35 }
@keyframes spin{ to{ transform:rotate(360deg) } }

/* -------------------- MARQUEE -------------------- */
.marquee{
  border-top:1px solid var(--line); border-bottom:1px solid var(--line);
  background:linear-gradient(180deg,#0b0c14, #0a0a13);
  overflow:hidden; white-space:nowrap; position:relative;
}
.marquee .track{
  display:inline-block; padding:14px 0; animation: slide 18s linear infinite;
}
.marquee .pill{
  display:inline-flex; align-items:center; gap:10px; color:#cfd3ea;
  border:1px solid #232640; padding:8px 14px; margin:0 10px; border-radius:999px;
  background:#0e1022;
}
.pill i{ font-style:normal; color:var(--accent) }
@keyframes slide{
  0%{ transform:translateX(0) } 100%{ transform:translateX(-50%) }
}

/* -------------------- STATS -------------------- */
.stats{
  width:min(1200px,94vw); margin:42px auto; display:grid; grid-template-columns:repeat(4,1fr); gap:16px;
}
.stat{
  background:var(--panel); border:1px solid var(--line); border-radius:14px; padding:22px;
  display:grid; gap:6px; place-content:center; text-align:center; position:relative; overflow:hidden;
}
.stat::after{
  content:""; position:absolute; inset:-2px; border-radius:16px; padding:2px;
  background:conic-gradient(from 180deg,rgba(255,23,68,.4),transparent 30%, transparent 70%, rgba(255,106,0,.4));
  -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0); -webkit-mask-composite: xor; mask-composite: exclude;
  opacity:.35; pointer-events:none;
}
.stat .num{ font-size:42px; font-weight:800; text-shadow:0 0 30px rgba(255,23,68,.25) }
.stat .lbl{ color:var(--muted) }

/* -------------------- STORY / TIMELINE -------------------- */
.story{
  width:min(1100px,92vw); margin:40px auto; display:grid; grid-template-columns: 1fr; gap:18px;
}
.story h2{ font-size:34px; margin:6px 0 10px 0 }
.timeline{
  position:relative; padding-left:26px; border-left:2px dashed #272a44;
}
.milestone{
  margin:18px 0; background:var(--panel2); border:1px solid var(--line); border-radius:12px; padding:16px 16px 12px;
  position:relative; overflow:hidden; transition:transform .2s ease, box-shadow .2s ease;
}
.milestone:hover{ transform:translateY(-2px); box-shadow:0 10px 26px rgba(0,0,0,.35) }
.milestone::before{
  content:""; position:absolute; left:-31px; top:18px; width:16px; height:16px; border-radius:50%;
  border:3px solid #343b6a; background:radial-gradient(#fff,#ff5f7a);
}
.ms-head{ display:flex; align-items:center; gap:10px; font-weight:700 }
.ms-year{ color:#ff5c7f; font-family:monospace }
.ms-body{ color:#cbd1ea; margin-top:8px; max-height:0; overflow:hidden; transition:max-height .35s ease }
.milestone.open .ms-body{ max-height:260px }
.ms-toggle{ margin-left:auto; color:#9aa0bd; cursor:pointer; user-select:none }

/* -------------------- TEAM -------------------- */
.team{
  width:min(1150px,94vw); margin:40px auto; display:grid; grid-template-columns:repeat(3,1fr); gap:18px;
}
.card{
  background:linear-gradient(180deg,#0e0f19,#0a0b14); border:1px solid var(--line); border-radius:16px; padding:18px;
  transform-style:preserve-3d; perspective:900px; transition:box-shadow .2s; position:relative; overflow:hidden;
}
.card:hover{ box-shadow:0 16px 36px rgba(0,0,0,.45) }
.card .tag{
  position:absolute; top:12px; left:12px; background:#141731; border:1px solid #2b2f53; color:#cdd3f7; font-size:12px;
  padding:4px 8px; border-radius:999px;
}
.avatar{
  height:120px; width:120px; border-radius:16px; background:
   radial-gradient(circle at 30% 30%, #ff9aa7, #ff1744 60%);
  margin-bottom:10px; transform:translateZ(40px);
}
.card h4{ margin:0; font-size:20px; transform:translateZ(40px) }
.card p.role{ color:#ff9ea6; margin:4px 0 10px 0; transform:translateZ(30px) }
.card .bio{ color:#c9cfe9; font-size:14px; transform:translateZ(20px) }
.card .links{ margin-top:12px; display:flex; gap:8px; }
.card .links a{
  padding:6px 10px; border-radius:10px; font-size:12px; border:1px solid #2e345c; color:#dfe3ff; text-decoration:none;
  background:#121530;
}
.card:hover .avatar{ filter:saturate(1.25) }

/* -------------------- TECH CHART -------------------- */
.tech{
  width:min(1100px,92vw); margin:50px auto; display:grid; grid-template-columns:1fr 1fr; gap:18px;
}
.panel{
  background:var(--panel); border:1px solid var(--line); border-radius:14px; padding:18px;
}
.panel h3{ margin:0 0 8px 0 }
.chart-wrap{ height:320px; position:relative }
.chart-wrap canvas{ width:100%; height:100%; }

/* -------------------- VALUES -------------------- */
.values{
  width:min(1150px,94vw); margin:40px auto; display:grid; grid-template-columns:repeat(4,1fr); gap:16px;
}
.value{
  background:var(--panel2); border:1px solid var(--line); border-radius:14px; padding:16px; position:relative; overflow:hidden;
}
.value::after{
  content:""; position:absolute; inset:0; pointer-events:none;
  background: radial-gradient(600px 120px at var(--mx,50%) var(--my,50%), rgba(255,23,68,.22), transparent 60%);
  mix-blend-mode:screen; transition: .08s linear;
}
.value h4{ margin:4px 0 6px 0 }
.value p{ color:var(--muted); font-size:14px }

/* -------------------- CTA STRIP -------------------- */
.cta{
  margin:60px auto 80px; width:min(1100px,92vw);
  background:linear-gradient(135deg,#16172a,#0b0c16); border:1px solid var(--line); border-radius:16px;
  padding:24px; display:flex; align-items:center; justify-content:space-between; gap:14px;
}
.cta .txt{max-width:700px}
.cta h3{ margin:0 0 6px 0 }
.cta .actions{ display:flex; gap:10px; flex-wrap:wrap }

/* -------------------- RESPONSIVE -------------------- */
@media (max-width: 980px){
  .hero-wrap{ grid-template-columns:1fr; text-align:center }
  .hero-right{ order:-1; height:420px }
  .stats{ grid-template-columns:repeat(2,1fr) }
  .team{ grid-template-columns:repeat(2,1fr) }
  .tech{ grid-template-columns:1fr }
  .values{ grid-template-columns:repeat(2,1fr) }
}
@media (max-width: 560px){
  .team{ grid-template-columns:1fr }
  .values{ grid-template-columns:1fr }
}
</style>

<div class="back-canvas"><canvas id="pulse"></canvas></div>
<div class="grid-overlay"></div>

<section class="hero-wrap">
  <div class="hero-left">
    <h1>We build <span style="color:var(--accent)">Battle-OP</span> for the <span style="color:var(--accent2)">fearless</span>.</h1>
    <p>Zero-lag combat, handcrafted systems, and a community that ships ideas faster than patches. Hum sirf game nahi — ek skill-based battlefield create karte hain jahan har frame count karta hai.</p>
    <div class="hero-cta">
      <a class="btn" href="home.php">Enter Arena</a>
      <a class="btn ghost" href="support.php">Contact Support</a>
    </div>
  </div>
  <div class="hero-right">
    <div class="hero-ring"></div>
    <div class="hero-ring r2"></div>
    <!-- Morphing SVG blob (no libs) -->
    <svg class="blob" viewBox="0 0 600 600">
      <defs>
        <linearGradient id="g1" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stop-color="#ff1744"/>
          <stop offset="100%" stop-color="#ff6a00"/>
        </linearGradient>
      </defs>
      <path id="blobPath" fill="url(#g1)">
        <animate attributeName="d" dur="16s" repeatCount="indefinite"
          values="
          M422,318Q420,386,365,440Q310,494,241,468Q172,442,129,386Q86,330,101,257Q116,184,169,139Q222,94,297,91Q372,88,409,150Q446,212,422,265Q398,318,422,318Z;
          M445,322Q438,394,380,443Q322,492,245,473Q168,454,122,395Q76,336,81,260Q86,184,142,134Q198,84,274,80Q350,76,400,132Q450,188,454,254Q458,320,445,322Z;
          M415,320Q418,392,360,448Q302,504,227,482Q152,460,120,392Q88,324,104,248Q120,172,178,130Q236,88,308,104Q380,120,409,186Q438,252,415,320Z;
          M422,318Q420,386,365,440Q310,494,241,468Q172,442,129,386Q86,330,101,257Q116,184,169,139Q222,94,297,91Q372,88,409,150Q446,212,422,265Q398,318,422,318Z
          " />
      </path>
    </svg>
  </div>
</section>

<!-- MARQUEE -->
<div class="marquee" aria-hidden="true">
  <div class="track">
    <span class="pill"><i>●</i> Zero-Lag Netcode</span>
    <span class="pill"><i>●</i> Skill-Based Matchmaking</span>
    <span class="pill"><i>●</i> Anti-Cheat Layer</span>
    <span class="pill"><i>●</i> 144Hz UI Animations</span>
    <span class="pill"><i>●</i> Community-First Patches</span>
    <span class="pill"><i>●</i> Creator Tools</span>
    <!-- duplicate for seamless loop -->
    <span class="pill"><i>●</i> Zero-Lag Netcode</span>
    <span class="pill"><i>●</i> Skill-Based Matchmaking</span>
    <span class="pill"><i>●</i> Anti-Cheat Layer</span>
    <span class="pill"><i>●</i> 144Hz UI Animations</span>
    <span class="pill"><i>●</i> Community-First Patches</span>
    <span class="pill"><i>●</i> Creator Tools</span>
  </div>
</div>

<!-- STATS -->
<section class="stats" id="stats">
  <div class="stat"><div class="num" data-count="300000">0</div><div class="lbl">Registered Players</div></div>
  <div class="stat"><div class="num" data-count="98">0</div><div class="lbl">Uptime %</div></div>
  <div class="stat"><div class="num" data-count="120">0</div><div class="lbl">Global Regions</div></div>
  <div class="stat"><div class="num" data-count="24">0</div><div class="lbl">Support / 7</div></div>
</section>

<!-- STORY / TIMELINE -->
<section class="story">
  <h2>Our Story</h2>
  <div class="timeline" id="timeline">
    <?php
      $milestones = [
        ["year"=>"2022", "title"=>"Prototype Online", "body"=>"A small weekend project turned into a low-latency arena prototype. We decided to chase it seriously."],
        ["year"=>"2023", "title"=>"Closed Alpha", "body"=>"First 1,000 players. We rewrote our input pipeline twice to nail timing."],
        ["year"=>"2024", "title"=>"Creator Tools", "body"=>"Open mod hooks, map scripting, replay layers. Community started shipping insane content."],
        ["year"=>"2025", "title"=>"Global Launch", "body"=>"Anti-cheat hardened, cloud regions x3, and partnered events went live."]
      ];
      foreach($milestones as $m){
        echo '<div class="milestone">
          <div class="ms-head"><span class="ms-year">'.$m["year"].'</span> '.$m["title"].'
          <span class="ms-toggle">expand</span></div>
          <div class="ms-body">'.$m["body"].'</div>
        </div>';
      }
    ?>
  </div>
</section>

<!-- TEAM -->
<section class="team" id="team">
  <?php
    $team = [
      ["name"=>"A. Khan","role"=>"Netcode Lead","bio"=>"Time-warps, tick drift & delay compensation freak.","tag"=>"Multiplayer"],
      ["name"=>"Z. Roy","role"=>"Gameplay Designer","bio"=>"If it’s not fun in 5s, it’s out.","tag"=>"Design"],
      ["name"=>"P. Singh","role"=>"Graphics","bio"=>"Loves shaders more than pizza.","tag"=>"Render"],
      ["name"=>"S. Mehta","role"=>"Product","bio"=>"Ships weekly, sleeps monthly.","tag"=>"Ops"],
      ["name"=>"R. Kumar","role"=>"Security","bio"=>"Cheaters hate this person.","tag"=>"Anti-Cheat"],
      ["name"=>"H. Ali","role"=>"Community","bio"=>"Players first, always.","tag"=>"Community"]
    ];
    foreach($team as $t){
      echo '<div class="card tilt">
        <span class="tag">'.$t["tag"].'</span>
        <div class="avatar"></div>
        <h4>'.$t["name"].'</h4>
        <p class="role">'.$t["role"].'</p>
        <p class="bio">'.$t["bio"].'</p>
        <div class="links">
          <a href="#">Profile</a><a href="#">Message</a><a href="#">Follow</a>
        </div>
      </div>';
    }
  ?>
</section>

<!-- TECH -->
<section class="tech">
  <div class="panel">
    <h3>Our Stack</h3>
    <p style="color:var(--muted)">Minimal libs, maximum control. Hum latency ko design ke sath treat karte hain.</p>
    <ul style="margin:10px 0 0 18px;color:#cdd2ec">
      <li>Custom rollback netcode</li>
      <li>Deterministic physics slices</li>
      <li>Zero-copy packet paths</li>
      <li>Multi-region relay mesh</li>
    </ul>
  </div>
  <div class="panel">
    <h3>Capability Radar</h3>
    <div class="chart-wrap"><canvas id="radar"></canvas></div>
  </div>
</section>

<!-- VALUES -->
<section class="values" id="values">
  <?php
    $values = [
      ["title"=>"Latency is a Feature","body"=>"Har frame, har hit-scan deterministic. Timing > everything."],
      ["title"=>"Community First","body"=>"Creator tools aur feedback loops hamara core roadmap chalate hain."],
      ["title"=>"Ship > Perfect","body"=>"Weeklies over perfection — iterate in public."],
      ["title"=>"Security by Design","body"=>"Anti-cheat is an architecture, not a patch."],
      ["title"=>"Open Pipelines","body"=>"Telemetry is visible, decisions are shared."],
      ["title"=>"Accessibility","body"=>"60–144Hz, low-end to high-end friendly."],
      ["title"=>"Performance Budget","body"=>"Every ms accounted for, UI included."],
      ["title"=>"Learning Loop","body"=>"Post-mortems for wins AND fails."]
    ];
    foreach($values as $v){
      echo '<div class="value"><h4>'.$v["title"].'</h4><p>'.$v["body"].'</p></div>';
    }
  ?>
</section>

<!-- CTA -->
<section class="cta">
  <div class="txt">
    <h3>Join the mission.</h3>
    <p style="color:var(--muted)">If you care about milliseconds, fair play, and giving creators superpowers — you’re one of us.</p>
  </div>
  <div class="actions">
    <a class="btn" href="games.php">Play Now</a>
    <a class="btn ghost" href="careers.php">Careers</a>
  </div>
</section>

<script>
/* =============== Pulse Grid Background (Canvas) =============== */
(function(){
  const c=document.getElementById('pulse'),ctx=c.getContext('2d');
  let w,h,t=0; function rs(){w=c.width=innerWidth;h=c.height=innerHeight;} rs(); addEventListener('resize',rs);
  function loop(){
    t+=0.008; ctx.fillStyle='#06060b'; ctx.fillRect(0,0,w,h);
    const s=28, cols=Math.ceil(w/s), rows=Math.ceil(h/s);
    for(let y=0;y<rows;y++){
      for(let x=0;x<cols;x++){
        const px=x*s, py=y*s;
        const v = 0.5+0.5*Math.sin((x*0.3)+(y*0.25)+t*3);
        const a = 0.06+0.25*v;
        ctx.fillStyle = `rgba(255,23,68,${a})`;
        ctx.fillRect(px+12,py+12,2,2);
      }
    }
    requestAnimationFrame(loop);
  } loop();
})();

/* =============== Stats Counter =============== */
(function(){
  const nums=[...document.querySelectorAll('.num')];
  const obs=new IntersectionObserver((es)=>{
    es.forEach(e=>{
      if(e.isIntersecting){
        const el=e.target, end=parseInt(el.dataset.count,10);
        let cur=0, step=Math.max(1, Math.floor(end/80));
        const iv=setInterval(()=>{ cur+=step; if(cur>=end){cur=end; clearInterval(iv);} el.textContent=cur.toLocaleString(); },18);
        obs.unobserve(el);
      }
    });
  },{threshold:0.5});
  nums.forEach(n=>obs.observe(n));
})();

/* =============== Timeline Expanders =============== */
document.querySelectorAll('.milestone').forEach(ms=>{
  ms.querySelector('.ms-toggle').addEventListener('click',()=>{
    ms.classList.toggle('open');
    ms.querySelector('.ms-toggle').textContent = ms.classList.contains('open')?'collapse':'expand';
  });
});

/* =============== Team Tilt (no libs) =============== */
document.querySelectorAll('.tilt').forEach(card=>{
  let rAF;
  card.addEventListener('mousemove', (e)=>{
    const b=card.getBoundingClientRect(), cx=b.left+b.width/2, cy=b.top+b.height/2;
    const dx=(e.clientX-cx)/b.width, dy=(e.clientY-cy)/b.height;
    cancelAnimationFrame(rAF);
    rAF=requestAnimationFrame(()=>{
      card.style.transform=`rotateX(${(-dy*10)}deg) rotateY(${dx*12}deg)`;
    });
  });
  card.addEventListener('mouseleave', ()=>{ card.style.transform='rotateX(0) rotateY(0)' });
});

/* =============== Radar Chart (pure canvas) =============== */
(function(){
  const el=document.getElementById('radar'), ctx=el.getContext('2d');
  let w,h; function rs(){ w=el.width=el.clientWidth*2; h=el.height=el.clientHeight*2; } rs(); addEventListener('resize',rs);
  const metrics=["Latency","Security","Scale","Tooling","UX"];
  const vals=[0.95,0.85,0.9,0.8,0.88]; // 0..1
  function draw(){
    ctx.clearRect(0,0,w,h);
    const cx=w/2, cy=h/2, R=Math.min(w,h)/2-40;
    // webs
    ctx.strokeStyle="#262a47"; ctx.lineWidth=2;
    for(let r=0.2;r<=1.01;r+=0.2){
      ctx.beginPath();
      for(let i=0;i<metrics.length;i++){
        const a=(Math.PI*2/metrics.length)*i - Math.PI/2;
        const x=cx+Math.cos(a)*R*r, y=cy+Math.sin(a)*R*r;
        i?ctx.lineTo(x,y):ctx.moveTo(x,y);
      }
      ctx.closePath(); ctx.stroke();
    }
    // axes
    for(let i=0;i<metrics.length;i++){
      const a=(Math.PI*2/metrics.length)*i - Math.PI/2;
      const x=cx+Math.cos(a)*R, y=cy+Math.sin(a)*R;
      ctx.strokeStyle="#2f345d"; ctx.beginPath(); ctx.moveTo(cx,cy); ctx.lineTo(x,y); ctx.stroke();
      // labels
      ctx.fillStyle="#cdd2ec"; ctx.font="28px sans-serif";
      const lx=cx+Math.cos(a)*(R+24), ly=cy+Math.sin(a)*(R+24);
      ctx.textAlign= Math.cos(a)>0.2 ? "left" : (Math.cos(a)<-0.2 ? "right":"center");
      ctx.fillText(metrics[i], lx, ly);
    }
    // polygon
    ctx.beginPath();
    for(let i=0;i<metrics.length;i++){
      const a=(Math.PI*2/metrics.length)*i - Math.PI/2;
      const x=cx+Math.cos(a)*R*vals[i], y=cy+Math.sin(a)*R*vals[i];
      i?ctx.lineTo(x,y):ctx.moveTo(x,y);
    }
    ctx.closePath();
    const grd=ctx.createLinearGradient(0,0,w,h);
    grd.addColorStop(0,"rgba(255,23,68,.35)");
    grd.addColorStop(1,"rgba(255,106,0,.25)");
    ctx.fillStyle=grd; ctx.fill();
    ctx.strokeStyle="rgba(255,90,90,.7)"; ctx.lineWidth=4; ctx.stroke();
  }
  draw();
})();

/* =============== Values hover light =============== */
document.querySelectorAll('.value').forEach(v=>{
  v.addEventListener('pointermove', (e)=>{
    const r=v.getBoundingClientRect();
    v.style.setProperty('--mx', (e.clientX - r.left) + 'px');
    v.style.setProperty('--my', (e.clientY - r.top) + 'px');
  });
});
</script>

<?php require __DIR__ . "/partials/footer.php"; ?>