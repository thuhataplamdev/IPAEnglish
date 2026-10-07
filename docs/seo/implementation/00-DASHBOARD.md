# IPAEnglish SEO Execution Dashboard

**Baseline:** `main` after SEO documentation merge  
**Delivery:** 3 working weeks  
**Execution model:** Week 1 baseline/audit → Week 2 parallel SEO + technical implementation → Week 3 re-crawl/QA/handover

| ID | Task | Timing | Owner | Priority | Source status | Dependency |
|---|---|---|---|---|---|---|
| SEO-W1-01 | Access & Measurement Baseline | Week 1 | SEO Exec | High | DONE | — |
| SEO-W1-02 | Initial Screaming Frog Crawl | Week 1 | SEO Exec | High | DONE | W1-01 complete; official Screaming Frog 24.3 evidence captured 2026-10-07 |
| SEO-W1-03 | Technical Audit Triage & Backlog | Week 1 | SEO Exec + Dev/Tech | High | DONE | W1-02 complete; triage finalized 2026-10-07 |
| SEO-W1-04 | Keyword Validation & Final Mapping | Week 1 | SEO Exec + Business | High | BASELINE_RESOLVED | W1-01; revalidate with GSC if available |
| SEO-W1-05 | Target-page On-page Baseline | Week 1 | SEO Exec | High | DONE | W1-02 complete; runtime + on-page before-state captured 2026-10-07; W1-04 still gates W2-01/W2-02 |
| SEO-W2-01 | Title + Meta Description Implementation | Week 2 | SEO Exec + Dev/Tech | Medium | OPEN | W1-04,W1-05 |
| SEO-W2-02 | H1/H2/ALT/Existing Copy Optimization | Week 2 | SEO Exec | Medium | OPEN | W1-04,W1-05 |
| SEO-W2-03 | Fix Native Sitemap HTTP 200 + Submit GSC | Week 2 | Dev/Tech + SEO | High | DONE | TECH-001 runtime fixed; public sitemap + 4 public child sitemaps verified HTTP 200/XML; robots retained; GSC submission accepted 2026-10-07; final Google fetch/processing status moves to W3 |
| SEO-W2-04 | Broken Links / 404 / 301 Remediation | Week 2 | Dev/Tech | Medium | NOT_APPLICABLE_BASELINE | W1-03: no internal 3xx/4xx/5xx or redirect chains |
| SEO-W2-05 | Image Compression / WebP | Week 2 | Dev/Tech | Medium | DONE | TECH-005 fixed 2026-10-07; single server-owned WebP path deployed; 56/56 target-page variants generated; sampled aggregate weight -68.0%; modern/fallback and 4-page image regression passed |
| SEO-W2-06 | Cache Ownership + Basic Performance | Week 2 | Dev/Tech | Medium | DONE | TECH-007 fixed 2026-10-07; W3TC page cache/minify remain OFF, W3TC compression flags disabled, Autoptimize owns public HTML/CSS/JS and bypasses logged-in editors/admins, Caddy owns zstd/gzip; runtime + equivalent before/after evidence captured |
| SEO-W2-07 | Robots / HTTPS / Canonical Regression | Week 2 | Dev/Tech | Low | READY | W2-03,W2-05,W2-06 complete; run final regression gate now |
| SEO-W2-08 | GA4 Production Setup / Verification | Week 2 | SEO Exec + Dev/Tech | High | DONE_OWNER_CONFIRMED | W1-01 complete; owner confirmed GA4 done; W3 final regression remains |
| SEO-W3-01 | Final Re-crawl + Before/After QA | Week 3 | SEO Exec + Dev/Tech | High | BLOCKED | Remaining: W2-01,W2-02,W2-07; W2-03,W2-05,W2-06,W2-08 satisfied and W2-04 baseline no-op |
| SEO-W3-02 | Final GSC + GA4 Verification | Week 3 | SEO Exec | High | READY | W2-03 and W2-08 complete; verify refreshed GSC sitemap fetch/processing state and final GA4 runtime in W3 |
| SEO-W3-03 | Handover + Sign-off | Week 3 | SEO Exec + Dev/Tech | High | BLOCKED | W3-01,W3-02 |

## Current audit mapping

| Audit finding | Task |
|---|---|
| TECH-001 — `/wp-sitemap.xml` returns XML with HTTP 404 | SEO-W2-03 |
| TECH-002 — Meta Description missing on 4 target URLs (and all 26 crawled HTML pages) | SEO-W2-01 |
| TECH-003 — Vietnamese target titles still generic/English on samples | SEO-W2-01 |
| TECH-004 — GA4 execution tag not verified | SEO-W2-08 |
| TECH-005 — WebP delivery not active in sampled image | SEO-W2-05 |
| TECH-006 — H1 missing on Teen / Book a Test / Learning System target pages | SEO-W2-02 |
| TECH-007 — W3TC + Autoptimize ownership overlap risk | SEO-W2-06 |
| TECH-008 — W1-02 found 0 internal 3xx/4xx/5xx and 0 redirect chains; no remediation baseline, re-open only on regression | SEO-W2-04 baseline no-op / W3 re-crawl |
| TECH-009 — robots.txt accepted baseline | SEO-W2-07 regression |
| TECH-010 — WordPress canonical accepted baseline; all 4 targets self-canonical in W1-02 | SEO-W2-07 regression |

## Gate A — End of Week 1

Gate A passes when:

- GSC/GA4 access state is documented;
- initial Screaming Frog crawl is complete;
- audit findings are triaged with owner/status;
- 20-keyword maximum and four target URLs are confirmed;
- current Title/Description/H1/H2/ALT/copy baseline is captured;
- Week 2 technical backlog is assigned.

## Gate B — End of Week 2

Gate B passes when:

- four target URLs have approved on-page changes;
- TECH-001/002/003/004/005/006/007/008 are Fixed, Accepted, Deferred, or Not Applicable with reason;
- robots, sitemap, redirect, cache and image changes are ready for re-crawl;
- no new duplicate canonical or duplicate Meta Description renderer exists.

## Gate C — End of Week 3

Gate C passes when:

- re-crawl completed using comparable settings;
- before/after evidence recorded;
- GSC sitemap submission/status captured;
- GA4 production traffic verified;
- final Keyword Map and Technical SEO Audit are updated;
- every unresolved item is explicitly Deferred/Out of Scope;
- handover checklist is signed off.

## Progress rule

Do not mark a task Done from code/config change alone. `Done = implementation + runtime verification + evidence + document update`.
