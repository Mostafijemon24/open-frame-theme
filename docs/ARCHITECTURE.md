# Open Frame — Architecture

> **Open Frame** is the finalized brand. Branding is centralized: text domain
> `open-frame`, function/hook prefix `open_frame_`, constants `OPEN_FRAME_*`,
> CSS custom properties `--of-*`, and CSS class prefix `of-`.

## Decision: classic theme + `theme.json` (hybrid)

The product requirements center on a **comprehensive Customizer** plus **header
and footer builders**. Those are Customizer-era features, so Open Frame is a
**classic PHP-template theme**. It also ships `theme.json` so the **block
editor** shares the same color palette, font families, spacing scale and element
styles as the frontend. This gives full Customizer control *and* a consistent
Gutenberg editing experience without becoming a pure block theme.

Design direction comes from the **Studio Framework Design System** reference
provided in the workspace (`Waiting on design direction/`): Hanken Grotesk +
JetBrains Mono, an indigo primary (`#3f4cd6`) on a cool slate neutral ramp,
a 4px spacing grid, and `6 / 10 / 16 / 999px` radii.

## Single source of truth: design tokens

`style.css :root` defines every token as a CSS custom property (`--of-*`).
Components consume only tokens — never hard-coded values. The Customizer writes
a small set of **overrides** at runtime:

- `inc/customizer/dynamic-css.php` reads theme mods and prints an inline
  `:root{…}` block attached to `open-frame-style` via `wp_add_inline_style()`.
- `assets/js/customize-preview.js` mirrors those same variables with
  `postMessage` for instant live preview.

Because everything cascades from custom properties, one Customizer color change
propagates consistently across header, buttons, links, cards and footer.

## File map

```
functions.php                 Constants + include loader (open_frame_require)
inc/
  setup.php                   add_theme_support, menus, sidebars, image sizes
  enqueue.php                 Styles/scripts; local-font gating; comment-reply
  template-tags.php           posted_on/by, entry meta/footer, thumbnail, comment
  template-functions.php      Layout resolution, body classes, pingback, excerpt
  class-open-frame-walker-nav-menu.php   Accessible submenu toggle buttons
  customizer/
    sanitize.php              Reusable sanitizers (checkbox/select/int/font/clamp)
    customizer.php            Panels, sections, settings, defaults, font choices
    dynamic-css.php           Theme-mod -> inline CSS variables
  header-builder.php          Header section + layouts + branding/nav/search
  footer-builder.php          Footer section + widget columns + copyright
templates/full-width.php      Page template (no sidebar, full content)
template-parts/               content, -single, -page, -search, -none
*.php                         header, footer, index, single, page, archive,
                              search, 404, comments, sidebar, searchform
theme.json                    Editor palette/typography/spacing/element styles
assets/css/editor.css         Editor-surface styles mirroring frontend tokens
assets/js/navigation.js       Accessible mobile menu + submenu + outside-click
assets/fonts/README.txt       Self-hosted font drop-in instructions + licenses
```

## Layout resolution

`open_frame_get_layout()` resolves the active layout
(`right-sidebar | left-sidebar | no-sidebar | full-width`) per context
(page / single / blog-archive-search) from Customizer settings, with the
`Full Width` page template forcing `full-width`. `open_frame_has_sidebar()` also
checks that the relevant widget area is populated, so empty sidebars never
create empty columns.

## Fallbacks (usable with zero configuration)

- No menu assigned → admins see an "Add a menu" link; visitors see nothing broken.
- No footer widgets → the widget region is skipped (no empty columns).
- No copyright text → `© {year} {site name}. All rights reserved.`
- No custom logo → site title/description text branding.
- Missing options → defaults from `open_frame_defaults()`; no fatals.

## Companion plugin boundary (planned, Phase 4)

The theme contains **no importer**. A separate, free *Starter Sites* plugin
(own slug/text-domain/prefix) will own demo catalog, manifest validation, secure
download/extraction and the staged import engine. The theme never depends on it
for rendering.
