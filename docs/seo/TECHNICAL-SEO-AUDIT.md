# IPAEnglish Technical SEO Audit

**Status:** Working / handover template  
**Primary audit tool:** Screaming Frog SEO Spider  
**Measurement:** Google Search Console + GA4

## 1. Audit metadata

| Field | Value |
|---|---|
| Audit date | 2026-09-23 live baseline; W1-01 access/measurement baseline completed 2026-10-07 |
| Production URL | https://www.ipaenglish.com/ |
| Canonical host | https://www.ipaenglish.com |
| Screaming Frog version | |
| Crawl mode | Spider / List / Sitemap-assisted |
| Crawl start URL | https://www.ipaenglish.com/ |
| Sitemap URL | https://www.ipaenglish.com/wp-sitemap.xml |
| Total URLs crawled | |
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

**W1-01 execution status:** `DONE`. Public runtime baseline is captured and the remaining private surfaces were owner-confirmed on 2026-10-07. No credentials, verification tokens, or server secrets are recorded in this repository. SEO-W1-02 is the next execution task.

## 2. Baseline checks

| Check | Baseline | Owner | Status | Evidence / Notes |
|---|---|---|---|---|
| HTTPS active | Yes | Dev / Tech | Accepted | Production serves HTTPS |
| Canonical host behavior | Apex -> www 301 | Dev / Tech | Accepted | https://ipaenglish.com/ redirects to https://www.ipaenglish.com/ |
| robots.txt reachable | Yes | Dev / Tech | Accepted | Returns 200 and references /wp-sitemap.xml |
| XML sitemap reachable | Body present but wrong HTTP status | Dev / Tech | Open | /wp-sitemap.xml returns XML with HTTP 404; must return 200 |
| Sitemap submitted to GSC | Not verified | SEO | Open | Submit only after sitemap endpoint returns 200 |
| GSC property verified | Owner-confirmed | SEO | Accepted | Production GSC setup/access confirmed complete on 2026-10-07; sitemap submission remains dependent on TECH-001 |
| GA4 receiving traffic | Owner-confirmed setup; runtime QA pending | SEO | Open | GA4 setup/access is confirmed complete; runtime/event verification remains tracked separately and should not rely on the pre-setup 2026-10-06 HTML sample |
| Image WebP/compression active | No active WebP delivery detected | Dev / Tech | Open | Sample JPG returns image/jpeg even with WebP Accept header |
| Cache active | Yes | Dev / Tech | Accepted | W3 Total Cache page marker present; Autoptimize serves optimized CSS/JS assets |

## 3. Screaming Frog findings

Use one row per actionable issue or issue group.

| ID | Category | Severity | URL / Pattern | Finding | Recommended Action | Owner | Status | Verification |
|---|---|---|---|---|---|---|---|---|
| TECH-001 | Sitemap status | High | /wp-sitemap.xml | Native sitemap returns XML body with HTTP 404 | Fix routing/status so the native sitemap returns HTTP 200; keep WordPress core as sole sitemap owner | Dev / Tech | Open | Recheck HTTP status and XML after fix |
| TECH-002 | Meta Description | Medium | 4 target Vietnamese URLs | No Meta Description detected in sampled live HTML | Add one version-controlled description output/override per target URL | SEO + Dev / Tech | Open | Re-crawl and inspect rendered head |
| TECH-003 | Title/localization | Medium | Vietnamese target URLs | Sampled /vi/ pages still use generic English document titles such as Book a Test - IPA English and Learning System - IPA English | Add controlled Vietnamese title overrides for the target pages | SEO + Dev / Tech | Open | Re-crawl title report |
| TECH-004 | GA4 | High | Sitewide | GA4 execution tag not verified in sampled live HTML | Configure/verify business-owned GA4 property and production tag | SEO | Open | Realtime/DebugView + rendered HTML/network check |
| TECH-005 | Image delivery | Medium | Sitewide / target pages | No active WebP delivery detected on sampled JPG | Enable one image compression/WebP path and verify quality | Dev / Tech | Open | Request same image with WebP-capable client |
| TECH-006 | H1 | Medium | /vi/book-a-test/, /vi/learning-system/ | Public rendering shows section-level heading first; dedicated H1 should be confirmed by crawl | Add/fix one descriptive H1 if Screaming Frog confirms missing H1 | SEO | Open | Screaming Frog H1 report |
| TECH-007 | Cache ownership | Medium | Sitewide | W3 Total Cache and Autoptimize both active | W3TC = page/browser cache; Autoptimize = CSS/JS optimization only; remove overlapping transforms | Dev / Tech | In Progress | Verify page marker/assets and regression test |
| TECH-008 | 404/redirect policy | Medium | Audit findings | URL-specific list pending Screaming Frog crawl | Fix broken internal links directly; 301 only for clear 1:1 moved/replaced URLs; no blanket Home redirects | Dev / Tech | Open | Re-crawl response codes/chains |
| TECH-009 | Robots | Low | /robots.txt | Reachable and points to native sitemap | Keep current basic policy; re-verify after sitemap fix | Dev / Tech | Accepted | 200 response + sitemap directive |
| TECH-010 | Canonical | Low | 4 target URLs | One WordPress canonical detected on sampled pages | Keep WordPress core as sole canonical emitter; do not add a second canonical from custom metadata layer | Dev / Tech | Accepted | Re-crawl canonical count |

Allowed status values: Open, In Progress, Fixed, Accepted, Deferred, Not Applicable.

## 4. Target-page on-page audit

| Target URL | Primary Intent | Current Title | Current Description | H1/H2 Issue | ALT Issue | Content/Sapo Note | Final Status |
|---|---|---|---|---|---|---|---|
| https://www.ipaenglish.com/vi/ | Local English center | IPA English - Study English in Hưng Yên | Missing in sampled HTML | Local/service H1 support to review | Priority images need descriptive ALT review | Add Ecopark/Văn Giang/Hưng Yên service context naturally | Open |
| https://www.ipaenglish.com/vi/global-english-for-teen-achievers/ | Teen/student English course | Global English for Teen Achievers - IPA English | Missing in sampled HTML | Vietnamese H1 exists; H2s should support academic + communication benefits | Review course images | Strengthen 11-18, academic + daily communication, small class, British teacher evidence | Open |
| https://www.ipaenglish.com/vi/book-a-test/ | Free English placement test | Book a Test - IPA English | Missing in sampled HTML | Confirm/add one Vietnamese H1 | Review form/hero imagery | Clarify free placement test, 24h contact, Ecopark | Open |
| https://www.ipaenglish.com/vi/learning-system/ | IPA learning method | Learning System - IPA English | Missing in sampled HTML | Confirm/add one Vietnamese H1 | Review system imagery | Align copy with communication + academic learning-method queries | Open |

## 5. Re-crawl verification

| Metric / Finding | Before | After | Result | Notes |
|---|---:|---:|---|---|
| Internal 404s | | | | |
| Redirect chains | | | | |
| Missing Titles | | | | |
| Duplicate Titles | | | | |
| Missing Meta Descriptions | | | | |
| Duplicate Meta Descriptions | | | | |
| Missing H1 | | | | |
| Images missing ALT | | | | |
| Oversized target images | | | | |
| Target URLs blocked/noindex | | | | |

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
| | | | |

## 8. Final sign-off

- [ ] Initial crawl completed.
- [ ] Technical issues assigned and status updated.
- [ ] Re-crawl completed.
- [ ] GSC and sitemap verified/submitted.
- [ ] GA4 verified.
- [ ] Keyword Map finalized.
- [ ] 3-5 target URLs verified after on-page changes.
- [ ] Deferred items documented.