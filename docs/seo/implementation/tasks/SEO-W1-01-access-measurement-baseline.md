# SEO-W1-01 — Access & Measurement Baseline

**Timing:** Week 1 — Day 1  
**Owner:** SEO Exec  
**Priority:** High  
**Status at source baseline:** READY

## Objective

Xác nhận các quyền truy cập và measurement surfaces bắt buộc trước khi triển khai: WordPress Admin, Google Search Console, GA4 và quyền truy cập production/staging cần thiết.

## Inputs

- `docs/seo/TECHNICAL-SEO-AUDIT.md`
- `docs/seo/SEO-SRS.md`
- Business-owned Google account
- WordPress Admin / deployment access

## Implementation steps

1. Xác nhận production canonical origin là `https://www.ipaenglish.com`.
2. Xác nhận GSC property:
   - ưu tiên Domain property `ipaenglish.com` nếu business đã có;
   - ghi trạng thái Owner/Full user;
   - không lưu verification token/credential vào repo.
3. Xác nhận GA4:
   - business-owned property;
   - production Web Data Stream;
   - measurement đang nhận hay chưa nhận traffic.
4. Xác nhận WordPress Admin có thể sửa:
   - page title/excerpt;
   - Elementor/page content;
   - plugin/runtime config cần cho cache/image;
   - permalink/rewrite nếu cần xử lý sitemap.
5. Ghi rõ access nào thiếu và người cần cấp.
6. Cập nhật phần Audit metadata + GSC/GA4 handover trong `TECHNICAL-SEO-AUDIT.md`.

## Evidence

- GSC property name/type + access status.
- GA4 property/data-stream status (không commit secret).
- Dated note: access verified / missing / waiting owner.
- WordPress access capabilities verified.

## Validation

- Có thể xem GSC Search Performance/Page Indexing/Sitemaps.
- Có thể xem GA4 Realtime hoặc xác định rõ vì sao chưa có data.
- Có account owner rõ ràng cho mỗi Google property.

## Rollback

Không có runtime mutation bắt buộc. Nếu task chỉ kiểm tra access, không cần rollback.

## Definition of Done

- [ ] GSC access state documented.
- [ ] GA4 access state documented.
- [ ] WordPress/deployment access state documented.
- [ ] Missing access has owner + next action.
- [ ] No credential/token committed.
