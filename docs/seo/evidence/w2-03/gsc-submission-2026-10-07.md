# GSC sitemap submission evidence — 2026-10-07

## Submission result

The project owner submitted `wp-sitemap.xml` in the Google Search Console property for `https://www.ipaenglish.com/` after the production sitemap HTTP-status remediation.

The user-provided GSC screenshot shows the confirmation dialog:

> Đã gửi sơ đồ trang web thành công

This is recorded as **Submitted successfully** for SEO-W2-03 acceptance. The task does not require waiting for Google to index all URLs before closure.

Immediately after submission, the sitemap table still displayed the earlier red status `Không thể tìm nạp` and 0 discovered pages. That table state is recorded as a pre-refresh / prior fetch state and is **not** being represented as a new successful fetch. Final GSC fetch/processing status remains a Week 3 verification item.

## Public runtime re-check

A post-submission anonymous public re-check of `https://www.ipaenglish.com/wp-sitemap.xml` returned:

- HTTP 200;
- `Content-Type: application/xml; charset=UTF-8`;
- parseable sitemap index;
- 4 public child sitemaps;
- all 4 public child sitemaps returned HTTP 200 and parseable XML.

The owner's browser screenshot rendered 7 child sitemap rows, while the anonymous public response used for crawler-facing verification returned 4. The exact session/cache cause of that difference was not established; closure evidence therefore records both observations without assuming they are equivalent. Search-engine-facing runtime verification uses the anonymous public response.

## Screenshot provenance

The screenshots were supplied by the project owner in the operator session on 2026-10-07. They are not copied into the repository, so no authenticated browser/session material is stored here.

No credentials, cookies, verification tokens, or private authentication material are stored in this evidence file.
