# IPAEnglish SEO Delivery Estimate

**Document ID:** IPA-SEO-ESTIMATE  
**Version:** 1.0  
**Status:** Planning baseline  
**Estimate date:** 2026-09-23  
**Related documents:** [SEO-SRS.md](./SEO-SRS.md), [SEO-TSD.md](./SEO-TSD.md)

## 1. Purpose

This document estimates the effort and calendar time required to complete, test, deploy, and stabilize the SEO scope defined in the IPAEnglish SEO SRS and TSD.

The estimate is for the complete technical SEO baseline, not only installation of an SEO plugin. It includes runtime discovery, implementation, LMS and multilingual SEO, structured data, indexation controls, performance checks, testing, production deployment, rollback readiness, and initial post-release monitoring.

SEO implementation completion and search-engine results are different milestones. The project can complete deployment on a known date, while Google recrawling, reprocessing, indexing, rich-result eligibility, and measurable organic-search impact may take additional days or weeks.

## 2. Estimation basis

### 2.1 Baseline team

The expected estimate assumes:

- 1 experienced WordPress/PHP developer as the primary implementer;
- 1 QA engineer available part-time for regression and release verification;
- 1 SEO/product/content owner available part-time for policy and content decisions;
- DevOps or hosting access available when server/CDN/redirect/cache changes are needed.

The person-day estimates below represent total engineering/QA effort. Calendar duration may be shorter when work is safely parallelized.

### 2.2 Baseline assumptions

The estimate assumes:

1. staging and production access can be provided without a long procurement or approval delay;
2. production database and WordPress Admin are available for the Phase 0 runtime audit;
3. the current WordPress/MasterStudy/TranslatePress architecture remains in place;
4. there is no full site redesign or LMS migration in the same release;
5. the scope covers the page types and requirements already defined in the SRS;
6. launch languages and the production language URL strategy can be confirmed during Phase 0;
7. content owners can answer blocking questions about which taxonomies, instructor pages, and course hubs should be indexable;
8. a staging environment can reproduce production routing, language behavior, plugin activation, and caching closely enough for meaningful verification;
9. no large-scale manual rewrite of existing course/article content is included;
10. no historical URL migration larger than the redirects required by this SEO rollout is included.

If one or more of these assumptions is false, use the adjustment factors in Section 8.

## 3. Summary estimate

### 3.1 Recommended planning range

| Scenario | Engineering + QA effort | Calendar duration | Use when |
|---|---:|---:|---|
| Optimistic | 4-5 person-days | 4-5 working days | Runtime is clean, decisions are immediate, multilingual behavior already works, and only minor performance remediation is needed |
| Expected | 6-8 person-days | 5-7 working days | Normal implementation with staging QA, multilingual verification, schema, cache/performance checks, and controlled production rollout |
| Conservative | 9-11 person-days | 8-10 working days | Runtime/plugin conflicts, translated SEO gaps, redirect changes, cache defects, or additional regression work are found |

**Recommended commitment for planning:** 5-7 working days to reach production go-live, with 2-3 additional business days of post-release monitoring.

This is a planning range, not a fixed deadline. The range should be re-baselined after the Phase 0 audit because the repository intentionally does not contain the production database, active-plugin state, live WordPress options, Search Console data, or CDN configuration.

### 3.2 Core implementation effort

The current bottom-up estimate is **5.25-7.75 person-days** before contingency. A small planning buffer produces a practical commitment range of approximately **6-9 person-days**.

The expected 5-7 day schedule assumes development, automated verification, content decisions, and release preparation are performed continuously rather than as separate long handoff phases.

## 4. Work breakdown estimate

