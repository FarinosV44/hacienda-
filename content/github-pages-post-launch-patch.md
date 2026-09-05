# Applied: the GitHub Pages copy is demoted

**Status: done.** The real PRAETORIA page was verified live, canonical, and
returning HTTP 200 at
`https://praetoriaabogados.es/abogado-hacienda-y-seguridad-social-en-valencia/`
before this patch was applied — see below for what changed and why the order
mattered.

## What was applied to `index.html`

1. **Robots meta → `noindex,follow`**
   ```diff
   - <meta name="robots" content="index,follow,max-image-preview:large">
   + <meta name="robots" content="noindex,follow">
   ```

2. **Canonical and `og:url` → the real page**
   ```diff
   - <link rel="canonical" href="https://farinosv44.github.io/hacienda-/">
   + <link rel="canonical" href="https://praetoriaabogados.es/abogado-hacienda-y-seguridad-social-en-valencia/">
   ```
   ```diff
   - <meta property="og:url" content="https://farinosv44.github.io/hacienda-/">
   + <meta property="og:url" content="https://praetoriaabogados.es/abogado-hacienda-y-seguridad-social-en-valencia/">
   ```
   The `LegalService` JSON-LD `"url"` field was updated the same way.

3. **Visible banner** added right after `<body>`, before the skip link,
   styled with the existing `.preview-banner` class in `styles.css`, linking
   to the real PRAETORIA URL.

4. **`sitemap.xml` removed** (a noindexed single-page site has no reason to
   keep a sitemap), and its `Sitemap:` line removed from `robots.txt`.
   `robots.txt` still allows crawling (`Allow: /`) — noindex only works if
   crawlers can reach the page and read the meta tag, so nothing here blocks
   crawling.

## Verify

- Fetch `https://farinosv44.github.io/hacienda-/` and confirm the `noindex`
  meta tag, updated canonical, and banner are present.
- Fetch the real PRAETORIA URL and confirm HTTP 200 (already done before
  this patch was applied).
- Re-check Google Search Console (if available) in the following days to
  confirm the GitHub Pages URL drops out of the index in favour of the real
  one.

## Why the order mattered

Setting canonical to a URL that returns 404 (or noindexing the only working
copy) actively hurts SEO — it tells Google "the real version is elsewhere"
before that real version exists to be indexed. This exact mistake was found
and fixed once already in this repo's history (the original canonical
pointed at a praetoriaabogados.es path that 404'd, before this WordPress
integration existed). This patch was deliberately held until the real page
was confirmed live, canonical, and indexed before being applied — so it
never happened a second time in reverse.
