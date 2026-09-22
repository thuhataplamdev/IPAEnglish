# SEO Software Requirements Specification (SRS)

**Document ID:** IPA-SEO-SRS  
**Version:** 1.0  
**Status:** Proposed baseline  
**Date:** 2026-09-22  
**System:** IPAEnglish WordPress / MasterStudy LMS  
**Related:** [SEO-TSD.md](./SEO-TSD.md)

## 1. Purpose

This SRS defines the software behavior required for IPAEnglish to be crawlable, indexable, understandable, performant, measurable, and maintainable for organic search.

It does not promise ranking positions. Ranking and organic traffic depend on search demand, content quality, competition, authority, algorithmic systems, and other factors outside deterministic software control.

## 2. Goals

The SEO platform shall:

1. expose only useful public content to search engines;
2. make every indexable URL declare consistent title, description, canonical, robots, language, and structured-data signals;
3. make public courses first-class organic landing pages;
4. prevent private LMS, transactional, account, and low-value utility pages from polluting the index;
5. support multilingual discovery without duplicate-language URL ambiguity;
6. provide structured data that reflects visible page content;
7. maintain good user experience and Core Web Vitals;
8. give content/SEO operators controlled metadata overrides;
9. provide measurable release and operational checks;
10. preserve SEO equity during URL/content migrations.

## 3. Non-goals

This specification does not include:

- guaranteed ranking, traffic, CTR, lead, or revenue outcomes;
- paid search/ads;
- backlink acquisition campaigns;
- mass AI-generated content;
- social-media publishing automation;
- a full visual redesign;
- replacing MasterStudy LMS;
- replacing TranslatePress solely for SEO;
- creating `llms.txt` as a Google Search ranking requirement;
- FAQ rich-result eligibility as a launch requirement;
- keyword-volume or competitor numbers without a separate research dataset.

## 4. Stakeholders and actors

| Actor | Responsibility |
|---|---|
| Product/Business owner | Defines commercial pages, target markets, conversion goals |
| SEO owner | Keyword mapping, indexability policy, metadata quality, Search Console monitoring |
| Content editor | Publishes pages/posts/courses and fills required SEO/content fields |
| Instructor | Supplies accurate public course/instructor information |
| Engineer | Implements and tests technical SEO contract |
| Operations | Maintains canonical host, HTTPS, cache/CDN, uptime |
| Search crawler | Discovers and renders public crawlable resources |
| Learner | Searches, lands on public content, evaluates courses, and converts |

## 5. Assumptions and dependencies

1. A production canonical domain will be designated.
2. Production can serve HTTPS consistently.
3. Public course landing pages remain `stm-courses`.
4. TranslatePress remains the multilingual URL/hreflang system unless explicitly replaced.
5. Search Console will be verified for the canonical property/domain.
6. Analytics/conversion tracking can be configured without exposing private learner data.
7. Runtime WordPress/database settings will be audited before release.
8. Any third-party SEO plugin adopted later must obey the single-owner rule in this specification.

## 6. Page-type SEO policy

The following is the required baseline. An SEO owner may tighten individual URLs, but weakening private/utility exclusions requires review.

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

## 7. Functional requirements

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

Technical SEO KPIs:

- 100% of intended indexable templates produce one canonical and one title;
- 0 private LMS/transaction URLs in submitted sitemap;
- 0 known critical structured-data errors on supported templates;
- 0 redirect loops on priority routes;
- 0 canonical URLs pointing to non-200/noindex pages in sampled crawl;
- hreflang reciprocal validity for all indexed language pairs;
- no unexpected sitewide noindex;
- Core Web Vitals pass target on key templates when sufficient field data exists.

Search KPIs to baseline in Search Console:

- indexed intended URLs vs submitted URLs;
- impressions, clicks, CTR, average position by page/query/country/device;
- branded vs non-branded query segments where feasible;
- course landing-page search traffic;
- language/country performance;
- rich-result/search-appearance eligibility;
- organic conversion rate using analytics.

## 11. Release acceptance matrix

A release affecting SEO is accepted only when:

1. representative home/page/article/course/category/language URLs return expected status;
2. metadata snapshot has no duplicate/conflicting output;
3. canonical/robots policy matches the page-type matrix;
4. sitemap contains only approved URL classes;
5. hreflang passes reciprocal checks for published translations;
6. structured data validates with zero critical errors;
7. no private content appears in crawl/sitemap;
8. performance regression is reviewed;
9. caches are purged and re-verified;
10. Search Console sitemap/URL Inspection follow-up is scheduled/documented.

## 12. Risks

| Risk | Impact | Control |
|---|---|---|
| Multiple SEO emitters | Conflicting canonical/schema/title | Single-owner contract and integration test |
| TranslatePress language misconfiguration | Duplicate/incorrect-language indexing | URL/hreflang matrix and self-canonical checks |
| Course/taxonomy thin content | Poor index quality | Quality gate and default noindex for thin archives |
| LMS update changes CPT/routes | Broken sitemap/canonical/schema | Upgrade regression tests |
| Cache serves wrong language/user state | Severe SEO/privacy issue | Cache vary/exclusion tests |
| URL migration without redirects | Lost signals/404s | Explicit migration map |
| Plugin settings exist only in DB | Reproducibility gap | Runtime config export/runbook |
| Over-optimization/minification | Broken rendering/CWV | Performance tests and rollback |
| Scaled low-value content | Search quality risk | People-first content governance |

## 13. Open decisions before implementation

1. What is the production canonical domain and host form?
2. Which languages are launch-indexable?
3. Is TranslatePress SEO Pack licensed/available, or should translated SEO fields be custom?
4. Will SEO metadata be managed by a custom IPAEnglish SEO layer or one dedicated SEO plugin?
5. Which course taxonomies are valuable search landing pages?
6. Are instructor profiles public and content-rich enough to index?
7. What are the primary conversion events: lead, enrollment, purchase, or multiple?
8. What Search Console/GA4 access and baseline data are available?
