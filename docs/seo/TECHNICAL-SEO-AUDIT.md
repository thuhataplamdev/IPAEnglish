# IPAEnglish Technical SEO Audit

**Status:** Working / handover template  
**Primary audit tool:** Screaming Frog SEO Spider  
**Measurement:** Google Search Console + GA4

## 1. Audit metadata

| Field | Value |
|---|---|
| Audit date | 2026-09-23 live baseline; W1-01 completed 2026-10-07; official W1-02 crawl completed 2026-10-07; W1-03 triage completed 2026-10-07 |
| Production URL | https://www.ipaenglish.com/ |
| Canonical host | https://www.ipaenglish.com |
| Screaming Frog version | 24.3 |
| Crawl mode | Spider / standard HTML crawl |
| Crawl start URL | https://www.ipaenglish.com/ |
| Sitemap URL | https://www.ipaenglish.com/wp-sitemap.xml |
| Total URLs crawled | 154 response rows including external checks; 142 internal resources; 26 internal HTML pages |
| GSC property | Production GSC access/setup owner-confirmed complete on 2026-10-07; no verification token stored in repo |
| GA4 property | Production GA4 property/data stream owner-confirmed configured and accessible on 2026-10-07; runtime verification remains part of later measurement QA |
| SEO Exec | |
| Dev / Tech Exec | |

### 1.1 W1-01 Access & Measurement Baseline — completed 2026-10-07

| Surface | Result | Evidence / Notes | Owner / Next Action |
|---|---|---|---|
| Production canonical origin | Verified (public runtime) | `http://ipaenglish.com/` -> HTTPS (308), `https://ipaenglish.com/` -> `https://www.ipaenglish.com/` (301), canonical production URL returns 200 | SEO Exec: retain `https://www.ipaenglish.com` as production canonical origin |
| robots.txt | Verified (public runtime) | `/robots.txt` returns 200 and contains a Sitemap directive referencing `/wp-sitemap.xml` | No access action required for W1-01; re-verify after sitemap work |
| WordPress Admin | Confirmed (owner-confirmed) | Authenticated WordPress administration access is available for the project | No W1-01 blocker; verify specific plugin/permalink capability only when a later implementation task requires it |
| Google Search Console | Confirmed (owner-confirmed) | Production GSC setup/access is confirmed complete by the project owner | Maintain access; submit/monitor the sitemap after TECH-001 is fixed |
| GA4 property / Web Data Stream | Confirmed (owner-confirmed) | Production GA4 setup/access is confirmed complete by the project owner. The earlier 2026-10-06 public HTML check predates this confirmation and is retained only as dated baseline evidence | Keep runtime/event verification in the dedicated measurement QA task; do not add a duplicate GA4 implementation owner |
| Production deployment / hosting | Confirmed (owner-confirmed) | VPS access via SSH; Nginx present; production WordPress path `/srv/app/IPAEnglish`; deployment is performed on the VPS and exposed through Caddy; source code and database are backed up by system timer | No W1-01 blocker; discover server-specific details only when a later technical fix requires them |
| Domain / DNS control | Confirmed (owner-confirmed) | Domain/DNS is managed in Squarespace | Use Squarespace only when DNS changes or DNS-based verification are required |

**W1-01 execution status:** `DONE`. Public runtime baseline is captured and the remaining private surfaces were owner-confirmed on 2026-10-07. No credentials, verification tokens, or server secrets are recorded in this repository. SEO-W1-02 was completed on 2026-10-07; SEO-W1-03 is the next execution task.

### 1.2 W1-02 Initial Screaming Frog Crawl — completed 2026-10-07

The official Screaming Frog SEO Spider 24.3 baseline is complete. The direct exports are authoritative; the earlier fallback crawl is retained only as an independent cross-check.

