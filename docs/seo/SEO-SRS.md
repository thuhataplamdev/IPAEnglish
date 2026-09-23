# SEO Software Requirements Specification (SRS)

**Document ID:** IPA-SEO-SRS  
**Version:** 1.1
**Status:** Agreed delivery scope
**Date:** 2026-09-23
**System:** IPAEnglish WordPress / MasterStudy LMS  
**Related:** [SEO-TSD.md](./SEO-TSD.md)

## 1. Purpose

This SRS defines the agreed delivery scope for IPAEnglish SEO: website audit, basic technical SEO remediation, Google Search Console and GA4 setup/verification, keyword research and mapping for a maximum of 20 keywords, and on-page optimization across 3-5 priority URLs.

It does not promise ranking positions. Ranking and organic traffic depend on search demand, content quality, competition, authority, algorithmic systems, and other factors outside deterministic software control.

## 2. Goals

The engagement shall:

1. establish a crawl/indexing baseline using Screaming Frog SEO Spider and runtime inspection;
2. configure and verify Google Search Console and Google Analytics 4;
3. create or verify a valid XML sitemap and submit it to Search Console;
4. identify and document basic technical SEO defects, including 404s, redirects, robots/sitemap issues, duplicate or missing metadata, missing image ALT text, and oversized images;
5. research, approve, and map a maximum of 20 target keywords to 3-5 priority URLs/landing pages;
6. optimize Meta Title, Meta Description, H1/H2, image ALT, and existing opening/body copy on those priority URLs;
7. fix agreed basic technical issues such as 404s, 301 redirects, robots.txt, sitemap, HTTPS checks, image compression/WebP, and caching;
8. deliver a Technical SEO Document, audit report, keyword map, and before/after implementation status;
9. verify the site is measurable and crawlable after implementation.

## 3. Non-goals

This specification does not include:

- guaranteed ranking, traffic, CTR, lead, or revenue outcomes;
- paid search/ads;
- backlink acquisition campaigns;
- mass AI-generated content;
- writing complete new articles or rebuilding existing articles from scratch;
- optimization beyond the agreed maximum of 20 keywords unless separately approved;
- broad on-page optimization beyond the agreed 3-5 target URLs unless separately approved;
- social-media publishing automation;
- a full visual redesign;
- replacing MasterStudy LMS;
- replacing TranslatePress solely for SEO;
- full multilingual SEO redesign;
- advanced structured-data/schema rollout beyond fixes needed for the audited target pages;
- a site-wide Core Web Vitals engineering program;
- a large historical URL migration;
- creating `llms.txt` as a Google Search ranking requirement;
- FAQ rich-result eligibility as a launch requirement;
- ongoing content publishing, backlink outreach, or monthly SEO operations after handover.

## 4. Stakeholders and actors

| Actor | Responsibility |
|---|---|
| Product/Business owner | Confirms business priority, target services/courses, 3-5 target URLs, and final keyword direction |
| SEO Exec | Audit, Screaming Frog crawl, keyword research/mapping, GSC/GA4 setup, Technical SEO Document, and on-page optimization |
| Dev / Tech Exec | Fixes agreed technical defects: 404/301, robots/sitemap, HTTPS checks, image compression/WebP, cache/basic performance |
| Content owner | Reviews wording changes where needed and approves changes to existing page copy |
| Search crawler | Discovers and renders public crawlable resources |

## 5. Assumptions and dependencies

1. A production canonical domain will be designated.
2. Production can serve HTTPS consistently.
3. SEO Exec receives the access required for Google Search Console, GA4, WordPress Admin, and crawl verification.
4. The business owner can approve the final 20-keyword set and 3-5 priority URLs during the research week.
5. Dev / Tech Exec can change redirects, robots/sitemap configuration, image optimization, and caching where required.
6. Existing page content can be edited for metadata, headings, ALT text, and small keyword-oriented copy adjustments.
7. Full article/content rewrites are outside this engagement.
8. Screaming Frog crawl results and Search Console data are treated as primary audit inputs together with source/runtime verification.

