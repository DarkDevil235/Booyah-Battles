<?php
// footer.php

// Simple visitor counter (session-based demo)
session_start();
if (!isset($_SESSION['visited'])) {
    $_SESSION['visited'] = true;
    if (!file_exists("counter.txt")) file_put_contents("counter.txt", 0);
    $count = (int)file_get_contents("counter.txt") + 1;
    file_put_contents("counter.txt", $count);
}
$visits = (int)file_get_contents("counter.txt");
?>
<style>
  footer{
    position:relative;
    background:#0a0a15;
    color:#ddd;
    padding:80px 30px 40px;
    overflow:hidden;
  }
  /* WAVES BG */
  .waves{
    position:absolute;
    top:-50px;left:0;width:100%;height:150px;z-index:0;
  }
  .wave path{
    animation:waveMove 8s linear infinite;
  }
  @keyframes waveMove{
    0%{transform:translateX(0);}
    100%{transform:translateX(-50%);}
  }

  /* FOOTER GRID */
  .footer-container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:40px;
    position:relative;
    z-index:1;
  }
  .footer-box h3{
    color:#ff1744;
    margin-bottom:18px;
    font-size:20px;
  }
  .footer-box a{
    display:block;
    color:#ccc;
    margin:8px 0;
    text-decoration:none;
    transition:.2s;
  }
  .footer-box a:hover{color:#ff1744;text-shadow:0 0 10px #ff1744;}

  /* NEWSLETTER */
  .newsletter input{
    padding:10px;border:none;border-radius:6px 0 0 6px;
    outline:none;width:70%;
  }
  .newsletter button{
    padding:10px 16px;border:none;border-radius:0 6px 6px 0;
    background:#ff1744;color:#fff;cursor:pointer;font-weight:bold;
    transition:.3s;
  }
  .newsletter button:hover{background:#e60f38;box-shadow:0 0 15px #ff1744;}

  /* BOTTOM LINE */
  .footer-bottom{
    margin-top:50px;
    text-align:center;
    font-size:14px;
    color:#aaa;
    border-top:1px solid #222;
    padding-top:20px;
  }
  .socials a{margin:0 8px;font-size:20px;text-decoration:none;color:#fff;}
  .socials a:hover{color:#ff1744;text-shadow:0 0 15px #ff1744;}

  /* VISITOR */
  .visitor{
    margin-top:10px;
    font-size:13px;
    color:#888;
  }
</style>

<footer>
  <!-- SVG Waves -->
  <svg class="waves" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
    <path d="M0,0 C300,120 900,0 1200,120 L1200,0 L0,0 Z" fill="rgba(255,23,68,0.15)" class="wave"></path>
    <path d="M0,0 C400,100 800,20 1200,100 L1200,0 L0,0 Z" fill="rgba(255,23,68,0.25)" class="wave"></path>
    <path d="M0,0 C600,100 600,0 1200,80 L1200,0 L0,0 Z" fill="rgba(255,23,68,0.4)" class="wave"></path>
  </svg>

  <div class="footer-container">
    <div class="footer-box">
      <h3>Quick Links</h3>
      <a href="home.php">Home</a>
      <a href="games.php">Games</a>
      <a href="reviews.php">Reviews</a>
      <a href="about.php">About</a>
      <a href="faq.php">FAQ</a>
      <a href="support.php">Support</a>
    </div>
    <div class="footer-box">
      <h3>Top Games</h3>
      <a href="#">BGMI</a>
      <a href="#">Free Fire</a>
      <a href="#">COD Mobile</a>
      <a href="#">PUBG Lite</a>
    </div>
    <div class="footer-box">
      <h3>Support</h3>
      <a href="#">Help Center</a>
      <a href="#">Report Issue</a>
      <a href="#">Terms & Conditions</a>
      <a href="#">Privacy Policy</a>
    </div>
    <div class="footer-box">
      <h3>Newsletter</h3>
      <form class="newsletter" onsubmit="event.preventDefault();alert('Subscribed!');">
        <input type="email" placeholder="Enter email" required>
        <button type="submit">Join</button>
      </form>
      <div class="socials" style="margin-top:20px;">
        <a href="#">👍</a>
        <a href="#">🐦</a>
        <a href="#">📸</a>
        <a href="#">▶️</a>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    © <?= date("Y") ?> Battle OP | All Rights Reserved.
    <div class="visitor">👀 Visitors: <?= $visits ?></div>
  </div>
</footer>