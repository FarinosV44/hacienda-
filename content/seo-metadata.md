# SEO metadata for the final PRAETORIA page

Target URL (the only canonical once live):
`https://praetoriaabogados.es/abogado-hacienda-seguridad-social-valencia/`

This site's active SEO plugin is **ThinkRank** (confirmed via the
`generator` meta tag and its own `breadcrumbs.css` on every page). Paste the
values below into ThinkRank's per-page SEO fields on the new page, rather
than having a second, unrelated piece of code try to guess at and override
ThinkRank's own output — that risks duplicate `<title>`/canonical/meta tags,
which is worse for SEO than doing nothing. The `praetoria-hacienda-funnel`
plugin deliberately does **not** touch page-level `<title>`, canonical, or
meta description for this reason; it only adds page-scoped FAQPage and
BreadcrumbList JSON-LD inside the shortcode output (safe to co-exist with
whatever ThinkRank renders elsewhere in `<head>`).

## Title (SEO title field)
```
Abogado Hacienda y Seguridad Social en Valencia | PRAETORIA
```
60 characters — covers "abogado Hacienda Valencia" and "abogado Seguridad
Social Valencia" without stuffing.

## Meta description
```
¿Requerimiento, liquidación, sanción o embargo de Hacienda o la Seguridad Social? Abogados en Valencia y El Puig. Estudiamos tu caso, plazos y defensa, para toda España.
```
~163 characters.

## Canonical URL
Self-referencing:
```
https://praetoriaabogados.es/abogado-hacienda-seguridad-social-valencia/
```
Most SEO plugins set this automatically for a normal (non-duplicated) page —
just confirm in ThinkRank's page panel that it is NOT overridden to point
anywhere else.

## Open Graph
```
og:title: Abogado Hacienda y Seguridad Social en Valencia | PRAETORIA
og:description: Revisamos la notificación, los plazos y las opciones para responder, alegar o recurrir.
og:url: https://praetoriaabogados.es/abogado-hacienda-seguridad-social-valencia/
og:type: website
og:image: https://praetoriaabogados.es/wp-content/uploads/2025/09/logo-praetoria-header.png
```
(Reusing the same PRAETORIA logo already used site-wide for `og:image`,
confirmed live on the homepage — do not create a new one unless the firm
wants a page-specific social image.)

## LegalService schema (optional, page-level)

The homepage does not appear to carry a sitewide `LegalService` JSON-LD
block (only `Organization`/WordPress defaults were detected during
inspection). If PRAETORIA wants explicit `LegalService` schema for this
specific practice area, ThinkRank likely has a "Schema" tab or a raw
HTML/code field per page — paste this there. If ThinkRank has no such field,
this can be added as a `<script type="application/ld+json">` block directly
in the page content (Custom HTML block in Gutenberg, or an HTML widget in
Elementor) placed once, near the top of the page:

```json
{
  "@context": "https://schema.org",
  "@type": "LegalService",
  "name": "PRAETORIA División Jurídica — Hacienda y Seguridad Social",
  "url": "https://praetoriaabogados.es/abogado-hacienda-seguridad-social-valencia/",
  "telephone": "+34607527719",
  "email": "juanfarinos@icav.es",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Calle Pintor Francisco Ribalta 4A",
    "postalCode": "46540",
    "addressLocality": "El Puig de Santa Maria",
    "addressRegion": "Valencia",
    "addressCountry": "ES"
  },
  "areaServed": ["Valencia", "El Puig de Santa Maria", "España"],
  "priceRange": "Honorarios según complejidad"
}
```

Do not add this a second time if PRAETORIA's theme/plugin stack already
renders a sitewide `LegalService`/`Organization` schema block containing the
same NAP (name/address/phone) data — verify first with Google's Rich
Results Test on the live homepage before duplicating.

## FAQPage and BreadcrumbList schema

Already generated automatically by the `[praetoria_hacienda_funnel]`
shortcode, built from the exact same FAQ questions/answers that are visible
on the page (required for FAQPage schema to be valid) and from the real
breadcrumb trail (Inicio → Ámbitos de Especialización → Hacienda y Seguridad
Social). No manual action needed for these two.

Note: since August 2023, Google generally only shows the visible
rich-snippet treatment for FAQPage on a narrow set of authoritative
government/health sites — the markup itself remains valid and harmless to
include, but do not promise the client a visible FAQ rich result in search.

## Sitemap

ThinkRank generates its own XML sitemap (standard behavior for an active WP
SEO plugin). After publishing the page:
1. Check `https://praetoriaabogados.es/sitemap.xml` (or whatever sitemap
   index URL ThinkRank uses — check its settings page for the exact path)
   includes the new URL. It should appear automatically once the page is
   published and not set to `noindex`.
2. If it does not appear within a day, check the page's visibility/robots
   setting in ThinkRank's page panel.

## Google Search Console

If GSC access is available for `praetoriaabogados.es`:
1. Confirm the new URL appears in the submitted sitemap (Sitemaps report).
2. Use **URL Inspection** on
   `https://praetoriaabogados.es/abogado-hacienda-seguridad-social-valencia/`
   to confirm it returns "URL is on Google" or "Live URL is available" with
   no indexing blockers.
3. Only request indexing after confirming the page returns HTTP 200, has the
   correct canonical (self), and is not set to `noindex`.

Do not request indexing before all three of the above are true.
