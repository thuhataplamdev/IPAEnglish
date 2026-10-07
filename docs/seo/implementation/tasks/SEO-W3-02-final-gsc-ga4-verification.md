# SEO-W3-02 — Final GSC + GA4 Verification

**Timing:** Week 3 — Early/Final  
**Owner:** SEO Exec  
**Priority:** High  
**Dependencies:** SEO-W2-03, SEO-W2-08
**Current status:** DONE — authenticated GSC, GA4 production reception, duplicate-page-view regression sampling, and all four target-page visibility checks are complete as of 2026-10-08.

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
- Follow-up authenticated GA4 reporting for 2026-10-07 through 2026-10-08 now identifies all four target paths:
  - `/vi/learning-system/` — 7 page views, 2 sessions, 1 active user.
  - `/vi/global-english-for-teen-achievers/` — 4 page views, 1 session, 1 active user.
  - `/vi/` — 3 page views, 1 session, 1 active user.
  - `/vi/book-a-test/` — 2 page views, 1 session, 1 active user.
- The GA4 landing-page report does not need to list all four paths because `landingPage` represents only the first page of a session; target-page acceptance is satisfied by the page-path report.

### Closure

GA4 reporting latency cleared on 2026-10-08 and all four target paths became observable in authenticated reporting. W3-02 now satisfies its immediate measurement handover acceptance criteria; indexing/ranking growth remains outside the instant handover gate.

## Definition of Done

- [x] GSC evidence captured (authenticated property + sitemap + URL Inspection + search baseline).
- [x] Refreshed authenticated GSC sitemap state captured.
- [x] GA4 Realtime/production traffic captured via current-day GA4 API evidence.
- [x] Target pages identifiable in GA4.
- [x] Audit handover section updated with final verified state.