### 5.1 Current delivery scope

**SEO Exec**

- install/verify Google Search Console and GA4;
- create/verify and submit `sitemap.xml`;
- crawl the website with Screaming Frog SEO Spider;
- record technical findings in the Technical SEO Document;
- research and finalize up to 20 keywords;
- map those keywords to 3-5 priority URLs;
- optimize Meta Title, Meta Description, H1/H2, target image ALT text, and existing opening/body copy on those URLs;
- update the audit/status document after remediation.

**Dev / Tech Exec**

- configure or correct `robots.txt` and automatic XML sitemap behavior;
- fix agreed broken links/404s and implement 301 redirects where required;
- verify HTTPS/SSL behavior;
- enable or configure automatic image compression/WebP where suitable;
- enable or tune basic caching for improved load performance;
- support technical fixes surfaced by the agreed audit where they remain within basic technical SEO scope.

### 5.2 Required handover

The engagement is accepted only when the following are handed over:

1. Technical SEO Document and Web Audit Report with issue status;
2. Keyword Map containing no more than 20 approved keywords mapped to 3-5 URLs;
3. optimized Title/Description/H1/H2/ALT/current copy for the 3-5 target URLs;
4. resolved or documented basic technical issues;
5. working Google Search Console and GA4 access/tracking;
6. sitemap submitted to Google Search Console and accepted for processing.

The broader technical requirements below remain engineering guardrails and future reference. Advanced multilingual, schema, LMS-platform, and performance work is not automatically in scope unless required to remediate a critical issue found during this engagement.

## 6. Technical reference: page-type SEO policy

The following is an engineering reference baseline, not a commitment to redesign every page type in this engagement. Only issues affecting the audited site, target URLs, sitemap/robots behavior, or agreed technical backlog are mandatory in the current scope.

| Page type | Index | Follow | Sitemap | Canonical | Primary schema |
|---|---:|---:|---:|---|---|
| Home | Yes | Yes | Yes | Self | Organization + WebSite |
| Public marketing/static page | Yes | Yes | Yes | Self | WebPage + Breadcrumb where applicable |
| Blog/article | Yes | Yes | Yes | Self | Article/BlogPosting + Breadcrumb |
| Curated blog/category hub | Conditional | Yes | If indexable | Self | CollectionPage/Breadcrumb |
| Tag/date archive | Default No | Yes | No | Self or no canonical policy per implementation | None required |
| Course detail (`stm-courses`) | Yes | Yes | Yes | Self | Course + Breadcrumb |
| Curated course category | Conditional | Yes | If indexable | Self | ItemList + Breadcrumb |
| Public instructor profile | Conditional | Yes | If indexable | Self | ProfilePage/Person where data supports it |
| WordPress internal search | No | Yes | No | Search URL or none; never canonicalize to unrelated content | None |
| Filter/sort/faceted URL | No by default | Yes | No | Clean parent listing URL when content-equivalent | None |
| Login/register/password-reset | No | No/Yes as operationally needed | No | Self | None |
| Account/LMS dashboard | No | No | No | Self | None |
| Lesson (`stm-lessons`) | No | No | No | Self | None |
| Quiz/question/review/order | No | No | No | Self | None |
| Checkout/payment/order confirmation | No | No | No | Self | None |
| 404/410 | No | N/A | No | None | None |
| Preview/draft | No | No | No | None | None |

“Conditional” means the page is indexable only when it has a clear search purpose, unique useful content, and enough inventory/content to avoid thin pages.

## 7. Technical reference requirements and current engagement requirements

SEO-FR-001 through SEO-FR-030 are retained as architecture/reference guardrails from the broader SEO design. The current three-week delivery scope is defined by SEO-FR-031 through SEO-FR-036 plus any earlier requirement needed to fix a confirmed blocker on the 3-5 target URLs or basic technical SEO surfaces.


