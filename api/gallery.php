<?php
/**
 * Stanlay Product Gallery API
 * GET /api/gallery.php?product={slug}
 *
 * Scans /images/products/{slug}/ and returns a JSON list of image URLs.
 * Images are served directly as static assets by Vercel — this API only
 * builds the URL list.
 *
 * Response: JSON { success: true, product: "slug", count: int, images: [...] }
 */

/* ── Security headers ──────────────────────────────────────── */
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: public, max-age=600');  /* 10-minute cache */

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

/* ── Validate slug — only alphanumeric + hyphens ───────────── */
$slug = isset($_GET['product']) ? trim((string) $_GET['product']) : '';

if ($slug === '' || !preg_match('/^[a-z0-9\-]{1,80}$/', $slug)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid or missing product slug']);
    exit;
}

/* ── Resolve directory safely (prevent path traversal) ─────── */
$baseDir   = realpath(__DIR__ . '/../images/products');
$targetDir = $baseDir ? realpath($baseDir . '/' . $slug) : false;

if (
    !$baseDir
    || !$targetDir
    || strpos($targetDir, $baseDir) !== 0  /* must stay inside base */
    || !is_dir($targetDir)
) {
    /* No images yet — return empty but valid response */
    echo json_encode([
        'success' => true,
        'product' => $slug,
        'count'   => 0,
        'images'  => [],
        'note'    => 'No images uploaded for this product yet.',
    ]);
    exit;
}

/* ── Scan for image files ──────────────────────────────────── */
$allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
$images  = [];

foreach (new DirectoryIterator($targetDir) as $file) {
    if ($file->isDot() || $file->isDir()) {
        continue;
    }
    $ext = strtolower($file->getExtension());
    if (!in_array($ext, $allowed, true)) {
        continue;
    }

    $filename  = $file->getFilename();
    $basename  = $file->getBasename('.' . $ext);
    $isMain    = in_array($basename, ['main', 'hero', '1', '01', 'cover'], true);

    $images[] = [
        'url'      => '/images/products/' . $slug . '/' . $filename,
        'filename' => $filename,
        'alt'      => ucfirst(str_replace(['-', '_'], ' ', $slug)) . ' — ' . $basename,
        'is_main'  => $isMain,
    ];
}

/* Sort: main image first, then alphabetical */
usort($images, fn($a, $b) =>
    ($b['is_main'] <=> $a['is_main']) ?: strcmp($a['filename'], $b['filename'])
);

echo json_encode([
    'success' => true,
    'product' => $slug,
    'count'   => count($images),
    'images'  => $images,
], JSON_UNESCAPED_UNICODE);
