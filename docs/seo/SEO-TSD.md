# SEO Technical Solution Design (TSD)

**Document ID:** IPA-SEO-TSD  
**Version:** 1.1
**Status:** Agreed execution design
**Date:** 2026-09-23
**System:** IPAEnglish WordPress / MasterStudy LMS  
**Related:** [SEO-SRS.md](./SEO-SRS.md)

## 1. Design objective

The current implementation objective is to deliver the agreed three-week SEO engagement: one week of research/audit followed by two weeks of implementation, verification, and handover.

Primary execution tools:

- Screaming Frog SEO Spider for crawl-based audit and re-crawl verification;
- Google Search Console for ownership, sitemap submission, indexing/query baseline, and post-change validation;
- Google Analytics 4 for traffic measurement and organic landing-page verification;
- WordPress/Admin/plugin/runtime configuration and repository changes for technical remediation.

Primary target:

- a maximum of 20 approved keywords;
- mapped to 3-5 priority URLs/landing pages;
- on-page optimization limited to metadata, headings, relevant image ALT, and small edits to existing content;
- basic technical remediation including 404/301, robots, sitemap, HTTPS verification, image compression/WebP, and cache/basic speed improvements.

The broader architecture sections in this TSD remain technical guardrails. They must not be interpreted as mandatory delivery of advanced multilingual SEO, full structured-data rollout, LMS SEO redesign, or a full Core Web Vitals program unless an audited blocker requires it and scope is explicitly expanded.

The design still avoids letting several plugins independently emit the same SEO signals. The central principle is:

> resolve page context once, apply one policy, emit each SEO primitive once.

### 1.1 Responsibility split

| Role | Execution responsibility |
|---|---|
| SEO Exec | GSC/GA4 setup, Screaming Frog audit, Technical SEO Document, keyword research/mapping, on-page optimization, before/after verification |
| Dev / Tech Exec | 404/301 fixes, robots/sitemap, HTTPS checks, image compression/WebP, caching/basic speed fixes, technical remediation support |
| Business/Content owner | Approves 20-keyword set, 3-5 target URLs, and wording changes when required |

## 2. Verified architecture baseline

The sections from architecture baseline through detailed component design are retained as implementation guardrails. They do not expand the current three-week delivery scope beyond the audit, 20-keyword/3-5 URL on-page work, and agreed basic technical fixes.

### 2.1 Runtime framework

- WordPress 7.1 source is tracked.
- MasterStudy theme 4.8.68 is tracked.
- MasterStudy LMS 3.7.48 is tracked.
- TranslatePress 3.3.4 is tracked.
- W3 Total Cache 2.10.6 is tracked.
- Autoptimize 3.1.15.1 is tracked.
- MasterStudy child theme exists and currently contains minimal custom PHP.

### 2.2 SEO-relevant content model

MasterStudy registers:

- `stm-courses`: public, publicly queryable, search-visible; course slug comes from LMS options;
- `stm-lessons`: excluded from search; public/queryable only in privileged author/admin/instructor contexts;
- `stm-quizzes`: private;
- `stm-questions`: private;
- `stm-reviews`: private;
- `stm-orders`: private;
- `stm_lms_course_taxonomy`: hierarchical course taxonomy with configurable rewrite slug.

This makes course detail and selected course category pages the primary LMS SEO surfaces. Lessons/quizzes/questions/orders are not SEO landing pages.

### 2.3 Multilingual baseline

TranslatePress can generate language URLs and hreflang output. Its code includes:

- per-language alternate tags;
- optional `x-default`;
- compatibility layers for canonical URLs from common SEO plugins;
- references to the premium SEO Pack for translated slugs and fuller SEO/sitemap integration.

The tracked repository does not contain a separate TranslatePress SEO Pack plugin, so production capability must be verified rather than assumed.

### 2.4 Performance baseline

The Apache file contains:

- HTTP -> HTTPS 301;
- W3TC page/browser-cache rules;
- compression;
- long-lived static-asset cache headers;
- HSTS/security headers.

The HTTPS redirect keeps the incoming host. Canonical www/non-www host normalization therefore remains an infrastructure requirement.

