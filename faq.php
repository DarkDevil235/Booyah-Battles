<?php
// faq.php
$title = "FAQ • Battle OP";
require __DIR__ . "/partials/header.php";

/**
 * Define FAQs (category-wise). Tags optional.
 * You can edit/add easily.
 */
$faqs = [
  "Getting Started" => [
    [
      "q" => "Battle OP kya hai aur kaise start karu?",
      "a" => "Battle OP ek skill-based arena experience hai. Download button se client lo, account create karo, aur quick tutorial complete kar ke first match join karo.",
      "tags" => ["intro","start","download"]
    ],
    [
      "q" => "Minimum system requirements?",
      "a" => "Dual-core CPU, 4GB RAM, basic integrated GPU, stable internet (≥5 Mbps). 60–144Hz displays supported; low-end optimization enabled.",
      "tags" => ["requirements","specs","performance"]
    ],
    [
      "q" => "Account create karna free hai?",
      "a" => "Haan, registration 100% free. Optional cosmetics available; gameplay par koi paywall nahi.",
      "tags" => ["account","free","pricing"]
    ],
  ],
  "Gameplay" => [
    [
      "q" => "Matchmaking kaise kaam karta hai?",
      "a" => "Hum skill-based MMR + region latency model use karte hain. Party queue me shared MMR window apply hota hai, taaki balanced lobbies milein.",
      "tags" => ["mmr","rank","latency"]
    ],
    [
      "q" => "Lag ya packet loss ho to kya karu?",
      "a" => "In-game Network Overlay on karo (Settings → Network). Jitter ≥15ms dikh raha ho to Wi-Fi se wired pe shift karo. Background downloads/streams band karo.",
      "tags" => ["lag","network","jitter"]
    ],
    [
      "q" => "Controls customize kar sakta hu?",
      "a" => "Haan, full key-rebinding + sensitivity curves + per-weapon ADS multipliers available. Settings → Controls me profile save/restore options bhi hain.",
      "tags" => ["controls","settings"]
    ],
  ],
  "Security & Fair Play" => [
    [
      "q" => "Anti-cheat kaise implement kiya hai?",
      "a" => "Client hooks + server-side validation + behavior heuristics. Deterministic snapshots ke sath replay diffing hoti hai. Suspicious patterns auto-flag hote hain.",
      "tags" => ["anticheat","security"]
    ],
    [
      "q" => "Ban appeal ka process?",
      "a" => "Support portal me ‘Ban Review’ form submit karo. Replay hash attach karo to review jaldi hoti hai. Decisions 3–5 business days me email se aate hain.",
      "tags" => ["ban","appeal"]
    ],
    [
      "q" => "Report kaise karu?",
      "a" => "Scoreboard se player profile kholkar ‘Report’ dabao. Category select karo (Cheating, Toxicity, Exploit). Anonymous reporting supported.",
      "tags" => ["report","moderation"]
    ],
  ],
  "Payments & Rewards" => [
    [
      "q" => "Withdrawal kitne time me aata hai?",
      "a" => "Instant withdraw partners ke through zyada cases me minutes. Rare AML checks me 24–48h lag sakte hain.",
      "tags" => ["withdraw","payout"]
    ],
    [
      "q" => "Regional pricing available hai?",
      "a" => "Haan, cosmetics aur passes par region-wise pricing apply hoti hai. Taxes local rules ke mutabik add hote hain.",
      "tags" => ["pricing","tax"]
    ],
    [
      "q" => "Daily rewards reset kab hote hain?",
      "a" => "Har din 00:00 UTC par reset. Streaks miss ho jaye to 1 grace token per week available.",
      "tags" => ["rewards","daily","streak"]
    ],
  ],
  "Troubleshooting" => [
    [
      "q" => "Game launch nahi ho raha?",
      "a" => "Anti-virus me allow-list add karo, Visual C++ redistributables install ensure karo, aur launcher ko ‘Run as Admin’ try karo. Logs: %LOCALAPPDATA%/BattleOP/logs.",
      "tags" => ["launch","error","logs"]
    ],
    [
      "q" => "Crashes / black screen fix?",
      "a" => "GPU drivers update, fullscreen optimizations off, Windows Game Mode on, aur windowed borderless try karo.",
      "tags" => ["crash","gpu","black screen"]
    ],
    [
      "q" => "Voice chat issues?",
      "a" => "OS mic permissions allow karo, in-game input device sahi select karo, push-to-talk vs open mic toggle check karo.",
      "tags" => ["voice","mic","audio"]
    ],
  ],
];

