# IPAEnglish SEO Delivery Estimate

**Document ID:** IPA-SEO-ESTIMATE  
**Version:** 1.2
**Status:** Agreed planning baseline
**Estimate date:** 2026-09-23
**Related documents:** [SEO-SRS.md](./SEO-SRS.md), [SEO-TSD.md](./SEO-TSD.md)

## 1. Scope

This estimate covers only the agreed SEO engagement:

- website audit using Screaming Frog SEO Spider;
- basic technical SEO review and remediation;
- Google Search Console setup/verification and sitemap submission;
- Google Analytics 4 setup/verification;
- research and mapping for a maximum of 20 keywords;
- on-page optimization for 3-5 priority URLs/landing pages;
- basic technical fixes for 404/301, robots, sitemap, HTTPS, image compression/WebP, and caching;
- final re-crawl, Technical SEO Document, Keyword Map, and handover.

The engagement does not include full content production, backlink campaigns, a complete multilingual SEO redesign, advanced schema rollout, a full Core Web Vitals engineering project, or optimization beyond the agreed 20 keywords and 3-5 target URLs.

## 2. Timeline summary

**Total calendar timeline: 3 working weeks**

- **Week 1:** Research, audit, baseline, keyword research, and keyword mapping.
- **Week 2:** On-page optimization and technical implementation.
- **Week 3:** Remaining fixes, re-crawl, QA, GSC/GA4 verification, and final handover.

The expected production-ready handover is at the end of Week 3, assuming required access and approvals are available on time.

The resolved baseline uses **4 Vietnamese target URLs** within the 3-5 URL cap; the exact URLs and 20-keyword mapping are maintained in KEYWORD-MAP.md.

## 3. Responsibility split

| Role | Main responsibility |
|---|---|
| SEO Exec | Audit, Screaming Frog crawl, keyword research/mapping, GSC/GA4, Technical SEO Document, on-page optimization, final verification |
| Dev / Tech Exec | 404/301 fixes, robots/sitemap, HTTPS checks, image compression/WebP, caching/basic speed fixes, technical remediation |
| Business/Content owner | Approves keyword set, target URLs, and wording changes where required |

## 4. Effort estimate

### 4.1 SEO Exec

| Work item | Estimated effort |
|---|---:|
| GSC/GA4 access check and baseline setup | 0.5 day |
| Initial Screaming Frog crawl and audit analysis | 1.0-1.5 days |
| Technical SEO Document preparation | 0.5-1.0 day |
| Keyword research for maximum 20 keywords | 1.5-2.0 days |
| Keyword grouping and mapping to 3-5 URLs | 0.5-1.0 day |
| Meta Title/Description optimization | 0.5-1.0 day |
| H1/H2/ALT and current-content optimization | 1.0-1.5 days |
| GSC sitemap submission and checks | 0.25-0.5 day |
| Final Screaming Frog re-crawl and comparison | 0.5-1.0 day |
| Final Keyword Map / audit status / handover | 0.5 day |
| **SEO Exec total** | **7.25-10.0 person-days** |

### 4.2 Dev / Tech Exec

| Work item | Estimated effort |
|---|---:|
| Review audit findings and technical feasibility | 0.5 day |
| Fix broken links/404s and required 301 redirects | 0.5-1.5 days |
| robots.txt and sitemap configuration/fixes | 0.5-1.0 day |
| SSL/HTTPS verification and redirect corrections | 0.25-0.5 day |
| Image compression/WebP setup | 0.5-1.0 day |
| Cache/basic performance configuration | 0.5-1.0 day |
| Final technical QA and remaining in-scope fixes | 0.5-1.0 day |
| **Dev / Tech Exec total** | **3.25-6.5 person-days** |

### 4.3 Combined effort

Expected combined effort is approximately **10.5-16.5 person-days**, distributed across the three-week calendar.

The calendar does not require all work to happen sequentially. SEO Exec and Dev / Tech Exec can work in parallel after the Week 1 audit backlog is available.

## 5. Week-by-week plan

### Week 1 — Research, audit, and planning

**SEO Exec**

1. Confirm GSC and GA4 access/status.
2. Run the initial Screaming Frog crawl.
3. Review:
   - 404/broken links;
   - redirects/chains;
   - duplicate or missing Title;
   - duplicate or missing Meta Description;
   - missing H1;
   - missing ALT;
   - oversized images;
   - canonical/indexability issues;
   - robots/sitemap observations.
4. Fill the Technical SEO Document.
5. Research candidate keywords.
6. Finalize no more than 20 keywords.
7. Group keywords by intent/topic.
8. Map the 20-keyword maximum to 3-5 priority URLs.
9. Capture current Title, Description, H1/H2, ALT, and relevant copy for those URLs.

**Dev / Tech Exec**

1. Review audit findings.
2. Confirm which findings require code/config work.
3. Verify existing HTTPS, robots, sitemap, image optimization, and cache setup.
4. Prepare implementation tasks for Week 2.

**Week 1 deliverables**

- initial Web Audit;
- Technical SEO Document;
- approved or approval-ready Keyword Map;
- 3-5 priority URLs;
- technical fix backlog.

### Week 2 — On-page optimization and technical fixes

