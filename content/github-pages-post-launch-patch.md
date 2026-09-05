# Pending: demote the GitHub Pages copy once the real page is live

**Do not apply this yet.** The instructions this package follows are explicit
that the GitHub Pages copy should only be demoted *after* the real
PRAETORIA page is confirmed live, canonicalised and returning HTTP 200 —
doing it earlier would leave zero indexable copy of this content during the
gap, which is worse than the current duplicate-content risk. As of this
writing, `https://praetoriaabogados.es/abogado-hacienda-seguridad-social-valencia/`
returns HTTP 404 — the page does not exist yet.

Once it is live, apply exactly this patch to `index.html` in this repo,
commit, and push:

## 1. Change robots meta to noindex,follow
```diff
- <meta name="robots" content="index,follow,max-image-preview:large">
+ <meta name="robots" content="noindex,follow,max-image-preview:large">
```

## 2. Point canonical and og:url to the real page
```diff
- <link rel="canonical" href="https://farinosv44.github.io/hacienda-/">
+ <link rel="canonical" href="https://praetoriaabogados.es/abogado-hacienda-seguridad-social-valencia/">
```
```diff
- <meta property="og:url" content="https://farinosv44.github.io/hacienda-/">
+ <meta property="og:url" content="https://praetoriaabogados.es/abogado-hacienda-seguridad-social-valencia/">
```
Also update the `LegalService` JSON-LD `"url"` field the same way.

## 3. Add a visible banner linking to the real page
Insert directly after the opening `<body>` tag, before the skip link:
```html
<div style="background:#111;color:#fff;text-align:center;padding:.85rem 1rem;font:600 .9rem/1.4 system-ui,sans-serif">
  Esta es una vista previa. La página oficial está en
  <a href="https://praetoriaabogados.es/abogado-hacienda-seguridad-social-valencia/" style="color:#f3c9c4;text-decoration:underline">praetoriaabogados.es →</a>
</div>
```

## 4. Update robots.txt / sitemap.xml
Remove the GitHub Pages URL from `sitemap.xml` (a noindexed page should not
be listed in its own sitemap), or delete `sitemap.xml` entirely since the
site no longer wants to be indexed.

## 5. Verify
- Fetch `https://farinosv44.github.io/hacienda-/` and confirm the `noindex`
  meta tag and updated canonical are present.
- Fetch the real PRAETORIA URL and confirm HTTP 200.
- Re-check Google Search Console (if available) a few days later to confirm
  the GitHub Pages URL drops out of the index in favour of the real one.

## Why this order matters

Setting canonical to a URL that returns 404 (or noindexing the only working
copy) actively hurts SEO — it tells Google "the real version is elsewhere"
before that real version exists to be indexed. This exact mistake was found
and fixed once already in this repo's history (the original canonical
pointed at a praetoriaabogados.es path that 404'd, before this WordPress
integration existed) — this patch file exists specifically so it doesn't
happen a second time in reverse.