| Item | Official result | Notes |
|---|---|---|
| Evidence path | `docs/seo/evidence/w1-02/screaming-frog-2026-10-07/` | `raw/` contains direct Screaming Frog exports; `derived/` contains deterministic issue slices |
| Start URL / host | `https://www.ipaenglish.com/` / `https://www.ipaenglish.com` | Spider / standard HTML crawl; no authenticated areas |
| User-Agent / limit | `Screaming Frog SEO Spider/24.3`; 500-URL free-mode limit | Reuse comparable settings for W3 |
| Crawl volume | 154 response rows; 142 internal resources; 26 internal HTML pages | External checks excluded from internal totals |
| Four target URLs | Present, HTTP 200, Indexable, self-canonical | All four required Vietnamese targets captured |
| Internal response codes | 0 internal 3xx; 0 internal 4xx; 0 internal 5xx | No actionable internal broken URL in this baseline |
| Redirect signal | 2 external redirects; 0 redirect chains | Google Maps 301; Messenger 302 |
| Title signal | 0 missing; 26 duplicate-title rows / 12 groups; 20 under 30 chars; 0 over 60 chars | Duplicate groups are primarily EN/VI pairs; W1-03 decides actionability |
| Meta Description signal | 26/26 HTML pages missing; 0 duplicate non-empty descriptions | Includes all four target URLs |
| H1 signal | 18/26 missing; 2 multiple | Teen, Book a Test and Learning System targets are missing H1 |
| Image ALT signal | 12/15 unique images missing/empty ALT text across 50 inlink occurrences | 0 images missing the ALT attribute itself |
| Image size signal | 2 unique images over 100 kB across 4 inlink occurrences | Candidates for W2-05 |
| Directives / canonical | 0 noindex; 0 HTML pages missing canonical | All four targets are self-canonical |

**W1-02 status:** `DONE`. Runtime log confirms Screaming Frog 24.3, explicit EULA acceptance in the temporary runtime after operator consent, and successful headless crawl/export. No licence key, RPM, EULA config, verification token, or credential is stored in the repository. SEO-W1-03 was completed on 2026-10-07; the bounded triage is recorded in `docs/seo/implementation/W1-03-TECHNICAL-TRIAGE.md`.

### 1.3 W1-03 Technical Audit Triage — completed 2026-10-07

The W1-02 crawl findings were grouped by root cause and mapped to bounded Week 2 work. The authoritative triage matrix is `docs/seo/implementation/W1-03-TECHNICAL-TRIAGE.md`.

- Actionable implementation: TECH-001, TECH-002, TECH-003, TECH-005, TECH-006, TECH-007.
- Owner-confirmed completed measurement setup: TECH-004; W3 retains final regression verification.
- Accepted/no-remediation baseline: TECH-008, TECH-009, TECH-010.
- SEO-W2-04 requires no baseline remediation because the official crawl found 0 internal 3xx/4xx/5xx and 0 redirect chains.
- Sitewide cleanup beyond the four priority targets is explicitly Deferred rather than expanding scope.

## 2. Baseline checks

| Check | Baseline | Owner | Status | Evidence / Notes |
|---|---|---|---|---|
| HTTPS active | Yes | Dev / Tech | Accepted | Production serves HTTPS |
| Canonical host behavior | Apex -> www 301 | Dev / Tech | Accepted | https://ipaenglish.com/ redirects to https://www.ipaenglish.com/ |
| robots.txt reachable | Yes | Dev / Tech | Accepted | Returns 200 and references /wp-sitemap.xml |
| XML sitemap reachable | Body present but wrong HTTP status | Dev / Tech | Open | /wp-sitemap.xml returns XML with HTTP 404; must return 200 |
| Sitemap submitted to GSC | Not verified | SEO | Open | Submit only after sitemap endpoint returns 200 |
| GSC property verified | Owner-confirmed | SEO | Accepted | Production GSC setup/access confirmed complete on 2026-10-07; sitemap submission remains dependent on TECH-001 |
| GA4 receiving traffic | Owner-confirmed complete | SEO | Fixed | Project owner confirmed production GA4 setup/verification complete; retain final W3 regression confirmation without adding a duplicate tag owner |
| Image WebP/compression active | No active WebP delivery detected | Dev / Tech | Open | Sample JPG returns image/jpeg even with WebP Accept header |
| Cache active | Yes | Dev / Tech | Accepted | W3 Total Cache page marker present; Autoptimize serves optimized CSS/JS assets |