**SEO Exec**

1. Rewrite or adjust Meta Title for 3-5 target URLs.
2. Rewrite or adjust Meta Description.
3. Optimize H1/H2 where needed.
4. Add or improve meaningful ALT text for target-page images.
5. Adjust the opening paragraph/sapo or existing body copy where needed.
6. Do not write a complete new article/page as part of this scope.
7. Create/verify sitemap submission in GSC.

**Dev / Tech Exec**

1. Fix agreed 404/broken internal links.
2. Add required 301 redirects.
3. Correct robots.txt configuration.
4. Correct or verify automatic sitemap generation.
5. Verify SSL/HTTPS.
6. Enable/configure image compression and WebP where appropriate.
7. Enable/tune cache for basic load-speed improvement.
8. Verify changes do not break authenticated/private LMS behavior.

**Week 2 deliverables**

- 3-5 target URLs updated for the approved keyword map;
- agreed technical fixes implemented;
- GSC sitemap submitted or ready for final verification;
- updated Technical SEO Document statuses.

### Week 3 — Re-crawl, QA, final fixes, and handover

**SEO Exec**

1. Re-crawl using Screaming Frog.
2. Compare before/after findings.
3. Verify final Title/Description/H1/H2/ALT on target URLs.
4. Verify GSC property and sitemap status.
5. Verify GA4 receives production traffic.
6. Finalize Keyword Map.
7. Finalize Technical SEO Document and Audit Report.

**Dev / Tech Exec**

1. Resolve remaining in-scope issues found by re-crawl.
2. Verify redirects and 404 behavior.
3. Verify robots/sitemap.
4. Verify HTTPS.
5. Verify image compression/WebP.
6. Verify cache/basic performance.
7. Record any deferred items that require separate scope.

**Week 3 deliverables**

- final Technical SEO Document / Web Audit Report;
- final Screaming Frog before/after evidence or export references;
- Keyword Map with maximum 20 keywords;
- 3-5 optimized target URLs;
- final Title/Description mapping;
- GSC status and sitemap submission status;
- GA4 verification status;
- technical fix status;
- deferred/recommended next actions.

## 6. Deliverable acceptance criteria

### 6.1 Technical SEO Document and Audit Report

Accepted when:

- initial Screaming Frog crawl is documented;
- issue owner and status are recorded;
- each agreed item is marked Fixed, Accepted, Deferred, or Not Applicable;
- final re-crawl has been completed.

### 6.2 Keyword Map

Accepted when:

- the final set contains no more than 20 keywords;
- keywords are grouped by search intent/topic;
- all approved keywords are mapped to 3-5 URLs;
- the business/content owner has approved the target direction.

### 6.3 On-page optimization

Accepted when all 3-5 target URLs have reviewed:

- Meta Title;
- Meta Description;
- H1;
- relevant H2;
- relevant image ALT;
- opening paragraph/sapo or existing copy where an adjustment is needed.

### 6.4 Technical implementation

Accepted when the agreed in-scope items have been fixed or documented:

- broken links/404;
- required 301 redirects;
- robots.txt;
- sitemap;
- HTTPS/SSL;
- image compression/WebP;
- cache/basic speed configuration.

### 6.5 GSC and GA4

Accepted when:

- Google Search Console property access is verified;
- sitemap has been submitted to GSC;
- GSC shows the sitemap as received/processed or the submission is documented if Google processing is still pending;
- GA4 is receiving production traffic;
- target pages can be identified in reporting.

Google indexing/ranking changes are not an immediate handover acceptance condition because Google processing may continue after the project is complete.

## 7. Dependencies

The three-week timeline assumes:

1. WordPress Admin and production/staging access are available in Week 1.
2. GSC and GA4 access can be granted without a long approval delay.
3. Screaming Frog can crawl the public website without blocking/challenge issues.
4. The 20-keyword maximum and 3-5 target URLs can be approved during Week 1.
5. Content changes on target pages do not require a separate legal/brand approval cycle.
6. Dev / Tech Exec can deploy configuration/code changes during Weeks 2-3.
7. No major site redesign, hosting migration, or plugin migration is introduced in parallel.

External waiting time can move calendar dates even when execution effort remains unchanged.

## 8. Out-of-scope expansion triggers

A separate estimate is required if the audit reveals or stakeholders request:

- more than 20 target keywords;
- more than 5 on-page target URLs;
- full article/page writing;
- large-scale historical redirect migration;
- advanced multilingual SEO implementation;
- major schema/structured-data rollout;
- a full Core Web Vitals remediation project;
- hosting/CDN migration;
- large theme/plugin refactor;
- ongoing monthly SEO operations.

## 9. Final planning commitment

For stakeholder planning:

> **Timeline: 3 working weeks total — 1 week for research/audit and keyword planning, followed by 2 weeks for on-page optimization, technical fixes, verification, and handover.**

Scope commitment:

> **Audit Web + Technical SEO cơ bản + GSC/GA4 + tối ưu On-page tối đa 20 keywords trên 3-5 URL/Landing Page chính.**

The delivery ends with documented implementation status and handover. Search ranking growth is monitored after delivery and is not guaranteed within the three-week implementation period.
