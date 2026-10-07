# SEO-W3-02 Evidence — Final GSC + GA4 Verification

Date: 2026-10-07

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
- The user opened all four target URLs for QA. Immediate current-day landing-page/page reports still contain only `/`; exact `pagePath` queries for all four target paths currently return 0, indicating the QA visits have not yet propagated into GA4 reporting.

## Pending before W3-02 can be Done

- Re-query GA4 after processing latency and capture all four target paths once they appear in authenticated reporting.

Search Console and GA4 reception are authenticated. QA visits to all four target pages have been completed; the only remaining acceptance gap is GA4 reporting latency for those paths.
