<?php
/**
 * Stanlay — new1.php
 * Example dynamic PHP page
 * URL: /api/new1.php
 */

$pageTitle   = "New Page — Stanlay";
$currentDate = date('d M Y');
$products    = [];

/* Load products.json to demonstrate dynamic content */
$dataFile = __DIR__ . '/../data/products.json';
if (file_exists($dataFile)) {
    $data     = json_decode(file_get_contents($dataFile), true);
    $products = $data['products'] ?? [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($pageTitle); ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>

<!-- NAV -->
<nav class="site-nav">
  <a href="/" class="nav-logo">STANLAY</a>
  <ul class="nav-links">
    <li><a href="/products.html">Products</a></li>
    <li><a href="/contact.html">Contact Us</a></li>
  </ul>
  <a href="/contact.html" class="nav-cta">Contact Us</a>
</nav>

<!-- HERO -->
<div class="hero">
  <div class="hero-2col">
    <div>
      <div class="hero-tag">Dynamic PHP Page</div>
      <h1 class="hero-title">New<br><span>Page</span></h1>
      <p class="hero-sub">
        This page is rendered by PHP on the server.<br>
        Today's date: <strong style="color:#fff"><?php echo $currentDate; ?></strong>
      </p>
    </div>
    <div class="hero-stats">
      <div class="hero-stat">
        <div class="hero-stat-num"><?php echo count($products); ?></div>
        <div class="hero-stat-label">Products loaded from JSON</div>
      </div>
      <div class="hero-stat">
        <div class="hero-stat-num">PHP</div>
        <div class="hero-stat-label"><?php echo phpversion(); ?></div>
      </div>
      <div class="hero-stat">
        <div class="hero-stat-num">✓</div>
        <div class="hero-stat-label">Server-side rendered</div>
      </div>
    </div>
  </div>
</div>

<!-- PRODUCT LIST — rendered by PHP -->
<section style="background:var(--bg);">
  <div class="section-header">
    <div class="section-label-line">
      <span class="label-tag">From PHP</span>
      <div class="label-rule"></div>
    </div>
    <h2 class="section-title">Products rendered server-side</h2>
    <p class="section-body">
      These cards are built by PHP directly — no JavaScript fetch needed.
    </p>
  </div>

  <div class="products-grid">
    <?php foreach ($products as $p): ?>
    <article class="product-card">
      <div class="product-card-img">
        <?php if (!empty($p['badge'])): ?>
          <span class="product-badge"><?php echo htmlspecialchars($p['badge']); ?></span>
        <?php endif; ?>
        <div class="product-card-img-placeholder">🔧</div>
      </div>
      <div class="product-card-body">
        <div class="product-category-tag"><?php echo htmlspecialchars($p['category'] ?? ''); ?></div>
        <h2 class="product-name"><?php echo htmlspecialchars($p['name'] ?? ''); ?></h2>
        <div class="product-brand"><?php echo htmlspecialchars($p['brand'] ?? ''); ?></div>
        <p class="product-tagline"><?php echo htmlspecialchars($p['tagline'] ?? ''); ?></p>
        <?php if (!empty($p['specs'])): ?>
        <div class="product-specs-mini">
          <?php foreach (array_slice($p['specs'], 0, 3) as $val): ?>
            <span class="spec-pill"><?php echo htmlspecialchars($val); ?></span>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
      <div class="product-card-footer">
        <a href="/contact.html?product=<?php echo urlencode($p['name'] ?? ''); ?>" class="product-link">
          Enquire →
        </a>
      </div>
    </article>
    <?php endforeach; ?>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-col">
    <div class="footer-logo">STANLAY</div>
    <p class="footer-tagline">India's specialist distributor for underground utility detection equipment.</p>
  </div>
  <div class="footer-col">
    <h4>Pages</h4>
    <ul>
      <li><a href="/products.html">Products</a></li>
      <li><a href="/contact.html">Contact Us</a></li>
      <li><a href="/api/new1.php">New Page (this page)</a></li>
    </ul>
  </div>
</footer>
<div class="footer-bottom">
  <span class="footer-copy">© 2026 Stanlay / Asian Contec Ltd. All rights reserved.</span>
  <span class="footer-copy">Rendered by PHP <?php echo phpversion(); ?></span>
</div>

</body>
</html>
