=== Open Frame ===

Contributors: mostafijemon
Requires at least: 6.4
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 0.5.0
License: GNU General Public License v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: blog, portfolio, news, custom-background, custom-colors, custom-logo, custom-menu, editor-style, featured-images, footer-widgets, full-width-template, left-sidebar, right-sidebar, two-columns, theme-options, threaded-comments, translation-ready, rtl-language-support, sticky-post, block-styles, wide-blocks

Open Frame is an original, lightweight, accessibility-first multipurpose WordPress theme with a token-driven design system.

== Description ==

Open Frame is a professional, lightweight multipurpose theme built on a token-driven design system (the "Studio Framework" reference). It ships with a comprehensive Customizer, header and footer builders, accessible navigation, and complete template coverage for blog, archive, search, single, page and 404 views. The theme is fully functional on its own and does not require any plugin to produce a usable website.

An optional, completely free Starter Sites companion plugin (distributed separately) can add demo content via a safe, selective importer. The theme never bundles the importer and never depends on it for layout or rendering.

== Features ==

* Token-driven design system (color, typography, spacing, radius, elevation).
* Comprehensive Customizer: global colors, typography, layout, header and footer builders — every control produces a real effect.
* Header builder with multiple layouts, sticky and optional transparent modes.
* Accessible, keyboard-friendly navigation with mobile menu and submenu toggles.
* Optional native multi-column mega menu — no plugin required (add the CSS class `of-mega` to a top-level menu item).
* Footer builder with 1–4 responsive widget columns; empty columns are hidden.
* Right/left/no-sidebar and full-width layouts, with per-context overrides.
* Blog, archive, search, single, page, 404 and comment templates.
* Block editor (Gutenberg) support via theme.json with a shared palette and editor styles.
* Translation-ready, RTL-friendly, reduced-motion aware.

== Installation ==

1. In your WordPress admin, go to Appearance > Themes > Add New > Upload Theme.
2. Upload the Open Frame ZIP and click Install Now, then Activate.
3. Visit Appearance > Customize to configure colors, typography, header and footer.

== Frequently Asked Questions ==

= Does Open Frame require a plugin? =
No. The theme is fully functional on its own. The optional free Starter Sites plugin only adds demo imports.

= Does Open Frame make remote requests? =
No tracking and no remote calls in core rendering. Fonts are self-hosted when the bundled WOFF2 files are added (see assets/fonts/README.txt); until then the system font stack is used.

= How do I create a mega menu? =
Open Frame includes a built-in mega menu that needs no plugin. In Appearance > Menus, open "Screen Options" (top right) and enable "CSS Classes". Add the class `of-mega` to a top-level menu item that has sub-items. Its direct child items become columns (shown as headings) and any items nested beneath them are listed as links under each column. Items without the `of-mega` class keep the standard dropdown behaviour, and the mega menu stacks into a single column on mobile.

== Copyright ==

Open Frame is distributed under the terms of the GNU GPL v2 or later.

Bundled resources:
* Hanken Grotesk — SIL Open Font License 1.1 — https://fonts.google.com/specimen/Hanken+Grotesk
* JetBrains Mono — SIL Open Font License 1.1 — https://fonts.google.com/specimen/JetBrains+Mono

== Changelog ==

= 0.5.0 =
* Fix: floated images (alignleft/alignright) and trailing thumbnails no longer stick out below the content card. `.entry-content`, `.entry-summary`, `.page-content` and `.comment-content` now establish a block formatting context (`display: flow-root`) so containers size to include their floats, without clipping full-bleed (`alignfull`) blocks.
* Fix: paginated-content links (`wp_link_pages`) now clear trailing floats and are styled as proper pagination, instead of wrapping beside a floated image (resolves the "Clearing Floats" Theme Unit Test page).
* Add: core `.clear` float-clearing helper.
* Verified in-browser (desktop + mobile) on the Clearing Floats and Image Alignment test pages: floats contained within the card, large 1200px images constrained to the content width, following content and comments clearing correctly, legitimate text wrapping preserved, and no horizontal overflow.

= 0.4.0 =
* Rebuild: professional navigation overhaul. Each menu item now lays its link and caret toggle on a single centered row, fixing the uneven vertical alignment of parent items on desktop.
* New: native multi-column mega menu, enabled per item via the `of-mega` CSS class — no plugin, premium add-on or external service required. Columns, headings, nested link lists and responsive single-column stacking are all built in.
* Fix: on mobile the open menu panel inherited `flex-wrap: wrap`, so long menus wrapped into a second column (e.g. the last item jumped to the top-right). The panel is now a single scrollable column (`flex-wrap: nowrap`, capped height with its own scroll).
* Polish: subtle caret indicators that rotate when open, hover/focus transitions, a hover "bridge" so dropdowns don't close in the gap, current-ancestor highlighting, and larger mobile tap targets for submenu toggles.
* Verified in-browser across 320/360/390/430/768/1024/1280/1440/1920 px: no horizontal overflow, hamburger hidden on desktop and shown at/under tablet, desktop dropdowns and mega menu in-viewport with correct stacking, mobile open/close + nested submenus, aria-expanded, keyboard focus-within and Escape (focus returns to toggle), and RTL mirroring.

= 0.3.0 =
* Fix: the generic button component style was overriding navigation controls — the mobile hamburger wrongly appeared on desktop and submenu toggles rendered as solid buttons. Nav toggles now opt out via the `of-plain` class (desktop shows the horizontal menu, mobile shows the hamburger).
* Fix: nested (2nd-level and deeper) submenus now expand inline with indentation instead of flying off-screen/overlapping sibling items; no horizontal overflow at any level.
* Verified in-browser: desktop dropdowns (position/z-index/no clipping), nested menus, mobile open/close + submenu, aria-expanded, keyboard focus-within, RTL mirroring.

= 0.2.0 =
* Fix: removed an invalid hyphenated JS object name from the navigation script localization that produced a console syntax error.
* Fix: full-width (alignfull) blocks now bleed edge-to-edge with no horizontal overflow on desktop and mobile.
* Clean-up: removed dead submenu-label global in the nav walker; dropped unused inline navigation data.
* i18n: added languages/open-frame.pot translation template.
* Docs: refreshed compliance matrix and added a PHPCS/WPCS ruleset (phpcs.xml.dist).

= 0.1.0 =
* Initial foundation: design system, Customizer, header/footer builders, navigation, core templates, theme.json, accessibility and i18n baseline.
