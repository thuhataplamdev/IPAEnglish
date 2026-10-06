# SEO-W2-04 — Broken Links / 404 / 301 Remediation

**Timing:** Week 2  
**Owner:** Dev / Tech Exec  
**Priority:** Medium  
**Audit mapping:** TECH-008  
**Dependency:** SEO-W1-03

## Objective

Xử lý broken internal links và redirect hợp lệ dựa trên URL-specific crawl list.

## Decision tree per URL

1. **Link sai nhưng target thực tồn tại**
   - sửa source link trực tiếp;
   - không cần 301 chỉ để bù lỗi nội bộ.
2. **URL cũ đã chuyển sang URL mới tương đương**
   - tạo 301 one-hop old → new;
   - update internal links sang new URL.
3. **Content bị xóa và không có replacement tương đương**
   - giữ proper 404/410;
   - remove broken internal links.
4. **Soft 404 / blanket Home redirect**
   - loại bỏ; không redirect mọi missing URL về Home.

## Implementation surfaces

Tùy root cause:

- WordPress page/menu/Elementor link.
- Plugin/runtime redirect configuration.
- Server rewrite for stable infrastructural redirect.
- `.htaccess` only when this is the correct owner; avoid editing W3TC-generated blocks manually.

## Validation

For each changed URL:

- expected status;
- one-hop redirect;
- destination returns 200;
- no loop;
- no chain;
- internal source now links directly to final URL.

## Evidence

Update `TECHNICAL-SEO-AUDIT.md` with URL/pattern, old status, action, new status and re-crawl verification.

## Definition of Done

- [ ] URL-specific list processed.
- [ ] No blanket Home redirect.
- [ ] Internal broken links fixed.
- [ ] Valid moved URLs have one-hop 301.
- [ ] Re-crawl evidence ready.
