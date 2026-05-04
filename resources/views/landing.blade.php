<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FitLife Gym — Forge Your Legacy</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Bebas+Neue&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{--red:#e63946;--red2:#ff6b6b;--dark:#080b14;--dark2:#0d1117;--card:#0f1623;--border:rgba(230,57,70,.18);--glow:rgba(230,57,70,.45)}
html{scroll-behavior:smooth}
body{background:var(--dark);color:#fff;font-family:'Inter',sans-serif;overflow-x:hidden}
/* ── CANVAS BG ── */
#heroCanvas{position:fixed;top:0;left:0;width:100%;height:100%;z-index:0;pointer-events:none}
/* ── NAV ── */
nav{position:fixed;top:0;left:0;right:0;z-index:100;padding:1.2rem 4rem;display:flex;align-items:center;justify-content:space-between;transition:background .4s,backdrop-filter .4s}
nav.scrolled{background:rgba(8,11,20,.85);backdrop-filter:blur(20px);border-bottom:1px solid var(--border)}
.nav-brand{display:flex;align-items:center;gap:.75rem;text-decoration:none}
.nav-logo{width:38px;height:38px;background:var(--red);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;box-shadow:0 0 20px var(--glow)}
.nav-name{font-size:1.1rem;font-weight:800;color:#fff;letter-spacing:.02em}
.nav-links{display:flex;align-items:center;gap:2rem}
.nav-links a{color:rgba(255,255,255,.65);text-decoration:none;font-size:.875rem;font-weight:500;transition:color .2s}
.nav-links a:hover{color:#fff}
.nav-cta{background:var(--red);color:#fff;padding:.55rem 1.4rem;border-radius:8px;font-weight:600;font-size:.875rem;text-decoration:none;transition:background .2s,box-shadow .2s,transform .15s;box-shadow:0 0 18px var(--glow)}
.nav-cta:hover{background:#c1121f;transform:translateY(-1px);box-shadow:0 0 30px var(--glow)}
/* ── HERO ── */
#hero{position:relative;min-height:100vh;display:flex;align-items:center;justify-content:center;text-align:center;z-index:1;padding:0 2rem}
.hero-inner{max-width:900px}
.hero-badge{display:inline-flex;align-items:center;gap:.5rem;background:rgba(230,57,70,.12);border:1px solid var(--border);border-radius:50px;padding:.4rem 1.1rem;font-size:.78rem;font-weight:600;color:var(--red2);letter-spacing:.06em;text-transform:uppercase;margin-bottom:2rem;animation:fadeUp .8s ease both}
.hero-badge span{width:6px;height:6px;background:var(--red);border-radius:50%;box-shadow:0 0 8px var(--red);animation:pulse 1.5s infinite}
.hero-title{font-family:'Bebas Neue',sans-serif;font-size:clamp(4rem,10vw,9rem);line-height:.95;letter-spacing:.02em;margin-bottom:1.5rem;animation:fadeUp .8s .15s ease both}
.hero-title .line1{display:block;color:#fff}
.hero-title .line2{display:block;background:linear-gradient(135deg,var(--red),var(--red2),#ff9a9e);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;filter:drop-shadow(0 0 30px rgba(230,57,70,.5))}
.hero-sub{font-size:1.1rem;color:rgba(255,255,255,.6);max-width:560px;margin:0 auto 2.5rem;line-height:1.7;animation:fadeUp .8s .3s ease both}
.hero-btns{display:flex;align-items:center;justify-content:center;gap:1rem;flex-wrap:wrap;animation:fadeUp .8s .45s ease both}
.btn-primary{background:var(--red);color:#fff;padding:.85rem 2.2rem;border-radius:10px;font-weight:700;font-size:1rem;text-decoration:none;transition:all .2s;box-shadow:0 0 30px var(--glow),0 4px 20px rgba(230,57,70,.4);position:relative;overflow:hidden}
.btn-primary::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,.15),transparent);opacity:0;transition:opacity .2s}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 0 50px var(--glow),0 8px 30px rgba(230,57,70,.5)}
.btn-primary:hover::before{opacity:1}
.btn-ghost{color:#fff;padding:.85rem 2.2rem;border-radius:10px;font-weight:600;font-size:1rem;text-decoration:none;border:1.5px solid rgba(255,255,255,.2);transition:all .2s;backdrop-filter:blur(10px)}
.btn-ghost:hover{border-color:rgba(255,255,255,.5);background:rgba(255,255,255,.05);transform:translateY(-2px)}
.hero-scroll{position:absolute;bottom:2.5rem;left:50%;transform:translateX(-50%);display:flex;flex-direction:column;align-items:center;gap:.5rem;color:rgba(255,255,255,.35);font-size:.75rem;letter-spacing:.1em;text-transform:uppercase;animation:fadeUp .8s .8s ease both}
.scroll-line{width:1px;height:50px;background:linear-gradient(to bottom,rgba(230,57,70,.8),transparent);animation:scrollLine 2s infinite}
/* ── STATS ── */
#stats{position:relative;z-index:1;padding:5rem 4rem;background:linear-gradient(to bottom,transparent,rgba(13,17,23,.95))}
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:2rem;max-width:1100px;margin:0 auto}
.stat-card{text-align:center;padding:2rem;background:var(--card);border:1px solid var(--border);border-radius:16px;position:relative;overflow:hidden;transition:transform .3s,box-shadow .3s}
.stat-card::before{content:'';position:absolute;inset:0;background:radial-gradient(circle at 50% 0%,rgba(230,57,70,.08),transparent 70%)}
.stat-card:hover{transform:translateY(-6px);box-shadow:0 20px 60px rgba(0,0,0,.4),0 0 30px rgba(230,57,70,.1)}
.stat-num{font-family:'Bebas Neue',sans-serif;font-size:3.5rem;color:var(--red);line-height:1;margin-bottom:.25rem;text-shadow:0 0 30px rgba(230,57,70,.5)}
.stat-label{font-size:.85rem;color:rgba(255,255,255,.5);font-weight:500;letter-spacing:.05em;text-transform:uppercase}
/* ── FEATURES ── */
#features{position:relative;z-index:1;padding:6rem 4rem;background:rgba(13,17,23,.95)}
.section-header{text-align:center;margin-bottom:4rem}
.section-tag{display:inline-block;background:rgba(230,57,70,.12);border:1px solid var(--border);border-radius:50px;padding:.35rem 1rem;font-size:.75rem;font-weight:600;color:var(--red2);letter-spacing:.08em;text-transform:uppercase;margin-bottom:1rem}
.section-title{font-family:'Bebas Neue',sans-serif;font-size:clamp(2.5rem,5vw,4rem);letter-spacing:.03em;margin-bottom:.75rem}
.section-sub{font-size:1rem;color:rgba(255,255,255,.5);max-width:500px;margin:0 auto}
.features-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;max-width:1100px;margin:0 auto}
.feat-card{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:2rem;position:relative;overflow:hidden;transition:transform .3s,box-shadow .3s,border-color .3s;cursor:default}
.feat-card::after{content:'';position:absolute;inset:0;background:radial-gradient(circle at var(--mx,50%) var(--my,50%),rgba(230,57,70,.07),transparent 60%);opacity:0;transition:opacity .3s}
.feat-card:hover{transform:translateY(-6px);box-shadow:0 20px 60px rgba(0,0,0,.5),0 0 40px rgba(230,57,70,.08);border-color:rgba(230,57,70,.35)}
.feat-card:hover::after{opacity:1}
.feat-icon{width:52px;height:52px;background:rgba(230,57,70,.12);border:1px solid rgba(230,57,70,.25);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;margin-bottom:1.25rem;transition:box-shadow .3s}
.feat-card:hover .feat-icon{box-shadow:0 0 20px rgba(230,57,70,.4)}
.feat-title{font-size:1.05rem;font-weight:700;margin-bottom:.6rem}
.feat-desc{font-size:.875rem;color:rgba(255,255,255,.5);line-height:1.65}
/* ── PLANS ── */
#plans{position:relative;z-index:1;padding:6rem 4rem;background:linear-gradient(to bottom,rgba(13,17,23,.95),rgba(8,11,20,1))}
.plans-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;max-width:1000px;margin:0 auto}
.plan-card{background:var(--card);border:1px solid var(--border);border-radius:20px;padding:2.5rem;position:relative;overflow:hidden;transition:transform .3s,box-shadow .3s}
.plan-card.featured{border-color:var(--red);background:linear-gradient(135deg,rgba(230,57,70,.08),var(--card))}
.plan-card.featured::before{content:'POPULAR';position:absolute;top:1.25rem;right:1.25rem;background:var(--red);color:#fff;font-size:.65rem;font-weight:700;letter-spacing:.1em;padding:.25rem .7rem;border-radius:50px;box-shadow:0 0 15px var(--glow)}
.plan-card:hover{transform:translateY(-6px);box-shadow:0 20px 60px rgba(0,0,0,.5)}
.plan-card.featured:hover{box-shadow:0 20px 60px rgba(0,0,0,.5),0 0 40px rgba(230,57,70,.2)}
.plan-name{font-size:.8rem;font-weight:700;color:var(--red2);letter-spacing:.1em;text-transform:uppercase;margin-bottom:.75rem}
.plan-price{font-family:'Bebas Neue',sans-serif;font-size:3.5rem;line-height:1;margin-bottom:.25rem}
.plan-price span{font-family:'Inter',sans-serif;font-size:1rem;font-weight:400;color:rgba(255,255,255,.4)}
.plan-period{font-size:.8rem;color:rgba(255,255,255,.4);margin-bottom:1.75rem}
.plan-features{list-style:none;margin-bottom:2rem}
.plan-features li{display:flex;align-items:center;gap:.6rem;font-size:.875rem;color:rgba(255,255,255,.7);padding:.4rem 0;border-bottom:1px solid rgba(255,255,255,.05)}
.plan-features li:last-child{border:none}
.plan-features li::before{content:'✓';color:var(--red);font-weight:700;font-size:.8rem;flex-shrink:0}
.btn-plan{display:block;text-align:center;padding:.8rem;border-radius:10px;font-weight:600;font-size:.9rem;text-decoration:none;transition:all .2s}
.btn-plan-ghost{border:1.5px solid rgba(255,255,255,.2);color:#fff}
.btn-plan-ghost:hover{border-color:var(--red);color:var(--red2);background:rgba(230,57,70,.05)}
.btn-plan-solid{background:var(--red);color:#fff;box-shadow:0 0 20px var(--glow)}
.btn-plan-solid:hover{background:#c1121f;box-shadow:0 0 35px var(--glow);transform:translateY(-1px)}
/* ── CTA ── */
#cta{position:relative;z-index:1;padding:7rem 4rem;text-align:center;overflow:hidden}
.cta-glow{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:600px;height:600px;background:radial-gradient(circle,rgba(230,57,70,.15),transparent 70%);pointer-events:none}
.cta-title{font-family:'Bebas Neue',sans-serif;font-size:clamp(3rem,7vw,6rem);letter-spacing:.03em;margin-bottom:1rem;position:relative}
.cta-sub{font-size:1.05rem;color:rgba(255,255,255,.55);margin-bottom:2.5rem;position:relative}
.cta-btns{display:flex;align-items:center;justify-content:center;gap:1rem;flex-wrap:wrap;position:relative}
/* ── FOOTER ── */
footer{position:relative;z-index:1;padding:2.5rem 4rem;border-top:1px solid rgba(255,255,255,.06);display:flex;align-items:center;justify-content:space-between;background:rgba(8,11,20,1)}
.footer-brand{display:flex;align-items:center;gap:.6rem;text-decoration:none}
.footer-logo{width:30px;height:30px;background:var(--red);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.85rem;box-shadow:0 0 12px var(--glow)}
.footer-name{font-size:.95rem;font-weight:700;color:#fff}
.footer-copy{font-size:.8rem;color:rgba(255,255,255,.3)}
.footer-links{display:flex;gap:1.5rem}
.footer-links a{font-size:.8rem;color:rgba(255,255,255,.35);text-decoration:none;transition:color .2s}
.footer-links a:hover{color:var(--red2)}
/* ── ANIMATIONS ── */
@keyframes fadeUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
@keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(.8)}}
@keyframes scrollLine{0%{transform:scaleY(0);transform-origin:top}50%{transform:scaleY(1);transform-origin:top}51%{transform:scaleY(1);transform-origin:bottom}100%{transform:scaleY(0);transform-origin:bottom}}
.reveal{opacity:0;transform:translateY(40px);transition:opacity .7s ease,transform .7s ease}
.reveal.visible{opacity:1;transform:translateY(0)}
/* ── RESPONSIVE ── */
@media(max-width:900px){
  nav{padding:1rem 1.5rem}
  .nav-links{display:none}
  #stats{padding:3rem 1.5rem}.stats-grid{grid-template-columns:repeat(2,1fr)}
  #features{padding:4rem 1.5rem}.features-grid{grid-template-columns:1fr}
  #plans{padding:4rem 1.5rem}.plans-grid{grid-template-columns:1fr}
  #cta{padding:4rem 1.5rem}
  footer{padding:2rem 1.5rem;flex-direction:column;gap:1rem;text-align:center}
  .footer-links{justify-content:center}
}
</style>
</head>
<body>

<!-- ══ CANVAS ══ -->
<canvas id="heroCanvas"></canvas>

<!-- ══ NAV ══ -->
<nav id="navbar">
  <a href="#" class="nav-brand">
    <div class="nav-logo">⚡</div>
    <span class="nav-name">FitLife Gym</span>
  </a>
  <div class="nav-links">
    <a href="#features">Features</a>
    <a href="#plans">Plans</a>
    <a href="#cta">Join Now</a>
    <a href="{{ route('member.login') }}" class="nav-cta">Member Login</a>
  </div>
</nav>

<!-- ══ HERO ══ -->
<section id="hero">
  <div class="hero-inner">
    <div class="hero-badge"><span></span>Now Open — New Members Welcome</div>
    <h1 class="hero-title">
      <span class="line1">FORGE YOUR</span>
      <span class="line2">LEGACY</span>
    </h1>
    <p class="hero-sub">State-of-the-art equipment, expert trainers, and a community that pushes you beyond your limits. Your transformation starts today.</p>
    <div class="hero-btns">
      <a href="{{ route('member.register') }}" class="btn-primary">🔥 Start Free Trial</a>
      <a href="{{ route('member.login') }}" class="btn-ghost">Member Login →</a>
    </div>
  </div>
  <div class="hero-scroll">
    <div class="scroll-line"></div>
    <span>Scroll</span>
  </div>
</section>

<!-- ══ STATS ══ -->
<section id="stats">
  <div class="stats-grid">
    <div class="stat-card reveal">
      <div class="stat-num" data-target="2500">0</div>
      <div class="stat-label">Active Members</div>
    </div>
    <div class="stat-card reveal">
      <div class="stat-num" data-target="48">0</div>
      <div class="stat-label">Weekly Classes</div>
    </div>
    <div class="stat-card reveal">
      <div class="stat-num" data-target="15">0</div>
      <div class="stat-label">Expert Trainers</div>
    </div>
    <div class="stat-card reveal">
      <div class="stat-num" data-target="99">0</div>
      <div class="stat-label">% Satisfaction</div>
    </div>
  </div>
</section>

<!-- ══ FEATURES ══ -->
<section id="features">
  <div class="section-header reveal">
    <div class="section-tag">Why FitLife</div>
    <h2 class="section-title">Everything You Need<br>To Dominate</h2>
    <p class="section-sub">A complete ecosystem built around your fitness goals.</p>
  </div>
  <div class="features-grid">
    <div class="feat-card reveal">
      <div class="feat-icon">🏋️</div>
      <div class="feat-title">Premium Equipment</div>
      <p class="feat-desc">Over 200 pieces of cutting-edge equipment from top brands. Free weights, machines, cardio — all maintained daily.</p>
    </div>
    <div class="feat-card reveal">
      <div class="feat-icon">📅</div>
      <div class="feat-title">Class Booking</div>
      <p class="feat-desc">Book yoga, HIIT, spin, boxing and more with one tap. Real-time availability and instant confirmation.</p>
    </div>
    <div class="feat-card reveal">
      <div class="feat-icon">👤</div>
      <div class="feat-title">Personal Trainers</div>
      <p class="feat-desc">Certified coaches who craft personalized programs and track your progress every step of the way.</p>
    </div>
    <div class="feat-card reveal">
      <div class="feat-icon">📊</div>
      <div class="feat-title">Progress Tracking</div>
      <p class="feat-desc">Your member dashboard shows workouts, bookings, payments and membership status in one clean view.</p>
    </div>
    <div class="feat-card reveal">
      <div class="feat-icon">💳</div>
      <div class="feat-title">Flexible Plans</div>
      <p class="feat-desc">Monthly, quarterly or annual memberships. Upgrade, downgrade or pause anytime — no hidden fees.</p>
    </div>
    <div class="feat-card reveal">
      <div class="feat-icon">🔒</div>
      <div class="feat-title">24/7 Access</div>
      <p class="feat-desc">Train on your schedule. Secure keycard access around the clock, every day of the year.</p>
    </div>
  </div>
</section>

<!-- ══ PLANS ══ -->
<section id="plans">
  <div class="section-header reveal">
    <div class="section-tag">Membership Plans</div>
    <h2 class="section-title">Pick Your Power Level</h2>
    <p class="section-sub">Simple, transparent pricing. No contracts, no surprises.</p>
  </div>
  <div class="plans-grid">
    <div class="plan-card reveal">
      <div class="plan-name">Starter</div>
      <div class="plan-price">$29<span>/mo</span></div>
      <div class="plan-period">Billed monthly</div>
      <ul class="plan-features">
        <li>Gym floor access</li>
        <li>2 group classes / week</li>
        <li>Locker room access</li>
        <li>Member dashboard</li>
      </ul>
      <a href="{{ route('member.register') }}" class="btn-plan btn-plan-ghost">Get Started</a>
    </div>
    <div class="plan-card featured reveal">
      <div class="plan-name">Pro</div>
      <div class="plan-price">$59<span>/mo</span></div>
      <div class="plan-period">Billed monthly</div>
      <ul class="plan-features">
        <li>Unlimited gym access</li>
        <li>Unlimited group classes</li>
        <li>1 PT session / month</li>
        <li>Progress tracking</li>
        <li>Guest passes (2/mo)</li>
      </ul>
      <a href="{{ route('member.register') }}" class="btn-plan btn-plan-solid">Join Pro</a>
    </div>
    <div class="plan-card reveal">
      <div class="plan-name">Elite</div>
      <div class="plan-price">$99<span>/mo</span></div>
      <div class="plan-period">Billed monthly</div>
      <ul class="plan-features">
        <li>Everything in Pro</li>
        <li>4 PT sessions / month</li>
        <li>Nutrition coaching</li>
        <li>Priority class booking</li>
        <li>Unlimited guest passes</li>
      </ul>
      <a href="{{ route('member.register') }}" class="btn-plan btn-plan-ghost">Go Elite</a>
    </div>
  </div>
</section>

<!-- ══ CTA ══ -->
<section id="cta">
  <div class="cta-glow"></div>
  <h2 class="cta-title reveal">Ready To<br><span style="background:linear-gradient(135deg,#e63946,#ff6b6b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Transform?</span></h2>
  <p class="cta-sub reveal">Join thousands of members already crushing their goals at FitLife.</p>
  <div class="cta-btns reveal">
    <a href="{{ route('member.register') }}" class="btn-primary">🚀 Create Free Account</a>
    <a href="{{ route('member.login') }}" class="btn-ghost">Already a member? Sign in</a>
  </div>
</section>

<!-- ══ FOOTER ══ -->
<footer>
  <a href="#" class="footer-brand">
    <div class="footer-logo">⚡</div>
    <span class="footer-name">FitLife Gym</span>
  </a>
  <span class="footer-copy">© 2026 FitLife Gym. All rights reserved.</span>
  <div class="footer-links">
    <a href="{{ route('member.login') }}">Member Portal</a>
    <a href="{{ route('login') }}">Admin</a>
  </div>
</footer>

<script>
// ══ CANVAS PARTICLE / 3D GRID ANIMATION ══
(function(){
  const canvas = document.getElementById('heroCanvas');
  const ctx = canvas.getContext('2d');
  let W, H, particles = [], mouse = {x: -9999, y: -9999};

  function resize(){
    W = canvas.width  = window.innerWidth;
    H = canvas.height = window.innerHeight;
  }
  resize();
  window.addEventListener('resize', resize);
  window.addEventListener('mousemove', e => { mouse.x = e.clientX; mouse.y = e.clientY; });

  // Particle class
  class Particle {
    constructor(){
      this.reset();
    }
    reset(){
      this.x  = Math.random() * W;
      this.y  = Math.random() * H;
      this.vx = (Math.random() - .5) * .4;
      this.vy = (Math.random() - .5) * .4;
      this.r  = Math.random() * 1.8 + .4;
      this.alpha = Math.random() * .5 + .1;
      this.color = Math.random() > .7 ? '#e63946' : '#ffffff';
    }
    update(){
      // Subtle mouse repulsion
      const dx = this.x - mouse.x, dy = this.y - mouse.y;
      const dist = Math.sqrt(dx*dx + dy*dy);
      if(dist < 120){
        const force = (120 - dist) / 120 * .6;
        this.vx += (dx / dist) * force;
        this.vy += (dy / dist) * force;
      }
      // Damping
      this.vx *= .98; this.vy *= .98;
      this.x += this.vx; this.y += this.vy;
      if(this.x < 0 || this.x > W) this.vx *= -1;
      if(this.y < 0 || this.y > H) this.vy *= -1;
    }
    draw(){
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.r, 0, Math.PI*2);
      ctx.fillStyle = this.color;
      ctx.globalAlpha = this.alpha;
      ctx.fill();
    }
  }

  // Init particles
  const COUNT = Math.min(120, Math.floor(W * H / 12000));
  for(let i = 0; i < COUNT; i++) particles.push(new Particle());

  // Draw connecting lines
  function drawLines(){
    for(let i = 0; i < particles.length; i++){
      for(let j = i+1; j < particles.length; j++){
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const d  = Math.sqrt(dx*dx + dy*dy);
        if(d < 130){
          ctx.beginPath();
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          const alpha = (1 - d/130) * .18;
          ctx.strokeStyle = `rgba(230,57,70,${alpha})`;
          ctx.globalAlpha = 1;
          ctx.lineWidth = .6;
          ctx.stroke();
        }
      }
    }
  }

  // Animated grid
  let gridOffset = 0;
  function drawGrid(){
    const spacing = 80;
    ctx.globalAlpha = .04;
    ctx.strokeStyle = '#e63946';
    ctx.lineWidth = .5;
    // Vertical lines
    for(let x = (gridOffset % spacing); x < W; x += spacing){
      ctx.beginPath(); ctx.moveTo(x,0); ctx.lineTo(x,H); ctx.stroke();
    }
    // Horizontal lines
    for(let y = (gridOffset % spacing); y < H; y += spacing){
      ctx.beginPath(); ctx.moveTo(0,y); ctx.lineTo(W,y); ctx.stroke();
    }
    ctx.globalAlpha = 1;
    gridOffset += .3;
  }

  // Glow orbs
  const orbs = [
    {x:.2, y:.3, r:300, color:'rgba(230,57,70,.06)'},
    {x:.8, y:.7, r:250, color:'rgba(230,57,70,.04)'},
    {x:.5, y:.1, r:200, color:'rgba(255,107,107,.05)'},
  ];
  function drawOrbs(){
    orbs.forEach(o => {
      const grd = ctx.createRadialGradient(o.x*W, o.y*H, 0, o.x*W, o.y*H, o.r);
      grd.addColorStop(0, o.color);
      grd.addColorStop(1, 'transparent');
      ctx.globalAlpha = 1;
      ctx.fillStyle = grd;
      ctx.fillRect(0,0,W,H);
    });
  }

  function loop(){
    ctx.clearRect(0,0,W,H);
    drawGrid();
    drawOrbs();
    drawLines();
    particles.forEach(p => { p.update(); p.draw(); });
    ctx.globalAlpha = 1;
    requestAnimationFrame(loop);
  }
  loop();
})();

// ══ NAVBAR SCROLL ══
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
  navbar.classList.toggle('scrolled', window.scrollY > 50);
});

// ══ SCROLL REVEAL ══
const revealEls = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
  entries.forEach((e, i) => {
    if(e.isIntersecting){
      setTimeout(() => e.target.classList.add('visible'), i * 80);
      observer.unobserve(e.target);
    }
  });
}, { threshold: .12 });
revealEls.forEach(el => observer.observe(el));

// ══ COUNTER ANIMATION ══
function animateCounter(el, target, duration){
  let start = 0, startTime = null;
  function step(ts){
    if(!startTime) startTime = ts;
    const progress = Math.min((ts - startTime) / duration, 1);
    const ease = 1 - Math.pow(1 - progress, 3);
    el.textContent = Math.floor(ease * target).toLocaleString();
    if(progress < 1) requestAnimationFrame(step);
    else el.textContent = target.toLocaleString() + (el.dataset.suffix || '');
  }
  requestAnimationFrame(step);
}
const counterObserver = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if(e.isIntersecting){
      const target = parseInt(e.target.dataset.target);
      animateCounter(e.target, target, 1800);
      counterObserver.unobserve(e.target);
    }
  });
}, { threshold: .5 });
document.querySelectorAll('[data-target]').forEach(el => counterObserver.observe(el));

// ══ FEATURE CARD MOUSE GLOW ══
document.querySelectorAll('.feat-card').forEach(card => {
  card.addEventListener('mousemove', e => {
    const rect = card.getBoundingClientRect();
    const x = ((e.clientX - rect.left) / rect.width  * 100).toFixed(1);
    const y = ((e.clientY - rect.top)  / rect.height * 100).toFixed(1);
    card.style.setProperty('--mx', x + '%');
    card.style.setProperty('--my', y + '%');
  });
});
</script>
</body>
</html>
