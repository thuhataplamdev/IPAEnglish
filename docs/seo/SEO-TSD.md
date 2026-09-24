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

## 3. Current-scope ownership model

### 3.1 No new SEO subsystem

Do not create a separate IPAEnglish SEO Policy Layer, SEO plugin replacement, SEO settings screen, or custom SEO data model for this engagement.

Use the existing WordPress stack:

- WordPress core/page editor for page titles and canonical output;
- WordPress-native Excerpt/summary data as the Meta Description source;
- MasterStudy/Elementor for visible page content;
- TranslatePress remains untouched for existing language routing;
- WordPress core remains the sitemap owner;
- W3 Total Cache owns page/browser caching;
- Autoptimize owns CSS/JS asset optimization.

The child theme may contain only the minimal integration needed to expose native WordPress data in the document head or enable an existing WordPress feature.

### 3.2 Responsibility table

| Surface | Owner |
|---|---|
| Page title/content | Existing WordPress page editor / Elementor content |
| Meta Description content | WordPress-native Excerpt/summary field |
| Meta Description HTML output | Minimal child-theme wp_head integration, exactly once |
| Canonical HTML output | WordPress core rel_canonical |
| robots.txt | Existing WordPress/runtime configuration |
| XML sitemap | WordPress core native sitemap |
| Language routing | Existing TranslatePress configuration; regression check only |
| 404/301 | WordPress/server configuration according to audited URL list |
| HTML/page cache | W3 Total Cache |
| CSS/JS optimization | Autoptimize |
| Image compression/WebP | One controlled image-optimization path selected during implementation |
| Search monitoring | Google Search Console |
| Analytics | GA4 |

### 3.3 Title handling

For the four target Vietnamese pages, prefer editing the existing WordPress page/site title inputs rather than creating a second SEO-title field.

Rules:

1. keep one effective HTML title;
2. use the target keyword naturally;
3. do not introduce a custom SEO-title database field;
4. verify navigation/visible heading behavior after any page-title edit because Elementor/theme templates may reuse the WordPress page title.

If a page-title change would create an unacceptable visible/navigation side effect, use the smallest existing WordPress document-title filter necessary for that page. This is an exception, not a new override system.

### 3.4 Meta Description handling

WordPress core does not currently emit a Meta Description on the sampled production pages. The current scope still requires a Meta Description for the four target URLs.

Use this minimal approach:

1. use a WordPress-native Excerpt/summary field as the editable description source;
2. if the Page post type does not expose Excerpt, enable native Page excerpt support in the child theme;
3. output one escaped Meta Description from that field through a minimal child-theme wp_head callback;
4. do not create a custom SEO settings screen or a parallel suite of _ipa_seo_* fields;
5. if the excerpt is empty, omit the tag and surface the page in QA instead of generating a generic site-wide description.

### 3.5 Canonical ownership

Keep WordPress core rel_canonical as the sole canonical emitter.

The implementation must not add a custom canonical renderer. Acceptance remains exactly one canonical on each sampled target page.

### 3.6 Sitemap ownership

Keep WordPress core as the sole sitemap owner.

The current production /wp-sitemap.xml body is sitemap XML but responds with HTTP 404. Fix the routing/status behavior so the same native endpoint returns HTTP 200. Do not add another sitemap plugin or sitemap_index.xml owner.

### 3.7 Scope boundary

Do not expand this engagement into hreflang redesign, translated slugs, translated SEO infrastructure, structured data/schema, social metadata, or a custom SEO override platform. Existing behavior on those surfaces is regression-only.

## 4. WordPress integration map

Use existing WordPress capabilities and the child theme only where a minimal integration is required.

| Need | Current-scope implementation |
|---|---|
| Title | Existing WordPress page/site title behavior; smallest document-title filter only if a page-title edit has unacceptable UI side effects |
| Meta Description source | WordPress-native Excerpt/summary |
| Meta Description output | One minimal child-theme wp_head callback |
| Robots | Existing WordPress/runtime behavior; only fix audited defects |
| Canonical | Keep WordPress core rel_canonical; no custom renderer |
| Sitemap | Keep WordPress core native sitemap; fix /wp-sitemap.xml HTTP status to 200 |
| Redirect | Direct-link correction or one-hop 301 only for confirmed moved/replaced URLs |
| Query/page editing | Existing WordPress/Elementor admin |
| Cache | W3 Total Cache for page/browser cache; Autoptimize for CSS/JS optimization |
| Image optimization | One selected image compression/WebP path |
| Analytics | GA4 business-owned property |
| Search monitoring | GSC business-owned property |