### SEO-FR-001 — Canonical scheme and host

The production site shall expose one canonical HTTPS origin.

Acceptance criteria:

- HTTP permanently redirects to HTTPS.
- All non-canonical host variants permanently redirect to the chosen canonical host.
- Redirects avoid multi-hop chains under normal requests.
- Generated canonical, sitemap, hreflang, Open Graph URL, and internal absolute URLs use the canonical origin.

### SEO-FR-002 — Unique title

Every indexable page shall output one useful document title.

Acceptance criteria:

- Exactly one effective HTML title exists.
- Title is descriptive and specific to the page.
- Course title identifies the course.
- Boilerplate does not overwhelm the page-specific text.
- Templates do not produce the same title for distinct indexable URLs.

### SEO-FR-003 — Meta description

Every priority/indexable landing page shall support a useful meta description.

Acceptance criteria:

- At most one meta description is emitted.
- Editor override is supported for priority pages/courses.
- A deterministic fallback can be generated from excerpt/summary when no override exists.
- Empty, duplicated, or site-wide generic descriptions are surfaced by QA.

### SEO-FR-004 — Canonical URL

Every indexable HTML page shall emit one canonical URL representing the preferred version of that page.

Acceptance criteria:

- Normal indexable pages self-canonicalize.
- Language variants self-canonicalize to the same language, not to the default-language URL.
- Tracking parameters do not create separate canonical targets.
- Pagination/faceted behavior follows an explicit policy rather than arbitrary canonicalization.
- Canonical URL returns an indexable 200 response.

### SEO-FR-005 — Robots meta

Indexability shall be controlled with page-level robots directives, not robots.txt alone.

Acceptance criteria:

- Private/account/transaction/search/lesson/quiz/question URLs are not indexable.
- Pages that must be removed from search are crawlable long enough for crawlers to observe `noindex`, unless authentication already makes them inaccessible.
- No indexable public page accidentally receives `noindex`.

### SEO-FR-006 — XML sitemap

The system shall publish XML sitemaps containing only intended canonical public URLs.

Acceptance criteria:

- Sitemap endpoint returns valid XML and 200.
- URLs are absolute, canonical, and use HTTPS/canonical host.
- Sitemap excludes noindex, private, redirecting, error, search, account, lesson, quiz, question, order, and preview URLs.
- Public course detail pages are included.
- Last-modified values are accurate when emitted.
- Sitemap is referenced in robots.txt and submitted to Search Console.

### SEO-FR-007 — robots.txt

The site shall provide a crawl-control robots.txt appropriate for WordPress.

Acceptance criteria:

- Important CSS/JS/image resources required for rendering are not globally blocked.
- WordPress admin/private utility crawling is limited where appropriate.
- The sitemap location is discoverable.
- robots.txt is not used as a substitute for noindex.

### SEO-FR-008 — Course landing-page indexability

Published public `stm-courses` pages shall be eligible for indexing when they satisfy content-quality requirements.

Acceptance criteria:

- Published course page is publicly reachable without authentication.
- Page returns 200 and is not noindex.
- Course has unique title, meaningful description, visible learning/value information, and a canonical URL.
- Course is linked from at least one crawlable hub/listing.
- Course appears in the public sitemap.

### SEO-FR-009 — Private LMS exclusion

Private learning and transactional content shall not enter search indexes.

Acceptance criteria:

- Lessons, quizzes, questions, orders, dashboards, and transaction-confirmation pages are excluded from sitemap.
- If publicly reachable by URL, they emit noindex according to policy.
- Authentication/authorization responses do not expose private learner data to crawlers.

### SEO-FR-010 — Taxonomy quality gate

Taxonomy/archive pages shall be indexable only when they provide useful search landing-page value.

Acceptance criteria:

- Thin/empty/unmanaged taxonomy pages default to noindex and sitemap exclusion.
- Indexable course categories have unique heading/introduction and useful course inventory.
- Pagination behavior is crawlable and does not create duplicate metadata.

