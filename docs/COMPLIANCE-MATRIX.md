# Open Frame — Compliance Matrix

Status legend: PASS · FAIL · BLOCKED · NOT VERIFIED · NOT APPLICABLE · TODO

_Last updated: 2026-10-16 (release-candidate v0.2.0, post Northline→Open Frame migration + production hardening)_

## Release gates (must clear before declaring a final release)
| Gate | Status | How to clear |
|---|---|---|
| WordPress.org name/slug availability (`Open Frame` / `open-frame`) | NOT VERIFIED | No network in this environment. Check the WP.org Themes directory and trac for an existing `open-frame` slug from an internet-capable machine before submitting. |
| PHPCS / WPCS coding standards | NOT VERIFIED | Run `phpcs` with WPCS + PHPCompatibilityWP using the prepared ruleset (kept OUTSIDE the theme at `releases/open-frame-phpcs.xml.dist`, since dev config must not ship in the theme) in a WPCS-equipped environment; record results here. |

### Running WPCS (prepared, not yet executed here)
The ruleset lives at `releases/open-frame-phpcs.xml.dist` (deliberately not inside the theme — Theme Check forbids dev config in a production theme). From the WordPress root:
```
composer global require squizlabs/php_codesniffer wp-coding-standards/wpcs phpcompatibility/phpcompatibility-wp dealerdirect/phpcodesniffer-composer-installer
phpcs --standard=../releases/open-frame-phpcs.xml.dist wp-content/themes/open-frame
```
The ruleset enforces: WordPress ruleset, `text_domain=open-frame`, prefixes `open_frame`/`OPEN_FRAME`/`Open_Frame`, and `PHPCompatibilityWP` at `testVersion 7.4-`.

## Workspace / provenance
| Item | Status | Notes |
|---|---|---|
| New directory, separate from prior work | PASS | `wp-content/themes/open-frame` |
| Prior work preserved | PASS | `northline` theme folder kept as backup; `northline-0.1.0.zip` preserved; no unrelated projects touched |
| Finalized brand | PASS | "Open Frame" / `open-frame` applied across files + DB |
| No plugin dependency | PASS | Renders fully standalone with all plugins deactivated |

## Theme structure & metadata
| Item | Status | Notes |
|---|---|---|
| `style.css` header complete | PASS | Name: Open Frame, Theme URI: (intentionally empty), Author: Mostafij Emon, Author URI: https://mostafijemon.live/, Version 0.1.0, GPL-2.0, Text Domain: open-frame |
| Text domain `open-frame` consistent | PASS | All gettext calls use `open-frame`; 0 residual brand tokens |
| Required templates present | PASS | index, header, footer, single, page, archive, search, 404, comments, sidebar |
| `theme.json` valid | PASS | v2 schema; palette/typography/spacing |
| PHP syntax | PASS | `php -l` clean on all PHP files + extracted ZIP copy |
| Full verbatim GPL-2.0 `LICENSE` | PASS | 349-line GPL text, brand header "Open Frame" |
| Clean activation (no fatal) | PASS | Active on wp.local; home/page/category/search/author 200, 404 correct, 0 fatals |