## 3. Proposed ownership model

### 3.1 Recommended model

Create a thin version-controlled **IPAEnglish SEO Policy Layer**, preferably as an MU plugin so behavior is not dependent on the active presentation theme.

Suggested future location:

`wp-content/mu-plugins/ipaenglish-seo/`

Recommended responsibilities:

- context classification;
- metadata defaults and controlled overrides;
- robots/indexability;
- canonical normalization;
- sitemap inclusion policy;
- structured-data graph;
- social metadata;
- testable integration adapters for MasterStudy and TranslatePress.

Do **not** put the main SEO policy in the parent MasterStudy theme because vendor upgrades can overwrite it. Avoid using untracked Code Snippets as the authoritative source.

### 3.2 Alternative: dedicated third-party SEO plugin

If the team chooses an SEO plugin for editor UX, it may replace the custom renderers for title/description/canonical/robots/sitemap/schema.

Rules:

1. only one SEO plugin is active as primary owner;
2. custom emitters for overlapping surfaces are disabled;
3. TranslatePress compatibility is verified;
4. MasterStudy course support is verified;
5. configuration is documented/exported where possible;
6. acceptance tests remain exactly the same.

### 3.3 Responsibility table

| Surface | Owner |
|---|---|
| Business/content fields | WordPress/MasterStudy |
| Language URL conversion | TranslatePress |
| hreflang | TranslatePress by default |
| SEO page classification | IPA SEO policy layer or selected SEO plugin |
| Title/meta/robots | One SEO owner only |
| Canonical URL resolution + HTML `rel="canonical"` emission | One SEO owner only; WordPress core `rel_canonical` and any custom/plugin renderer must never emit in parallel |
| JSON-LD | One SEO owner only |
| Sitemap inclusion | One SEO owner using WordPress sitemap APIs or selected plugin |
| HTTPS/canonical host redirects | Web server/CDN/edge |
| HTML/page cache | W3TC |
| Front-end optimization | Autoptimize/W3TC, coordinated |
| Search performance/index monitoring | Search Console |
| Conversion analytics | GA4/approved analytics |

## 4. Component design

If the custom policy layer is selected, split behavior by responsibility.

### 4.1 SeoContextResolver

Inputs:

- request/query state;
- WordPress queried object;
- post type/taxonomy;
- authentication state;
- MasterStudy route/content information;
- current TranslatePress language;
- pagination/query parameters.

Output model:

- `pageType`;
- `indexable`;
- `follow`;
- `canonicalUrl`;
- `language`;
- `alternateUrls`;
- `sitemapEligible`;
- `schemaProfile`;
- `socialProfile`.

The resolver is the single source of page classification used by all emitters.

### 4.2 MetadataResolver

Precedence:

1. explicit SEO override;
2. page-type-specific source field;
3. deterministic generated fallback;
4. site-level fallback.

Example default sources:

| Page | Title source | Description source |
|---|---|---|
| Home | configured SEO home title | configured business proposition |
| Page | explicit override -> post title | override -> excerpt/curated summary |
| Article | override -> post title | override -> excerpt |
| Course | override -> course title | override -> course excerpt/short description |
| Course category | override/term meta -> term name | curated term description |
| Instructor | override -> display name + role/topic | biography excerpt |

Generated descriptions must be length-aware but not mechanically cut in a way that destroys meaning. Google may rewrite snippets; the system’s job is to provide a strong candidate.

### 4.3 RobotsPolicy

Rules derive from the SRS page matrix.

Baseline:

- `index,follow`: useful public home/pages/articles/courses/approved hubs;
- `noindex,follow`: internal search, thin archives, filter/sort pages where links should still be discovered;
- `noindex,nofollow`: private/user/transactional contexts when links are not public discovery paths;
- drafts/previews: noindex and excluded from sitemap.

Use the WordPress robots metadata API/filter rather than raw duplicate tags.

### 4.4 CanonicalResolver

Algorithm:

