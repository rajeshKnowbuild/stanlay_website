<?php
/**
 * Stanlay Products API
 * GET /api/products.php
 *
 * Query params:
 *   category (string) — filter by category slug (e.g. underground-locating)
 *   q        (string) — full-text search across name / tagline / brand / description
 *   id       (string) — return single product by id or slug
 *
 * Response: JSON { success: true, total: int, categories: [...], products: [...] }
 */

/* ── Security headers ──────────────────────────────────────── */
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: public, max-age=300');  /* 5-minute cache */

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

/* ── Load products.json ────────────────────────────────────── */
$dataFile = __DIR__ . '/../data/products.json';

if (!file_exists($dataFile) || !is_readable($dataFile)) {
    http_response_code(503);
    echo json_encode(['success' => false, 'error' => 'Product data unavailable']);
    exit;
}

$raw  = file_get_contents($dataFile);
$data = json_decode($raw, true);

if (json_last_error() !== JSON_ERROR_NONE || !isset($data['products'])) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Data parse error']);
    exit;
}

$products = $data['products'];

/* ── Single product lookup ─────────────────────────────────── */
$id = isset($_GET['id']) ? trim(strip_tags((string) $_GET['id'])) : '';
if ($id !== '') {
    foreach ($data['products'] as $p) {
        if (($p['id'] ?? '') === $id || ($p['slug'] ?? '') === $id) {
            echo json_encode(['success' => true, 'product' => $p]);
            exit;
        }
    }
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Product not found']);
    exit;
}

/* ── Filter by category ────────────────────────────────────── */
$category = isset($_GET['category']) ? trim(strip_tags((string) $_GET['category'])) : '';
if ($category !== '' && $category !== 'all') {
    $products = array_values(array_filter(
        $products,
        fn($p) => ($p['category'] ?? '') === $category
    ));
}

/* ── Full-text search ──────────────────────────────────────── */
$q = isset($_GET['q']) ? trim(strip_tags((string) $_GET['q'])) : '';
if ($q !== '') {
    $ql       = mb_strtolower($q);
    $products = array_values(array_filter($products, function ($p) use ($ql) {
        return mb_strpos(mb_strtolower($p['name']        ?? ''), $ql) !== false
            || mb_strpos(mb_strtolower($p['tagline']     ?? ''), $ql) !== false
            || mb_strpos(mb_strtolower($p['brand']       ?? ''), $ql) !== false
            || mb_strpos(mb_strtolower($p['description'] ?? ''), $ql) !== false;
    }));
}

/* ── Respond ───────────────────────────────────────────────── */
echo json_encode([
    'success'    => true,
    'total'      => count($products),
    'categories' => $data['categories'] ?? [],
    'products'   => $products,
], JSON_UNESCAPED_UNICODE);
