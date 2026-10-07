# SEO-W1-05 — Target-page On-page Baseline

**Timing:** Week 1 — Day 4–5  
**Owner:** SEO Exec  
**Priority:** High
**Execution date:** 2026-10-07
**Execution result:** DONE

## Objective

Ghi lại trạng thái trước thay đổi cho 4 target URLs để Week 2 có thể sửa chính xác và Week 3 so sánh before/after.

## Target URLs

- `https://www.ipaenglish.com/vi/`
- `https://www.ipaenglish.com/vi/global-english-for-teen-achievers/`
- `https://www.ipaenglish.com/vi/book-a-test/`
- `https://www.ipaenglish.com/vi/learning-system/`

## Capture for each URL

- Final URL + HTTP status + redirect chain.
- Rendered `<title>`.
- Meta Description count/value.
- Canonical count/value.
- Robots meta.
- H1 count/value.
- Relevant H2s.
- Priority image ALT values.
- Opening/sapo text and local/service context.
- Internal links to/from relevant pages.
- Existing language switch behavior.

## Known baseline cues

- Meta Description thiếu trên cả 4 target pages.
- `/vi/` có một H1 (`Học Viện Anh Ngữ IPA`); Teen, Book a Test và Learning System đều thiếu H1.
- Teen, Book a Test và Learning System hiện dùng H2 làm heading chính của nội dung.
- Một số Vietnamese target titles vẫn là generic English titles.
- Cả 4 target pages đều HTTP 200, Indexable trong W1-02 và self-canonical; không thêm canonical renderer thứ hai.
- Runtime capture xác nhận language switch từ bản Vietnamese sang English counterpart tương ứng.

## Evidence format

Mỗi URL có row trong `TECHNICAL-SEO-AUDIT.md` và mapping tương ứng trong `KEYWORD-MAP.md`.

Retained W1-05 evidence:

- `docs/seo/evidence/w1-05/runtime-2026-10-07/README.md`
- `docs/seo/evidence/w1-05/runtime-2026-10-07/html-manifest.csv`
- `docs/seo/evidence/w1-05/runtime-2026-10-07/target-page-baseline.csv`
- `docs/seo/evidence/w1-05/runtime-2026-10-07/images-alt.csv`
- `docs/seo/evidence/w1-05/runtime-2026-10-07/target-link-matrix.csv`

The public HTML bodies are represented by exact byte length + SHA-256 in the manifest and by retained structured SEO/runtime extracts. No authentication material, cookies or private headers are stored.

## Execution notes

- Direct requests to all 4 target URLs returned HTTP 200 with no redirect chain.
- Runtime title/meta/canonical/H1/H2 values match the official W1-02 Screaming Frog baseline where fields overlap.
- Browser-JavaScript title mutation was not separately observed because a browser renderer was not available; the public runtime/server HTML title is retained and no discrepancy with Screaming Frog was found.
- W1-04 keyword finalization remains separate and still gates W2-01/W2-02; W1-05 only freezes the before-state.

## Definition of Done

- [x] All 4 pages captured.
- [x] HTML/runtime evidence retained.
- [x] Baseline values entered into Keyword Map/Audit.
- [x] Any unknown is explicit, not guessed.