### SEO-FR-011 — Multilingual URL separation

Each indexed language version shall have a distinct crawlable URL.

Acceptance criteria:

- Content language is visible in rendered main content.
- Language switching creates stable URLs, not cookie-only alternate content.
- Search crawlers can fetch each intended language without requiring interaction.

### SEO-FR-012 — hreflang

Language variants shall publish reciprocal hreflang annotations.

Acceptance criteria:

- Every language page includes itself and all equivalent published alternates.
- Hreflang language/region codes are valid.
- Alternate URLs return 200 and are canonical in their own language.
- Optional `x-default` points to the designated fallback selector/default page.
- Hreflang is omitted for pages with no valid alternate instead of fabricating URLs.

### SEO-FR-013 — Language-specific canonical

Canonicalization shall not collapse valid translations into one language.

Acceptance criteria:

- Vietnamese URL canonicals to Vietnamese URL, English to English URL, etc.
- A translated page is not canonically pointed to the default language merely because content originates there.

### SEO-FR-014 — Translated SEO fields and slugs

If translated pages are intended to rank independently, the system shall support translated search-facing metadata and, when required by the content strategy, translated slugs.

Acceptance criteria:

- Title and description can match the target language.
- Slug behavior is documented and stable.
- The implementation uses either a verified TranslatePress SEO Pack capability or a custom version-controlled equivalent; free TranslatePress capability must not be assumed beyond what is verified.
- URL changes include redirect mappings.

### SEO-FR-015 — Site/entity structured data

The site shall publish one coherent structured-data graph for site/business identity.

Acceptance criteria:

- Organization/WebSite data reflects real visible business information.
- URLs, names, logos, and social identifiers are accurate.
- Duplicate conflicting Organization/WebSite nodes are not emitted by multiple owners.

### SEO-FR-016 — Course structured data

Eligible course pages and course lists shall implement Google-supported Course structured data.

Acceptance criteria:

- Course schema reflects visible course data.
- Course list/hub markup uses ItemList where applicable.
- List items use unique course URLs and deterministic positions.
- At least three valid courses exist before treating a list as Course-list rich-result eligible.
- Required/recommended fields are validated against current Google documentation before release.

### SEO-FR-017 — Breadcrumb structured data

Indexable hierarchical pages shall expose breadcrumb structured data consistent with visible navigation.

Acceptance criteria:

- Breadcrumb order and URLs match the logical hierarchy.
- The current page and ancestors use canonical URLs.
- Structured-data breadcrumb does not describe a hierarchy hidden from users.

### SEO-FR-018 — Article structured data

Editorial article/blog templates shall support Article or BlogPosting structured data.

Acceptance criteria:

- Headline, author, dates, image, and publisher values match visible/page metadata.
- Modified date changes only for meaningful editorial updates.
- Author is a real attributable person/entity when supplied.

### SEO-FR-019 — Instructor profile semantics

Public instructor profiles may be indexed only when they provide meaningful standalone content.

Acceptance criteria:

- Profile contains unique biography/expertise and relevant public courses.
- Thin auto-generated user archives remain noindex.
- If ProfilePage/Person schema is used, it matches visible information.

### SEO-FR-020 — Crawlable internal links

Important public content shall be discoverable through standard HTML links.

Acceptance criteria:

- Primary navigation and content hubs use crawlable anchor elements with href.
- Course/category/article relationships use contextual links.
- Orphan priority pages are identified in audit.

### SEO-FR-021 — Image SEO

Priority content shall expose useful images without harming performance.

Acceptance criteria:

- Meaningful images have descriptive alt text; decorative images use empty alt where appropriate.
- Width/height or aspect-ratio prevents avoidable layout shifts.
- Hero/LCP image is not unintentionally lazy-loaded.
- Indexable pages expose representative social/search images where supported.

### SEO-FR-022 — Redirects, deleted content, and 404