1. determine canonical WordPress object URL;
2. force canonical scheme/host from deployment configuration;
3. apply language conversion for current TranslatePress language;
4. normalize only known non-content tracking parameters;
5. preserve parameters that materially identify distinct intended content;
6. apply trailing-slash/permalink convention consistently;
7. verify target returns intended 200/indexable response.

Do not cross-canonical valid language variants.

#### 4.4.1 Canonical emission ownership and WordPress core

The checked-in WordPress 7.1 source already registers the core canonical renderer:

```php
add_action( 'wp_head', 'rel_canonical' );
```

Therefore `CanonicalResolver` computes the canonical URL, but **canonical HTML emission must have exactly one owner**. The implementation must choose one of these mutually exclusive modes:

1. **WordPress-core-owned emission**
   - keep the core `rel_canonical` callback enabled;
   - do not render another `<link rel="canonical">` from the IPA SEO layer or another SEO plugin;
   - only use this mode when the core output can represent the complete IPAEnglish canonical policy for the page type and language.
2. **IPA SEO/plugin-owned emission**
   - disable/remove the WordPress core `rel_canonical` callback after WordPress has registered it and before `wp_head` executes;
   - ensure any selected third-party SEO plugin's canonical renderer is also disabled unless that plugin is the chosen canonical owner;
   - render exactly one canonical tag using the resolved URL.

The implementation must not use a "core canonical plus custom canonical" strategy, even when both URLs are expected to match. Ownership is about preventing duplicate markup as well as preventing conflicting URLs.

Implementation acceptance:

- public indexable pages: exactly one HTML `link[rel="canonical"]`;
- pages where policy intentionally omits canonical: zero canonical tags;
- no tested page may emit more than one canonical tag;
- the canonical target must match the current-language policy and return the intended response.

### 4.5 AlternateLanguageAdapter

TranslatePress remains the default hreflang renderer.

Integration requirements:

- confirm configured languages at runtime;
- confirm reciprocal alternates;
- enable `x-default` only when a meaningful fallback is defined;
- verify URL conversion for course/page/post/taxonomy types;
- verify translations are actually publishable/indexable;
- verify translated slug/meta behavior separately from hreflang.

The custom SEO owner must not emit a second hreflang set unless it explicitly disables/replaces TranslatePress output.

### 4.6 SitemapPolicy

Prefer WordPress native sitemap infrastructure unless a selected SEO plugin becomes the sitemap owner.

Include:

- home/public pages;
- published indexable posts/articles;
- published indexable courses;
- approved public taxonomies/hubs;
- language variants when the chosen multilingual integration reliably exposes them.

Exclude:

- lessons;
- quizzes;
- questions;
- reviews/orders;
- account/dashboard/login/reset;
- checkout/payment/order confirmation;
- search result pages;
- preview/draft;
- noindex pages;
- redirects/errors;
- filter/sort/query duplicates;
- thin/disallowed archives.

Before implementation, verify the exact sitemap hooks against the WordPress 7.1 APIs in this repository. Candidate integration surfaces include post-type/taxonomy provider filters and query-argument filters; do not copy hook names from an older WordPress version without source verification.

### 4.7 StructuredDataGraph

Emit a single JSON-LD graph per page where practical.

Base nodes:

- `Organization`;
- `WebSite`;
- `WebPage` or subtype;
- `BreadcrumbList` where hierarchy exists.

Template-specific nodes:

- Course detail: `Course`;
- Course hub/list: `ItemList` with Course references/items;
- Article: `Article` or `BlogPosting`;
- Public instructor profile: `ProfilePage` + `Person` only when profile quality supports indexing.

Do not manufacture fields that are not visible/true. Do not output fake aggregate ratings, prices, availability, instructors, or dates.

FAQ content may exist in HTML, but FAQ rich-result schema is not an implementation target in this 2026 baseline.

### 4.8 SocialMetaRenderer

For priority indexable pages emit one coherent set of:

- `og:type`;
- `og:url`;
- `og:title`;
- `og:description`;
- `og:image`;
- Twitter/X-compatible card metadata.

Use the same resolved canonical/title/description where appropriate to prevent divergence.

## 5. WordPress integration map

The implementation should use public WordPress hooks/APIs, verified against the checked-in 7.1 source before coding.

