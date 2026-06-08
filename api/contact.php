<?php
/**
 * Stanlay Contact Form Handler
 * POST /api/contact.php
 *
 * Required fields: first_name, email, nearest_office, message
 * Optional fields: last_name, phone
 *
 * On Vercel the writable filesystem is /tmp (ephemeral).
 * For production persistence, replace the file-write section with:
 *   - A database (Supabase, PlanetScale, Neon, etc.)
 *   - A transactional email service (Resend, SendGrid, Mailgun)
 *   See README.md §5 for setup instructions.
 *
 * Response: JSON { success: true,  message: "...", id: "..." }
 *        or JSON { success: false, error:   "..." }
 */

/* ── Security headers ──────────────────────────────────────── */
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

/* ── Sanitise ──────────────────────────────────────────────── */
function clean(string $val): string
{
    return htmlspecialchars(strip_tags(trim($val)), ENT_QUOTES, 'UTF-8');
}

$firstName     = clean((string) ($_POST['first_name']     ?? ''));
$lastName      = clean((string) ($_POST['last_name']      ?? ''));
$email         = trim((string)  ($_POST['email']          ?? ''));
$phone         = clean((string) ($_POST['phone']          ?? ''));
$nearestOffice = clean((string) ($_POST['nearest_office'] ?? ''));
$message       = clean((string) ($_POST['message']        ?? ''));

/* ── Validate ──────────────────────────────────────────────── */
$errors = [];

if ($firstName === '')                               { $errors[] = 'First name is required.'; }
if (!filter_var($email, FILTER_VALIDATE_EMAIL))      { $errors[] = 'A valid email address is required.'; }
if ($nearestOffice === '')                           { $errors[] = 'Please select your nearest office.'; }
if ($message === '')                                 { $errors[] = 'Message is required.'; }

/* Length limits to prevent abuse */
if (mb_strlen($firstName) > 100)  { $errors[] = 'First name is too long (max 100 chars).'; }
if (mb_strlen($lastName)  > 100)  { $errors[] = 'Last name is too long (max 100 chars).'; }
if (mb_strlen($email)     > 320)  { $errors[] = 'Email address is too long.'; }
if (mb_strlen($phone)     > 30)   { $errors[] = 'Phone number is too long.'; }
if (mb_strlen($message)   > 2000) { $errors[] = 'Message must be under 2000 characters.'; }

/* Reject if honeypot field is filled (basic bot protection) */
if (!empty($_POST['website'])) {
    /* Silently succeed so bots don't know they were blocked */
    echo json_encode(['success' => true, 'message' => 'Thank you for your enquiry.', 'id' => 'bot']);
    exit;
}

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => implode(' ', $errors)]);
    exit;
}

/* ── Build enquiry record ──────────────────────────────────── */
$enquiry = [
    'id'             => uniqid('enq_', true),
    'submitted_at'   => gmdate('c'),
    'ip'             => $_SERVER['HTTP_X_FORWARDED_FOR']
                        ?? $_SERVER['REMOTE_ADDR']
                        ?? 'unknown',
    'first_name'     => $firstName,
    'last_name'      => $lastName,
    'email'          => $email,
    'phone'          => $phone,
    'nearest_office' => $nearestOffice,
    'message'        => $message,
];

/* ── Persist to /tmp (Vercel ephemeral filesystem) ─────────── */
/* NOTE: /tmp is cleared on each new serverless instance.
 * Replace this block with a real DB write for production.     */
$logFile  = sys_get_temp_dir() . '/stanlay_enquiries.json';
$existing = [];

if (file_exists($logFile) && is_readable($logFile)) {
    $raw      = file_get_contents($logFile);
    $existing = json_decode($raw ?: '[]', true) ?: [];
}

$existing[] = $enquiry;
@file_put_contents(
    $logFile,
    json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    LOCK_EX
);

/* ── Send notification email ───────────────────────────────── */
/* php mail() is unreliable on serverless.
 * TODO: swap for Resend / SendGrid / Mailgun PHP SDK.         */
$notifyTo = getenv('CONTACT_EMAIL') ?: 'sales@stanlay.com';
$subject  = "New Enquiry: {$firstName} {$lastName} — Stanlay Website";
$body     = implode("\n", [
    'New website enquiry',
    '',
    "Name    : {$firstName} {$lastName}",
    "Email   : {$email}",
    "Phone   : {$phone}",
    "Office  : {$nearestOffice}",
    "Message : {$message}",
    '',
    'Submitted : ' . gmdate('Y-m-d H:i:s') . ' UTC',
    'ID        : ' . $enquiry['id'],
]);
$headers  = "From: website@stanlay.in\r\nReply-To: {$email}\r\nX-Mailer: PHP/" . PHP_VERSION;
@mail($notifyTo, $subject, $body, $headers);

/* ── Respond ───────────────────────────────────────────────── */
http_response_code(200);
echo json_encode([
    'success' => true,
    'message' => 'Thank you! We have received your enquiry and will respond within one business day.',
    'id'      => $enquiry['id'],
]);