## Quality gates run in this environment
| Item | Status | Notes |
|---|---|---|
| Theme Check | PASS | REQUIRED 0, WARNING 0, RECOMMENDED 1 (`custom-header`, intentionally omitted), INFO 1 |
| `screenshot.png` (≤1200×900) | PASS | 1200×900 PNG, real theme capture, brand-neutral |
| Template hierarchy runtime | PASS | home, page, category, search, author, 404 — correct responses, 0 fatals, native header/footer on all |
| Gutenberg alignfull/alignwide — desktop 1280 | PASS | overflow 0; alignfull full-bleed (1280), alignwide 1054 |
| Gutenberg alignfull/alignwide — mobile 390 | PASS | overflow 0; alignfull full-bleed (390), alignwide 285 |
| Customizer migration + live effect | PASS | mods ported (northline_* → open_frame_*), menu locations preserved, dynamic CSS reflects settings |
| Release ZIP install validity | PASS | extracted ZIP installed under scratch slug → `wp_get_theme()->errors()` empty, headers correct (Open Frame / 0.2.0 / open-frame / empty Theme URI), lint clean, 0 brand residue, no dev files |
| RTL support (runtime) | PASS | `dir=rtl` runtime test: logical properties mirror (blockquote accent L→R), `body` computes `direction: rtl`, overflow 0; visually confirmed |
| Accessibility (runtime) | PASS | landmarks banner/nav/main/contentinfo present, skip link targets existing `#content`, single h1 with ordered headings, image alt present, mobile menu toggle opens/closes with correct aria-expanded + visibility |
| Color contrast (default tokens) | PASS | body 17:1, links 6.5:1, hover 9:1, button 6.5:1, footer 12:1 — all AA; accent token unused in default styling (palette option only) |
| Navigation system (v0.3.0) | PASS | Root cause fixed: generic `button:not(.of-plain)` component rule was overriding nav controls (hamburger showed on desktop; submenu carets rendered as solid buttons). Nav toggles now use `of-plain`. Nested submenus expand inline (no off-screen flyout/overlap). Verified in-browser: desktop dropdown position/z-index 50/no clipping, nested menus, keyboard focus-within, RTL mirroring. |
| Navigation rebuild (v0.4.0) | PASS | Each `li` is now a centered flex row so link+caret align — fixes desktop parent-item vertical misalignment (all 7 top items `top:16, h:35`, one row). Integrated caret toggles (transparent, rotate on open), hover "bridge", current-ancestor highlight. Verified in-browser at 1280/1440/1920. |
| Mega menu (v0.4.0, native) | PASS | Opt-in via `of-mega` CSS class on a top-level item (native Appearance→Menus field, no plugin). DOM-verified multi-column render (5 columns / 2 rows, 754px, in-viewport, overflow 0); ordinary items keep normal dropdown; stacks to single column on mobile. |
| Mobile menu / responsive JS | PASS | 320/360/390/430/768 verified: open/close via hamburger (aria-expanded, Escape closes + focus returns to toggle), inline submenu expand, single scrollable column (fixed a `flex-wrap:wrap` second-column bug), overflow 0 at every width; hamburger hidden ≥1024. |
| Menu assignments preserved | PASS | `primary` location still assigned (menu id 183) after all edits; `of-mega` test was DOM-only and never written to the DB. Registered locations: primary, secondary, footer. |
| Heuristic standards/security self-audit | PASS (preliminary — NOT WPCS) | no disallowed/debug funcs, no short tags, no raw superglobals, ABSPATH guards on includes, escaped output, single text domain |

## Security & i18n
| Item | Status | Notes |
|---|---|---|
| Output escaping | PASS (baseline) | esc_html/esc_attr/esc_url/wp_kses_post throughout |
| Customizer sanitization | PASS | Every setting has a sanitize_callback |
| Prefixing (no global collisions) | PASS | `open_frame_` fns, `OPEN_FRAME_` consts, `Open_Frame_` classes, `--of-`/`of-` CSS |
| Translation functions | PASS | All user-facing strings wrapped; textdomain loaded from `/languages` |
| ABSPATH guards on includes | PASS | All `inc/` files guarded |

## Accessibility
| Item | Status | Notes |
|---|---|---|
| Skip link | PASS | `#content` skip link |
| Keyboard nav + submenu toggles | PASS (code) | Walker + navigation.js; NOT VERIFIED with assistive tech |
| Visible focus | PASS | `:focus-visible` outline + focus-ring token |
| Reduced motion | PASS | `prefers-reduced-motion` honored |
| Color contrast | PASS | Measured: all default text/UI pairs AA (6.5–17.8:1); accent token unused in default styling |
| Keyboard mobile menu | PASS | Toggle open/close verified at runtime with aria-expanded |

## Release artifact
| Item | Status | Notes |
|---|---|---|
| `open-frame-0.2.0.zip` | CANDIDATE | Current candidate in `wp/releases/`; NOT declared final until the two release gates above clear |
| Preserved prior artifacts | PASS | `northline-0.1.0.zip`, `open-frame-0.1.0.zip`, and the `northline/` theme backup all retained |
| Version policy | 0.2.0 | Candidate; bump per release policy once gates clear |
