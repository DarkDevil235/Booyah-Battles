<?php
// support.php
$title = "Support • Battle OP";
require __DIR__ . "/partials/header.php";
?>

<style>
:root {
  --bg:#05060c; --fg:#f4f6ff;
  --accent:#ff1744; --accent2:#ff6a00;
  --panel:#101223; --panel2:#17192c; --line:#2c2f52;
}
*{box-sizing:border-box}
.support-root{background:radial-gradient(80% 120% at 50% 0%, #0a0c1c 0%, #05060c 80%);color:var(--fg)}
.wrap{width:min(1250px,95%);margin:0 auto;padding:100px 0}

/* BACKGROUND */
.bgfx{position:fixed;inset:0;z-index:-2}
.bgfx canvas{width:100%;height:100%;display:block}
.grid{
 position:fixed;inset:0;z-index:-1;opacity:.25;pointer-events:none;
 background:
  linear-gradient(#0a0c1d 1px,transparent 1px),
  linear-gradient(90deg,#0a0c1d 1px,transparent 1px);
 background-size:40px 40px;
}

/* HEADER */
.head{display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:12px;margin-bottom:24px}
.head h1{font-size:clamp(28px,5vw,44px);margin:0}
.actions{display:flex;gap:10px}
.btn{background:linear-gradient(135deg,var(--accent),var(--accent2));color:#fff;padding:10px 16px;border:none;border-radius:12px;cursor:pointer;font-weight:700;box-shadow:0 6px 20px rgba(255,60,80,.3)}
.btn.ghost{background:#12142c;box-shadow:none}
.input,textarea,select{width:100%;padding:10px 12px;background:#11142b;color:#fff;border:1px solid #2c2f52;border-radius:10px;font-size:15px}
textarea{resize:vertical;min-height:100px}

/* TABS */
.tabs{display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap}
.tab{padding:10px 14px;border-radius:10px;background:#14162d;color:#d6d8ff;cursor:pointer;font-weight:600;border:1px solid #2c2f52}
.tab.active{background:linear-gradient(135deg,var(--accent),var(--accent2));color:#fff;box-shadow:0 6px 18px rgba(255,60,80,.35)}

/* PANELS */
.panel{background:var(--panel);border:1px solid var(--line);border-radius:16px;padding:20px;margin-bottom:20px}
.panel h2{margin:0 0 14px;font-size:22px}
.hidden{display:none}

/* FAQ QUICK */
.faq-list .q{padding:12px;margin:8px 0;background:#0f1126;border:1px solid #272b52;border-radius:10px;cursor:pointer}
.faq-list .q.open{background:#15173a}
.faq-list .a{max-height:0;overflow:hidden;transition:max-height .3s ease}
.faq-list .q.open .a{max-height:200px;margin-top:6px;color:#cfd2ff}

/* FORM */
.form-row{display:grid;gap:12px;margin-bottom:12px}
.attach{border:1px dashed #44497a;padding:20px;text-align:center;border-radius:12px;cursor:pointer}
.attach input{display:none}
#preview{margin-top:8px;display:flex;gap:10px;flex-wrap:wrap}
#preview img{max-height:60px;border-radius:8px;border:1px solid #333}

/* STATUS */
.status{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:14px}
.card{background:#13162c;border:1px solid #2a2d55;border-radius:14px;padding:14px;text-align:center}
.card.up{border-color:#3cfa8d}
.card.down{border-color:#ff3c5c}
.card h3{margin:0;font-size:16px}
.card span{font-size:12px;color:#9aa2c9}

/* HISTORY */
.history-item{padding:12px;border-bottom:1px dashed #2a2e55}
.history-item strong{display:block}
.empty{text-align:center;color:#999;padding:20px}

/* FLOAT WIDGET */
.widget{position:fixed;right:18px;bottom:18px;z-index:9}
.widget .bubble{background:#13152e;padding:14px;border-radius:16px;border:1px solid #2c2f52;box-shadow:0 12px 30px rgba(0,0,0,.5);width:260px}
.widget .bubble h3{margin:0 0 8px}
.widget .actions{display:flex;gap:8px;margin-top:10px}
.widget .actions a{flex:1;text-align:center;text-decoration:none;padding:8px;border-radius:8px;font-weight:700}
.widget .chat{background:var(--accent);color:#fff}
.widget .faq{background:#222847;color:#fff}

/* MISC */
.note{font-size:13px;color:#9ea3d2;margin-top:6px}
</style>

<div class="bgfx"><canvas id="bgcanvas"></canvas></div>
<div class="grid"></div>

<div class="support-root">
  <div class="wrap">

    <div class="head">
      <h1>Support Center</h1>
      <div class="actions">
        <button class="btn" id="newTicketBtn">New Ticket</button>
        <button class="btn ghost" id="themeBtn">Toggle Theme</button>
      </div>
    </div>

    <!-- Tabs -->
    <div class="tabs" id="tabs">
      <div class="tab active" data-tab="faq">FAQ</div>
      <div class="tab" data-tab="form">Submit Ticket</div>
      <div class="tab" data-tab="status">System Status</div>
      <div class="tab" data-tab="history">My Tickets</div>
      <div class="tab" data-tab="guides">Guides</div>
    </div>

    <!-- FAQ -->
    <div class="panel" id="faqPanel">
      <h2>Quick Help</h2>
      <div class="faq-list" id="faqList">
        <div class="q"><strong>Login nahi ho raha?</strong>
          <div class="a">Password reset page se reset karo. Agar still issue hai to ticket banao.</div>
        </div>
        <div class="q"><strong>Withdraw kitne din me?</strong>
          <div class="a">Usually minutes, max 48h in rare cases.</div>
        </div>
        <div class="q"><strong>Game crash fix?</strong>
          <div class="a">Drivers update + Run as admin + Disable overlays.</div>
        </div>
      </div>
    </div>

    <!-- FORM -->
    <div class="panel hidden" id="formPanel">
      <h2>Submit Ticket</h2>
      <form id="ticketForm">
        <div class="form-row">
          <input class="input" name="name" placeholder="Your Name" required>
          <input class="input" name="email" placeholder="Email" type="email" required>
        </div>
        <div class="form-row">
          <select name="category" class="input" required>
            <option value="">Select Category</option>
            <option>Account</option>
            <option>Payments</option>
            <option>Technical</option>
            <option>Gameplay</option>
          </select>
        </div>
        <div class="form-row">
          <textarea name="msg" placeholder="Describe your issue..." required></textarea>
        </div>
        <div class="form-row">
          <label class="attach">Attach Screenshot
            <input type="file" id="attachInput" multiple accept="image/*">
          </label>
          <div id="preview"></div>
        </div>
        <button class="btn" type="submit">Submit Ticket</button>
        <div class="note">Drafts auto-saved locally</div>
      </form>
    </div>

    <!-- STATUS -->
    <div class="panel hidden" id="statusPanel">
      <h2>System Status</h2>
      <div class="status" id="statusCards">
        <div class="card up"><h3>Auth</h3><span>Operational</span></div>
        <div class="card up"><h3>Matchmaking</h3><span>Operational</span></div>
        <div class="card up"><h3>Payments</h3><span>Operational</span></div>
        <div class="card up"><h3>Voice</h3><span>Operational</span></div>
      </div>
    </div>

    <!-- HISTORY -->
    <div class="panel hidden" id="historyPanel">
      <h2>My Tickets</h2>
      <div id="history"></div>
    </div>

    <!-- GUIDES -->
    <div class="panel hidden" id="guidesPanel">
      <h2>Guides</h2>
      <p><a href="faq.php">Visit FAQ</a> • <a href="about.php">About Us</a></p>
      <p>Step-by-step setup videos coming soon!</p>
    </div>

  </div>
</div>

<!-- WIDGET -->
<div class="widget" id="widget">
  <div class="bubble">
    <h3>Need Quick Help?</h3>
    <div class="actions">
      <a href="#faq" class="faq">FAQ</a>
      <a href="#form" class="chat">New Ticket</a>
    </div>
  </div>
</div>

<script>
// BG particles
(function(){
 const c=document.getElementById('bgcanvas'),ctx=c.getContext('2d');
 let w,h;function rs(){w=c.width=innerWidth;h=c.height=innerHeight}rs();addEventListener('resize',rs);
 const pts=[...Array(80)].map(()=>({x:Math.random()*w,y:Math.random()*h,vx:(Math.random()-.5)*.6,vy:(Math.random()-.5)*.6}));
 function loop(){ctx.fillStyle="#05060c";ctx.fillRect(0,0,w,h);for(let p of pts){p.x+=p.vx;p.y+=p.vy;if(p.x<0||p.x>w)p.vx*=-1;if(p.y<0||p.y>h)p.vy*=-1;ctx.fillStyle="rgba(255,40,60,.35)";ctx.fillRect(p.x,p.y,2,2);}requestAnimationFrame(loop);}loop();
})();

// Tabs
const tabs=document.getElementById('tabs').children;
function showPanel(name){
  ['faq','form','status','history','guides'].forEach(id=>{
    document.getElementById(id+'Panel').classList.toggle('hidden',id!==name);
  });
  [...tabs].forEach(t=>t.classList.toggle('active',t.dataset.tab===name));
}
[...tabs].forEach(t=>t.onclick=()=>showPanel(t.dataset.tab));

// FAQ toggle
document.getElementById('faqList').addEventListener('click',e=>{
  const q=e.target.closest('.q');if(!q)return;q.classList.toggle('open');
});

// FORM with preview + save draft
const form=document.getElementById('ticketForm');
const attach=document.getElementById('attachInput');
const preview=document.getElementById('preview');
const LSKEY="ticketDraft";
function saveDraft(){localStorage.setItem(LSKEY,JSON.stringify(Object.fromEntries(new FormData(form))));}
function loadDraft(){try{const d=JSON.parse(localStorage.getItem(LSKEY));if(d)for(let k in d){if(form[k])form[k].value=d[k];}}catch{}}
form.addEventListener('input',saveDraft);loadDraft();
attach.onchange=()=>{preview.innerHTML="";[...attach.files].forEach(f=>{const img=document.createElement("img");img.src=URL.createObjectURL(f);preview.appendChild(img);});};
form.onsubmit=e=>{
  e.preventDefault();
  const data=Object.fromEntries(new FormData(form));
  let hist=JSON.parse(localStorage.getItem("ticketHist")||"[]");
  hist.unshift({time:new Date().toLocaleString(),...data});
  localStorage.setItem("ticketHist",JSON.stringify(hist));
  localStorage.removeItem(LSKEY);
  alert("Ticket submitted!");
  form.reset();preview.innerHTML="";
  renderHistory();
};

// HISTORY
function renderHistory(){
 const box=document.getElementById("history");
 let hist=JSON.parse(localStorage.getItem("ticketHist")||"[]");
 if(!hist.length){box.innerHTML="<div class='empty'>No tickets yet</div>";return;}
 box.innerHTML=hist.map(h=>`<div class="history-item"><strong>${h.category} • ${h.time}</strong><div>${h.msg}</div></div>`).join("");
}
renderHistory();

// THEME
document.getElementById("themeBtn").onclick=()=>{document.body.classList.toggle("dark");};

// Quick widget
document.getElementById("widget").addEventListener("click",e=>{
 if(e.target.matches(".faq")){e.preventDefault();showPanel("faq");}
 if(e.target.matches(".chat")){e.preventDefault();showPanel("form");}
});

// Shortcut: N for new ticket
addEventListener("keydown",e=>{
 if(e.key.toLowerCase()==="n"){showPanel("form");}
});
</script>

<?php require __DIR__ . "/partials/footer.php"; ?>