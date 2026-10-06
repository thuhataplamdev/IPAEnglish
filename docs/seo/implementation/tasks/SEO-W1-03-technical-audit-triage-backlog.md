# SEO-W1-03 — Technical Audit Triage & Backlog

**Timing:** Week 1 — Day 2–3  
**Owner:** SEO Exec + Dev / Tech Exec  
**Priority:** High  
**Dependency:** SEO-W1-02

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

## Definition of Done

- [ ] Crawl findings triaged.
- [ ] Owner assigned.
- [ ] False positives/accepted behavior separated.
- [ ] Week 2 backlog bounded to current scope.
- [ ] Deferred items documented.
