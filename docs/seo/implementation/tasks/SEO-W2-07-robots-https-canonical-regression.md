# SEO-W2-07 — Robots / HTTPS / Canonical Regression

**Timing:** Week 2 after technical changes  
**Owner:** Dev / Tech Exec  
**Priority:** Low  
**Audit mapping:** TECH-009, TECH-010; redirect regression guard also covers TECH-008
**Source baseline:** ACCEPTED_BASELINE
**Status:** DONE — 2026-10-07

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

## Implementation result — 2026-10-07

- `robots.txt` remains HTTP 200 and still references `https://www.ipaenglish.com/wp-sitemap.xml`; its only disallow is `/wp-admin/` with `/wp-admin/admin-ajax.php` explicitly allowed. Sample public CSS, JS and image assets all returned HTTP 200.
- All four target pages return HTTP 200, emit exactly one canonical, self-canonicalize to the HTTPS `www.ipaenglish.com` URL, and each canonical target returns HTTP 200.
- Pre-check found one infrastructure-only two-hop chain for the combined noncanonical scheme/host case: `http://ipaenglish.com/...` → Caddy 308 to `https://ipaenglish.com/...` → WordPress 301 to `https://www.ipaenglish.com/...`.
- Redirect ownership was confirmed in `/etc/caddy/conf.d/ipaenglish.caddy`; `.htaccess` was not changed. Caddy was updated so both HTTP apex and HTTPS apex redirect directly to the selected HTTPS `www` host.
- Caddy config was validated before and after deployment, reloaded successfully, and a rollback copy was captured at `/root/backups/ipaenglish/w2-07-20261007-165540/`.
- Post-change checks show all tested noncanonical host/scheme variants for `/` and the four target pages converge to the canonical HTTPS `www` URL in one redirect; canonical URLs require zero redirects.

## Definition of Done

- [x] TECH-009 remains Accepted with fresh runtime evidence.
- [x] TECH-010 remains Accepted with fresh runtime evidence.
- [x] No unnecessary redirect chain remains in the tested host/scheme variants.
- [x] No duplicate canonical introduced.