URL lifecycle shall preserve user and crawler signals.

Acceptance criteria:

- Permanent URL moves use one-hop 301/308 to the closest relevant replacement.
- Deleted content with no replacement returns 404 or 410.
- Soft 404s are avoided.
- Redirect loops/chains are release blockers for priority URLs.

### SEO-FR-023 — Query-parameter policy

Tracking, sorting, filtering, and functional parameters shall not create uncontrolled indexable duplicates.

Acceptance criteria:

- Known tracking parameters do not change canonical identity.
- Filter/sort URLs default to noindex unless explicitly promoted as landing pages.
- Cache behavior and canonical behavior agree on URL identity.
- Functional parameters that materially change content are reviewed before canonical stripping.

### SEO-FR-024 — Social metadata

Indexable priority pages shall provide deterministic Open Graph and Twitter/X-compatible metadata.

Acceptance criteria:

- URL, title, description, and image align with canonical page metadata.
- Course shares show course-specific content.
- Language variants use language-appropriate text/image when configured.

### SEO-FR-025 — Search Console

The canonical production property shall be verifiable and monitored in Google Search Console.

Acceptance criteria:

- Ownership is documented.
- Sitemap is submitted.
- Indexing, enhancement/structured-data, Core Web Vitals, and security/manual-action reports are reviewed.
- URL Inspection is part of release verification for representative templates.

### SEO-FR-026 — Analytics and organic conversion measurement

The system shall support measuring organic-search outcomes without exposing learner secrets.

Minimum recommended events:

- landing-page/session attribution;
- course view;
- primary CTA;
- lead/contact submit;
- enrollment/begin-checkout if applicable;
- purchase/enrollment completion if applicable.

Acceptance criteria:

- Event names and conversion definitions are documented.
- No password, lesson answer, payment secret, or sensitive private learner content is sent as analytics payload.
- Search Console and analytics can be joined conceptually by landing page/date, without requiring personal identity.

### SEO-FR-027 — Editor-controlled SEO override

Priority public pages/courses shall allow controlled overrides for at least SEO title and description.

Acceptance criteria:

- Override has documented precedence over generated default.
- Clearing an override restores the deterministic fallback.
- Robots/canonical overrides, if exposed to editors, require guardrails to prevent accidental sitewide deindexing/canonicalization.

### SEO-FR-028 — Single SEO output owner

The runtime shall not emit duplicate/conflicting SEO primitives.

Acceptance criteria:

- One canonical tag.
- One robots policy result.
- One effective title.
- No conflicting schema graphs for the same entity.
- Enabling a third-party SEO plugin requires disabling overlapping custom renderers.

### SEO-FR-029 — AI search compatibility

The system shall optimize for search-engine AI features through the same crawlability, indexability, content-quality, structured-data, and performance foundations.

Acceptance criteria:

- No special `llms.txt` dependency is required for Google Search/AI eligibility.
- Important content is rendered in crawlable HTML and is internally linked.
- Content remains people-first and source-attributable.

### SEO-FR-030 — SEO pre-release audit

No SEO implementation is considered production-ready until the runtime baseline is captured.

Required baseline evidence:

- canonical production URL/host;
- rendered head tags for representative page types;
- robots.txt and sitemap;
- status/redirect matrix;
- language/hreflang matrix;
- crawl sample;
- Search Console index/performance baseline;
- Core Web Vitals/Lighthouse baseline;
- active plugin/settings inventory.

### SEO-FR-031 — Screaming Frog website audit

The SEO Exec shall crawl the accessible public website using Screaming Frog SEO Spider and record actionable findings.

Acceptance criteria:

- crawl covers the public site reachable from the selected starting URL and sitemap where available;
- findings include at minimum 4xx/404 URLs, redirect chains, duplicate/missing titles, duplicate/missing descriptions, missing H1, missing image ALT, oversized images, canonical/indexability anomalies, and sitemap/robots observations where detectable;
- findings are transferred into the Technical SEO Document with status and owner;
- false positives or non-actionable findings are explicitly marked rather than treated as defects.

