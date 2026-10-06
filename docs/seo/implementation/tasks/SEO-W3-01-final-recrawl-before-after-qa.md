# SEO-W3-01 — Final Re-crawl + Before/After QA

**Timing:** Week 3 — Early  
**Owner:** SEO Exec + Dev / Tech Exec  
**Priority:** High  
**Dependencies:** all applicable Week 2 tasks

## Objective

Chạy re-crawl có thể so sánh với initial crawl và xác nhận các issue đã đóng đúng bằng runtime evidence.

## Method

1. Dùng cùng Screaming Frog version/config hoặc ghi rõ khác biệt.
2. Crawl cùng canonical host.
3. Export cùng report categories như Week 1.
4. So sánh:
   - internal 404s;
   - redirect chains;
   - missing/duplicate titles;
   - missing/duplicate descriptions;
   - missing H1;
   - image ALT;
   - oversized images;
   - noindex/index mismatch;
   - target-page status;
   - canonical count.
5. Recheck TECH-001 → TECH-010.
6. Issue mới:
   - fix nếu rõ ràng in-scope và nhỏ;
   - nếu lớn, Deferred với reason.

## Target-page HTML matrix

For each of 4 targets capture final:

- HTTP status/final URL;
- Title;
- Meta Description;
- robots;
- canonical;
- H1/H2;
- relevant ALT;
- internal links.

## Definition of Done

- [ ] Re-crawl completed.
- [ ] Before/after metrics filled in audit.
- [ ] Every agreed finding has final status.
- [ ] Regression sample includes English counterpart/private LMS routes where relevant.
