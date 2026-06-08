<?php
/**
 * Stanlay — Shared Footer Component
 * Include on any page: <?php include('api/footer.php'); ?>
 */
?>
<style>
.sl-footer *, .sl-footer *::before, .sl-footer *::after { box-sizing: border-box; margin: 0; padding: 0; }

.sl-footer {
  background: #3D3D3D;
  font-family: 'Barlow', 'Segoe UI', sans-serif;
}

.sl-footer__grid {
  display: grid;
  grid-template-columns: 1.2fr 1.5fr 1fr 1fr;
  gap: 2.5rem;
  padding: 3rem 2.5rem 2.5rem;
}

/* Logo col */
.sl-footer__logo {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 28px;
  font-weight: 800;
  color: #D0271D !important;
  letter-spacing: 0.04em;
  text-decoration: none !important;
  display: block;
  margin-bottom: 0.75rem;
}
.sl-footer__tagline {
  font-size: 12px;
  color: rgba(255,255,255,0.35);
  line-height: 1.6;
  max-width: 180px;
}

/* Column headings */
.sl-footer__col h4 {
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: rgba(255,255,255,0.35);
  margin-bottom: 1.25rem;
}

/* Links */
.sl-footer__col ul { list-style: none; }
.sl-footer__col li { margin-bottom: 0.6rem; }
.sl-footer__col a {
  font-size: 13px;
  color: rgba(255,255,255,0.55);
  text-decoration: none;
  transition: color 0.2s;
}
.sl-footer__col a:hover { color: #ffffff; }

/* Bottom bar */
.sl-footer__bottom {
  border-top: 1px solid rgba(255,255,255,0.08);
  padding: 1rem 2.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 0.5rem;
}
.sl-footer__copy {
  font-size: 12px;
  color: rgba(255,255,255,0.2);
}

/* Tablet */
@media (max-width: 1024px) {
  .sl-footer__grid { grid-template-columns: 1fr 1fr; gap: 2rem; }
}

/* Mobile */
@media (max-width: 600px) {
  .sl-footer__grid { grid-template-columns: 1fr; padding: 2rem 1.5rem 1.5rem; }
  .sl-footer__bottom { padding: 1rem 1.5rem; flex-direction: column; align-items: flex-start; }
}
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@800&family=Barlow:wght@400;600;700&display=swap" rel="stylesheet">

<footer class="sl-footer" role="contentinfo">
  <div class="sl-footer__grid">

    <!-- Col 1: Brand -->
    <div class="sl-footer__col">
      <a href="/index.html" class="sl-footer__logo" style="color:#D0271D !important; font-size: 25px !important;">STANLAY</a>
      <p class="sl-footer__tagline">India's specialist distributor for underground utility detection equipment.</p>
    </div>

    <!-- Col 2: Browse by Category -->
    <div class="sl-footer__col">
      <h4>Browse by Category</h4>
      <ul>
        <li><a href="/products.html?category=underground-locating">Underground Locating Equipment</a></li>
        <li><a href="/products.html?category=cable-installation">Cable Installation Equipment</a></li>
        <li><a href="/products.html?category=water-sewer">Water &amp; Sewer Line Maintenance</a></li>
        <li><a href="/products.html?category=pipe-inspection">Pipe Inspection Camera</a></li>
        <li><a href="/products.html?category=telecom-test">Telecom Test Equipment</a></li>
      </ul>
    </div>

    <!-- Col 3: Quick Links -->
    <div class="sl-footer__col">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Career</a></li>
        <li><a href="#">Experience</a></li>
        <li><a href="#">News &amp; Events</a></li>
      </ul>
    </div>

    <!-- Col 4: Contact -->
    <div class="sl-footer__col">
      <h4>Contact</h4>
      <ul>
        <li><a href="tel:+911141860000">+91-11-41860000</a></li>
        <li><a href="tel:+919319396589">+91-93-19396589</a></li>
        <li><a href="mailto:sales@stanlay.com">sales@stanlay.com</a></li>
        <li><a href="https://www.stanlay.in" rel="noopener">www.stanlay.in</a></li>
      </ul>
    </div>

  </div>

  <div class="sl-footer__bottom">
    <span class="sl-footer__copy">© 2026 Stanlay / Asian Contec Ltd. All rights reserved.</span>
    <span class="sl-footer__copy">Okhla Phase III, New Delhi — 110 020</span>
  </div>
</footer>