Expected integration categories:

| Need | WordPress integration |
|---|---|
| Title | document-title filters/API |
| Robots | `wp_robots` filter/API |
| Canonical | choose exactly one emitter: keep WordPress core `rel_canonical`, or disable it before `wp_head` and use one controlled SEO-owner renderer |
| Head metadata | one controlled `wp_head` renderer |
| Sitemap | WordPress sitemap provider/query filters |
| Redirect | canonical-host at edge; WordPress redirect hooks only for application URL migrations |
| Query classification | main-query/queried-object APIs |
| Metadata storage | post/term options/meta APIs |
| Cache invalidation | W3TC purge integration or documented purge after metadata updates |

Exact hooks are implementation details to confirm from local WordPress 7.1 source; the TSD intentionally does not freeze obsolete hook names beyond stable APIs already verified.

For canonical specifically, the current repository already verifies that WordPress 7.1 registers `rel_canonical` on `wp_head`. Any implementation that introduces a custom canonical renderer must explicitly account for and disable that default emitter before rendering its own tag.

## 6. MasterStudy integration

### 6.1 Course detail

Data mapping should use MasterStudy/WordPress data as source of truth:

- ID/URL;
- title/name;
- excerpt/short description;
- main visible description;
- featured image;
- instructor;
- course taxonomy;
- level/duration/price only when reliably stored and visible;
- publish/update date where meaningful.

The adapter should isolate MasterStudy-specific meta keys/functions so LMS upgrades affect one module rather than every SEO renderer.

### 6.2 Course category

For `stm_lms_course_taxonomy`:

- default to noindex until the term has useful introduction + sufficient published course inventory;
- allow explicit promotion to indexable SEO hub;
- render ItemList for visible listed courses;
- include in sitemap only when indexable.

### 6.3 Private learning objects

Never infer public SEO eligibility merely because a WordPress URL can technically resolve. The post-type policy is authoritative:

- lesson excluded;
- quiz excluded;
- question excluded;
- order excluded;
- review object excluded as a standalone SEO URL.

## 7. Multilingual design

### 7.1 URL model

Use one stable URL per language. The exact production pattern must be verified from TranslatePress runtime configuration, for example subdirectory-style language paths.

Do not invent a domain/path in source documentation.

### 7.2 Canonical + hreflang invariant

For each equivalent page set:

- each language URL self-canonicalizes;
- each includes reciprocal alternate references to published equivalents;
- each alternate resolves to 200 and is not noindex;
- optional x-default points to the chosen fallback.

### 7.3 Translated slugs

Because the tracked free TranslatePress code explicitly treats slug translation as an SEO Pack feature, choose one path:

**Path A — TranslatePress SEO Pack**
- verify compatible licensed add-on is deployed;
- verify slug translation, metadata translation, sitemap integration;
- document settings.

**Path B — Custom**
- store translated SEO metadata/slug mappings in version-compatible WordPress data;
- generate redirects when a translated slug changes;
- integrate with TranslatePress language resolution.

Path A is operationally simpler if already licensed. Path B has higher engineering/maintenance cost.

## 8. URL and redirect design

### 8.1 Canonical host

Configure the web server/CDN so all alternate host variants redirect directly to the selected HTTPS host.

Current tracked Apache rule only enforces HTTPS and uses the received host, so host normalization must be added at deployment once the canonical domain is known.

### 8.2 Tracking parameters

Known campaign parameters should not create canonical identities. Examples include common analytics/ad click parameters.

Do not blanket-strip all query parameters: course filters, pagination, preview, authentication, or application state can have different semantics.

### 8.3 URL migration

Any change to:

- course base slug;
- course category slug;
- language prefix/domain;
- permalink structure;
- article/page slug;

requires:

1. old -> new URL map;
2. one-hop permanent redirects;
3. internal link updates;
4. sitemap update;
5. canonical/hreflang update;
6. Search Console monitoring.

## 9. robots.txt design

Recommended baseline behavior:

- allow rendering resources required by public pages;
- prevent wasteful crawling of non-public admin/utility areas where appropriate;
- do not block pages solely to remove them from the index;
- expose sitemap location;
- avoid broad wildcard rules without crawl evidence.

