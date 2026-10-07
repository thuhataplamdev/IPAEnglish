# SEO-W1-03 — Technical Audit Triage & Backlog

**Timing:** Week 1 — Day 2–3  
**Owner:** SEO Exec + Dev / Tech Exec  
**Priority:** High  
**Dependency:** SEO-W1-02
**Status:** DONE — completed 2026-10-07

## Objective

Chuyển crawl findings thành backlog triển khai có severity, owner, status, action và verification cụ thể.

## Starting audit items

Baseline hiện có:

- TECH-001 Sitemap HTTP status — High — Open.
- TECH-002 Meta Description — Medium — Open.
- TECH-003 Vietnamese Title/localization — Medium — Open.
- TECH-004 GA4 — High — Open.
- TECH-005 Image/WebP — Medium — Open.
- TECH-006 H1 — Medium — Open.
- TECH-007 Cache ownership — Medium — In Progress.
- TECH-008 404/redirect list — Medium — Open.
- TECH-009 Robots — Low — Accepted.
- TECH-010 Canonical — Low — Accepted.

## Implementation steps

1. Import/inspect crawl exports.
2. Group duplicate issues by root cause; không tạo hàng trăm task cho cùng một lỗi template.
3. Với mỗi issue:
   - URL/pattern;
   - severity;
   - evidence;
   - recommended action;
   - owner;
   - status.
4. Dev/Tech xác định:
   - code change;
   - WordPress config;
   - server/rewrite;
   - plugin config;
   - content-only;
   - false positive / accepted behavior.
5. Chỉ đưa basic technical SEO vào Week 2.
6. Mọi issue lớn hơn scope chuyển `Deferred` và ghi lý do.

## Status vocabulary

`Open`, `In Progress`, `Fixed`, `Accepted`, `Deferred`, `Not Applicable`.

## Gate output

Backlog Week 2 phải đủ để mỗi item có một verification method, không có item kiểu “fix SEO” chung chung.

Authoritative triage output: `docs/seo/implementation/W1-03-TECHNICAL-TRIAGE.md`.

### Execution result — 2026-10-07

- 10/10 audit findings were triaged against the official W1-02 Screaming Frog baseline.
- Actionable Week 2 implementation: TECH-001, TECH-002, TECH-003, TECH-005, TECH-006, TECH-007.
- TECH-004 is Fixed by owner-confirmed GA4 completion; no duplicate GA4 owner is added, and W3 retains final regression verification.
- Accepted/no-remediation baseline: TECH-008, TECH-009, TECH-010.
- SEO-W2-04 is `NOT_APPLICABLE_BASELINE` because W1-02 found 0 internal 3xx/4xx/5xx and 0 redirect chains; re-open only if later evidence changes.
- Broader sitewide title/meta/H1/ALT cleanup and advanced performance/media work are explicitly Deferred.

## Definition of Done

- [x] Crawl findings triaged.
- [x] Owner assigned.
- [x] False positives/accepted behavior separated.
- [x] Week 2 backlog bounded to current scope.
- [x] Deferred items documented.
