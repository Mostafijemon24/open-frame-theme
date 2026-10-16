# Open Frame

An original, lightweight, accessibility-first **multipurpose WordPress theme** built on a token-driven design system. Open Frame ships with a comprehensive Customizer, header and footer builders, an accessible navigation system with a native (plugin-free) mega menu, and complete template coverage for blog, archive, search, single, page and 404 views. It works fully on its own and requires **no plugin**.

- **Author:** Mostafij Emon — <https://mostafijemon.live/>
- **License:** GNU General Public License v2 or later (GPL-2.0-or-later)
- **Text domain:** `open-frame`
- **Requires WordPress:** 6.4+ · **Requires PHP:** 7.4+

## Features

- Token-driven design system (color, typography, spacing, radius, elevation).
- Comprehensive Customizer: global colors, typography, layout, header and footer builders — every control has a real effect.
- Accessible, keyboard-friendly navigation: desktop dropdowns, nested menus, a native multi-column **mega menu** (add the `of-mega` CSS class to a top-level menu item), and a reliable mobile menu with correct ARIA.
- Header builder with multiple layouts, sticky and optional transparent modes.
- Footer builder with 1–4 responsive widget columns; empty columns are hidden.
- Right/left/no-sidebar and full-width layouts.
- Block editor (Gutenberg) support via `theme.json`, shared palette, editor styles, `alignwide`/`alignfull`, and proper float containment.
- Translation-ready, RTL-friendly, reduced-motion aware.
- No remote requests, no tracking, no bundled third-party assets.

## Installation

1. Download/clone this repository, or build a ZIP (see below).
2. In WordPress admin: **Appearance → Themes → Add New → Upload Theme**, upload the ZIP, **Install** then **Activate**.
3. Visit **Appearance → Customize** to configure colors, typography, header and footer.

### Creating a mega menu

In **Appearance → Menus**, open **Screen Options** and enable **CSS Classes**. Add the class `of-mega` to a top-level menu item that has sub-items. Its direct children become columns; items nested beneath them list as links. Other items keep the standard dropdown.

## Development

- Source of truth for styling tokens: the `:root` custom properties in `style.css`.
- PHP follows the WordPress Coding Standards. Lint with:
  ```
  phpcs --standard=open-frame-phpcs.xml.dist .
  ```
  (the ruleset is maintained alongside releases). All PHP targets PHP 7.4+.
- `docs/` contains development-only notes and a compliance matrix; it is excluded from the distributable theme ZIP.

## Building a release ZIP

The installable theme excludes development files (`docs/`, `.git*`, PHPCS config, OS metadata):

```
rsync -a --exclude 'docs' --exclude '.git*' --exclude '.DS_Store' ./ /tmp/open-frame/open-frame/
cd /tmp/open-frame && zip -rqX open-frame.zip open-frame
```

## Changelog

See the `== Changelog ==` section of [`readme.txt`](readme.txt) for the full, versioned history.

## License

Open Frame is free software distributed under the terms of the GNU GPL v2 or later. See [`LICENSE`](LICENSE).