## 3. Screaming Frog findings

Use one row per actionable issue or issue group.

| ID | Category | Severity | URL / Pattern | Finding | Recommended Action | Owner | Status | Verification |
|---|---|---|---|---|---|---|---|---|
| TECH-001 | Sitemap status | High | /wp-sitemap.xml | Native sitemap returns XML body with HTTP 404 | Fix routing/status so the native sitemap returns HTTP 200; keep WordPress core as sole sitemap owner | Dev / Tech | Open | Recheck HTTP status and XML after fix |
| TECH-002 | Meta Description | Medium | 4 target Vietnamese URLs / sitewide sampled HTML | Official W1-02 crawl found Meta Description missing on all 26 crawled HTML pages, including all four targets | Add one controlled description output per target URL; broader sitewide work remains outside the four-page priority unless separately approved | SEO + Dev / Tech | Open | Re-crawl Meta Description report |
| TECH-003 | Title/localization | Medium | Vietnamese target URLs | Sampled /vi/ pages still use generic English document titles such as Book a Test - IPA English and Learning System - IPA English | Add controlled Vietnamese title overrides for the target pages | SEO + Dev / Tech | Open | Re-crawl title report |
| TECH-004 | GA4 | High | Sitewide | Production GA4 setup and verification are owner-confirmed complete | Treat implementation as resolved; do not add another tag owner; retain final regression verification in W3 | SEO + Dev / Tech | Fixed | Final W3 Realtime/network confirmation + duplicate page_view check |
| TECH-005 | Image delivery | Medium | Sitewide / target pages | No active WebP delivery detected on sampled JPG | Enable one image compression/WebP path and verify quality | Dev / Tech | Open | Request same image with WebP-capable client |
| TECH-006 | H1 | Medium | /vi/global-english-for-teen-achievers/, /vi/book-a-test/, /vi/learning-system/ | Official W1-02 crawl confirms all three target pages are missing H1; `/vi/` has one H1 (`Học Viện Anh Ngữ IPA`) | Add one descriptive Vietnamese H1 to each missing-H1 target while preserving heading hierarchy | SEO | Open | Re-crawl H1 report |
| TECH-007 | Cache ownership | Medium | Sitewide | W3 Total Cache and Autoptimize both active | W3TC = page/browser cache; Autoptimize = CSS/JS optimization only; remove overlapping transforms | Dev / Tech | In Progress | Verify page marker/assets and regression test |
| TECH-008 | 404/redirect policy | Medium | Public crawl baseline | Official W1-02 crawl found 0 internal 4xx, 0 internal 3xx and 0 redirect chains; two redirects observed are external (Google Maps/Messenger) | Preserve clean internal-link baseline; apply 301 only for future clear 1:1 moved/replaced URLs; no blanket Home redirects | Dev / Tech | Accepted | W3 re-crawl response codes/chains |
| TECH-009 | Robots | Low | /robots.txt | Reachable and points to native sitemap | Keep current basic policy; re-verify after sitemap fix | Dev / Tech | Accepted | 200 response + sitemap directive |
| TECH-010 | Canonical | Low | 4 target URLs | Official W1-02 crawl confirms all four target URLs are Indexable and self-canonical; 0 crawled HTML pages are missing a canonical | Keep WordPress core as sole canonical emitter; do not add a second canonical from custom metadata layer | Dev / Tech | Accepted | W3 re-crawl canonical count |

Allowed status values: Open, In Progress, Fixed, Accepted, Deferred, Not Applicable.

## 4. Target-page on-page audit

