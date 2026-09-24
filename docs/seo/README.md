# IPAEnglish SEO Documentation

**Audit date:** 2026-09-22  
**Repository:** thuhataplamdev/IPAEnglish  
**Current delivery scope:** Web audit + basic technical SEO + Google Search Console/GA4 setup + on-page optimization for a maximum of 20 keywords across 3-5 priority URLs.

This directory contains the source-grounded SEO specification for IPAEnglish. The current engagement is intentionally narrower than a full SEO-platform redesign: one research/audit week followed by two execution weeks. Screaming Frog SEO Spider is the primary crawl/audit tool; Google Search Console and GA4 are the primary measurement/setup tools.

## Documents

- [SEO-SRS.md](./SEO-SRS.md) — Software Requirements Specification for the agreed audit, technical SEO, GSC/GA4, 20-keyword mapping, and 3-5 URL on-page scope.
- [SEO-TSD.md](./SEO-TSD.md) — Technical execution design and implementation guardrails for crawl/audit, basic technical fixes, tracking, on-page changes, validation, and handover.
- [SEO-ESTIMATE.md](./SEO-ESTIMATE.md) — Three-week delivery plan: one research/audit week plus two implementation/handover weeks.
- [TECHNICAL-SEO-AUDIT.md](./TECHNICAL-SEO-AUDIT.md) — Working/handover template for Screaming Frog findings, technical owner, fix status, and verification evidence.
- [KEYWORD-MAP.md](./KEYWORD-MAP.md) — Working/handover template for the maximum 20-keyword set mapped to 3-5 priority URLs with final on-page metadata.

## 1. Source-verified current state

| Area | Verified finding | Source |
|---|---|---|
| Platform | WordPress 7.1 | `wp-includes/version.php` |
| Theme | MasterStudy 4.8.68 | `wp-content/themes/masterstudy/style.css` |
| Child theme | MasterStudy Child 3.0; only enqueues child stylesheet in tracked PHP | `wp-content/themes/masterstudy-child/functions.php` |
| LMS | MasterStudy LMS 3.7.48 | `wp-content/plugins/masterstudy-lms-learning-management-system/masterstudy-lms-learning-management-system.php` |
| Course content type | `stm-courses` is public and publicly queryable; excluded-from-search is false | `_core/includes/post_type/posts.php` |
| Lesson content type | `stm-lessons` is excluded from search and only becomes queryable for privileged/current-author contexts | same file |
| Quiz/question/review/order | Not public/search-index content types | same file |
| Course taxonomy | `stm_lms_course_taxonomy` is hierarchical and has a configurable rewrite slug | `_core/includes/post_type/taxonomies.php` |
| Multilingual | TranslatePress 3.3.4 is present | `wp-content/plugins/translatepress-multilingual/index.php` |
| hreflang capability | TranslatePress code emits alternate hreflang tags and supports optional `x-default` | `includes/class-url-converter.php` |
| Translated SEO capability | TranslatePress free code references the premium SEO Pack for translated slugs and SEO/sitemap integrations; no separate SEO Pack plugin directory is tracked | TranslatePress source + plugin inventory |
| Dedicated SEO plugin | No tracked AIOSEO, Yoast, Rank Math, or SEOPress plugin directory was found | `wp-content/plugins/` inventory |
| WordPress title support | MasterStudy enables `title-tag`; header calls `wp_head()` | `inc/setup.php`, `header.php` |
| Custom SEO overrides | No custom canonical/robots/sitemap layer was found in child theme or MU plugin source | tracked child theme/MU plugin source |
| Sitemap capability | WordPress core sitemap implementation is present; no tracked custom code was found disabling it | `wp-includes/sitemaps/` + custom-code scan |
| HTTPS | Apache rules force HTTP to HTTPS with 301 | `.htaccess` |
| Canonical host normalization | HTTPS is enforced, but the tracked rule preserves the incoming host; no source-level www/non-www normalization was verified | `.htaccess` |
| Cache/performance | W3 Total Cache 2.10.6 and Autoptimize 3.1.15.1 are present; W3TC browser/page-cache directives are tracked | plugin headers + `.htaccess` |

### Important clarification

License inventory files mention some historical plugins, including SEO/analytics packages, but those license records do **not** prove the plugins are present or active. This specification uses the tracked plugin directories and source behavior as the source-level truth.

## 2. Runtime facts not available in this repository