| Work package | Scope | Estimate |
|---|---|---:|
| Phase 0 — Runtime baseline audit | Active plugins/theme, production URL/canonical host, WordPress settings, live head tags, sitemap, robots, redirects, Search Console/analytics/CWV baseline | 0.5-0.75 day |
| SEO ownership and implementation setup | Confirm one SEO owner, staging configuration, ownership matrix, implementation skeleton | 0.25-0.5 day |
| Phase 1 — Indexation foundation | Title/meta ownership, canonical policy, duplicate-canonical prevention, robots rules, sitemap inclusion/exclusion, canonical-host redirects, status/redirect behavior | 0.75-1.0 day |
| Phase 2 — LMS structured SEO | Course metadata mapping, Course schema, ItemList, Breadcrumb, article/instructor semantics where approved, course taxonomy quality gate | 0.75-1.0 day |
| Phase 3 — Multilingual SEO | Self-canonical, reciprocal hreflang, x-default decision, translated metadata/slugs, multilingual sitemap, language-variant verification | 0.75-1.0 day |
| Performance/cache correctness | W3TC/Autoptimize responsibility split, cache correctness, metadata purge, representative CWV remediation | 0.5-0.75 day |
| Search Console and analytics | Property/sitemap verification, baseline reporting, organic conversion event verification | 0.25-0.5 day |
| Automated/static verification | Policy tests, canonical/robots/sitemap/schema/language checks, regression guards | 0.5-0.75 day |
| HTML integration + crawl QA | Representative URL matrix, schema validation, crawl, redirects, private-page/indexability checks | 0.5-0.75 day |
| Production deployment + rollback verification | Backup/config snapshot, deploy, cache purge, smoke checks, rollback readiness, production crawl spot-check | 0.25-0.5 day |
| Documentation and handover | Final runtime decisions, operation notes, monitoring checklist, known limitations | 0.25 day |
| **Total before contingency** |  | **5.25-7.75 days** |

## 5. Proposed calendar plan

**Day 1**

- perform Phase 0 runtime audit;
- capture current production output and Search Console/performance baseline;
- confirm canonical host, languages, active plugins, and current SEO owner behavior;
- close blocking design decisions;
- establish the implementation skeleton.

**Day 2**

- implement SEO ownership layer/configuration;
- implement title/meta/robots/canonical policy;
- ensure exactly one canonical emitter;
- implement sitemap inclusion/exclusion rules;
- configure canonical-host redirects if required.

**Day 3**

- implement LMS course metadata mapping;
- add Course/Breadcrumb/ItemList structured data;
- apply private LMS page exclusions and taxonomy quality rules;
- implement/verify multilingual self-canonical and hreflang;
- verify reciprocal language alternates;
- implement translated metadata/slug path agreed during Phase 0.

**Day 4**

- verify multilingual sitemap behavior;
- resolve W3TC/Autoptimize ownership overlap;
- verify cache keys and metadata purge behavior;
- address high-impact LCP/INP/CLS problems on representative templates;
- verify Search Console/analytics integration;
- run automated/static verification.

**Day 5**

- run HTML integration matrix;
- run sitemap and structured-data checks;
- run bounded crawl;
- fix release-blocking regressions;
- production configuration review;
- final deployment checklist and rollback rehearsal.

**Day 6**

- production deployment in an agreed low-risk window;
- cache/CDN purge;
- immediate smoke verification;
- production canonical/robots/hreflang/schema checks;
- production crawl spot-check;
- submit/verify sitemap;

**Day 7**

- resolve any release-specific defect;
- verify Search Console processing and analytics continuity;
- complete handover and monitoring checklist.

If the implementation is clean after Day 5, production go-live can occur on Day 5 or Day 6. Day 7 is primarily a stabilization allowance, not a mandatory full development day.

## 6. Deployment estimate

### 6.1 Production change window

For a prepared release with staging already approved:

| Activity | Expected duration |
|---|---:|
| Pre-deploy backup/config snapshot and release checks | 20-30 minutes |
| Application/config deployment | 20-45 minutes |
| Cache/CDN purge and warm-up | 15-30 minutes |
| Immediate SEO smoke verification | 45-60 minutes |
| Initial production crawl spot-check | 20-30 minutes |

Plan a **2-3 hour controlled release window**, even if the actual code deployment takes much less time. The extra time is for validation and safe rollback, not continuous downtime.

The desired deployment should not require multi-hour site downtime. If a hosting/database constraint makes downtime necessary, that becomes a separate operational estimate after Phase 0.

### 6.2 First 2-3 business days after release

Monitor daily:

- canonical count and canonical targets on priority templates;
- robots/noindex behavior;
- hreflang reciprocity;
- sitemap availability and submitted/indexed trends;
- 404/5xx and redirect anomalies;
- schema validation errors;
- cache-related language or logged-in/logged-out leakage;
- Search Console crawl/indexing warnings;
- analytics organic landing/conversion continuity;
- representative CWV/Lighthouse regressions.

Critical runtime defects should be corrected immediately. Search Console changes that only reflect normal recrawl/reprocessing should be monitored rather than treated automatically as software defects.

## 7. Definition of implementation complete

The SEO implementation is considered complete when:

1. all release-blocking SRS requirements are implemented or explicitly accepted as deferred;
2. production page-type indexability matches the approved matrix;
3. each tested page has no more than one canonical tag and the canonical target is correct;
4. multilingual pages have valid self-canonical and reciprocal hreflang behavior;
5. private LMS/account/order/search/filter surfaces are excluded as designed;
6. sitemap contains only intended canonical/indexable URLs;
7. supported structured data has no critical validation error;
8. staging and production smoke/integration checks pass;
9. cache invalidation works for SEO metadata updates;
10. rollback steps are documented and usable;
11. Search Console sitemap/property access and baseline monitoring are in place;
12. no open P0/P1 SEO defect remains.

Search ranking growth, impressions growth, click growth, or a specific indexing percentage are **not** implementation-complete criteria because they depend on search-engine recrawl, competition, content quality, demand, and time.

## 8. Estimate adjustment factors

Add effort when the following conditions are discovered.

| Condition | Typical additional effort |
|---|---:|
| TranslatePress SEO Pack is unavailable and translated slug/meta editing must be custom-built | +1-2 days |
| Existing active SEO plugin conflicts with the selected ownership model | +0.5-1 day |
| Large historical redirect/URL migration is required | +1-2 days depending on inventory |
| More than two launch languages require full template/content verification | +0.25-0.5 day per additional language |
| Staging differs materially from production | +0.5-1.5 days |
| No Search Console/analytics access is available and setup/verification must be coordinated | +0.25-1 day plus external approval time |
| Significant Elementor/slider/third-party-script CWV remediation is required | +0.5-2.5 days |
| Course/taxonomy content requires manual rewriting rather than technical defaults | estimate separately as content production |
| CDN/WAF/host redirect rules require external infrastructure coordination | +0.25-1 day plus waiting time |
| Production plugin/theme upgrades must be bundled with SEO work | estimate separately after compatibility review |

External waiting time is not person-day effort but can extend calendar duration.

## 9. Staffing and parallelization

### Single primary developer

With one experienced developer and part-time QA/SEO support:

- expected effort: 6-8 person-days;
- expected calendar: approximately 5-7 working days;
- post-release monitoring: 2-3 business days.

### Two developers

With two developers, selected work can run in parallel:

- Developer A: indexation/canonical/robots/sitemap/runtime ownership;
- Developer B: LMS schema/multilingual/performance;
- QA: integration matrix and crawl validation in parallel.

Expected calendar duration can reduce to approximately **4-5 working days**, but deployment and final integration still remain sequential gates.

## 10. Milestones

| Milestone | Target in expected plan |
|---|---|
| M1 — Runtime baseline and decisions complete | Day 1 |
| M2 — Indexation foundation complete | Day 2 |
| M3 — LMS + multilingual SEO complete | Day 3 |
| M4 — Performance/cache + automated verification complete | Day 4 |
| M5 — Staging release gates passed | Day 5 |
| M6 — Production go-live | Day 5-6 |
| M7 — Initial stabilization and handover | Day 7 |

Milestone dates should be converted to calendar dates only after the actual project start date and team availability are confirmed.

## 11. Risks to schedule

The largest schedule risks are:

1. production behavior differing from the repository because active plugins/settings are database-driven;
2. an untracked SEO plugin or Code Snippets rule already emitting metadata/canonical/schema;
3. TranslatePress production language configuration differing from assumptions;
4. custom translated SEO fields/slugs being required without the SEO Pack;
5. cache/CDN behavior masking or mixing language/metadata changes;
6. canonical host or URL migration requiring infrastructure changes;
7. MasterStudy template/plugin output conflicting with custom schema or metadata;
8. lack of Search Console/analytics access delaying validation;
9. performance remediation expanding beyond SEO-specific changes;
10. content decisions for taxonomy/instructor pages not being available when implementation reaches those templates.

The Phase 0 audit exists specifically to turn these unknowns into confirmed scope before the project commits to the final date.

## 12. Recommended project commitment

For stakeholder planning, use:

> **Expected delivery:** approximately 5-7 working days from implementation start to controlled production go-live, assuming normal access and no major runtime conflict. Continue focused monitoring for 2-3 business days after release.

For engineering capacity planning, reserve:

> **6-9 person-days** including normal contingency.

Do not promise search-ranking or organic-traffic improvement within the same 5-7 day implementation window. The estimate is for implementation, verification, and deployment of the SEO platform baseline described by the SRS/TSD.