WordPress admin AJAX/resource endpoints needed by rendering must not be accidentally blocked.

## 10. Structured data details

### 10.1 Course detail example model

Logical fields:

- `@type: Course`;
- name;
- description;
- provider/organization where accurate;
- URL;
- image if representative;
- course/instructor properties supported by current Google/schema guidance and visible content.

Before implementation, compare required/recommended properties with the current Google Course documentation because rich-result requirements can change.

### 10.2 Course list

A qualifying list/hub:

- visibly contains at least three eligible courses;
- has ItemList positions;
- each item resolves to a unique canonical course URL;
- list order in JSON-LD reflects visible order.

### 10.3 Breadcrumb

The JSON-LD hierarchy must correspond to a visible, sensible navigation path. Do not use breadcrumbs to stuff keywords.

### 10.4 Article

Use visible headline, author, publish/modified date, images, publisher. Do not change `dateModified` for trivial technical cache/template deployments.

## 11. Metadata storage design

If custom SEO editing is implemented, use namespaced fields such as:

- `_ipa_seo_title`;
- `_ipa_seo_description`;
- `_ipa_seo_robots_override`;
- `_ipa_seo_og_image_id`.

Guardrails:

- canonical override should not be a free-text field for ordinary editors unless needed;
- robots noindex override should display a warning;
- sanitization/permissions/nonces required;
- translated values must be language-aware;
- empty override means “use generated default.”

If a third-party SEO plugin is selected, do not create parallel fields unless migration requires them.

## 12. Performance and Core Web Vitals

### 12.1 Targets

At the 75th percentile for key public templates:

- LCP <= 2.5 s;
- INP <= 200 ms;
- CLS <= 0.1.

### 12.2 Existing tools

W3 Total Cache and Autoptimize overlap in some optimization areas. The deployment must define which tool owns:

- page cache;
- CSS minification/aggregation;
- JS minification/defer/delay;
- image lazy loading;
- CDN rewriting;
- browser cache.

Do not enable the same transformation blindly in both.

### 12.3 Template-specific priorities

Home/course/article:

- prioritize LCP hero/featured image;
- do not lazy-load the LCP image;
- set image dimensions/aspect ratio;
- reduce blocking CSS/JS;
- minimize large slider/Elementor payload where unnecessary;
- preload only critical assets with measured benefit;
- use modern image formats where supported;
- avoid layout shifts from fonts/banners/iframes;
- delay non-essential third-party scripts.

Measure after each optimization because aggressive script delay can break enrollment/forms/analytics.

## 13. Cache correctness

Cache keys must distinguish:

- language when HTML differs;
- authentication/private user state;
- application states that materially change public response.

Never cache personalized dashboard/order content into a public page cache.

SEO metadata changes require purge/invalidation of the affected URL and language variants.

## 14. Analytics and Search Console design

### 14.1 Search Console

For this engagement:

1. confirm or create the production Search Console property;
2. verify access/ownership;
3. submit the production XML sitemap;
4. capture baseline indexing/query/page data for the target URLs where available;
5. record sitemap processing and target-page status in the handover.

Use a domain property where operationally feasible and monitor:

- submitted vs indexed URLs;
- page indexing reasons;
- sitemap health;
- search performance by page/query/country/device;
- Core Web Vitals;
- manual actions/security issues.

### 14.2 Analytics

For this engagement, confirm GA4 is receiving production page-view traffic and that the 3-5 target landing pages can be identified in reporting. New custom event architecture is not required unless separately approved.

Recommended public conversion funnel:

1. organic landing;
2. course view;
3. CTA;
4. lead/enrollment/begin checkout;
5. completion.

Keep event payloads content-oriented. Do not send learner answers, credentials, private order notes, or payment secrets.

## 15. Testing strategy

### 15.1 Static/source tests

When custom code exists:

- unit tests for context classification;
- title/description precedence;
- robots policy;
- canonical URL normalization;
- sitemap inclusion;
- schema construction;
- language mapping.

### 15.2 HTML integration matrix

Test at minimum:

