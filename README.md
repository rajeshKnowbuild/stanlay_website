# Stanlay Website

Static HTML + PHP serverless backend — deployed on Vercel.

---

## Project structure

```
stanlay-website/
├── api/
│   ├── products.php     ← GET /api/products  (product list + search)
│   ├── contact.php      ← POST /api/contact  (form submission)
│   └── gallery.php      ← GET /api/gallery   (product image list)
├── assets/
│   └── css/
│       └── styles.css   ← shared stylesheet
├── data/
│   └── products.json    ← product catalogue data
├── images/
│   └── products/
│       └── {slug}/      ← add product images here (e.g. main.jpg)
├── products.html        ← Products listing page  → /products
├── contact.html         ← Contact page           → /contact
├── vercel.json          ← Vercel configuration
└── .gitignore
```

---

## Step 1 — Create a GitHub repo

1. Go to **https://github.com** and log in (or create a free account).
2. Click the **+** icon → **New repository**.
3. Name it `stanlay-website` (or any name you like).
4. Set it to **Private** (recommended) or Public.
5. Click **Create repository**.

---

## Step 2 — Push your code to GitHub

Open a terminal (PowerShell or Git Bash) in the project folder and run:

```bash
git init
git add .
git commit -m "Initial commit — Products + Contact pages"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/stanlay-website.git
git push -u origin main
```

Replace `YOUR_USERNAME` with your GitHub username.

---

## Step 3 — Create a Vercel account

1. Go to **https://vercel.com** and click **Sign Up**.
2. Choose **Continue with GitHub** — this links Vercel to your GitHub account.
3. Authorise Vercel to access your repositories.

---

## Step 4 — Deploy to Vercel

1. On the Vercel dashboard click **Add New → Project**.
2. Find `stanlay-website` in the list and click **Import**.
3. On the configuration screen:
   - **Framework Preset**: leave as `Other`
   - **Root Directory**: leave as `/` (the project root)
   - **Build & Output Settings**: leave empty (no build step needed)
4. Click **Deploy**.

Vercel will automatically detect `vercel.json`, install the PHP runtime, and deploy.

Your site will be live at `https://stanlay-website.vercel.app` (or a custom domain).

---

## Step 5 — Add a custom domain (optional)

1. In Vercel project → **Settings → Domains**.
2. Add `stanlay.in` (or your domain).
3. Vercel will show you DNS records — add them in your domain registrar (GoDaddy / Namecheap / etc.).

---

## Step 6 — Environment variables (recommended)

In Vercel → **Settings → Environment Variables**, add:

| Name            | Value                     | Notes                             |
|-----------------|---------------------------|-----------------------------------|
| `CONTACT_EMAIL` | `sales@stanlay.com`       | Where enquiry emails are sent     |

The `contact.php` API reads this variable: `getenv('CONTACT_EMAIL')`.

---

## Step 7 — Adding product images

1. Create a folder: `images/products/{product-slug}/`
   - Example: `images/products/dxl4/main.jpg`
2. Commit and push — Vercel redeploys automatically.
3. The gallery API (`/api/gallery.php?product=dxl4`) will return the image URLs.

---

## Step 8 — Updating product data

Edit `data/products.json` — add new products or update existing ones.
Each product object shape:

```json
{
  "id": "unique-id",
  "slug": "url-friendly-name",
  "name": "Product Display Name",
  "brand": "Brand Name",
  "category": "underground-locating",
  "tagline": "One-line marketing description",
  "description": "Full description",
  "badge": "Popular | New | Kit | null",
  "specs": { "Key": "Value" },
  "images": ["/images/products/slug/main.jpg"],
  "detailUrl": "/products/slug"
}
```

Valid category IDs: `underground-locating`, `cable-installation`, `water-sewer`, `pipe-inspection`, `telecom-test`.

---

## Production checklist

- [ ] Remove the "Design Prototype" handoff bar from both HTML pages (delete the `<div id="handoff-bar">` block)
- [ ] Update `<link rel="canonical">` with the live domain
- [ ] Update `og:image` paths with real images
- [ ] Replace placeholder office addresses in `contact.html` with real addresses
- [ ] Set `CONTACT_EMAIL` environment variable in Vercel
- [ ] Add real product images to `images/products/{slug}/`
- [ ] For email delivery: integrate Resend or SendGrid in `api/contact.php` (see below)

---

## Upgrading email delivery (production)

`php mail()` is blocked on most serverless platforms. Use **Resend** (free tier available):

1. Sign up at https://resend.com and get an API key.
2. Add env var `RESEND_API_KEY` in Vercel.
3. Replace the `@mail(...)` call in `api/contact.php` with:

```php
$ch = curl_init('https://api.resend.com/emails');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_HTTPHEADER     => [
        'Authorization: Bearer ' . getenv('RESEND_API_KEY'),
        'Content-Type: application/json',
    ],
    CURLOPT_POSTFIELDS => json_encode([
        'from'    => 'website@stanlay.in',
        'to'      => [getenv('CONTACT_EMAIL') ?: 'sales@stanlay.com'],
        'subject' => $subject,
        'text'    => $body,
        'reply_to'=> $email,
    ]),
]);
curl_exec($ch);
curl_close($ch);
```

---

## SEO notes (to complete)

The pages include full SEO structure — update these placeholders before going live:

- `<link rel="canonical">` — set your real domain
- `og:image` — add real Open Graph images (1200×630 px recommended)
- JSON-LD schemas — already structured; update with real address, phone, hours
- Page titles and meta descriptions are ready to use as-is

---

## Local development

Since this is plain HTML + PHP, you can preview with any local PHP server:

```bash
# PHP built-in server (PHP 8.1+)
php -S localhost:8000

# Then open:
# http://localhost:8000/products.html
# http://localhost:8000/contact.html
```

Note: PHP API routes (`/api/products.php`) work directly with the PHP built-in server.
