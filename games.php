<?php
// games.php
$title = "Games • Battle OP";
require __DIR__ . "/partials/header.php";
?>

<style>
/* =================== GAMES PAGE =================== */
:root{
  --accent:#ff1e3c;
  --accent2:#ff5a00;
  --panel:#11111c;
  --text:#fff;
  --muted:#9fa3b5;
}
.games-wrap{
  position:relative; min-height:100vh;
  background: #070710;
  overflow:hidden; isolation:isolate;
}
.games-bg{ position:absolute; inset:0; z-index:-2; }
.games-bg canvas{ width:100%; height:100%; display:block; }

/* Shimmer placeholders */
.shimmer{
  background:linear-gradient(100deg,#1a1a28 20%,#2a2a3a 40%,#1a1a28 60%);
  background-size:200% 100%; animation:shine 1.2s linear infinite;
}
@keyframes shine{ to{ background-position:-200% 0; } }

/* Search + filter bar */
.bar{
  width:min(1100px,94vw); margin:0 auto; padding:30px 0 20px;
  display:flex; gap:12px; flex-wrap:wrap; justify-content:space-between; align-items:center;
}
.bar input{
  flex:1; min-width:200px; padding:12px 16px;
  border-radius:10px; border:none; background:#1a1a28; color:#fff;
}
.filters{ display:flex; gap:10px; flex-wrap:wrap; }
.filters button{
  padding:10px 16px; border-radius:10px;
  background:#1a1a28; color:#ccc; border:none; cursor:pointer;
  transition:.3s;
}
.filters button.active, .filters button:hover{ background:var(--accent); color:#fff; }

/* Grid of games */
.grid{
  width:min(1100px,94vw); margin:0 auto; display:grid;
  grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
  gap:20px; padding:20px 0 60px;
}
.card{
  position:relative; border-radius:16px; overflow:hidden;
  background:#1a1a28; cursor:pointer;
  transition:transform .35s ease, box-shadow .35s ease;
}
.card:hover{ transform:translateY(-6px); box-shadow:0 25px 60px rgba(0,0,0,.6); }
.card .thumb{
  width:100%; height:160px; object-fit:cover; display:block;
}
.card .thumb.shimmer{ height:160px; }
.card .info{ padding:14px; display:grid; gap:4px; }
.card .title{ font-weight:700; color:#fff; }
.card .genre{ font-size:13px; color:var(--muted); }

/* Section titles */
.section{ width:min(1100px,94vw); margin:40px auto 20px; }
.section h2{ font-size:28px; color:var(--accent); margin-bottom:8px; }
.section p{ color:#aaa; font-size:15px; }

/* Modal preview */
.modal{
  position:fixed; inset:0; z-index:1000;
  background:rgba(0,0,0,.85); display:none; align-items:center; justify-content:center;
}
.modal.show{ display:flex; }
.modal-content{
  background:#12121e; border-radius:18px;
  width:min(800px,90vw); max-height:90vh; overflow:auto;
  padding:20px; color:#fff; position:relative;
}
.modal-content img{ width:100%; border-radius:12px; margin-bottom:14px; }
.modal-content h3{ font-size:24px; margin-bottom:10px; }
.modal-content p{ color:#ccc; margin-bottom:12px; }
.modal-content .close{
  position:absolute; right:12px; top:12px;
  background:none; border:none; font-size:26px; color:#fff; cursor:pointer;
}
</style>

<div class="games-wrap">
  <div class="games-bg"><canvas id="pulse"></canvas></div>

  <!-- Search and filters -->
  <div class="bar">
    <input type="text" id="search" placeholder="Search games...">
    <div class="filters">
      <button class="active" data-filter="all">All</button>
      <button data-filter="battle">Battle</button>
      <button data-filter="adventure">Adventure</button>
      <button data-filter="sports">Sports</button>
      <button data-filter="upcoming">Upcoming</button>
    </div>
  </div>

  <!-- Trending -->
  <div class="section">
    <h2>🔥 Trending Now</h2>
    <p>These titles are dominating the arena today.</p>
  </div>
  <div class="grid" id="grid">
    <!-- cards generated in JS -->
  </div>

  <!-- Upcoming -->
  <div class="section">
    <h2>🚀 Upcoming Launches</h2>
    <p>Get ready for the next wave of high-intensity battles.</p>
  </div>
  <div class="grid" id="upcoming">
    <!-- cards generated in JS -->
  </div>
</div>

<!-- Modal -->
<div class="modal" id="modal">
  <div class="modal-content">
    <button class="close" id="modalClose">&times;</button>
    <img src="" alt="" id="modalImg">
    <h3 id="modalTitle"></h3>
    <p id="modalGenre"></p>
    <p id="modalDesc"></p>
  </div>
</div>

<script>
/* ============ Neon Pulse Background ============ */
(function(){
  const c=document.getElementById('pulse'),ctx=c.getContext('2d');
  let w,h,dpr; let t=0;
  function resize(){
    dpr=window.devicePixelRatio||1;
    w=c.width=innerWidth*dpr; h=c.height=innerHeight*dpr;
    c.style.width=innerWidth+'px'; c.style.height=innerHeight+'px';
  }
  function draw(){
    ctx.clearRect(0,0,w,h);
    t+=0.02;
    const cx=w/2, cy=h/2;
    for(let i=0;i<50;i++){
      const r= (i*25 + (Math.sin(t+i/3)*20));
      ctx.strokeStyle=`hsla(${(i*15+t*40)%360},100%,50%,.12)`;
      ctx.beginPath();
      ctx.arc(cx, cy+h*0.15, r, 0, Math.PI*2);
      ctx.stroke();
    }
    requestAnimationFrame(draw);
  }
  resize(); addEventListener('resize',resize);
  draw();
})();

/* ============ Games Data (fake JSON inline) ============ */
const games=[
  {title:"Booyah Royale", genre:"battle", img:"https://picsum.photos/seed/royale/400/240", desc:"Intense last-man-standing battle royale with shrinking zones."},
  {title:"Shadow Quest", genre:"adventure", img:"https://picsum.photos/seed/quest/400/240", desc:"Epic adventure through dungeons and mysterious lands."},
  {title:"Street Strikers", genre:"sports", img:"https://picsum.photos/seed/street/400/240", desc:"High-speed street football with arcade-style mechanics."},
  {title:"Arena Blitz", genre:"battle", img:"https://picsum.photos/seed/blitz/400/240", desc:"Team-based arena shooter with neon effects."},
  {title:"Cyber Drift", genre:"sports", img:"https://picsum.photos/seed/drift/400/240", desc:"Futuristic racing with neon tracks and gravity-defying stunts."},
  {title:"Dragon Realms", genre:"adventure", img:"https://picsum.photos/seed/dragon/400/240", desc:"Fantasy RPG with guilds, quests, and epic dragons."}
];
const upcoming=[
  {title:"Nebula Wars", genre:"upcoming", img:"https://picsum.photos/seed/nebula/400/240", desc:"Sci-fi fleet battles across galaxies."},
  {title:"Iron League", genre:"upcoming", img:"https://picsum.photos/seed/iron/400/240", desc:"Heavy mech clashes in cyber arenas."},
  {title:"Skate Legends", genre:"upcoming", img:"https://picsum.photos/seed/skate/400/240", desc:"Urban skating with online tournaments."}
];

/* Render cards */
function makeCard(g){
  const div=document.createElement('div'); div.className="card"; div.dataset.genre=g.genre;
  const img=document.createElement('img'); img.dataset.src=g.img; img.alt=g.title; img.className="thumb shimmer";
  const info=document.createElement('div'); info.className="info";
  info.innerHTML=`<div class="title">${g.title}</div><div class="genre">${g.genre}</div>`;
  div.appendChild(img); div.appendChild(info);
  div.addEventListener('click',()=>openModal(g));
  return div;
}
const grid=document.getElementById('grid');
games.forEach(g=>grid.appendChild(makeCard(g)));
const upg=document.getElementById('upcoming');
upcoming.forEach(g=>upg.appendChild(makeCard(g)));

/* Lazy load with shimmer */
const io=new IntersectionObserver((ents)=>{
  ents.forEach(e=>{
    if(e.isIntersecting){
      const img=e.target;
      img.src=img.dataset.src;
      img.onload=()=>img.classList.remove('shimmer');
      io.unobserve(img);
    }
  });
},{rootMargin:"100px"});
document.querySelectorAll('img[data-src]').forEach(img=>io.observe(img));

/* Filters */
document.querySelectorAll('.filters button').forEach(btn=>{
  btn.addEventListener('click',()=>{
    document.querySelectorAll('.filters button').forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
    const f=btn.dataset.filter;
    document.querySelectorAll('.card').forEach(c=>{
      c.style.display=(f==="all"||c.dataset.genre===f)?'block':'none';
    });
  });
});

/* Search */
document.getElementById('search').addEventListener('input',e=>{
  const val=e.target.value.toLowerCase();
  document.querySelectorAll('.card').forEach(c=>{
    const t=c.querySelector('.title').textContent.toLowerCase();
    c.style.display=t.includes(val)?'block':'none';
  });
});

/* Modal */
const modal=document.getElementById('modal');
const modalImg=document.getElementById('modalImg');
const modalTitle=document.getElementById('modalTitle');
const modalGenre=document.getElementById('modalGenre');
const modalDesc=document.getElementById('modalDesc');
document.getElementById('modalClose').addEventListener('click',()=>modal.classList.remove('show'));
function openModal(g){
  modalImg.src=g.img;
  modalTitle.textContent=g.title;
  modalGenre.textContent="Genre: "+g.genre;
  modalDesc.textContent=g.desc;
  modal.classList.add('show');
}
</script>

<?php require __DIR__ . "/partials/footer.php"; ?>