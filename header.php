<?php
// header.php
if (!isset($title)) $title = "Battle OP";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($title) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
  :root{
    --bg:#05060c;--fg:#f6f7ff;--accent:#ff1744;--accent2:#ff6a00;
    --panel:#101223;--line:#2c2f52;--blur:rgba(10,10,20,0.65);
  }
  *{margin:0;padding:0;box-sizing:border-box;font-family:Segoe UI,Arial}
  body{background:var(--bg);color:var(--fg);}

  /* HEADER */
  header{
    position:sticky;top:0;z-index:1000;
    backdrop-filter:blur(12px);background:var(--blur);
    display:flex;align-items:center;justify-content:space-between;
    padding:12px 24px;border-bottom:1px solid #202340;
  }
  .logo{font-size:26px;font-weight:800;color:var(--accent);letter-spacing:1px;cursor:pointer}
  nav{display:flex;gap:18px;align-items:center;}
  nav a{color:var(--fg);text-decoration:none;font-weight:600;transition:.2s;padding:6px 10px;border-radius:6px}
  nav a:hover{background:rgba(255,40,70,.15);color:var(--accent)}

  /* DROPDOWN */
  .dropdown{position:relative}
  .dropdown:hover .menu{display:block}
  .menu{display:none;position:absolute;top:110%;left:0;background:#13142b;border:1px solid #2a2e52;border-radius:10px;overflow:hidden;min-width:150px;box-shadow:0 8px 30px rgba(0,0,0,.4)}
  .menu a{display:block;padding:10px 14px;font-weight:500}
  .menu a:hover{background:#1b1e3d}

  /* SEARCH */
  .search{position:relative}
  .search input{padding:8px 30px 8px 12px;border-radius:8px;border:1px solid #2a2e52;background:#0f1025;color:#fff}
  .search .icon{position:absolute;right:8px;top:50%;transform:translateY(-50%);color:#888}

  /* CLOCK + NOTIFICATION */
  .right{display:flex;align-items:center;gap:18px}
  .clock{font-size:14px;color:#ccc}
  .notif{position:relative;cursor:pointer}
  .notif span{position:absolute;top:-4px;right:-4px;background:var(--accent);color:#fff;border-radius:50%;font-size:10px;padding:2px 5px}
  .notif-box{display:none;position:absolute;top:130%;right:0;background:#13142b;border:1px solid #2a2e52;border-radius:10px;min-width:220px;box-shadow:0 6px 20px rgba(0,0,0,.5)}
  .notif-box.active{display:block}
  .notif-box div{padding:10px;border-bottom:1px solid #22264a;font-size:14px}
  .notif-box div:last-child{border:none}

  /* PROFILE */
  .profile{position:relative;cursor:pointer}
  .profile-menu{display:none;position:absolute;top:130%;right:0;background:#13142b;border:1px solid #2a2e52;border-radius:10px;overflow:hidden;min-width:180px}
  .profile-menu a{display:block;padding:10px;font-size:14px;color:#eee}
  .profile-menu a:hover{background:#1c1e3c}
  .profile.open .profile-menu{display:block}

  /* TOGGLE THEME */
  .theme-btn{cursor:pointer;background:#1a1c38;border:none;border-radius:8px;padding:6px 10px;color:#fff;font-weight:600}

  /* MOBILE MENU */
  .burger{display:none;flex-direction:column;gap:4px;cursor:pointer}
  .burger span{width:24px;height:3px;background:#fff;border-radius:2px}
  .mobile{display:none;position:absolute;top:100%;left:0;right:0;background:#101223;border-top:1px solid #2a2e52;flex-direction:column}
  .mobile a{padding:12px 20px;border-bottom:1px solid #222645}
  .mobile a:hover{background:#16183a}

  @media(max-width:800px){
    nav{display:none}
    .burger{display:flex}
    .mobile{display:flex;display:none}
    .mobile.show{display:flex}
  }
  </style>
</head>
<body>
<header>
  <div class="logo">BATTLE<span style="color:var(--accent2)">OP</span></div>
  <nav>
    <a href="home.php">Home</a>
    <div class="dropdown">
      <a href="games.php">Games ▾</a>
      <div class="menu">
        <a href="#">Action</a>
        <a href="#">Shooter</a>
        <a href="#">Arcade</a>
      </div>
    </div>
    <a href="reviews.php">Reviews</a>
    <a href="about.php">About</a>
    <a href="faq.php">FAQ</a>
    <a href="support.php">Support</a>
    <div class="search">
      <input type="text" placeholder="Search..."><span class="icon">🔍</span>
    </div>
  </nav>
  <div class="burger" id="burger">
    <span></span><span></span><span></span>
  </div>
  <div class="right">
    <div class="clock" id="clock">--:--:--</div>
    <div class="notif" id="notifBell">🔔<span id="notifCount">3</span>
      <div class="notif-box" id="notifBox">
        <div>Update 1.2 Released!</div>
        <div>Server maintenance 8PM</div>
        <div>New rewards available</div>
      </div>
    </div>
    <button class="theme-btn" id="themeBtn">Toggle</button>
    <div class="profile" id="profile">
      <span>👤</span>
      <div class="profile-menu">
        <a href="#">Login</a>
        <a href="#">Register</a>
        <a href="#">My Account</a>
      </div>
    </div>
  </div>
</header>
<div class="mobile" id="mobileNav">
  <a href="home.php">Home</a>
  <a href="games.php">Games</a>
  <a href="reviews.php">Reviews</a>
  <a href="about.php">About</a>
  <a href="faq.php">FAQ</a>
  <a href="support.php">Support</a>
</div>

<script>
// CLOCK
function updateClock(){
  document.getElementById("clock").textContent=new Date().toLocaleTimeString();
}
setInterval(updateClock,1000);updateClock();

// NOTIF
const bell=document.getElementById("notifBell"),box=document.getElementById("notifBox");
bell.onclick=()=>box.classList.toggle("active");

// PROFILE MENU
const profile=document.getElementById("profile");
profile.onclick=()=>profile.classList.toggle("open");

// THEME TOGGLE
document.getElementById("themeBtn").onclick=()=>{
  document.body.classList.toggle("light");
  if(document.body.classList.contains("light")){
    document.documentElement.style.setProperty("--bg","#fafafa");
    document.documentElement.style.setProperty("--fg","#111");
    document.documentElement.style.setProperty("--blur","rgba(250,250,250,0.7)");
  }else{
    document.documentElement.style.setProperty("--bg","#05060c");
    document.documentElement.style.setProperty("--fg","#f6f7ff");
    document.documentElement.style.setProperty("--blur","rgba(10,10,20,0.65)");
  }
};

// BURGER
const burger=document.getElementById("burger"),mobile=document.getElementById("mobileNav");
burger.onclick=()=>mobile.classList.toggle("show");
</script>