### SEO-FR-032 — Google Search Console and GA4 setup

Google Search Console and GA4 shall be installed, connected, or verified as operational for the production website.

Acceptance criteria:

- Search Console property access is confirmed;
- sitemap is submitted to Search Console;
- GA4 receives production page-view data;
- tracking does not expose private learner/order data;
- setup status and access owner are recorded in the handover.

### SEO-FR-033 — Maximum 20-keyword research and map

The SEO Exec shall prepare and finalize a keyword set containing no more than 20 target keywords.

Acceptance criteria:

- the set includes a practical mix of primary/short-tail and long-tail terms;
- keywords are grouped by search intent/topic rather than treated as 20 unrelated targets;
- every approved keyword is mapped to one of 3-5 priority URLs;
- one URL is not assigned mutually conflicting search intents;
- final keyword map is approved before final on-page changes.

### SEO-FR-034 — On-page optimization for 3-5 URLs

The SEO Exec shall optimize the agreed 3-5 priority URLs for the approved keyword map.

Acceptance criteria:

- Meta Title is reviewed/re-written to reflect the mapped keyword and page intent;
- Meta Description is reviewed/re-written for relevance and CTR clarity;
- H1 and relevant H2 headings are reviewed and adjusted where needed;
- target images on those pages receive meaningful ALT text where appropriate;
- opening paragraph/sapo or existing body copy may be adjusted to improve topical relevance;
- the work does not require writing a completely new article/page from scratch;
- final copy remains natural and avoids keyword stuffing.

### SEO-FR-035 — Basic technical remediation

Dev / Tech Exec shall remediate agreed basic technical SEO defects identified during audit.

Acceptance criteria:

- agreed 404/broken internal links are corrected or redirected appropriately;
- required permanent URL moves use 301 redirects without avoidable chains;
- robots.txt and sitemap behavior are valid for the production site;
- HTTPS is confirmed and insecure variants do not remain as intended canonical URLs;
- basic image compression/WebP is enabled or implemented where technically appropriate;
- basic page caching is enabled/tuned without breaking authenticated/private LMS behavior;
- each audit item records final status: fixed, accepted, deferred, or not applicable.

### SEO-FR-036 — Final handover package

The final handover shall contain:

- completed Technical SEO Document / Web Audit Report;
- Screaming Frog crawl summary or export references;
- 20-keyword maximum Keyword Map;
- mapping of 3-5 target URLs with final Title and Description;
- implementation status for technical defects;
- GSC/GA4 status;
- sitemap submission status;
- open/deferred items and recommended next actions.


## 8. Content requirements

### 8.1 Public course page minimum

An indexable course page should expose, when applicable:

- unique course name;
- concise value proposition;
- who the course is for;
- learning outcomes;
- syllabus/modules overview without exposing private lesson material;
- instructor identity and expertise;
- delivery format;
- level/prerequisites;
- duration/schedule when relevant;
- price/enrollment state when relevant;
- reviews/testimonials only when genuine and policy-compliant;
- related courses/topic links;
- FAQ content if useful to learners, without relying on FAQ rich-result eligibility.

### 8.2 Editorial content

Articles should have:

- one clear primary topic/search intent;
- visible authorship;
- meaningful update dates;
- original examples/explanations;
- links to relevant course/hub pages where useful;
- descriptive headings;
- sources for factual claims where appropriate;
- no large-scale thin pages generated only to capture keyword variants.

### 8.3 Language quality

Translated content intended for indexing must be useful and readable in the target language. Machine translation may assist workflow but must not create low-quality scaled pages.

## 9. Non-functional requirements

### SEO-NFR-001 — Core Web Vitals

For key public templates, target 75th-percentile field performance:

- LCP <= 2.5 seconds;
- INP <= 200 milliseconds;
- CLS <= 0.1.

