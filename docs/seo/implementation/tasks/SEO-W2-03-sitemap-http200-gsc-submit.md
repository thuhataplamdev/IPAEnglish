# SEO-W2-03 — Fix Native Sitemap HTTP 200 + Submit to GSC

**Timing:** Week 2  
**Owner:** Dev / Tech Exec + SEO Exec  
**Priority:** High  
**Audit mapping:** TECH-001  
**Dependency:** SEO-W1-03
**Status:** DONE — production sitemap runtime fixed and verified; Google Search Console accepted the sitemap submission on 2026-10-07. Final Google fetch/processing status remains a Week 3 verification item.

## Objective

Giữ WordPress core là sitemap owner duy nhất và sửa `/wp-sitemap.xml` từ trạng thái **XML body + HTTP 404** thành **valid XML + HTTP 200**, sau đó submit vào GSC.

## Known baseline

- `https://www.ipaenglish.com/wp-sitemap.xml`
- Body có sitemap XML.
- HTTP status đang được audit ghi là 404.
- `robots.txt` đã reference endpoint này.
- Không được cài thêm sitemap owner chỉ để che lỗi status.

## Diagnostic sequence

1. Reproduce:
   - status;
   - headers;
   - content type;
   - body.
2. Bypass cache/CDN nếu có cách an toàn để xác định layer trả 404.
3. Kiểm tra WordPress permalink/rewrite state.
4. Kiểm tra liệu `wp-sitemap.xml` route được WordPress xử lý nhưng status bị set lại bởi:
   - theme/plugin `status_header`/404 handling;
   - server rewrite;
   - cache layer;
   - stale rewrite rules.
5. Flush rewrite rules qua WordPress admin/CLI **chỉ sau khi xác định an toàn**; không gọi flush trên mọi request trong code.
6. Nếu code fix cần thiết:
   - sửa root cause nhỏ nhất;
   - không tạo sitemap custom thứ hai.
7. Purge relevant cache.
8. Verify endpoint.

## Implementation checkpoint — 2026-10-07

- Reproduced production `/wp-sitemap.xml`: valid WordPress sitemap XML body with HTTP 404 and XML content type.
- Confirmed `/robots.txt` still references the native sitemap.
- Root cause matches WordPress Core #65945: WordPress 7.1 `WP::handle_404()` can mark valid native sitemap routes as 404 when the main query has no published posts.
- Backported the official WordPress 7.1.1 fix from the upstream package into only:
  - `wp-includes/class-wp.php`;
  - `wp-includes/sitemaps/class-wp-sitemaps.php`.
- No second sitemap owner/plugin is introduced.
- Production deploy completed after verified database + source backups and dedicated rollback copies of the two replaced core files.
- Both deployed files match the intended upstream WordPress 7.1.1 backport hashes and pass PHP lint.
- WordPress object cache and W3 Total Cache were purged successfully.
- Production `/wp-sitemap.xml` now returns HTTP 200 with `application/xml`; the sitemap index parses successfully.
- Anonymous public verification returns four public child sitemaps; all four return HTTP 200 with XML content type, parse successfully, and use the HTTPS canonical host.
- `/robots.txt` still references `https://www.ipaenglish.com/wp-sitemap.xml`.
- The project owner submitted `wp-sitemap.xml` in GSC and the UI confirmed `Đã gửi sơ đồ trang web thành công` on 2026-10-07.
- Immediately after the successful submission confirmation, the GSC table still displayed the previous `Không thể tìm nạp` state. This is not claimed as a successful Google fetch; final processing/fetch status is deferred to W3 verification.
- Owner browser evidence displayed seven child sitemap rows while anonymous public verification returned four. The exact session/cache reason is not assumed; both observations are recorded in evidence.

Evidence: `docs/seo/evidence/w2-03/`.

## Acceptance

- Status 200.
- XML parses.
- Correct XML content type.
- URLs dùng HTTPS/canonical host.
- Không có private/noindex/error URLs rõ ràng.
- `robots.txt` vẫn reference sitemap.
- GSC receives submission.

## GSC step

SEO Exec submit sitemap sau khi HTTP 200 đã pass. Ghi trạng thái `Submitted / Received / Processing / Success` theo trạng thái thực tế, không chờ Google index toàn bộ để close project.

Recorded state for W2-03 closure: **Submitted successfully on 2026-10-07**. Google fetch/processing/indexing is not claimed complete and remains part of W3 verification.

## Rollback

- Revert rewrite/filter change.
- Restore previous permalink/server config.
- Purge cache.
- Không rollback bằng cách cài sitemap plugin mới.

## Definition of Done

- [x] TECH-001 Fixed.
- [x] HTTP 200 verified.
- [x] XML validity verified.
- [x] robots.txt directive verified.
- [x] GSC submission evidence recorded.