No custom SEO metadata storage model is required.

## 5. MasterStudy integration

### 5.1 Course detail

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

### 5.2 Course category

For `stm_lms_course_taxonomy`:

- default to noindex until the term has useful introduction + sufficient published course inventory;
- allow explicit promotion to indexable SEO hub;
- render ItemList for visible listed courses;
- include in sitemap only when indexable.

### 5.3 Private learning objects

Never infer public SEO eligibility merely because a WordPress URL can technically resolve. The post-type policy is authoritative:

- lesson excluded;
- quiz excluded;
- question excluded;
- order excluded;
- review object excluded as a standalone SEO URL.

## 6. Out-of-scope compatibility boundary

The engagement does not implement:

- hreflang changes;
- translated slug changes;
- translated SEO-field infrastructure;
- structured data/schema;
- Open Graph or Twitter/X metadata;
- a separate SEO override platform.

Existing English/Vietnamese routing and language switching must continue working after edits to the four Vietnamese target pages.

## 7. URL and redirect design

### 7.1 Canonical host

Configure the web server/CDN so all alternate host variants redirect directly to the selected HTTPS host.

Current tracked Apache rule only enforces HTTPS and uses the received host, so host normalization must be added at deployment once the canonical domain is known.

### 7.2 Tracking parameters

Known campaign parameters should not create canonical identities. Examples include common analytics/ad click parameters.

Do not blanket-strip all query parameters: course filters, pagination, preview, authentication, or application state can have different semantics.

### 7.3 URL migration

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
5. canonical and internal-link update;
6. Search Console monitoring.

## 8. robots.txt design

Recommended baseline behavior:

- allow rendering resources required by public pages;
- prevent wasteful crawling of non-public admin/utility areas where appropriate;
- do not block pages solely to remove them from the index;
- expose sitemap location;
- avoid broad wildcard rules without crawl evidence.

WordPress admin AJAX/resource endpoints needed by rendering must not be accidentally blocked.

## 9. Metadata storage design

Do not create a custom SEO metadata subsystem.

For the four target pages:

- use existing WordPress page/site title behavior for Title;
- use a WordPress-native Excerpt/summary field as the editable Meta Description source;
- if Page excerpts are not enabled, enable native Page excerpt support in the child theme;
- render exactly one escaped Meta Description from that native field;
- do not introduce a custom SEO settings screen;
- do not introduce a parallel set of custom SEO fields;
- keep WordPress core as canonical owner.

## 10. Basic performance optimization

The current engagement covers only basic speed hygiene.

Implementation focus:

- W3 Total Cache owns page/browser caching;
- Autoptimize owns CSS/JS asset optimization;
- enable one image compression/WebP path;
- avoid duplicate minification/cache transforms;
- verify forms, LMS/login flows, and target-page rendering after changes;
- capture a before/after Lighthouse or equivalent diagnostic sample.

LCP, INP, and CLS may be observed, but a full Core Web Vitals remediation program is outside scope. Larger Elementor/JavaScript/CSS work must be logged as deferred work rather than silently expanding this engagement.

## 11. Cache correctness

Cache keys must distinguish:

- language when HTML differs;
- authentication/private user state;
- application states that materially change public response.

Never cache personalized dashboard/order content into a public page cache.

SEO metadata changes require purge/invalidation of the affected URL and language variants.

## 12. Analytics and Search Console design

### 12.1 Search Console

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

### 12.2 Analytics

For this engagement, confirm GA4 is receiving production page-view traffic and that the 3-5 target landing pages can be identified in reporting. New custom event architecture is not required unless separately approved.

Recommended public conversion funnel:

1. organic landing;
2. course view;
3. CTA;
4. lead/enrollment/begin checkout;
5. completion.

Keep event payloads content-oriented. Do not send learner answers, credentials, private order notes, or payment secrets.

## 13. Testing strategy

### 13.1 Static/source tests

When minimal child-theme code is added, test only the behavior introduced by this engagement:

- Page excerpt support is enabled when required;
- one Meta Description is emitted from the native WordPress source;
- no duplicate canonical is introduced;
- sitemap fix preserves valid XML and changes the response status to 200;
- cache/optimization changes do not alter authenticated/private behavior.

### 13.2 HTML integration matrix

Test the four Vietnamese target URLs plus a small regression sample of the corresponding English URLs and key private/LMS routes.

For each target page capture:

- HTTP status;
- final URL/redirect chain;
- Title;
- Meta Description;
- robots;
- canonical;
- H1/H2;
- relevant image ALT;
- key internal links.

The English counterparts are regression checks only. Hreflang, translated slugs, structured data, and social metadata are not acceptance surfaces.

### 13.3 Sitemap tests

Automated checks:

- XML parses;
- every listed URL uses canonical host/HTTPS;
- no duplicates;
- no URL returns redirect/4xx/5xx;
- no URL is noindex;
- no private post type;
- public course coverage matches intended inventory.

### 13.4 Multilingual regression check

For each edited Vietnamese target page, verify only that:

- the page still resolves normally;
- its English counterpart remains reachable;
- the existing language switch still works;
- no URL structure is changed as part of this engagement.

No hreflang validation, translated-slug implementation, or translated SEO infrastructure is required.

### 13.5 Crawl tests

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

### 13.6 Performance tests

Run a basic before/after Lighthouse or equivalent diagnostic check on the target pages. Record larger performance work as deferred if it exceeds cache/image/basic front-end tuning.

## 14. Deployment plan

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

## 15. Rollback plan

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

## 16. Upgrade strategy

After WordPress, MasterStudy, TranslatePress, W3TC, Autoptimize, or the selected SEO plugin changes:

1. run the HTML integration matrix;
2. verify CPT/taxonomy registrations;
3. verify sitemap coverage;
4. verify canonical and sitemap behavior;
5. verify cache/private-page behavior;
6. compare basic performance.

Vendor theme/plugin code should not be patched directly for SEO unless no extension point exists and the patch is explicitly maintained.

## 17. Security and privacy

- No private learner data in metadata or analytics.
- No order/payment data in indexable HTML.
- No authentication token/session identifier in canonical/sitemap.
- Analytics payloads must not include secrets or learner answers.
- Search crawler accessibility never bypasses authorization.

## 18. Observability and handover follow-up

During the three-week engagement, checks should cover:

- sitemap fetch/parsing;
- robots.txt availability;
- target-page status/canonical/title snapshot;
- 4xx/5xx findings from crawl;
- redirect chains affecting target pages;
- GSC sitemap and target-page status;
- GA4 production traffic for target pages.

After handover, ongoing SEO monitoring is a separate operational scope. Recommended follow-up includes monthly Search Console review, new crawl issues, keyword/page performance, and content opportunities.

## 19. Resolved technical decisions

| Decision | Resolution | Implementation rule |
|---|---|---|
| Canonical host | https://www.ipaenglish.com | Keep apex -> www permanent redirect and generate all canonical/sitemap targets on www |
| Target URLs | Four Vietnamese URLs: /vi/, /vi/global-english-for-teen-achievers/, /vi/book-a-test/, /vi/learning-system/ | Optimize these four only; English equivalents are regression/parity checks |
| Keyword set | 20-keyword baseline from KEYWORD-MAP.md | GSC may reorder/replace terms during Week 1, but never exceed 20 without scope change |
| Metadata owner | Existing WordPress title/site-title behavior + native Excerpt/summary for Meta Description | Do not build a separate SEO override system. Child-theme code may only enable Page excerpts and emit one Meta Description. WordPress core remains canonical owner. |
| Sitemap owner | WordPress core /wp-sitemap.xml | Fix current HTTP 404 to 200 and keep robots.txt pointing to it; do not add sitemap_index.xml/plugin sitemap |
| 404 remediation | Direct-link correction first; 301 only for a true moved/replaced URL with a 1:1 successor; otherwise 404/410 | No blanket redirects to Home and no avoidable redirect chains |
| Image optimization | WebP currently treated as inactive | Enable one controlled compression/WebP path and verify actual response format + visual quality |
| Cache ownership | W3 Total Cache = page/browser/cache behavior; Autoptimize = CSS/JS asset optimization | Avoid overlapping minify/cache transforms; Caddy/hosting must not duplicate these responsibilities unless documented |
| GSC ownership | Required target state: business-owned IPAEnglish Google account as Owner; SEO Exec gets operational access | Prefer Domain property ipaenglish.com when DNS verification is available |
| GA4 ownership | Required target state: business-owned IPAEnglish GA4 property/admin; SEO Exec gets operational access | Current live tag is not verified; configure/verify during Week 1 and confirm Realtime/DebugView |

These decisions supersede the earlier open-decision list for the current three-week engagement.

## 20. Definition of done for current SEO engagement

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
