# SEO-W1-05 Runtime Evidence — 2026-10-07

## Purpose

This directory retains the target-page on-page **before state** used to close SEO-W1-05. It covers only the four Vietnamese priority URLs in the agreed engagement scope.

## Sources

- Official Screaming Frog 24.3 W1-02 evidence in `docs/seo/evidence/w1-02/screaming-frog-2026-10-07/`.
- Fresh unauthenticated public HTTP capture on 2026-10-07 around 05:16 UTC using user agent `Mozilla/5.0 (compatible; IPAEnglish-W1-05/1.0)`.
- Runtime/server HTML extraction for title, Meta Description, canonical, robots, H1/H2, image ALT, opening copy, internal target links and language-switch links.

## Evidence files

- `html-manifest.csv` — exact final URL, status, redirect count, HTML byte length and SHA-256 for each captured body.
- `target-page-baseline.csv` — page-level SEO/runtime before-state.
- `images-alt.csv` — missing/empty ALT occurrences relevant to the four targets.
- `target-link-matrix.csv` — cross-target navigation and Vietnamese/English switch behavior.

Raw page bodies are not duplicated in Git. Instead, their exact byte length and SHA-256 are retained together with the structured SEO/runtime extracts required by W1-05. This keeps the evidence reproducible without storing a large volatile copy of the public WordPress output.

## Cross-check summary

- All four direct target requests returned `200` with zero redirects.
- All four targets are self-canonical.
- Meta Description count is `0` on all four targets.
- `/vi/` has one H1: `Học Viện Anh Ngữ IPA`.
- Teen, Book a Test and Learning System have no H1 and expose their primary visible page heading as H2.
- Language switch links resolve to the matching English counterpart for all four pages.

No credentials, cookies, verification tokens or authenticated responses are stored in this evidence pack.