- home;
- static page;
- article;
- public course;
- approved course category;
- thin category;
- internal search;
- filter/sort URL;
- login/account;
- lesson;
- quiz/question where routable;
- 404;
- every launch language variant.

For each capture:

- HTTP status;
- final URL/redirect chain;
- title;
- meta description;
- robots;
- canonical;
- hreflang;
- OG/Twitter tags;
- JSON-LD;
- H1;
- key crawlable links.

### 15.3 Sitemap tests

Automated checks:

- XML parses;
- every listed URL uses canonical host/HTTPS;
- no duplicates;
- no URL returns redirect/4xx/5xx;
- no URL is noindex;
- no private post type;
- public course coverage matches intended inventory.

### 15.4 Structured-data tests

Use:

- schema parser/unit tests;
- Google Rich Results Test for supported search features;
- Search Console enhancement reports after deployment.

Zero critical validation errors on supported templates is the release gate.

### 15.5 Multilingual tests

Build a language-equivalence matrix and assert:

- self canonical;
- reciprocal hreflang;
- valid codes;
- no alternate -> redirect/error/noindex;
- x-default consistent;
- translated metadata language matches visible content.

### 15.6 Crawl tests

Use Screaming Frog SEO Spider as the primary crawl/audit and re-crawl verification tool.

Initial crawl shall check at minimum:

- 4xx/404 URLs and broken internal links;
- redirect chains and loops;
- duplicate titles/descriptions;
- missing titles/descriptions;
- missing H1;
- missing image ALT on relevant images;
- oversized images;
- canonical conflicts;
- noindex/index mismatches;
- robots/sitemap inconsistencies detectable by crawl;
- target URL status/indexability.

After implementation, re-crawl the affected site/sections and update the Technical SEO Document with final status. Crawl findings are evidence, not automatic defects; false positives and intentionally excluded URLs must be marked accordingly.

### 15.7 Performance tests

Run mobile and desktop lab tests on representative URLs and compare before/after. Use Search Console/CrUX field data when sufficient traffic exists.

## 16. Deployment plan

### Week 1 — Research, audit, and keyword planning

**SEO Exec**

- verify GSC and GA4 access/state;
- crawl the website with Screaming Frog;
- collect 404/redirect/metadata/H1/ALT/image-size/robots/sitemap findings;
- populate the Technical SEO Document;
- research candidate keywords;
- finalize a maximum of 20 keywords;
- map the approved keywords to 3-5 priority URLs;
- capture current Title, Description, headings, ALT, and relevant copy for those URLs.

**Dev / Tech Exec**

- review technical findings for feasibility and ownership;
- confirm current HTTPS, robots, sitemap, image optimization, and cache setup;
- identify fixes that require code/config changes.

**Week 1 output**

- Web Audit / Technical SEO Document;
- approved keyword map draft/final;
- implementation backlog split between SEO Exec and Dev / Tech Exec.

### Week 2 — On-page optimization and technical fixes

**SEO Exec**

- rewrite/adjust Meta Title and Meta Description for the 3-5 target URLs;
- optimize H1/H2 where required;
- add/improve relevant image ALT text;
- adjust opening paragraph/sapo or existing copy for keyword relevance without full content rewrite;
- create/verify sitemap submission in GSC.

**Dev / Tech Exec**

- fix agreed 404s/broken internal links;
- implement required 301 redirects;
- correct robots.txt and sitemap behavior;
- verify SSL/HTTPS;
- enable/configure WebP or image compression where suitable;
- enable/tune basic cache/performance configuration.

### Week 3 — Re-crawl, QA, final fixes, and handover

**SEO Exec**

- re-crawl using Screaming Frog;
- compare before/after findings;
- verify final Title/Description/H1/H2/ALT on 3-5 target URLs;
- verify GSC sitemap status and target-page crawl/indexing signals available at that time;
- verify GA4 is receiving traffic;
- complete Keyword Map and Technical SEO Document.

**Dev / Tech Exec**

- resolve remaining in-scope defects from QA/re-crawl;
- verify redirects, robots, sitemap, HTTPS, image optimization, and cache behavior;
- document deferred items requiring future scope.