The following must be collected in a production/staging audit before SEO release:

- production base URL and chosen canonical host;
- active theme and active plugin list;
- WordPress `home`, `siteurl`, permalink, reading, and search-engine-visibility settings;
- actual course/page/post/taxonomy inventory and publishing state;
- actual TranslatePress languages, URL mode, and `x-default` settings;
- whether a premium TranslatePress SEO Pack is active outside tracked source;
- generated HTML for title, description, canonical, robots, Open Graph, Twitter cards, and hreflang;
- live `robots.txt`, `wp-sitemap.xml` or alternative sitemap endpoint;
- redirect chains, status codes, soft-404 behavior, duplicate URLs, query-parameter behavior;
- Google Search Console ownership, indexing reports, search performance, rich-result reports, and Core Web Vitals;
- GA4/analytics implementation and conversion events;
- production cache/CDN/edge configuration and field performance.

These are requirements of the Phase 0 baseline audit in the SRS/TSD, not assumptions.

## 3. Current SEO architecture assessment

The repository has enough existing WordPress capability to complete the current engagement without building a separate SEO platform.

Existing useful capabilities:

1. WordPress already provides page titles, canonical output, robots APIs, and the native sitemap framework.
2. MasterStudy/Elementor already provide the visible landing-page content.
3. TranslatePress already handles the current English/Vietnamese language routing and should be left unchanged.
4. W3 Total Cache and Autoptimize already provide the current caching/front-end optimization foundation.
5. HTTPS redirection and the production www host are already active.

Primary gaps to close for this engagement:

1. Audit the live site with Screaming Frog and record actionable issues.
2. Fix the native WordPress sitemap endpoint so it returns HTTP 200.
3. Configure/verify GSC and GA4 using business-owned accounts.
4. Optimize the approved 20 keywords across the four Vietnamese target URLs.
5. Use the existing WordPress editing model for Title and Meta Description data; do not build a separate SEO override system.
6. Fix agreed 404/301, robots, image/WebP, and cache/basic-speed issues.
7. Re-crawl and hand over final issue status and keyword mapping.

## 4. Current-scope implementation principle

Use existing WordPress capabilities first and add only the smallest integration required.

Current ownership:

- Title: existing WordPress page/site title behavior.
- Meta Description source: WordPress-native Excerpt/summary.
- Meta Description output: one minimal child-theme renderer.
- Canonical: WordPress core.
- Sitemap: WordPress core native sitemap.
- Language routing: existing TranslatePress configuration; regression check only.
- Page/browser cache: W3 Total Cache.
- CSS/JS optimization: Autoptimize.
- Search monitoring: Google Search Console.
- Analytics: GA4.

Hreflang redesign, translated slugs, schema/structured data, social metadata, and a new SEO override platform are explicitly outside the current scope.

## 5. Search-engine guidance used for this scope

The current work follows the relevant foundational guidance only:

- useful, descriptive titles and snippets;
- canonicalization and crawl/index controls;
- XML sitemap correctness;
- crawlable internal links and valid status codes;
- image ALT and basic performance hygiene;
- Search Console monitoring;
- people-first on-page content.

Advanced structured-data and multilingual SEO guidance may be referenced in future work but is not part of this engagement.

## 6. Official references

- Google Search Essentials: https://developers.google.com/search/docs/essentials
- Title links: https://developers.google.com/search/docs/appearance/title-link
- Snippets/meta descriptions: https://developers.google.com/search/docs/appearance/snippet
- Canonicalization: https://developers.google.com/search/docs/crawling-indexing/canonicalization
- Robots.txt: https://developers.google.com/search/docs/crawling-indexing/robots/intro
- Sitemaps: https://developers.google.com/search/docs/crawling-indexing/sitemaps/build-sitemap
- AI features and website guidance: https://developers.google.com/search/docs/appearance/ai-features
- AI optimization guidance: https://developers.google.com/search/docs/fundamentals/ai-optimization-guide
- Web Vitals: https://web.dev/articles/vitals

## 7. Document governance

When SEO behavior changes, update both the requirement and design documents in the same change:

1. SRS requirement/acceptance criteria;
2. TSD component or policy;
3. test/verification impact;
4. migration/rollback impact if public URLs or indexability change.

Do not change canonical URLs, public course slugs, language URL structure, or indexability as an incidental refactor. Those changes require an explicit SEO migration plan.
