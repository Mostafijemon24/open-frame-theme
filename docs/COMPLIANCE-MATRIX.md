# Open Frame — Compliance Matrix

Status legend: PASS · FAIL · BLOCKED · NOT VERIFIED · NOT APPLICABLE · TODO

_Last updated: 2026-10-17 (release-candidate v0.6.0 — mobile header alignment follows Customizer layout; v0.5.0 float-containment fix, WPCS-clean, GitHub published)_

## v0.6.0 audit results
| Item | Status | Evidence |
|---|---|---|
| Mobile header alignment defect | PASS | Root cause: on `@media (max-width:1023px)` the nav used `flex-basis:100%` (wrapping to a full-width second row) and `.menu-toggle{margin-inline-start:auto}`, but auto-margins do not apply to an inline-flex child of a *block* `.main-navigation`, so the toggle rendered at the inline start regardless of layout (measured left:24 / top:76, own row). Fix: keep the nav on the header row (removed `flex-basis:100%`) so the existing `header-layout-*` rule positions it (e.g. `logo-left-menu-right` → `margin-inline-start:auto`), dropped the open menu as an absolute full-width panel anchored to `.site-header-inner`, and removed the ineffective toggle auto-margin. |
| Mobile config-driven alignment | PASS | Browser DOM/CSSOM measured: `logo-left-menu-right` → logo left (24) + toggle right (edge 366/296 per width), same row; switched saved mod to `logo-right-menu-left`, reloaded → logo right (366) + toggle left (24); restored original. Verified 320/360/390/430/768 (toggle right, no overflow), menu open/close (toggle Δx 0, logo fixed), RTL (logo right/toggle left, mirrored), desktop 1024/1440 unchanged (toggle hidden, horizontal menu at inline end). |

## v0.5.0 audit results
| Item | Status | Evidence |
|---|---|---|
| Clearing Floats defect | PASS | Root cause: `.entry-content` did not contain floats, so a trailing floated thumbnail protruded 45px below the card and `wp_link_pages` wrapped beside it. Fix: `display:flow-root` on `.entry-content`/`.entry-summary`/`.page-content`/`.comment-content` + `clear:both` on `.page-links`. Browser-verified desktop+mobile: float contained (−97px inside card), page-links cleared below, overflow 0; `alignfull` still full-bleed (no regression). |
| Image Alignment page | PASS | 11 images, none protrude the card, large 1200px images constrained to content width (1160), comments clear below, overflow 0 (desktop + mobile). |
| WPCS (WordPress + Extra) | PASS | 0 errors / 0 warnings (post `phpcbf`). |
| Theme Check (v0.5.0) | PASS | REQUIRED 0, WARNING 0, RECOMMENDED 1 (`custom-header`, intentional), INFO 1. |
| Security/privacy scan | PASS | No `wp_remote_*`/curl/fsockopen/`file_get_contents(url)`; no `eval`/`base64_decode`/exec; no Google Fonts/CDN; no tracking. |
| Bundled-asset licensing | PASS | Only binary is original `screenshot.png` (1200×900); no third-party fonts/images/videos shipped. All code GPL-2.0. |
| Standalone ZIP install | PASS | Extracted under a scratch slug → `wp_get_theme()->errors()` empty; works with all plugins deactivated. |
| GitHub publication | PASS | Public repo https://github.com/Mostafijemon24/open-frame-theme, branch `main`, tag `v0.5.0`; secret scan clean; no `.git`/secrets/zip tracked. |
| Envato technical requirements | PASS (technical) | Theme Check clean, no-plugin operation, security, Gutenberg/theme.json, prefixing, licensing. Business/packaging items (full HTML end-user docs, listing/preview asset licensing) depend on final Envato product configuration. |


## Release gates (must clear before declaring a final release)
| Gate | Status | How to clear |
|---|---|---|
| WordPress.org name/slug availability (`Open Frame` / `open-frame`) | PASS (available) | WP.org themes info API returns `{"error":"Theme not found"}` (HTTP 404) for `request[slug]=open-frame`, while a known slug (`twentytwentyfour`) returns HTTP 200 — so `open-frame` is not currently registered in the directory. Re-confirm at submission time. |
| PHPCS / WPCS coding standards | PASS | PHPCS 3.11.3 + WPCS (WordPress/-Extra/-Docs) run against the whole theme: **0 errors, 0 warnings** after auto-fixing 78 cosmetic alignment/formatting items with `phpcbf`. Security, escaping, sanitization, i18n, text-domain and prefixing sniffs were clean before the fixes. |
| PHP 7.4+ compatibility (PHPCompatibilityWP) | NOT VERIFIED (tooling) / PASS (manual) | PHPCompatibility 9.3.5 has a sniff-autoload clash with the sandbox phpcs phar. Manual evidence: `php -l` clean on PHP 8.5; no PHP 8-only constructs (no arrow fns, `match`, nullsafe, typed properties, promotion, enums, attributes, PHP8 string fns); `Requires PHP: 7.4`. |

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
