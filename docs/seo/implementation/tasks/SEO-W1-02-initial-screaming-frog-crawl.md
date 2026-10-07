# SEO-W1-02 — Initial Screaming Frog Crawl

**Timing:** Week 1 — Day 1–2  
**Owner:** SEO Exec  
**Priority:** High  
**Status at source baseline:** READY

**Execution date:** 2026-10-07
**Execution result:** `DONE` — official Screaming Frog SEO Spider 24.3 baseline completed and evidence stored in-repo.

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

## Official Screaming Frog crawl — 2026-10-07

Authoritative evidence directory:

`docs/seo/evidence/w1-02/screaming-frog-2026-10-07/`

Recorded configuration:

- Screaming Frog SEO Spider `24.3`.
- Free mode; no licence key stored in the repository.
- Start URL: `https://www.ipaenglish.com/`.
- Spider / standard HTML crawl.
- User-Agent: `Screaming Frog SEO Spider/24.3`.
- Crawl limit: 500 URLs.
- Images enabled.
- No authenticated/private areas.
- External response/redirect signals may be collected, but external URLs are excluded from internal totals.
- First-run EULA acceptance was supplied only after explicit operator consent and only in a temporary runtime home; the RPM and EULA config are not stored in this repository.

Use the same Spider mode, User-Agent, crawl limit, production host and public-auth scope for the W3 comparison crawl.

### Official baseline results

- 142 internal resources; 26 internal HTML pages.
- 0 internal 3xx, 0 internal 4xx and 0 internal 5xx.
- 2 discovered external redirects: Google Maps 301 and Messenger 302.
- 0 redirect chains.
- 0 missing titles.
- 26 duplicate-title rows across 12 duplicate groups, driven primarily by English/Vietnamese page pairs.
- 20 titles under 30 characters; 0 titles over 60 characters.
- 26/26 HTML pages missing Meta Description; 0 duplicate non-empty descriptions.
- 18/26 HTML pages missing H1; 2 pages have multiple H1s.
- 15 unique images in the image report; 12 unique images have missing/empty ALT text across 50 inlink occurrences.
- 0 images have a missing ALT attribute; the missing-ALT problem is empty ALT text on the affected image usages.
- 2 unique images are over 100 kB across 4 inlink occurrences.
- 0 noindex directives in the crawl.
- 0 HTML pages missing a canonical.
- All four required Vietnamese target URLs are present, return HTTP 200, are Indexable, and use self-referencing canonicals.

### Target-page H1 result

Screaming Frog confirms:

- `/vi/` — one H1: `Học Viện Anh Ngữ IPA`.
- `/vi/global-english-for-teen-achievers/` — missing H1.
- `/vi/book-a-test/` — missing H1.
- `/vi/learning-system/` — missing H1.

This resolves the earlier fallback discrepancy: the Teen target is also missing an H1 in the official crawl.

## Independent fallback cross-check

The earlier HTML-only fallback crawl is retained under:

`docs/seo/evidence/w1-02/fallback-2026-10-07/`

It is not the Definition-of-Done evidence. Its main counts were consistent with the official crawl for Meta Description, H1 and missing-ALT occurrence signals.

## Evidence

- Raw Screaming Frog exports: `docs/seo/evidence/w1-02/screaming-frog-2026-10-07/raw/`.
- Deterministic issue slices derived from those exports: `docs/seo/evidence/w1-02/screaming-frog-2026-10-07/derived/`.
- Human-readable evidence summary: `docs/seo/evidence/w1-02/screaming-frog-2026-10-07/README.md`.
- Machine-readable summary: `docs/seo/evidence/w1-02/screaming-frog-2026-10-07/crawl-summary.json`.
- Runtime proof: `docs/seo/evidence/w1-02/screaming-frog-2026-10-07/runtime-proof.txt`.

## Definition of Done

- [x] Crawl config recorded.
- [x] Required exports generated.
- [x] Four target URLs present in crawl.
- [x] High-impact blockers identified.
- [x] Export/evidence reference added to audit document.
