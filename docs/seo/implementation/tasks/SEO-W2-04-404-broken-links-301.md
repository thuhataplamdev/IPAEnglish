# SEO-W2-04 — Broken Links / 404 / 301 Remediation

**Timing:** Week 2  
**Owner:** Dev / Tech Exec  
**Priority:** Medium  
**Audit mapping:** TECH-008  
**Dependency:** SEO-W1-03

## Execution status — completed 2026-10-12

W1-02 had no actionable internal 3xx/4xx baseline, but Search Console later surfaced a new exclusion set. W2-04 was therefore re-opened as a bounded indexing-hygiene remediation rather than adding speculative redirects.

- Canonical host/scheme redirects remain intentional and one-hop.
- The obsolete `/stm_lms_course_category/english/` URL remains a proper 404 because no equivalent replacement or literal internal source reference was found.
- Utility/account/demo/feed/author surfaces are now explicitly excluded from native XML sitemap discovery and/or marked `noindex` through a small MU-plugin.
- The four priority SEO URLs remain HTTP 200 and indexable at runtime.
- Evidence: `docs/seo/evidence/w2-04/index-hygiene-2026-10-12.md`.

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

## Implemented remediation

Repository-owned implementation: `wp-content/mu-plugins/ipa-seo-index-hygiene.php`.

The MU-plugin deliberately uses WordPress-native hooks instead of replacing the sitemap subsystem:

- removes operational/template pages from the native `page` sitemap;
- removes the demo `stm-certificates` sitemap provider;
- removes the `users` sitemap provider because author archives are not search landing pages;
- emits native `noindex` plus `X-Robots-Tag: noindex, follow` for explicit utility/feed/author/demo request patterns;
- does not noindex the four priority SEO pages;
- does not redirect the obsolete LMS taxonomy URL to Home or another non-equivalent page.

The cleaned sitemap was re-submitted to GSC on 2026-10-12; Google accepted it and queued a fresh download.

## Evidence

Runtime and GSC evidence is recorded in `docs/seo/evidence/w2-04/index-hygiene-2026-10-12.md` and summarized in `TECHNICAL-SEO-AUDIT.md`.

Fresh URL Inspection on 2026-10-12 found three of the four priority URLs still `Submitted and indexed`. `/vi/book-a-test/` is `Crawled - currently not indexed`, while robots are allowed, indexing is allowed, fetch is successful, and both Google/user canonical point to itself. That is routed to W2-01/W2-02 content/on-page remediation rather than being misclassified as a redirect/robots defect in W2-04.

## Definition of Done

- [x] URL-specific list processed.
- [x] No blanket Home redirect.
- [x] Internal-source search completed; no literal internal source reference to the obsolete LMS taxonomy URL was found.
- [x] Canonical host/scheme moved URLs retain direct one-hop redirects.
- [x] Utility/demo/feed/author sitemap and noindex behavior verified at runtime.
- [x] Four priority URLs verified HTTP 200 and indexable at runtime.
- [x] Cleaned sitemap re-submitted to GSC and fresh URL Inspection captured.
- [x] Evidence ready.
