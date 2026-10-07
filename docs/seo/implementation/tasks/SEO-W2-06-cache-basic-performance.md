# SEO-W2-06 — Cache Ownership + Basic Performance

**Timing:** Week 2  
**Owner:** Dev / Tech Exec  
**Priority:** Medium  
**Audit mapping:** TECH-007  
**Source baseline:** IN_PROGRESS_SOURCE
**Status:** DONE — 2026-10-07

## Objective

Làm rõ ownership để W3 Total Cache và Autoptimize không thực hiện overlapping transforms, đồng thời có basic before/after performance evidence.

## Final ownership

- W3 Total Cache: browser-cache module/config only; page cache and minify remain intentionally OFF.
- Autoptimize: public HTML/CSS/JS optimization; logged-in editors/admins are excluded from optimization.
- Caddy: runtime HTTP response compression (`zstd` / `gzip`) and the W2-05 image content negotiation path.
- Không có duplicate page cache/minification/compression owner trong active runtime path.

## Repository/runtime notes

`.htaccess` chứa các W3TC-generated blocks, nhưng production đang được serve bởi Caddy. Không hand-edit generated W3TC block như một cấu hình lâu dài. Runtime verification cho thấy W3TC footer comment vẫn có thể xuất hiện khi `pgcache.enabled=false`, nên footer marker không được dùng làm bằng chứng page cache đang bật.

## Steps

1. Capture current W3TC settings.
2. Capture current Autoptimize settings.
3. Identify overlaps:
   - HTML/CSS/JS minify;
   - page cache;
   - compression;
   - lazy loading if another plugin owns it.
4. Chọn owner theo runtime thực tế.
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

## Implementation result — 2026-10-07

- Before: `pgcache.enabled=false`, `minify.enabled=false`, `browsercache.enabled=true`; all three W3TC browser-cache compression flags were `true`; `autoptimize_optimize_logged="on"`.
- Changed only ownership-sensitive settings:
  - `autoptimize_optimize_logged` → unchecked/empty so logged-in editors/admins bypass Autoptimize;
  - W3TC `browsercache.html.compression`, `browsercache.cssjs.compression`, `browsercache.other.compression` → `false`.
- Kept W3TC page cache OFF rather than enabling public HTML caching on an LMS/account site.
- Kept W3TC minify OFF; Autoptimize remains the only public HTML/CSS/JS optimization owner.
- Kept W3TC browser-cache module enabled; no new Caddy max-age policy was introduced in this task.
- Caddy remains the sole observed runtime compression owner; sampled Autoptimize CSS returned `Content-Encoding: zstd` after W3TC compression flags were disabled.
- Autoptimize, W3TC and WordPress object caches were purged after the setting change.
- Four target pages remained HTTP 200. `/wp-login.php`, `/user-account/`, `/membership-account/`, `/my-account/`, `/courses/` and `/vi/book-a-test/` remained reachable; booking page still exposed form markup.
- English `/` remained `lang="en-US"`; Vietnamese `/vi/` remained `lang="vi"` after alternating requests.
- Equivalent curl diagnostic used three compressed requests per target before and after. Overall 12-request median TTFB was ~0.804s before and ~0.813s after. This task does not claim a speed improvement; the objective was deterministic ownership and regression safety.
- No real user session was impersonated. Auth safety is established here by W3TC page cache remaining globally OFF, the Autoptimize logged-in bypass setting, plus anonymous login/account-shell regression checks. A real authenticated click-through can be repeated in W3 final QA if an operator session is available.

## Safety checks

- Never publicly cache personalized account/order/dashboard content.
- Language-specific HTML must not cross-contaminate cache.
- SEO metadata update must be visible after purge.

## Rollback

Restore the selected Autoptimize/W3TC settings from the pre-change evidence/config backup, then purge Autoptimize, W3TC and WordPress object caches.

## Definition of Done

- [x] TECH-007 status updated.
- [x] Ownership documented.
- [x] No obvious duplicated transform.
- [x] Private/auth safety/regression checked without impersonating a real user session.
- [x] Before/after diagnostic sample captured.
