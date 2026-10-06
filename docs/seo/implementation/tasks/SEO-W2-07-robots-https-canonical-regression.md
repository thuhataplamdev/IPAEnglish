# SEO-W2-07 — Robots / HTTPS / Canonical Regression

**Timing:** Week 2 after technical changes  
**Owner:** Dev / Tech Exec  
**Priority:** Low  
**Audit mapping:** TECH-009, TECH-010  
**Source baseline:** ACCEPTED_BASELINE

## Objective

Không redesign các surface đang đúng; chỉ chứng minh rằng Week 2 changes không làm regress robots, HTTPS/canonical-host behavior hoặc canonical output.

## Checks

### robots.txt
- HTTP 200.
- Sitemap directive trỏ đúng native sitemap.
- Không block CSS/JS/image assets cần để render.
- Không dùng robots.txt thay cho noindex.

### HTTPS / host
- HTTP → HTTPS permanent redirect.
- Apex/noncanonical host → selected canonical host theo runtime thực tế.
- Không tạo multi-hop không cần thiết.

> Lưu ý: tracked `.htaccess` chỉ thể hiện HTTPS redirect preserving incoming host. Audit live baseline ghi apex → www 301, nên host normalization có thể nằm ở infrastructure khác. Không sửa `.htaccess` để “đồng bộ” nếu chưa xác định owner runtime.

### Canonical
- Exactly one canonical trên 4 target pages.
- Self-canonical đúng language URL.
- Không thêm custom canonical renderer.
- Canonical target trả 200.

## Definition of Done

- [ ] TECH-009 remains Accepted or changed with evidence.
- [ ] TECH-010 remains Accepted or changed with evidence.
- [ ] No redirect chain introduced.
- [ ] No duplicate canonical introduced.
