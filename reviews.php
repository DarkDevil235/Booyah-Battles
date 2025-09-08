<?php
// reviews.php
$title = "Reviews • Battle OP";
require __DIR__ . "/partials/header.php";
?>

<style>
/* ================= REVIEWS PAGE ================= */
:root{
  --accent:#ff1744;
  --panel:#12121c;
  --panel2:#181825;
  --text:#fff;
  --muted:#9ea2b7;
}
.reviews-wrap{
  display:flex; gap:20px; width:min(1200px,96vw);
  margin:0 auto; padding:40px 0;
  position:relative; z-index:1;
}
.rev-bg{ position:fixed; inset:0; z-index:-2; }
.rev-bg canvas{ width:100%; height:100%; display:block; }

/* Left feed */
.feed{ flex:2; display:flex; flex-direction:column; gap:20px; }
.card{
  background:var(--panel); border-radius:14px;
  padding:20px; color:#fff; box-shadow:0 6px 20px rgba(0,0,0,.6);
  position:relative; overflow:hidden; transition:.35s;
}
.card:hover{ transform:translateY(-4px); box-shadow:0 10px 30px rgba(0,0,0,.7); }
.card .head{ display:flex; gap:12px; align-items:center; margin-bottom:12px; }
.avatar{
  width:42px; height:42px; border-radius:50%; display:flex; align-items:center; justify-content:center;
  font-weight:700; background:linear-gradient(135deg,#ff1744,#ff5f00); color:#fff;
}
.meta{ font-size:14px; color:var(--muted); }
.card .title{ font-weight:600; margin-bottom:6px; }
.card .stars{ color:gold; font-size:16px; margin-bottom:8px; }
.card .body{ max-height:80px; overflow:hidden; transition:.3s; color:#ddd; }
.card.expanded .body{ max-height:300px; }
.expand{ cursor:pointer; font-size:13px; color:var(--accent); margin-top:6px; }

/* Right panel */
.side{ flex:1; background:var(--panel2); border-radius:14px;
  padding:20px; color:#fff; box-shadow:0 6px 20px rgba(0,0,0,.6);
  display:flex; flex-direction:column; gap:20px;
}
.side h3{ margin-bottom:8px; }
.chart{ height:200px; background:#0b0b14; border-radius:10px; position:relative; padding:10px; }
.bar{ position:absolute; bottom:0; width:40px; background:var(--accent); border-radius:6px 6px 0 0; transition:.5s; }
.bar-label{ position:absolute; bottom:-20px; width:40px; text-align:center; font-size:12px; color:#ccc; }
.bar-val{ position:absolute; top:-20px; width:40px; text-align:center; font-size:12px; color:#fff; }

/* Rating + Review form */
.rate-box{ background:#0b0b14; border-radius:10px; padding:14px; text-align:center; }
.stars-input span{ font-size:24px; cursor:pointer; color:#555; transition:.3s; }
.stars-input span.active{ color:gold; transform:scale(1.2); }
.review-form{
  background:#0b0b14; border-radius:10px; padding:14px; margin-top:10px;
  display:flex; flex-direction:column; gap:10px;
}
.review-form textarea{
  width:100%; min-height:60px; border-radius:6px; border:none;
  padding:8px; font-size:14px; resize:vertical;
}
.review-form button{
  background:var(--accent); color:#fff; border:none; border-radius:6px;
  padding:8px; cursor:pointer; font-weight:600; transition:.3s;
}
.review-form button:hover{ background:#ff455f; }

/* Infinite scroll loader */
.loader{ text-align:center; padding:20px; color:#aaa; }
</style>

<div class="rev-bg"><canvas id="stars"></canvas></div>

<div class="reviews-wrap">
  <!-- Feed -->
  <div class="feed" id="feed">
    <!-- Reviews injected by JS -->
  </div>

  <!-- Side -->
  <div class="side">
    <div>
      <h3>Community Ratings</h3>
      <div class="chart" id="chart"></div>
    </div>
    <div class="rate-box">
      <h3>Your Rating</h3>
      <div class="stars-input" id="rateInput">
        <span data-val="1">★</span>
        <span data-val="2">★</span>
        <span data-val="3">★</span>
        <span data-val="4">★</span>
        <span data-val="5">★</span>
      </div>
      <small style="color:#999;">Select stars & write review</small>
    </div>
    <div class="review-form">
      <textarea id="reviewText" placeholder="Write your review..."></textarea>
      <button id="submitReview">Submit</button>
    </div>
  </div>
</div>
<div class="loader" id="loader">Scroll down to load more reviews...</div>

<script>
/* ========== Falling Stars Background ========== */
(function(){
  const c=document.getElementById("stars"),ctx=c.getContext("2d");
  let w,h;let stars=[];
  function resize(){w=c.width=innerWidth;h=c.height=innerHeight;}
  function Star(){this.x=Math.random()*w;this.y=Math.random()*-h;this.speed=2+Math.random()*3;this.size=1+Math.random()*2;}
  Star.prototype.update=function(){this.y+=this.speed;if(this.y>h){this.y=-10;this.x=Math.random()*w;}}
  Star.prototype.draw=function(){ctx.beginPath();ctx.fillStyle="rgba(255,255,255,.8)";ctx.arc(this.x,this.y,this.size,0,Math.PI*2);ctx.fill();}
  function loop(){ctx.clearRect(0,0,w,h);stars.forEach(s=>{s.update();s.draw();});requestAnimationFrame(loop);}
  resize();addEventListener("resize",resize);for(let i=0;i<150;i++)stars.push(new Star());loop();
})();

/* ========== Fake Review Data ========== */
let reviews=[
  {user:"Arjun", rating:5, title:"Mind-blowing!", text:"This game is fire 🔥🔥. Graphics, gameplay, everything top notch. Feels like a console on mobile.", time:"2h ago"},
  {user:"Sara", rating:4, title:"Solid fun", text:"I enjoyed it a lot, especially the new battle modes. Could improve matchmaking though.", time:"5h ago"},
  {user:"Imran", rating:3, title:"Decent", text:"Not bad, but feels grindy after some time. Hope updates bring variety.", time:"8h ago"},
  {user:"Lina", rating:5, title:"Epic battles", text:"Me and my squad play daily. Smooth controls, zero lag.", time:"1d ago"},
  {user:"Ravi", rating:2, title:"Meh", text:"Buggy on my device. Crashes randomly. Please fix devs.", time:"2d ago"}
];
let feed=document.getElementById("feed");
function avatar(name){return name[0].toUpperCase();}
function makeCard(r){
  let c=document.createElement("div");c.className="card";
  c.innerHTML=`<div class="head">
    <div class="avatar">${avatar(r.user)}</div>
    <div>
      <div class="title">${r.user}</div>
      <div class="meta">${r.time}</div>
    </div>
  </div>
  <div class="title">${r.title}</div>
  <div class="stars">${"★".repeat(r.rating)}${"☆".repeat(5-r.rating)}</div>
  <div class="body">${r.text}</div>
  <div class="expand">Read more</div>`;
  c.querySelector(".expand").addEventListener("click",()=>c.classList.toggle("expanded"));
  return c;
}
function loadReviews(batch=reviews){
  batch.forEach(r=>feed.appendChild(makeCard(r)));
}
loadReviews();

/* ========== Infinite Scroll (dummy new reviews) ========== */
let moreCount=0;
window.addEventListener("scroll",()=>{
  if(window.innerHeight+window.scrollY>=document.body.offsetHeight-50){
    if(moreCount<3){
      moreCount++;
      document.getElementById("loader").textContent="Loading...";
      setTimeout(()=>{
        let extra=[
          {user:"Guest"+Math.floor(Math.random()*100), rating:Math.ceil(Math.random()*5), title:"Random review", text:"This is an auto-loaded review to test infinite scroll.", time:"just now"}
        ];
        loadReviews(extra);
        document.getElementById("loader").textContent="Scroll down to load more reviews...";
      },1000);
    }else{ document.getElementById("loader").textContent="No more reviews."; }
  }
});

/* ========== Ratings Chart ========== */
let chart=document.getElementById("chart");
let counts={1:1,2:2,3:3,4:2,5:4};
function renderChart(){
  chart.innerHTML="";
  let max=Math.max(...Object.values(counts));
  let idx=0;
  for(let i=1;i<=5;i++){
    let h=(counts[i]/max)*160||0;
    let bar=document.createElement("div");
    bar.className="bar"; bar.style.left=(idx*60+20)+"px"; bar.style.height=h+"px";
    let lbl=document.createElement("div");lbl.className="bar-label";lbl.style.left=(idx*60+20)+"px";lbl.textContent=i+"★";
    let val=document.createElement("div");val.className="bar-val";val.style.left=(idx*60+20)+"px";val.textContent=counts[i];
    chart.appendChild(bar);chart.appendChild(lbl);chart.appendChild(val);
    idx++;
  }
}
renderChart();

/* ========== Interactive Rating Input + Text Review ========== */
document.querySelectorAll("#rateInput span").forEach(st=>{
  st.addEventListener("click",()=>{
    let v=parseInt(st.dataset.val);
    document.querySelectorAll("#rateInput span").forEach(s=>s.classList.remove("active"));
    for(let i=0;i<v;i++){document.querySelectorAll("#rateInput span")[i].classList.add("active");}
  });
});

// Random email generator
function randomEmail(){
  let names=["alpha","beta","gamma","delta","sigma","player"];
  return names[Math.floor(Math.random()*names.length)]+Math.floor(Math.random()*100)+"@example.com";
}

// Submit Review
document.getElementById("submitReview").addEventListener("click",()=>{
  let text=document.getElementById("reviewText").value.trim();
  let stars=document.querySelectorAll("#rateInput .active").length;
  if(stars===0){ alert("Please select a star rating first."); return; }
  if(text.length<5){ alert("Review must be at least 5 characters."); return; }
  
  let newReview={
    user: randomEmail(), 
    rating: stars, 
    title: "User Review", 
    text: text, 
    time: "just now"
  };
  
  feed.prepend(makeCard(newReview)); // Top par add
  counts[stars]++; renderChart();
  document.getElementById("reviewText").value="";
  document.querySelectorAll("#rateInput span").forEach(s=>s.classList.remove("active"));
  alert("Thanks for your review!");
});
</script>

<?php require __DIR__ . "/partials/footer.php"; ?>