Field data is authoritative when available. Lab/Lighthouse is a diagnostic gate, not a substitute for field data.

### SEO-NFR-002 — Renderability

Critical main content, links, headings, metadata, and structured data must be available to normal search-engine rendering without login or user gestures for public pages.

### SEO-NFR-003 — Availability

Priority SEO landing pages and sitemap/robots endpoints should be stable and should not intermittently return 5xx, challenge pages, or cache corruption to legitimate crawlers.

### SEO-NFR-004 — Maintainability

SEO rules must be version-controlled or explicitly documented as runtime configuration. No undocumented Code Snippets/GUI rule may be the sole implementation of a critical canonical/indexability policy.

### SEO-NFR-005 — Compatibility

SEO changes must be tested with:

- WordPress core;
- MasterStudy theme/LMS;
- TranslatePress;
- W3 Total Cache;
- Autoptimize;
- Elementor/header-footer rendering where used.

### SEO-NFR-006 — Security/privacy

SEO and analytics outputs must never disclose private learner/order data. Structured data must use public information only.

### SEO-NFR-007 — Cache correctness

HTML cache variants must not mix languages, authentication state, or personalized/private content. Cache invalidation must update changed SEO metadata within the documented cache TTL/purge path.

## 10. KPIs and operational measures

Traffic/conversion targets require a baseline and business target, so this SRS does not invent percentage-growth goals.

Delivery KPIs:

- 100% of the 3-5 target URLs have reviewed Title, Description, H1/H2, and relevant image ALT;
- no more than 20 keywords are included in the committed keyword map;
- 100% of approved keywords are mapped to one of the agreed target URLs;
- all agreed critical/high-priority 404/redirect/robots/sitemap findings have a final status;
- no redirect loop on the target URLs;
- sitemap is valid and submitted to Search Console;
- GSC and GA4 are operational at handover;
- target URLs do not contain known duplicate/conflicting canonical/title output after remediation.

Search baseline to capture in Search Console/GA4 where data exists:

- impressions, clicks, CTR, and average position for target queries/pages;
- indexed status of target URLs;
- sitemap processing status;
- query/page baseline for the approved keyword set;
- organic landing traffic in GA4.

## 11. Release acceptance matrix

The engagement is accepted only when:

1. Screaming Frog audit has been completed and findings are documented;
2. the final keyword map contains no more than 20 keywords and maps to 3-5 target URLs;
3. the 3-5 target URLs have completed on-page optimization;
4. agreed basic technical defects are fixed or explicitly deferred with reason;
5. robots.txt and sitemap behavior are verified;
6. sitemap is submitted to Search Console;
7. Search Console and GA4 are operational;
8. HTTPS, redirects, image optimization, and cache changes are verified where applicable;
9. final Technical SEO Document records before/after status;
10. no open blocker prevents Google from crawling the target pages.

## 12. Risks

| Risk | Impact | Control |
|---|---|---|
| GSC/GA4 access is delayed | Week 1 baseline and Week 3 verification slip | Confirm access on Day 1 and record owner |
| Screaming Frog crawl is blocked or incomplete | Audit misses technical issues | Adjust crawl settings, use sitemap/internal links, document crawl limits |
| Keyword approval is delayed | On-page work cannot finalize | Approve 20-keyword maximum and 3-5 URLs in Week 1 |
| Keyword cannibalization | Multiple target URLs compete for the same intent | Use one keyword map and group terms by intent |
| Metadata changes conflict with existing SEO output | Duplicate title/description/canonical | Verify rendered HTML before and after changes |
| 301/404 fixes create redirect chains | Crawl waste and poor UX | Re-crawl redirects and flatten avoidable chains |
| Cache or optimization breaks LMS behavior | Functional regression | Test logged-out and authenticated flows after changes |
| Image compression changes visual quality | UX degradation | Use reasonable compression and review target images |
| Google processing is slower than project timeline | Sitemap/index status still pending at handover | Treat submission/verification as acceptance, not ranking/indexing completion |
| Scope expands beyond 20 keywords or 5 URLs | Timeline and effort exceed plan | Raise a separate estimate/change request |

