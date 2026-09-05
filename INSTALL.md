# Deployment status — PRAETORIA Hacienda y Seguridad Social funnel

**Live in production.** The funnel is published and verified at:

`https://praetoriaabogados.es/abogado-hacienda-y-seguridad-social-en-valencia/`

- Returns HTTP 200.
- The `praetoria-hacienda-funnel` WordPress plugin renders the funnel (see
  `wordpress-plugin/praetoria-hacienda-funnel/` for source, and
  [GitHub Releases](https://github.com/FarinosV44/hacienda-/releases) for the
  installable ZIP).
- SEO title, meta description, and canonical are correct and self-referencing.
- Included in `https://praetoriaabogados.es/sitemap.xml`.
- "Hacienda y Seguridad Social" is in the site's main navigation, under
  "Ámbitos de Especialización".

The GitHub Pages copy (`index.html` / `app.js` / `styles.css`, at
`https://farinosv44.github.io/hacienda-/`) has been demoted accordingly —
see `content/github-pages-post-launch-patch.md` for exactly what changed and
why the order mattered. It is now `noindex,follow`, canonical to the real
PRAETORIA URL, with a visible banner linking there, and no longer has its
own sitemap.

## If the plugin ever needs to be reinstalled or updated

1. Download the latest ZIP from
   [GitHub Releases](https://github.com/FarinosV44/hacienda-/releases).
2. WordPress admin → **Plugins → Add New → Upload Plugin** → select the ZIP
   → **Install Now**. If updating an existing install, deactivate and delete
   the old version first (or let WordPress overwrite it).
3. Activate. Nothing else needs to change — the shortcode
   `[praetoria_hacienda_funnel]` and the page it lives on are untouched by a
   plugin reinstall.

## Rollback

Nothing in this plugin touches the database or the parent theme, so rollback
is a single step: **Plugins → Deactivate → Delete** the
"PRAETORIA - Hacienda y Seguridad Social Funnel" plugin. The page created for
it can be unpublished separately if needed. No backup restore should be
necessary for this specifically.

## Testing checklist (already completed once; reuse after any future change)

- [ ] Page returns HTTP 200 at the final URL.
- [ ] Desktop and mobile layouts match
      `wordpress-plugin/praetoria-hacienda-funnel/tests/preview.html` (a
      static mirror of the shortcode's exact markup, used to verify the
      redesign with Playwright before anything was installed on WordPress).
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
- [ ] No visual conflicts with the rest of the theme.
- [ ] Structured data (FAQPage + BreadcrumbList) validates in Google's Rich
      Results Test.

## Internal links and menu

- `content/nav-menu-instructions.md` — done (menu item added).
- `content/internal-links.md` — remaining internal-link insertions (homepage,
  existing Hacienda/SS blog post, "Ámbitos de Especialización", "Derecho
  Mercantil", the transport article) to reinforce the page's SEO further.

## Content cluster

`content/wordpress-ready/` has two complete, WordPress-ready articles:

- `hacienda-me-pide-justificar-ingresos.html`
- `como-contestar-requerimiento-hacienda.html`

**Not published yet** — no WordPress credentials are available in this
environment. Manual publication checklist, per article:

1. Open the `.html` file and read the HTML comment at the top for the
   proposed SEO title, slug, and meta description — do not paste that
   comment block itself.
2. WordPress admin → **Posts → Add New**.
3. Set the **title** to the article's `<h1>` text, and the **slug** to the
   one proposed in the file's header comment.
4. Switch the block editor to **Code editor** mode (or add a **Custom
   HTML** block) and paste everything from `<h1>` to the final closing
   `</p>` — do not paste the leading HTML comment.
5. Set the **SEO title** and **meta description** in ThinkRank's panel to
   the values proposed in the file's header comment.
6. Set the category (suggested: Blog > Fiscal / Hacienda).
7. Preview and confirm: the internal link to
   `/abogado-hacienda-y-seguridad-social-en-valencia/` works, headings
   render as H1/H2/H3 (not paragraphs), and the FAQ questions display as
   proper headings.
8. Publish.

`content/editorial-plan.md` prioritises the remaining six articles with
target keywords and an outline for each, to be developed with the same care
rather than published thin.
