# SEO-W3-02 Evidence — Final GSC + GA4 Verification

Closure date: 2026-10-08

## Verified

- `/wp-sitemap.xml` remains HTTP 200, `application/xml`, parseable, with four public child sitemaps.
- Authenticated GSC Wizard access sees both the URL-prefix and domain properties.
- GSC sitemap state: `isPending=false`, last downloaded 2026-10-07, 0 warnings, 0 errors, 44 submitted URLs and 0 indexed URLs currently reported by the sitemap report.
- 4/4 target URLs were inspected through the Google URL Inspection API and all returned `PASS`, `Submitted and indexed`, robots allowed, indexing allowed and successful page fetch.
- GSC performance baseline through settled date 2026-10-04 is currently 0 clicks / 0 impressions with no top-page rows.
- All four target pages return HTTP 200.
- Each target page exposes exactly one Google Site Kit `gtag.js` loader and one Google-tag config call.
- Public tag owner observed: `GT-NB9W8HJ3`.
- No GTM container loader and no second Google-tag config owner were found in the sampled target-page HTML.
- The inline Site Kit bootstrap contains no explicit `page_view` event call and does not disable automatic page-view sending.

## Authenticated GA4 verification

- Site mapping is active: `https://www.ipaenglish.com/` → `IPAEnglish` (`properties/557611190`).
- Current-day GA4 overview for 2026-10-07: 7 sessions, 7 active users.
- Current-day GA4 events: 7 `session_start`, 7 `first_visit`, 7 `page_view`.
- Current sample therefore shows one `page_view` per session/user and no duplicate-page-view signal.
- Public Google tag `GT-NB9W8HJ3` resolves to destination `G-M1DEWC95TY`.
- After reporting latency cleared, authenticated GA4 page reporting for 2026-10-07 through 2026-10-08 shows all four target paths:
  - `/vi/learning-system/` — 7 page views, 2 sessions, 1 active user.
  - `/vi/global-english-for-teen-achievers/` — 4 page views, 1 session, 1 active user.
  - `/vi/` — 3 page views, 1 session, 1 active user.
  - `/vi/book-a-test/` — 2 page views, 1 session, 1 active user.
- The landing-page breakdown is not expected to list every traversed target page because GA4 `landingPage` is session-entry scoped; page-path visibility is the relevant acceptance evidence here.

## Closure

Search Console and GA4 handover evidence are now complete for W3-02. The four target paths are visible in authenticated GA4 reporting, so the task is `DONE` as of 2026-10-08.
