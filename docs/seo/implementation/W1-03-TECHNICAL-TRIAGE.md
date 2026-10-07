# SEO-W1-03 — Technical Audit Triage & Week 2 Backlog

**Execution date:** 2026-10-07
**Source:** Official Screaming Frog 24.3 baseline from SEO-W1-02
**Scope:** Basic technical SEO + four priority Vietnamese target pages

## Triage principles

- Group repeated crawl findings by root cause instead of creating one task per URL.
- Keep Week 2 implementation bounded to the agreed four-page/on-page scope plus basic technical SEO.
- Preserve accepted production behavior; do not redesign working robots/canonical/redirect behavior.
- Do not create a second metadata, sitemap, cache, canonical, GA4, or image-optimization owner.
- Broader sitewide cleanup discovered by the crawl is documented as Deferred instead of silently expanding scope.

## Technical finding triage

| ID | Severity | Evidence / Current State | Triage Decision | Implementation Surface | Week 2 Task | Owner | Status | Verification |
|---|---|---|---|---|---|---|---|---|
| TECH-001 | High | `/wp-sitemap.xml` returns sitemap XML with HTTP 404 | Actionable; fix root cause, keep WordPress core as sole sitemap owner | WordPress rewrite / server routing / cache layer, whichever is proven owner | SEO-W2-03 | Dev / Tech + SEO | Open | HTTP 200, XML parses, correct content type, robots directive remains, GSC submission recorded |
| TECH-002 | Medium | 26/26 crawled HTML pages have no Meta Description; all four targets affected | Actionable for four target pages; non-target sitewide descriptions Deferred | WordPress native Excerpt/summary + minimal child-theme renderer only if no existing owner | SEO-W2-01 | SEO + Dev / Tech | Open | Exactly one rendered description on each target + Screaming Frog re-crawl |
| TECH-003 | Medium | Target Vietnamese pages use generic/English titles; W1-02 also found 12 duplicate-title groups | Actionable for four target pages; broad non-target title/localization cleanup Deferred | WordPress title/translation first; smallest title filter only if required | SEO-W2-01 | SEO + Dev / Tech | Open | One effective Vietnamese title per target; English counterpart unaffected; title re-crawl |
| TECH-004 | High | Project owner confirms production GA4 setup and verification are complete | Treat setup/implementation as resolved; do not add a second tag. Keep W3 as final regression/measurement confirmation only | Existing Google tag/GTM/WordPress integration owner | SEO-W2-08 completed; SEO-W3-02 regression | SEO + Dev / Tech | Fixed | Final W3 Realtime/network confirmation, target URLs identifiable, no duplicate page_view |
| TECH-005 | Medium | No active WebP delivery detected; 2 unique images >100 kB in W1-02 | Actionable for priority/high-impact assets; full media-library migration Deferred | One existing plugin, server, or CDN image optimization owner | SEO-W2-05 | Dev / Tech | Open | WebP/modern delivery where configured, fallback works, sampled bytes reduced, no visual regression |
| TECH-006 | Medium | 18/26 HTML pages missing H1; three of four target pages affected | Actionable on target pages; non-target H1 cleanup Deferred | WordPress/Elementor content-only changes | SEO-W2-02 | SEO | Open | One meaningful H1 per target, heading hierarchy reviewed, Screaming Frog H1 re-crawl |
| TECH-007 | Medium | W3 Total Cache and Autoptimize are both active | Continue existing ownership model: W3TC page/browser cache; Autoptimize CSS/JS only; remove proven overlap only | Plugin configuration + cache purge | SEO-W2-06 | Dev / Tech | In Progress | Settings evidence, no duplicate transforms, private/auth flows regression-tested, basic before/after diagnostic |
| TECH-008 | Medium | W1-02 found 0 internal 3xx, 0 internal 4xx, 0 internal 5xx and 0 redirect chains | No remediation implementation required from current baseline; preserve policy and re-open only if later crawl finds a regression | None for baseline; future URL-specific WordPress/server redirect only when justified | SEO-W2-04 (baseline no-op), W3 re-crawl | Dev / Tech | Accepted | W3 response-code + redirect-chain reports remain clean |
| TECH-009 | Low | `robots.txt` returns 200 and references native sitemap | Accepted baseline; regression verification only | Existing robots owner | SEO-W2-07 | Dev / Tech | Accepted | 200, sitemap directive correct, required assets not blocked |
| TECH-010 | Low | 0 crawled HTML pages missing canonical; all four targets are Indexable and self-canonical | Accepted baseline; do not add custom canonical renderer | WordPress core canonical owner | SEO-W2-07 | Dev / Tech | Accepted | Exactly one self-canonical on each target; canonical target 200 |

## Bounded Week 2 execution backlog

| Task | Disposition after W1-03 | Reason |
|---|---|---|
| SEO-W2-01 — Title + Meta Description | Waiting on W1-04/W1-05 | TECH-002/003 are actionable, but approved keyword/page baseline should be frozen first |
| SEO-W2-02 — H1/H2/ALT/Copy | Waiting on W1-04/W1-05 | TECH-006 is actionable on the four targets; broader sitewide H1/ALT cleanup is out of current scope |
| SEO-W2-03 — Sitemap HTTP 200 + GSC | READY | W1-03 triage complete; highest-priority technical fix |
| SEO-W2-04 — Broken Links / 404 / 301 | NOT_APPLICABLE_BASELINE | No internal broken URL, internal redirect, or redirect chain was found in W1-02; re-open only if later evidence changes |
| SEO-W2-05 — Image WebP / Compression | READY | TECH-005 confirmed; prioritize the two >100 kB images and target-page assets |
| SEO-W2-06 — Cache Ownership / Basic Performance | IN_PROGRESS_SOURCE | Existing W3TC/Autoptimize ownership baseline exists; verify/remove only proven overlap |
| SEO-W2-07 — Robots / HTTPS / Canonical Regression | ACCEPTED_BASELINE | No redesign needed; run after Week 2 changes as regression protection |
| SEO-W2-08 — GA4 Verification | DONE_OWNER_CONFIRMED | Project owner confirmed GA4 setup/verification complete; do not duplicate implementation, retain W3 final regression only |

## Deferred / out-of-scope findings

| Item | Evidence | Why Deferred | Future Action |
|---|---|---|---|
| Sitewide Meta Description completion outside the four target pages | 26/26 HTML pages missing descriptions; current delivery scope prioritizes four target URLs | Full-site content/metadata production exceeds agreed on-page scope | Plan a separate sitewide metadata pass after target-page results are validated |
| Non-target title/localization duplicate cleanup | 26 duplicate-title rows / 12 groups, primarily EN/VI pairs | Current scope only approves four Vietnamese target-page titles | Audit remaining duplicate groups and localize only with page-level intent/translation approval |
| Non-target H1 remediation | 18 pages missing H1; only three are current target pages | Full-site heading rewrite is outside four-page scope | Create a later template/content cleanup backlog by page type |
| Full-site ALT cleanup | 12/15 unique images have missing/empty ALT text across 50 inlink occurrences | W2 focuses target/priority imagery; a whole media-library rewrite expands scope | Review by target/high-impact first, then batch the remaining informative images separately |
| Full image-library migration / advanced Core Web Vitals program | W1-02 identifies only basic image/performance signals | Explicitly outside basic SEO delivery | Separate performance/media project if business wants deeper CWV optimization |

## Gate output

W1-03 is complete when the authoritative audit and execution dashboard mirror this triage. Week 2 has named owners, bounded implementation surfaces, explicit verification methods, accepted/no-op findings, and a deferred register; there is no generic “fix SEO” task left.
