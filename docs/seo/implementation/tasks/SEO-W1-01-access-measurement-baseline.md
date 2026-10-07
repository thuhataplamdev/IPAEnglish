# SEO-W1-01 — Access & Measurement Baseline

**Timing:** Week 1 — Day 1  
**Owner:** SEO Exec  
**Priority:** High  
**Status at source baseline:** READY

**Execution date:** 2026-10-06 to 2026-10-07
**Execution result:** `DONE` — public/runtime baseline captured and private access/operations surfaces owner-confirmed.

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

## Execution record — 2026-10-06 to 2026-10-07

### Public/runtime checks completed

- Production canonical chain verified:
  - `http://ipaenglish.com/` -> HTTPS via 308;
  - `https://ipaenglish.com/` -> `https://www.ipaenglish.com/` via 301;
  - `https://www.ipaenglish.com/` returns HTTP 200.
- `https://www.ipaenglish.com/robots.txt` returns HTTP 200 and references `/wp-sitemap.xml`.
- `https://www.ipaenglish.com/wp-admin/` redirects to the WordPress login page. This public check only proved endpoint reachability; authenticated WordPress access was later owner-confirmed on 2026-10-07.
- Public home-page HTML did not expose an executable GA4/GTM implementation signal during the 2026-10-06 check. GA4 setup/access was later owner-confirmed on 2026-10-07, so the earlier HTML sample is retained only as dated baseline evidence.

### Confirmed private-access / operations state — 2026-10-07

| Surface | Status | Evidence / next action |
|---|---|---|
| GSC | Confirmed | Production GSC setup/access owner-confirmed complete. Keep verification token/credentials out of the repository. |
| GA4 | Confirmed | Production GA4 property/data-stream setup/access owner-confirmed complete. Runtime/event verification remains a later QA concern, not a W1-01 blocker. |
| WordPress Admin | Confirmed | Authenticated WordPress administration access is available. Verify task-specific plugin/permalink permissions only when needed. |
| VPS access | Confirmed | SSH. |
| Web server / exposure | Confirmed | Nginx is present; deployment is performed on the VPS and production is exposed through Caddy. |
| WordPress production path | Confirmed | `/srv/app/IPAEnglish` |
| Backup | Confirmed | Source code and database are backed up using a system timer. |
| Domain / DNS | Confirmed | Managed in Squarespace. |

The detailed baseline is recorded in `docs/seo/TECHNICAL-SEO-AUDIT.md` section 1.1 and section 6.

## Validation

- GSC setup/access state is owner-confirmed and documented.
- GA4 setup/access state is owner-confirmed and documented.
- WordPress, VPS, production path, proxy/exposure, backup, and DNS ownership are documented without storing credentials.

## Rollback

Không có runtime mutation bắt buộc. Nếu task chỉ kiểm tra access, không cần rollback.

## Definition of Done

- [x] GSC access state documented.
- [x] GA4 access state documented.
- [x] WordPress/deployment access state documented.
- [x] Infrastructure and DNS ownership documented.
- [x] No credential/token committed in the W1-01 documentation change.

> W1-01 is complete. SEO-W1-02 — Initial Screaming Frog Crawl is the next execution task. Server-specific implementation details should be discovered only when a later technical task actually requires them.
