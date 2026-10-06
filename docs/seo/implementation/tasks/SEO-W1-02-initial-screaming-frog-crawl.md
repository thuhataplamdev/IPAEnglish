# SEO-W1-02 — Initial Screaming Frog Crawl

**Timing:** Week 1 — Day 1–2  
**Owner:** SEO Exec  
**Priority:** High  
**Status at source baseline:** READY

## Objective

Tạo baseline crawl có thể lặp lại để phát hiện 4xx, redirect, Title/Description, H1, ALT, canonical, directives và các vấn đề kỹ thuật trong scope.

## Target URLs

- `https://www.ipaenglish.com/vi/`
- `https://www.ipaenglish.com/vi/global-english-for-teen-achievers/`
- `https://www.ipaenglish.com/vi/book-a-test/`
- `https://www.ipaenglish.com/vi/learning-system/`

## Crawl configuration

1. Start URL: `https://www.ipaenglish.com/`.
2. Crawl canonical production host trước; external links chỉ thu thập để kiểm tra broken outbound nếu cần, không đưa vào internal totals.
3. Giữ cùng một user-agent/config cho initial crawl và re-crawl.
4. Bật crawl images để kiểm tra ALT và kích thước.
5. Không đăng nhập vào LMS/private areas cho baseline public crawl.
6. Nếu HTML source không phản ánh nội dung do JS:
   - lưu crawl HTML-only trước;
   - chạy JavaScript rendering sample riêng cho 4 target URLs;
   - không thay đổi mode giữa before/after mà không ghi chú.

## Required exports

- Internal HTML.
- Response Codes / Client Error (4xx).
- Redirection (3xx) + redirect chains.
- Page Titles: Missing, Duplicate, Over/Under length as signals.
- Meta Description: Missing, Duplicate.
- H1: Missing, Multiple.
- Images: Missing ALT, large/oversized candidates.
- Canonicals.
- Directives / noindex.
- Inlinks for each actionable broken URL.

## Triage rules

- Crawl finding không tự động là defect.
- Private/auth/transactional URLs có thể hợp lệ khi noindex/excluded.
- Không tạo 301 về Home cho mọi 404.
- Không sửa English pages theo keyword scope; chỉ dùng chúng làm regression samples.

## Evidence

Ghi file/export name, crawl date, Screaming Frog version và tổng số URL vào `TECHNICAL-SEO-AUDIT.md`.

## Definition of Done

- [ ] Crawl config recorded.
- [ ] Required exports generated.
- [ ] Four target URLs present in crawl.
- [ ] High-impact blockers identified.
- [ ] Export/evidence reference added to audit document.
