# SEO-W2-03 — Fix Native Sitemap HTTP 200 + Submit to GSC

**Timing:** Week 2  
**Owner:** Dev / Tech Exec + SEO Exec  
**Priority:** High  
**Audit mapping:** TECH-001  
**Dependency:** SEO-W1-03

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

## Rollback

- Revert rewrite/filter change.
- Restore previous permalink/server config.
- Purge cache.
- Không rollback bằng cách cài sitemap plugin mới.

## Definition of Done

- [ ] TECH-001 Fixed.
- [ ] HTTP 200 verified.
- [ ] XML validity verified.
- [ ] robots.txt directive verified.
- [ ] GSC submission evidence recorded.