function slugify($str){
  $s = strtolower(trim(preg_replace('/[^a-z0-9]+/i','-',$str),'-'));
  return $s ?: substr(md5($str),0,8);
}
?>

<style>
:root{
  --bg:#06070e; --panel:#0e0f18; --panel2:#131426;
  --line:#22253e; --muted:#9aa0b8; --text:#eef2ff;
  --accent:#ff1744; --accent2:#ff6a00; --glow:rgba(255,40,60,.35);
}
*{box-sizing:border-box}
.faq-root{ position:relative; color:var(--text); background:radial-gradient(70% 120% at 50% 0%, #090a14 0%, #05060c 60%); }
.faq-wrap{ width:min(1200px,94vw); margin:0 auto; padding:96px 0 60px; position:relative; }

/* BACKGROUNDS */
.bg-canvas{ position:fixed; inset:0; z-index:-2 }
.grid{
  position:fixed; inset:0; pointer-events:none; opacity:.2; z-index:-1;
  background:
    radial-gradient(600px 200px at var(--mx,70%) var(--my,20%), rgba(255,23,68,.12), transparent 60%),
    linear-gradient(transparent 31px,#0b0d19 32px),
    linear-gradient(90deg,transparent 31px,#0b0d19 32px);
  background-size:auto, 32px 32px, 32px 32px;
}

/* HEADER STRIP */
.faq-head{
  display:flex; align-items:center; gap:12px; justify-content:space-between;
  background:linear-gradient(180deg,#0a0b15,#0c0e1f);
  border:1px solid var(--line); border-radius:16px; padding:16px 16px; margin-bottom:16px;
  box-shadow:0 10px 40px rgba(0,0,0,.4), 0 0 0 1px rgba(255,255,255,.02) inset;
}
.faq-title{ font-size: clamp(28px, 4vw, 44px); margin:0; letter-spacing:.2px; }
.tools{ display:flex; gap:10px; flex-wrap:wrap }
.input, .select, .btn{
  background:#12132a; color:#e7eaff; border:1px solid #2b2e4b; border-radius:12px; padding:10px 12px;
  outline:none; font-weight:600;
}
.input{ min-width:220px }
.select{ cursor:pointer }
.btn{ cursor:pointer; background:linear-gradient(135deg,var(--accent),var(--accent2)); border:none; box-shadow:0 6px 22px var(--glow) }
.btn.ghost{ background:#12132a; box-shadow:none }
.btn.small{ padding:8px 10px; font-size:12px; border-radius:10px }

/* TIPS MARQUEE */
.tips{
  overflow:hidden; white-space:nowrap; margin:14px 0 20px; border:1px solid var(--line);
  background:#0b0d1a; border-radius:12px;
}
.tips .track{ display:inline-block; padding:10px 0; animation:slide 18s linear infinite }
.tips .pill{ background:#12142b; border:1px solid #262c57; color:#cfd3ff; padding:6px 12px; margin:0 8px; border-radius:999px; display:inline-flex; gap:8px }
.tips .pill i{ font-style:normal; color:var(--accent) }
@keyframes slide{ to{ transform:translateX(-50%) } }

/* LAYOUT */
.layout{ display:grid; grid-template-columns: .75fr .25fr; gap:16px }
@media(max-width: 980px){ .layout{ grid-template-columns:1fr } }

/* ACCORDION */
.faq-col{
  background:var(--panel); border:1px solid var(--line); border-radius:16px; padding:12px;
}
.cat-head{
  padding:8px 10px 0; color:#cdd3ff; letter-spacing:.3px; font-weight:800; font-size:14px; opacity:.9;
}
.qa{
  background:linear-gradient(180deg,#0f1020,#0a0b16); border:1px solid #202445; border-radius:14px;
  padding:14px 14px; margin:10px 0; position:relative; overflow:hidden;
  transition: box-shadow .2s ease, transform .2s ease;
}
.qa:hover{ box-shadow:0 14px 28px rgba(0,0,0,.35) }
.qhead{ display:flex; align-items:center; gap:10px; cursor:pointer }
.qtitle{ font-weight:800; }
.badges{ display:flex; gap:6px; flex-wrap:wrap; margin-left:auto }
.badge{
  font-size:10px; padding:5px 8px; border-radius:999px; color:#dfe2ff; background:#141637; border:1px solid #2b2f5a;
}
.chev{ width:18px; height:18px; border-radius:50%; background:#16183b; display:grid; place-items:center; margin-left:8px; border:1px solid #2b2f5a }
.chev::before{ content:"+"; color:#9fa6d8; font-weight:900 }

.body{
  max-height:0; overflow:hidden; color:#bfc6f3; line-height:1.55; transition:max-height .3s ease;
  padding:0 2px;
}
.qa.open .body{ max-height:320px; }
.qa.open .chev::before{ content:"–" }

/* ACTIONS under each answer */
.actions{ display:flex; align-items:center; gap:8px; margin-top:12px; }
.link, .vote{
  background:#10122e; border:1px solid #272b56; color:#d9ddff; border-radius:10px; padding:6px 8px; cursor:pointer;
  font-size:12px; display:inline-flex; align-items:center; gap:6px;
}
.voted{ background:linear-gradient(135deg, #1a1e44, #162045); border-color:#2d376d }
.meta{ margin-left:auto; color:#8d94c4; font-size:12px }

/* SIDEBAR */
.sidebar{
  background:var(--panel2); border:1px solid var(--line); border-radius:16px; padding:14px; position:sticky; top:96px; height:max-content;
}
.sb-title{ margin:0 0 10px; font-size:16px; }
.tags{ display:flex; flex-wrap:wrap; gap:8px }
.tag{
  background:#12142c; color:#dfe2ff; border:1px solid #2c2f54; border-radius:999px; padding:6px 10px; cursor:pointer; font-size:12px;
}
.tag.active{ background:linear-gradient(135deg,var(--accent),var(--accent2)); border:none; box-shadow:0 6px 18px var(--glow) }

.kb{ margin-top:14px; padding-top:14px; border-top:1px dashed #2a2e55; color:#bfc6f3; font-size:14px }
.kb a{ color:#ffd9e0; text-decoration:none; border-bottom:1px dashed #ff6a7e }

/* STICKY HELP WIDGET */
.help-widget{
  position:fixed; right:18px; bottom:18px; z-index:9;
}
.help-widget .bubble{
  background:linear-gradient(135deg,#151735,#0e0f24); border:1px solid #2b2e55; border-radius:16px; padding:12px; width:260px;
  box-shadow:0 12px 36px rgba(0,0,0,.5);
}
.help-actions{ display:flex; gap:8px; margin-top:8px }
.help-actions a{ flex:1; text-align:center; text-decoration:none; color:#fff; font-weight:700 }
.help-actions .btn{ width:100% }

/* FOOT NOTE */
.note{
  margin-top:14px; font-size:12px; color:#8d94c4; text-align:center;
}

/* TOOLS ROW */
.tools-row{
  display:flex; gap:8px; align-items:center; margin:10px 0 14px;
}
.tools-row .btn{ height:36px; display:inline-flex; align-items:center }

/* ACCESSIBILITY FOCUS */
.qhead:focus{ outline:2px solid #ff3e6a; outline-offset:4px; border-radius:8px }
</style>

<div class="bg-canvas"><canvas id="pulse"></canvas></div>
<div class="grid" id="gridFx"></div>

<div class="faq-root">
  <div class="faq-wrap">

    <div class="faq-head" role="banner">
      <h1 class="faq-title">Frequently Asked Questions</h1>
      <div class="tools">
        <input id="search" class="input" type="search" placeholder="Search questions (e.g. lag, account)" aria-label="Search FAQs">
        <select id="category" class="select" aria-label="Filter by category">
          <option value="all">All Categories</option>
          <?php foreach(array_keys($faqs) as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
          <?php endforeach; ?>
        </select>
        <button id="expandAll" class="btn small" type="button">Expand All</button>
        <button id="collapseAll" class="btn ghost small" type="button">Collapse All</button>
      </div>
    </div>

    <div class="tips" aria-hidden="true">
      <div class="track">
        <span class="pill"><i>●</i> Tip: Press “/” to focus search.</span>
        <span class="pill"><i>●</i> Tip: Use # link to share a question.</span>
        <span class="pill"><i>●</i> Tip: Filter by tags in sidebar.</span>
        <span class="pill"><i>●</i> Tip: Vote answers to improve help.</span>
        <span class="pill"><i>●</i> Tip: Press “?” to open help widget.</span>

        <span class="pill"><i>●</i> Tip: Press “/” to focus search.</span>
        <span class="pill"><i>●</i> Tip: Use # link to share a question.</span>
        <span class="pill"><i>●</i> Tip: Filter by tags in sidebar.</span>
        <span class="pill"><i>●</i> Tip: Vote answers to improve help.</span>
        <span class="pill"><i>●</i> Tip: Press “?” to open help widget.</span>
      </div>
    </div>

    <div class="layout" id="layout">
      <!-- MAIN COL -->
      <div class="faq-col" id="faqList" role="region" aria-label="FAQ list">
        <?php
          $allTags = [];
          foreach($faqs as $cat => $items):
        ?>
          <div class="cat-head"><?= htmlspecialchars($cat) ?></div>
          <?php foreach($items as $i => $item):
            $id = slugify($cat . '-' . $item['q']);
            $tags = $item['tags'] ?? [];
            $allTags = array_merge($allTags, $tags);
          ?>
            <div class="qa" data-cat="<?= htmlspecialchars($cat) ?>" data-tags="<?= htmlspecialchars(implode(',', $tags)) ?>" id="faq-<?= $id ?>">
              <div class="qhead" tabindex="0" role="button" aria-expanded="false" aria-controls="body-<?= $id ?>">
                <div class="qtitle"><?= htmlspecialchars($item['q']) ?></div>
                <div class="badges">
                  <?php foreach($tags as $t): ?>
                    <span class="badge"><?= htmlspecialchars($t) ?></span>
                  <?php endforeach; ?>
                </div>
                <div class="chev" aria-hidden="true"></div>
              </div>
              <div class="body" id="body-<?= $id ?>">
                <p><?= htmlspecialchars($item['a']) ?></p>
                <div class="actions">
                  <button class="vote" data-id="<?= $id ?>" data-kind="up" type="button" aria-label="Mark helpful">👍 Helpful</button>
                  <button class="vote" data-id="<?= $id ?>" data-kind="down" type="button" aria-label="Mark not helpful">👎 Not helpful</button>
                  <button class="link" data-id="<?= $id ?>" type="button" aria-label="Copy link">🔗 Copy link</button>
                  <span class="meta" id="meta-<?= $id ?>">0 found this helpful</span>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </div>

      <!-- SIDEBAR -->
      <aside class="sidebar" role="complementary" aria-label="Filters and help">
        <h3 class="sb-title">Filter by tags</h3>
        <div class="tags" id="tagList">
          <?php
            $unique = array_values(array_unique(array_map('strtolower',$allTags)));
            sort($unique);
            foreach($unique as $t):
          ?>
            <button class="tag" type="button" data-tag="<?= htmlspecialchars($t) ?>"><?= htmlspecialchars($t) ?></button>
          <?php endforeach; ?>
        </div>

        <div class="kb">
          <strong>Knowledge Base:</strong>
          <p>Advanced guides &amp; patch notes.</p>
          <a href="support.php">Open Support &rarr;</a>
        </div>

        <div class="note">Press “/” to search, “?” for help widget.</div>
      </aside>
    </div>

    <div class="tools-row">
      <a class="btn" href="support.php">Still need help? Contact Support</a>
      <button id="clearVotes" class="btn ghost" type="button" title="Clear local helpful votes">Reset My Votes</button>
    </div>

  </div>
</div>

<!-- HELP WIDGET -->
<div class="help-widget" id="helpWidget" hidden>
  <div class="bubble">
    <strong>Need more help?</strong>
    <p style="color:#cbd2ff;margin:.4rem 0 0">Quick links:</p>
    <div class="help-actions">
      <a href="support.php" class="btn">Open Ticket</a>
      <a href="about.php" class="btn ghost">About Us</a>
    </div>
    <div class="note">Tip: Press “?” to toggle this.</div>
  </div>
</div>

<script>
/* ================== Background Pulse Grid (canvas) ================== */
(function(){
  const c=document.getElementById('pulse'), ctx=c.getContext('2d');
  const grid=document.getElementById('gridFx');
  let w,h,t=0;
  function rs(){ w=c.width=innerWidth; h=c.height=innerHeight; }
  rs(); addEventListener('resize', rs);
  function loop(){
    t+=0.007; ctx.fillStyle='#06070e'; ctx.fillRect(0,0,w,h);
    const s=30, cols=Math.ceil(w/s), rows=Math.ceil(h/s);
    for(let y=0;y<rows;y++){
      for(let x=0;x<cols;x++){
        const px=x*s, py=y*s;
        const v = 0.5 + 0.5*Math.sin((x*0.35)+(y*0.22)+t*3.2);
        const a = 0.04 + 0.22*v;
        ctx.fillStyle = `rgba(255,23,68,${a})`;
        ctx.fillRect(px+14,py+14,2,2);
      }
    }
    requestAnimationFrame(loop);
  } loop();

  // pointer-reactive glow grid overlay
  addEventListener('pointermove', (e)=>{
    grid.style.setProperty('--mx', e.clientX + 'px');
    grid.style.setProperty('--my', e.clientY + 'px');
  });
})();

/* ================== Accordion + Smooth Height ================== */
const list = document.getElementById('faqList');
function toggleQA(item, forceOpen = null){
  const body=item.querySelector('.body');
  const head=item.querySelector('.qhead');
  const open = forceOpen!==null ? forceOpen : !item.classList.contains('open');
  head.setAttribute('aria-expanded', open ? 'true' : 'false');
  if(open){
    item.classList.add('open');
    // smooth height
    body.style.maxHeight = body.scrollHeight + 'px';
  }else{
    body.style.maxHeight = body.scrollHeight + 'px';
    requestAnimationFrame(()=>{ body.style.maxHeight = '0px'; });
    item.classList.remove('open');
  }
}
list.addEventListener('click', (e)=>{
  const h = e.target.closest('.qhead');
  if(!h) return;
  toggleQA(h.closest('.qa'));
});
list.addEventListener('keydown', (e)=>{
  if(e.key==='Enter' || e.key===' '){
    const h=e.target.closest('.qhead'); if(!h) return;
    e.preventDefault(); toggleQA(h.closest('.qa'));
  }
});

/* ================== Search + Category + Tags ================== */
const search = document.getElementById('search');
const category = document.getElementById('category');
const tagList = document.getElementById('tagList');
let activeTag = null;

function applyFilters(){
  const q = search.value.toLowerCase().trim();
  const cat = category.value;
  const cards = [...document.querySelectorAll('.qa')];
  cards.forEach(card=>{
    const c = card.dataset.cat;
    const tags = (card.dataset.tags || '').toLowerCase();
    const title = card.querySelector('.qtitle').textContent.toLowerCase();
    const answer = card.querySelector('.body').innerText.toLowerCase();
    let show = true;
    if(cat !== 'all' && c !== cat) show = false;
    if(q && !(title.includes(q)||answer.includes(q)||tags.includes(q))) show = false;
    if(activeTag && !tags.split(',').includes(activeTag)) show = false;
    card.style.display = show ? '' : 'none';
  });
}
search.addEventListener('input', applyFilters);
category.addEventListener('change', applyFilters);
tagList.addEventListener('click', (e)=>{
  const btn = e.target.closest('.tag'); if(!btn) return;
  if(activeTag === btn.dataset.tag){ activeTag=null; btn.classList.remove('active'); }
  else{
    [...tagList.querySelectorAll('.tag')].forEach(t=>t.classList.remove('active'));
    activeTag = btn.dataset.tag; btn.classList.add('active');
  }
  applyFilters();
});

/* keyboard shortcut to focus search */
addEventListener('keydown', (e)=>{ if(e.key==='/'){ e.preventDefault(); search.focus(); } });

/* ================== Expand/Collapse All ================== */
document.getElementById('expandAll').addEventListener('click', ()=>{
  document.querySelectorAll('.qa').forEach(q=>toggleQA(q,true));
});
document.getElementById('collapseAll').addEventListener('click', ()=>{
  document.querySelectorAll('.qa').forEach(q=>toggleQA(q,false));
});

/* ================== Deep Links + Copy Links ================== */
function openFromHash(){
  const id = location.hash.replace('#','');
  if(!id) return;
  const el = document.getElementById(id);
  if(el && el.classList.contains('qa')){
    toggleQA(el,true);
    el.scrollIntoView({behavior:'smooth', block:'start'});
  }
}
openFromHash();
window.addEventListener('hashchange', openFromHash);

list.addEventListener('click', (e)=>{
  const btn = e.target.closest('.link');
  if(!btn) return;
  const id = 'faq-' + btn.dataset.id;
  const url = location.origin + location.pathname + '#' + id;
  navigator.clipboard.writeText(url).then(()=>{
    btn.textContent = '✅ Copied!';
    setTimeout(()=>btn.textContent='🔗 Copy link',1200);
  });
});

/* ================== Helpful Votes (localStorage) ================== */
const LSKEY='faqVotes.v1';
let votes = {};
try{ votes = JSON.parse(localStorage.getItem(LSKEY)||'{}'); }catch(e){}
function renderVote(id){
  const meta = document.getElementById('meta-'+id);
  const up = votes[id]?.up||0, down=votes[id]?.down||0;
  meta.textContent = `${up} found this helpful${down?` • ${down} not helpful`:''}`;
  // mark buttons
  document.querySelectorAll(`.vote[data-id="${id}"]`).forEach(b=>{
    const k=b.dataset.kind; b.classList.toggle('voted', !!votes[id]?.[k]);
  });
}
document.querySelectorAll('.vote').forEach(b=>{
  const id=b.dataset.id;
  renderVote(id);
  b.addEventListener('click', ()=>{
    votes[id]=votes[id]||{up:0,down:0};
    votes[id][b.dataset.kind] = (votes[id][b.dataset.kind]||0) + 1;
    localStorage.setItem(LSKEY, JSON.stringify(votes));
    renderVote(id);
  });
});
document.getElementById('clearVotes').addEventListener('click', ()=>{
  localStorage.removeItem(LSKEY); votes={};
  document.querySelectorAll('.vote').forEach(b=>{
    const id=b.dataset.id; renderVote(id);
  });
});

/* ================== Help Widget ( ? to toggle ) ================== */
const help=document.getElementById('helpWidget');
function toggleHelp(force=null){
  const show = force!==null ? force : help.hasAttribute('hidden');
  if(show) help.removeAttribute('hidden'); else help.setAttribute('hidden','');
}
addEventListener('keydown', (e)=>{ if(e.key==='?'){ e.preventDefault(); toggleHelp(); } });

/* improve perf: defer initial filter */
requestAnimationFrame(applyFilters);
</script>

<?php require __DIR__ . "/partials/footer.php"; ?>
```0