**Handover package**

- Technical SEO Document / Web Audit Report with final status;
- Screaming Frog crawl summary/export references;
- Keyword Map for maximum 20 keywords and 3-5 URLs;
- final Title/Description per target URL;
- GSC/GA4 setup status;
- sitemap submission status;
- open/deferred recommendations.

## 17. Rollback plan

Every SEO rollout must support reverting without leaving search signals inconsistent.

Rollback order:

1. disable new renderer/policy component;
2. restore previous metadata owner;
3. restore previous sitemap/robots behavior;
4. restore redirect rules only if they are proven harmful and old URLs still exist;
5. purge caches/CDN;
6. verify representative URLs;
7. record the incident and Search Console impact.

Never roll back a public URL migration by simply removing redirects after search engines/users have adopted the new URL. URL rollback needs its own migration plan.

## 18. Upgrade strategy

After WordPress, MasterStudy, TranslatePress, W3TC, Autoptimize, or the selected SEO plugin changes:

1. run the HTML integration matrix;
2. verify CPT/taxonomy registrations;
3. verify sitemap coverage;
4. verify canonical/hreflang;
5. verify schema;
6. verify cache/language/private-page behavior;
7. compare performance.

Vendor theme/plugin code should not be patched directly for SEO unless no extension point exists and the patch is explicitly maintained.

## 19. Security and privacy

- No private learner data in metadata/schema.
- No order/payment data in indexable HTML.
- No authentication token/session identifier in canonical/sitemap.
- Do not leak draft course content through structured data.
- Analytics payloads must not include secrets or learner answers.
- Search crawler accessibility never bypasses authorization.

## 20. Observability and handover follow-up

During the three-week engagement, checks should cover:

- sitemap fetch/parsing;
- robots.txt availability;
- target-page status/canonical/title snapshot;
- 4xx/5xx findings from crawl;
- redirect chains affecting target pages;
- GSC sitemap and target-page status;
- GA4 production traffic for target pages.

After handover, ongoing SEO monitoring is a separate operational scope. Recommended follow-up includes monthly Search Console review, new crawl issues, keyword/page performance, and content opportunities.

## 21. Technical decisions required before implementation

| Decision | Options | Recommended baseline |
|---|---|---|
| Target URLs | 3-5 commercial landing pages | Approve in Week 1 based on business priority and keyword intent |
| Keyword set | Up to 20 keywords | Group by intent and map each to one target URL |
| Metadata owner | WordPress/plugin/custom | Use the existing production owner unless audit finds conflicts |
| Sitemap owner | WordPress native vs SEO plugin | Keep one active sitemap owner and submit its canonical endpoint |
| Canonical host | www vs non-www | Business/ops decision; enforce one |
| 404 remediation | Direct-link fix, 301, 410, or keep 404 | Choose based on whether a valid replacement exists |
| Image optimization | Existing plugin/host vs new configuration | Reuse existing capability where safe; avoid duplicate optimization layers |
| Cache owner | W3TC, Autoptimize, host/CDN | Define one owner per transformation and avoid overlapping rules |
| GSC property | Domain vs URL-prefix | Prefer the property the business can reliably verify and maintain |
| GA4 | Existing property vs new property | Reuse valid existing production tracking when available |

## 22. Definition of done for current SEO engagement

The current SEO engagement is done when:

- initial Screaming Frog audit is completed and documented;
- the Technical SEO Document contains owner and status for audited issues;
- a maximum of 20 keywords is approved and mapped to 3-5 target URLs;
- those 3-5 URLs have reviewed/updated Title, Description, H1/H2, relevant image ALT, and existing copy where needed;
- agreed 404/301/robots/sitemap/HTTPS issues are fixed or explicitly deferred;
- image compression/WebP and basic cache configuration are enabled or documented as not applicable;
- a post-change Screaming Frog re-crawl has been completed;
- Google Search Console is verified and the sitemap is submitted;
- GA4 is receiving production traffic;
- no known in-scope blocker prevents Google from crawling the target URLs;
- final audit report, keyword map, implementation status, and deferred recommendations are handed over.
