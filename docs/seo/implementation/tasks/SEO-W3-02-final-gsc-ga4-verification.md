# SEO-W3-02 — Final GSC + GA4 Verification

**Timing:** Week 3 — Early/Final  
**Owner:** SEO Exec  
**Priority:** High  
**Dependencies:** SEO-W2-03, SEO-W2-08
**Current status:** IN_PROGRESS — authenticated GSC and GA4 production reception are verified. The user opened all four target URLs for QA, but the GA4 reporting API has not processed those paths yet; target-page visibility remains the final acceptance item.

## Objective

Chứng minh search/analytics measurement surfaces hoạt động ở thời điểm bàn giao.

## GSC checks

- Correct property access.
- Sitemap submitted.
- Sitemap status received/processing/success as actually shown.
- URL Inspection for target URLs where useful.
- No manual action/security blocker observed if user has access.
- Capture available target-page/query baseline.

## GA4 checks

- Realtime production traffic.
- Target landing pages visible.
- No duplicate page_view.
- Reporting identity matches production host.

## Important acceptance rule

Google indexing/ranking growth **không** phải điều kiện bàn giao tức thời. Task được Done khi configuration, submission, crawlability và available evidence đã xác minh.

## Current verification — 2026-10-07

### Verified — public/runtime and authenticated GSC

- Production sitemap remains HTTP 200 with `application/xml`, parses successfully, and currently exposes four public child sitemaps.
- GSC Wizard authenticated property access is confirmed for `https://www.ipaenglish.com/` and `sc-domain:ipaenglish.com`.
- `https://www.ipaenglish.com/wp-sitemap.xml` is submitted in GSC, `isPending=false`, was downloaded by Google on 2026-10-07, and reports 0 warnings / 0 errors.
- GSC reports 44 submitted sitemap URLs and currently 0 indexed through the sitemap report; indexing count is not an immediate handover gate.
- URL Inspection was run on all four target URLs: all four returned `PASS`, `Submitted and indexed`, `robots_txt_state=ALLOWED`, `indexing_state=INDEXING_ALLOWED`, and `page_fetch_state=SUCCESSFUL`.
- Search performance baseline through settled date 2026-10-04 currently reports 0 clicks / 0 impressions and no top-page rows for this URL-prefix property; this is recorded as an available baseline rather than treated as an error.
- All four target pages return HTTP 200 and expose exactly one Google tag loader and one `gtag("config", ...)` call through Google Site Kit.
- The public pages use Google tag `GT-NB9W8HJ3`; no GTM container loader was observed and no second config owner was detected in sampled HTML.
- The Google tag config does not set `send_page_view: false`; no explicit duplicate `page_view` call is emitted by the inline Site Kit bootstrap.

### Verified — authenticated GA4

- GSC Wizard now links `https://www.ipaenglish.com/` to GA4 property `IPAEnglish` (`properties/557611190`).
- GA4 current-day report for 2026-10-07 shows 7 sessions and 7 active users.
- Current-day event report shows exactly 7 `session_start`, 7 `first_visit`, and 7 `page_view` events across 7 users. This sampled ratio shows no duplicate `page_view` signal in the currently observed traffic.
- Public Google tag `GT-NB9W8HJ3` resolves to GA4 destination `G-M1DEWC95TY`.
- After the user opened all four target URLs for QA, immediate GA4 page/landing-page reports still contain only `/` with 7 sessions / 7 page views. Exact `pagePath` checks for `/vi/`, `/vi/global-english-for-teen-achievers/`, `/vi/book-a-test/`, and `/vi/learning-system/` currently return 0, consistent with GA4 reporting latency rather than a connectivity failure.

### Remaining acceptance item

- Re-query GA4 after reporting latency and capture the four target paths once they become available.

Do not promote this task to `DONE` until the four target URLs are observable in GA4. The browser visits have already been performed; the remaining blocker is GA4 report processing latency, not GA4 connectivity or missing QA traffic.

## Definition of Done

- [x] GSC evidence captured (authenticated property + sitemap + URL Inspection + search baseline).
- [x] Refreshed authenticated GSC sitemap state captured.
- [x] GA4 Realtime/production traffic captured via current-day GA4 API evidence.
- [ ] Target pages identifiable in GA4.
- [x] Audit handover section updated with current verified/pending state.
