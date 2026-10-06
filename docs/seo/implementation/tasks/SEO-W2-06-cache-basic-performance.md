# SEO-W2-06 — Cache Ownership + Basic Performance

**Timing:** Week 2  
**Owner:** Dev / Tech Exec  
**Priority:** Medium  
**Audit mapping:** TECH-007  
**Source baseline:** IN_PROGRESS_SOURCE

## Objective

Làm rõ ownership để W3 Total Cache và Autoptimize không thực hiện overlapping transforms, đồng thời có basic before/after performance evidence.

## Ownership baseline

- W3 Total Cache: page cache + browser cache.
- Autoptimize: CSS/JS asset optimization.
- Không bật duplicate page cache/minification ở nhiều owner.

## Repository/runtime notes

`.htaccess` chứa các W3TC-generated blocks. Không hand-edit generated block như một cấu hình lâu dài nếu setting có thể quản lý từ W3TC.

## Steps

1. Capture current W3TC settings.
2. Capture current Autoptimize settings.
3. Identify overlaps:
   - HTML/CSS/JS minify;
   - page cache;
   - compression;
   - lazy loading if another plugin owns it.
4. Chọn owner theo baseline.
5. Apply smallest config changes.
6. Purge caches.
7. Test:
   - four target pages;
   - login;
   - LMS/dashboard private paths;
   - booking/form flow;
   - language switching.
8. Run Lighthouse/equivalent sample before/after on target pages.
9. Record larger JS/CSS/Elementor problems as Deferred.

## Safety checks

- Never publicly cache personalized account/order/dashboard content.
- Language-specific HTML must not cross-contaminate cache.
- SEO metadata update must be visible after purge.

## Rollback

Restore exported/plugin settings; purge all affected caches.

## Definition of Done

- [ ] TECH-007 status updated.
- [ ] Ownership documented.
- [ ] No obvious duplicated transform.
- [ ] Private/auth flows regression tested.
- [ ] Before/after diagnostic sample captured.