## 13. Resolved implementation decisions

These decisions are closed for the current three-week engagement.

| # | Decision | Resolution | Evidence / operating rule |
|---:|---|---|---|
| 1 | Production canonical domain | https://www.ipaenglish.com | Apex https://ipaenglish.com redirects permanently to the www host. All target canonicals, sitemap URLs, internal absolute URLs, and GSC URL checks use www. |
| 2 | GSC and GA4 ownership | Required ownership model: an IPAEnglish business-owned Google account is Owner/Admin; SEO Exec receives the access needed to configure and verify during the engagement | Do not make a contractor/personal account the sole owner. DNS verification is coordinated with the business/ops owner. Current public runtime does not prove GSC access and no executable GA4 tag is currently verified, so both are Week 1 setup/verification tasks. |
| 3 | Commercial priority URLs | Four Vietnamese landing pages: /vi/, /vi/global-english-for-teen-achievers/, /vi/book-a-test/, /vi/learning-system/ | These represent local discovery, the live teen course, conversion/placement-test intent, and the differentiated learning method. The adult course is currently not selected because the live page is still Coming soon. |
| 4 | Keyword set | The 20-keyword baseline in KEYWORD-MAP.md is approved for this engagement | The set is intentionally limited to local English-center, teen/student English, free placement-test, and learning-method intent. Week 1 GSC research may reorder priority, but adding keywords above 20 requires scope change. |
| 5 | Language/version in scope | Vietnamese /vi/ versions of the four target URLs | English equivalents remain technically crawlable and must not be broken, but English copy optimization is outside the 20-keyword on-page allocation. |
| 6 | Title/Description owner | Keep WordPress core as title/canonical owner; add one thin version-controlled IPAEnglish metadata layer for the 4 target URLs; do not add a full SEO plugin for this scope | Live output already has WordPress titles and one canonical, but no Meta Description was detected on sampled target pages. The custom layer may override title via WordPress title filters and emit one description, while core canonical remains the sole canonical emitter. |
| 7 | Sitemap owner | WordPress core native sitemap | robots.txt already points to /wp-sitemap.xml. The endpoint currently returns sitemap XML with HTTP 404, which is a P1 technical defect: fix it to return 200. Do not introduce a second plugin sitemap. |
| 8 | 404/redirect rule | Use direct-link correction by default; use 301 only for a real moved/replaced public URL with a clear 1:1 successor | Do not blanket-redirect 404s to Home. Broken internal links to existing pages are fixed at source. Removed URLs with no relevant replacement remain 404/410. Redirect chains must be flattened. |
| 9 | WebP/image compression | Treat WebP as not active and implement it as an in-scope technical fix | A sampled production JPG still returns image/jpeg even when the client advertises WebP support, and no dedicated image/WebP plugin is tracked. Reuse a safe existing/hosting capability if available; otherwise add one controlled image-optimization path. |
| 10 | Cache ownership | W3 Total Cache owns page/browser/cache behavior; Autoptimize owns CSS/JS asset optimization only; Caddy/hosting must not duplicate those transformations unless explicitly configured | Production HTML contains W3 Total Cache's served-page marker and Autoptimize asset URLs. Keep responsibilities separated to avoid overlapping page cache/minification behavior. |

### 13.1 Approved target URLs

1. https://www.ipaenglish.com/vi/
2. https://www.ipaenglish.com/vi/global-english-for-teen-achievers/
3. https://www.ipaenglish.com/vi/book-a-test/
4. https://www.ipaenglish.com/vi/learning-system/

### 13.2 Decision change control

Any change to canonical host, language scope, sitemap owner, cache ownership, the four target URLs, or the 20-keyword cap must be recorded as a scope/technical decision change before implementation.
