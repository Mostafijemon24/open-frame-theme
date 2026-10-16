Open Frame bundled fonts
=======================

The Open Frame design system uses two open-source, GPL-compatible typefaces.
To ship a privacy-friendly, WordPress.org-compliant build with no remote font
requests, place the self-hosted WOFF2 files in THIS directory and a matching
`fonts.css` that declares the @font-face rules. The theme auto-loads
`assets/fonts/fonts.css` only when at least one .woff2 file is present here;
otherwise it falls back to the system font stack.

Required families and licenses
------------------------------
1. Hanken Grotesk — SIL Open Font License 1.1
   Source: https://fonts.google.com/specimen/Hanken+Grotesk
   Weights used: 400, 500, 600, 700, 800

2. JetBrains Mono — SIL Open Font License 1.1
   Source: https://fonts.google.com/specimen/JetBrains+Mono
   Weights used: 400, 500, 600

Expected files (example)
------------------------
assets/fonts/hanken-grotesk-400.woff2
assets/fonts/hanken-grotesk-500.woff2
assets/fonts/hanken-grotesk-600.woff2
assets/fonts/hanken-grotesk-700.woff2
assets/fonts/hanken-grotesk-800.woff2
assets/fonts/jetbrains-mono-400.woff2
assets/fonts/jetbrains-mono-500.woff2
assets/fonts/jetbrains-mono-600.woff2

When adding the files, also record them in docs/ASSET-LICENSES.md with the
upstream version and a copy of each OFL license under assets/fonts/licenses/.

STATUS: NOT YET BUNDLED. Until the WOFF2 files and fonts.css are added, the
theme renders with the system UI font stack (fully functional, slightly
different look from the Studio Framework reference).
