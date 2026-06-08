<?php
/**
 * Stanlay — Shared Header Component
 * Include on any page: <?php include('api/header.php'); ?>
 *
 * Variables you can set BEFORE including:
 *   $activePage = 'products' | 'catalogues' | 'experience' | 'about' | 'contact'
 */
$activePage = $activePage ?? '';
?>
<!-- ═══════════════════════════════════════════════
     STANLAY HEADER
═══════════════════════════════════════════════ -->
<style>
.sl-header *, .sl-header *::before, .sl-header *::after { box-sizing: border-box; margin: 0; padding: 0; }

.sl-header {
  position: sticky; top: 0; z-index: 1000;
  background: #fff; border-bottom: 1px solid #E2E2E2;
  font-family: 'Barlow', 'Segoe UI', sans-serif;
}
.sl-header__inner {
  display: flex; align-items: center;
  height: 60px; padding: 0 2rem; gap: 19.5rem;
}
.sl-header__logo {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 22px; font-weight: 800; letter-spacing: 0.04em;
  color: #D0271D; text-decoration: none; flex-shrink: 0;
}
.sl-header__nav { display: flex; align-items: center; list-style: none; }
.sl-header__nav a {
  display: flex; align-items: center; align-self: stretch;
  padding: 0 1rem; font-size: 12.5px; font-weight: 600;
  letter-spacing: 0.07em; text-transform: uppercase;
  color: #555; text-decoration: none; white-space: nowrap;
  border-bottom: 2px solid transparent; transition: color 0.2s, border-color 0.2s;
}
.sl-header__nav a:hover { color: #D0271D; }
.sl-header__nav a.active { color: #D0271D; border-bottom-color: #D0271D; }

.sl-header__search {
  display: flex; align-items: center; height: 36px; flex: 0 0 260px;
  background: #F8F7F5; border: 1px solid #E2E2E2;
  overflow: hidden; transition: border-color 0.2s; margin-left: auto;
}
.sl-header__search:focus-within { border-color: #D0271D; }
.sl-header__search input {
  flex: 1; border: none; background: transparent; font-family: inherit;
  font-size: 13px; color: #333; padding: 0 0.75rem; outline: none; min-width: 0;
}
.sl-header__search input::placeholder { color: #aaa; font-size: 12px; }
.sl-header__search button {
  width: 36px; height: 36px; border: none; background: transparent;
  color: #aaa; display: flex; align-items: center; justify-content: center;
  cursor: pointer; transition: color 0.2s; padding: 0;
}
.sl-header__search button:hover { color: #D0271D; }

.sl-header__cta {
  background: #D0271D; color: #fff !important; border: none;
  padding: 0 1.25rem; height: 36px; font-family: inherit;
  font-size: 12.5px; font-weight: 700; letter-spacing: 0.07em;
  text-transform: uppercase; text-decoration: none;
  display: inline-flex; align-items: center; justify-content: center;
  cursor: pointer; transition: background 0.2s; flex-shrink: 0;
}
.sl-header__cta:hover { background: #A01E16; }

.sl-header__hamburger {
  display: none; flex-direction: column; justify-content: center;
  gap: 5px; width: 36px; height: 36px; background: transparent;
  border: 1px solid #E2E2E2; cursor: pointer; padding: 0 8px;
  flex-shrink: 0; margin-left: auto;
}
.sl-header__hamburger span { display: block; height: 2px; background: #333; border-radius: 2px; }

.sl-header__drawer {
  display: none; background: #fff;
  border-top: 1px solid #E2E2E2; padding: 0.75rem 1.5rem 1rem;
}
.sl-header__drawer.open { display: block; }
.sl-header__drawer ul { list-style: none; margin-bottom: 0.75rem; }
.sl-header__drawer ul li a {
  display: block; padding: 0.65rem 0; font-size: 14px; font-weight: 600;
  letter-spacing: 0.06em; text-transform: uppercase; color: #555;
  text-decoration: none; border-bottom: 1px solid #f0f0f0; transition: color 0.2s;
}
.sl-header__drawer ul li a:hover,
.sl-header__drawer ul li a.active { color: #D0271D; }

.sl-header__drawer-search {
  display: flex; border: 1px solid #E2E2E2;
  background: #F8F7F5; margin-bottom: 0.75rem;
}
.sl-header__drawer-search input {
  flex: 1; border: none; background: transparent;
  font-family: inherit; font-size: 13px; padding: 0.6rem 0.75rem; outline: none; color: #333;
}
.sl-header__drawer-search input::placeholder { color: #aaa; }
.sl-header__drawer-search button {
  border: none; background: #D0271D; color: #fff; padding: 0 1rem; cursor: pointer;
}
.sl-header__drawer .sl-header__cta { width: 100%; height: 42px; }

@media (max-width: 1024px) {
  .sl-header__search { flex: 0 0 200px; }
  .sl-header__nav a { padding: 0 0.6rem; font-size: 11.5px; }
}
@media (max-width: 768px) {
  .sl-header__nav, .sl-header__search, .sl-header__cta { display: none; }
  .sl-header__hamburger { display: flex; }
}
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">

<header class="sl-header" role="banner">
  <div class="sl-header__inner">

    <!-- Logo -->
    <a href="/index.html" class="sl-header__logo" aria-label="Stanlay home">STANLAY</a>

    <!-- Desktop nav -->
    <ul class="sl-header__nav" role="list" aria-label="Main navigation">
      <li><a href="/products.html"  <?= $activePage==='products'    ? 'class="active" aria-current="page"' : '' ?>>Products</a></li>
      <li><a href="#"               <?= $activePage==='catalogues'  ? 'class="active" aria-current="page"' : '' ?>>Catalogues</a></li>
      <li><a href="#"               <?= $activePage==='experience'  ? 'class="active" aria-current="page"' : '' ?>>Experience</a></li>
      <li><a href="#"               <?= $activePage==='about'       ? 'class="active" aria-current="page"' : '' ?>>About Us</a></li>
    </ul>

    <!-- Search -->
    <div class="sl-header__search" role="search">
      <input type="search"
             id="slHeaderSearch"
             placeholder="Type product name or model…"
             aria-label="Search products"
             autocomplete="off">
      <button onclick="slHeaderSearch()" aria-label="Search">
        <!-- Magnifier SVG -->
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.2"
             stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
      </button>
    </div>

    <!-- CTA -->
    <a href="/contact.html" class="sl-header__cta"
       <?= $activePage==='contact' ? 'aria-current="page"' : '' ?>>
      Contact Us
    </a>

    <!-- Hamburger -->
    <button class="sl-header__hamburger"
            id="slHamburger"
            aria-label="Open menu"
            aria-expanded="false"
            aria-controls="slDrawer"
            onclick="slToggleDrawer()">
      <span></span>
      <span></span>
      <span></span>
    </button>

  </div><!-- /.sl-header__inner -->

  <!-- Mobile drawer -->
  <div class="sl-header__drawer" id="slDrawer" role="navigation" aria-label="Mobile navigation">
    <ul role="list">
      <li><a href="/products.html" <?= $activePage==='products'   ? 'class="active"' : '' ?>>Products</a></li>
      <li><a href="#"              <?= $activePage==='catalogues' ? 'class="active"' : '' ?>>Catalogues</a></li>
      <li><a href="#"              <?= $activePage==='experience' ? 'class="active"' : '' ?>>Experience</a></li>
      <li><a href="#"              <?= $activePage==='about'      ? 'class="active"' : '' ?>>About Us</a></li>
    </ul>
    <div class="sl-header__drawer-search">
      <input type="search"
             id="slDrawerSearch"
             placeholder="Type product name or model…"
             aria-label="Search products"
             autocomplete="off">
      <button onclick="slDrawerSearch()" aria-label="Search">&#8594;</button>
    </div>
    <a href="/contact.html" class="sl-header__cta">Contact Us</a>
  </div>

</header>

<script>
function slToggleDrawer() {
  var drawer  = document.getElementById('slDrawer');
  var btn     = document.getElementById('slHamburger');
  var isOpen  = drawer.classList.toggle('open');
  btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
}

function slHeaderSearch() {
  var q = document.getElementById('slHeaderSearch').value.trim();
  if (q) window.location.href = '/products.html?q=' + encodeURIComponent(q);
}

function slDrawerSearch() {
  var q = document.getElementById('slDrawerSearch').value.trim();
  if (q) window.location.href = '/products.html?q=' + encodeURIComponent(q);
}

document.getElementById('slHeaderSearch').addEventListener('keydown', function(e) {
  if (e.key === 'Enter') slHeaderSearch();
});

document.getElementById('slDrawerSearch').addEventListener('keydown', function(e) {
  if (e.key === 'Enter') slDrawerSearch();
});
</script>
