# Deploying the funnel as a native PRAETORIA page

This repo now contains two things:

1. **`index.html` / `app.js` / `styles.css`** — the original static build, still
   live at `https://farinosv44.github.io/hacienda-/`. This is a **temporary
   preview only**. See `content/github-pages-post-launch-patch.md` for what
   to do with it once step 2 below is live.
2. **`wordpress-plugin/praetoria-hacienda-funnel/`** — a small, self-contained
   WordPress plugin that renders the same funnel, redesigned to match the
   real PRAETORIA identity (Astra + Elementor site, red `#C10000` CTAs,
   Roboto typography, white/soft-blue sections), for publishing at
   `https://praetoriaabogados.es/abogado-hacienda-seguridad-social-valencia/`.

The site was inspected live (WordPress 7.1, Astra 4.13.6, Elementor 4.2.3,
Header Footer Elementor for the global header/footer, Complianz for cookie
consent, Google Site Kit + Burst Statistics for analytics, ThinkRank as the
SEO plugin, hosted on Hostinger). No WordPress admin or hosting credentials
were available in this environment, so nothing has been installed on
praetoriaabogados.es yet — this document is the exact procedure to finish
the job once that access is available.

## 1. Backup first

Before touching the live site:
- If Hostinger's hPanel is reachable, take a manual backup (hPanel usually
  keeps daily backups already — confirm a recent one exists) or use
  **Plugins > Add New**, search for **UpdraftPlus** (or check if a backup
  plugin is already installed) and run a manual backup of files + database.
- This step is the rollback plan: if anything goes wrong, restore that
  backup. No other rollback mechanism is needed for a change this small
  (one new plugin, one new page, a handful of internal links).

## 2. Install the plugin

1. Zip the `wordpress-plugin/praetoria-hacienda-funnel/` folder (the zip's
   top level must be the `praetoria-hacienda-funnel` folder itself).
2. WordPress admin → **Plugins → Add New → Upload Plugin** → select the zip
   → **Install Now** → **Activate**.
3. Nothing renders yet — the plugin only registers the
   `[praetoria_hacienda_funnel]` shortcode and its scoped assets. It does
   not touch any existing theme file, template, or other plugin.

## 3. Create the page

1. **Pages → Add New**.
2. Title: `Abogado Hacienda y Seguridad Social en Valencia`
   (the visible on-page H1 is written by the shortcode itself and doesn't
   have to match the WP page title exactly, but keeping them close helps
   SEO).
3. Set the **permalink/slug** to exactly:
   `abogado-hacienda-seguridad-social-valencia`
4. Choose the same page template the other service pages use so the global
   header/footer render automatically — on this site that's the Elementor
   "full width" / "canvas" template tied to the Header Footer Elementor
   templates (visible as `page-template-elementor_header_footer` in the
   other pages' body class). If building with Elementor, add an
   **Elementor "Shortcode"** widget and paste `[praetoria_hacienda_funnel]`
   into it. If using the block editor instead, add a **Shortcode block**
   with the same content.
5. Publish.

## 4. SEO fields

Open `content/seo-metadata.md` and paste the title, meta description, and
(if desired) the `LegalService` schema block into ThinkRank's per-page SEO
panel for this page. Confirm the canonical is self-referencing (it usually
is by default for a new, non-duplicated page — just don't override it).

## 5. Internal links and navigation

- `content/nav-menu-instructions.md` — add "Hacienda y Seguridad Social" to
  the "Ámbitos de Especialización" menu dropdown.
- `content/internal-links.md` — the exact pages, insertion points, and
  anchor text for links from the homepage, the existing Hacienda/SS blog
  post, "Ámbitos de Especialización", "Derecho Mercantil", and the transport
  article.

## 6. Testing checklist (do this before calling it done)

- [ ] Page returns HTTP 200 at the final URL.
- [ ] Desktop and mobile layouts look correct (compare against
      `wordpress-plugin/praetoria-hacienda-funnel/tests/preview.html`, which
      mirrors the shortcode's exact markup and was used to verify the
      redesign in this repo with Playwright before any of this was written
      to WordPress).
- [ ] All four branches (Hacienda/AEAT, Seguridad Social/TGSS, INSS, "No lo
      sé") complete the 5-step funnel and reach the success screen.
- [ ] Required-field validation blocks progress on every step when a field
      is missing.
- [ ] The WhatsApp link opens with the real number (34607527719) and the
      full structured summary (all answers, including dates and amount).
- [ ] The email fallback link opens with the same summary, addressed to
      juanfarinos@icav.es.
- [ ] The privacy-policy consent link and legal disclaimer text are present
      and correct.
- [ ] No JavaScript console errors on the page.
- [ ] No visual conflicts with the rest of the theme (the plugin's CSS is
      scoped under `.phf-funnel` specifically to prevent this — but verify
      the header, footer, and cookie banner still look and behave exactly
      as they do on every other page).
- [ ] Existing pages (homepage, other service pages, the Hacienda/SS blog
      post) still render correctly after adding the internal links.
- [ ] Structured data (FAQPage + BreadcrumbList, both generated by the
      shortcode) validates in Google's Rich Results Test.

## 7. Sitemap and Search Console

Follow the "Sitemap" and "Google Search Console" sections in
`content/seo-metadata.md`. Only request indexing after the page is
confirmed live, self-canonical, and not `noindex`.

## 8. Demote the GitHub Pages preview

Only after the steps above are confirmed working: follow
`content/github-pages-post-launch-patch.md` to set the GitHub Pages copy to
`noindex,follow`, point its canonical at the real PRAETORIA URL, and add a
visible link to it. Commit and push that change to this same repository —
it stays the source-controlled version of both the preview and the
WordPress plugin.

## 9. Content cluster (optional, ongoing)

`content/articles/` has two complete, ready-to-publish articles.
`content/editorial-plan.md` prioritises the remaining six with target
keywords and an outline for each, to be developed with the same care rather
than published thin.