| Target URL | Primary Intent | Current Title | Current Description | H1/H2 Issue | ALT Issue | Content/Sapo Note | Final Status |
|---|---|---|---|---|---|---|---|
| https://www.ipaenglish.com/vi/ | Local English center | IPA English – Study English in Hưng Yên | Missing in official crawl | One H1 present: `Học Viện Anh Ngữ IPA`; review H2 support | Priority images need descriptive ALT review | Add Ecopark/Văn Giang/Hưng Yên service context naturally | Open |
| https://www.ipaenglish.com/vi/global-english-for-teen-achievers/ | Teen/student English course | Global English for Teen Achievers – IPA English | Missing in official crawl | H1 missing in official crawl; add one Vietnamese H1 and review H2 support | Review course images | Strengthen 11-18, academic + daily communication, small class, British teacher evidence | Open |
| https://www.ipaenglish.com/vi/book-a-test/ | Free English placement test | Book a Test – IPA English | Missing in official crawl | H1 missing in official crawl; add one Vietnamese H1 | Review form/hero imagery | Clarify free placement test, 24h contact, Ecopark | Open |
| https://www.ipaenglish.com/vi/learning-system/ | IPA learning method | Learning System – IPA English | Missing in official crawl | H1 missing in official crawl; add one Vietnamese H1 | Review system imagery | Align copy with communication + academic learning-method queries | Open |

## 5. Re-crawl verification

| Metric / Finding | Before | After | Result | Notes |
|---|---:|---:|---|---|
| Internal 404s | 0 | | | Official W1-02 internal baseline |
| Redirect chains | 0 | | | Two external redirects observed, no chain |
| Missing Titles | 0 | | | 26 HTML title rows |
| Duplicate Titles | 26 rows / 12 groups | | | Primarily English/Vietnamese pairs; triage in W1-03 |
| Missing Meta Descriptions | 26 | | | 26/26 crawled HTML pages |
| Duplicate Meta Descriptions | 0 | | | No non-empty descriptions exist in baseline |
| Missing H1 | 18 | | | Includes Teen, Book a Test and Learning System targets |
| Images missing ALT | 12 unique / 50 inlink occurrences | | | Missing/empty ALT text; ALT attribute itself present |
| Oversized target images | 2 unique >100 kB / 4 inlink occurrences | | | Candidate set from Screaming Frog image report |
| Target URLs blocked/noindex | 0 | | | All four targets are HTTP 200, Indexable and self-canonical |

## 6. GSC / GA4 handover

| Item | Status | Evidence / Notes |
|---|---|---|
| GSC property verified | Done (owner-confirmed) | Production GSC setup/access confirmed complete on 2026-10-07 |
| Sitemap submitted | | |
| Sitemap received/processing | | |
| Target URL inspection completed where useful | | |
| GA4 production traffic received | Setup/access done; runtime verification pending | Owner-confirmed production GA4 setup is complete; verify Realtime/events in the dedicated measurement QA step |
| Target landing pages visible in GA4 | Setup/access done; runtime verification pending | Confirm target-page traffic/events during final QA |

## 7. Deferred / next actions

| Item | Reason Deferred | Recommended Next Step | Priority |
|---|---|---|---|
| Sitewide Meta Description completion outside four target pages | W1-02 found 26/26 HTML pages missing descriptions, but current delivery prioritizes four target URLs | Separate sitewide metadata pass after the four target pages are implemented and validated | Medium |
| Non-target title/localization duplicate cleanup | W1-02 found 26 duplicate-title rows / 12 groups; current scope approves four Vietnamese target-page titles only | Review remaining groups by page intent and translation ownership in a later SEO pass | Medium |
| Non-target H1 remediation | W1-02 found 18 missing H1 pages; three current target pages are handled in W2-02 | Build later page-type/template cleanup backlog | Medium |
| Full-site ALT cleanup | 12/15 unique images have missing/empty ALT text across 50 inlink occurrences; W2 prioritizes target/high-impact imagery | Batch remaining informative images after target-page ALT review | Low |
| Full image-library migration / advanced Core Web Vitals program | Outside agreed basic technical SEO scope | Treat as a separate performance/media workstream if approved | Low |

## 8. Final sign-off

- [x] Initial crawl completed.
- [x] Technical issues assigned and status updated.
- [ ] Re-crawl completed.
- [ ] GSC and sitemap verified/submitted.
- [ ] GA4 verified.
- [ ] Keyword Map finalized.
- [ ] 3-5 target URLs verified after on-page changes.
- [x] Deferred items documented.
