/* ======================================================
   APP.JS - Battle OP Website Effects & Interactions
   Custom made | Unique | Not AI-Generated Style
   ====================================================== */

/* ========= GLOBAL SETUP ========= */
document.addEventListener("DOMContentLoaded", () => {
  console.log("%c Battle OP Loaded ⚡", "color: red; font-size:16px; font-weight:bold;");

  initParticles();
  initCursor();
  initParallax();
  initSmoothScroll();
  initGlowHover();
  initButtonsRipple();
  initTypeWriter();
  initNavHighlighter();
});

/* ========= PARTICLE BACKGROUND ========= */
function initParticles() {
  const canvas = document.createElement("canvas");
  canvas.id = "particle-bg";
  document.body.appendChild(canvas);
  const ctx = canvas.getContext("2d");

  let particles = [];
  const numParticles = 150;

  function resize() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  }
  window.addEventListener("resize", resize);
  resize();

  class Particle {
    constructor() {
      this.reset();
    }
    reset() {
      this.x = Math.random() * canvas.width;
      this.y = Math.random() * canvas.height;
      this.size = Math.random() * 3 + 1;
      this.speedX = (Math.random() - 0.5) * 2;
      this.speedY = (Math.random() - 0.5) * 2;
    }
    update() {
      this.x += this.speedX;
      this.y += this.speedY;
      if (this.x < 0 || this.x > canvas.width || this.y < 0 || this.y > canvas.height) {
        this.reset();
      }
    }
    draw() {
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
      ctx.fillStyle = "rgba(255,0,0,0.7)";
      ctx.shadowBlur = 20;
      ctx.shadowColor = "red";
      ctx.fill();
    }
  }

  function connect() {
    for (let a = 0; a < particles.length; a++) {
      for (let b = a; b < particles.length; b++) {
        let dx = particles[a].x - particles[b].x;
        let dy = particles[a].y - particles[b].y;
        let dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < 120) {
          ctx.beginPath();
          ctx.strokeStyle = "rgba(255,0,0,0.3)";
          ctx.moveTo(particles[a].x, particles[a].y);
          ctx.lineTo(particles[b].x, particles[b].y);
          ctx.stroke();
        }
      }
    }
  }

  function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    particles.forEach(p => {
      p.update();
      p.draw();
    });
    connect();
    requestAnimationFrame(animate);
  }

  for (let i = 0; i < numParticles; i++) {
    particles.push(new Particle());
  }
  animate();
}

/* ========= CUSTOM CURSOR ========= */
function initCursor() {
  const cursor = document.createElement("div");
  cursor.id = "cursor";
  document.body.appendChild(cursor);

  const style = document.createElement("style");
  style.innerHTML = `
    #cursor {
      width: 20px; height: 20px;
      border: 2px solid red;
      border-radius: 50%;
      position: fixed;
      transform: translate(-50%, -50%);
      pointer-events: none;
      z-index: 9999;
      transition: transform 0.15s ease-out, width 0.2s, height 0.2s;
    }
    a:hover ~ #cursor, button:hover ~ #cursor {
      width: 40px; height: 40px;
      background: rgba(255,0,0,0.2);
    }
  `;
  document.head.appendChild(style);

  document.addEventListener("mousemove", e => {
    cursor.style.left = `${e.pageX}px`;
    cursor.style.top = `${e.pageY}px`;
  });
}

/* ========= PARALLAX EFFECT ========= */
function initParallax() {
  document.addEventListener("mousemove", e => {
    const x = (window.innerWidth / 2 - e.pageX) / 100;
    const y = (window.innerHeight / 2 - e.pageY) / 100;
    document.querySelectorAll(".parallax").forEach(el => {
      el.style.transform = `translate(${x}px, ${y}px)`;
    });
  });
}

/* ========= SMOOTH SCROLL ========= */
function initSmoothScroll() {
  document.querySelectorAll("a[href^='#']").forEach(anchor => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      document.querySelector(this.getAttribute("href")).scrollIntoView({
        behavior: "smooth"
      });
    });
  });
}

/* ========= GLOW HOVER CARDS ========= */
function initGlowHover() {
  document.querySelectorAll(".feature-box").forEach(box => {
    box.addEventListener("mousemove", e => {
      const rect = box.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      box.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(255,0,0,0.3), #111)`;
    });
    box.addEventListener("mouseleave", () => {
      box.style.background = "#111";
    });
  });
}

/* ========= RIPPLE BUTTONS ========= */
function initButtonsRipple() {
  document.querySelectorAll("a, button").forEach(btn => {
    btn.addEventListener("click", function (e) {
      let ripple = document.createElement("span");
      ripple.className = "ripple";
      this.appendChild(ripple);

      let x = e.clientX - this.getBoundingClientRect().left;
      let y = e.clientY - this.getBoundingClientRect().top;

      ripple.style.left = `${x}px`;
      ripple.style.top = `${y}px`;

      setTimeout(() => ripple.remove(), 600);
    });
  });

  const style = document.createElement("style");
  style.innerHTML = `
    .ripple {
      position: absolute;
      width: 20px; height: 20px;
      background: rgba(255,0,0,0.5);
      border-radius: 50%;
      transform: scale(0);
      animation: rippleAnim 0.6s linear;
      pointer-events: none;
    }
    @keyframes rippleAnim {
      to {
        transform: scale(10);
        opacity: 0;
      }
    }
  `;
  document.head.appendChild(style);
}

/* ========= TYPEWRITER TEXT ========= */
function initTypeWriter() {
  const hero = document.querySelector(".hero h1");
  if (!hero) return;
  const text = hero.innerText;
  hero.innerText = "";
  let i = 0;

  function typing() {
    if (i < text.length) {
      hero.innerText += text.charAt(i);
      i++;
      setTimeout(typing, 120);
    }
  }
  typing();
}

/* ========= NAV HIGHLIGHT ON SCROLL ========= */
function initNavHighlighter() {
  const sections = document.querySelectorAll("section");
  const navLinks = document.querySelectorAll("header nav a");

  window.addEventListener("scroll", () => {
    let current = "";
    sections.forEach(section => {
      const top = section.offsetTop - 100;
      if (pageYOffset >= top) {
        current = section.getAttribute("id");
      }
    });

    navLinks.forEach(link => {
      link.classList.remove("active");
      if (link.getAttribute("href").includes(current)) {
        link.classList.add("active");
      }
    });
  });
}