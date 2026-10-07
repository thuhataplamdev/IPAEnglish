# SEO-W2-03 runtime evidence

Captured 2026-10-07 before and after production remediation, including GSC submission closure evidence.

## Before

- `wp-sitemap-before.headers.txt`: public response headers for `/wp-sitemap.xml`; failing baseline is HTTP 404 with XML content type.
- `wp-sitemap-before.xml`: public native WordPress sitemap body captured from the same request.
- `robots-before.txt`: public robots baseline retaining the native sitemap directive.

## After

- `wp-sitemap-after.headers.txt`: public response headers after the WordPress 7.1.1 sitemap-status backport; HTTP 200 with `application/xml`.
- `wp-sitemap-after.xml`: post-deploy native WordPress sitemap index; XML parsing succeeds.
- `child-sitemaps-after.txt`: the anonymous public sitemap index exposed four child sitemaps; all four returned HTTP 200, XML content type, and parsed successfully.
- `robots-after.headers.txt` / `robots-after.txt`: post-deploy robots response; sitemap directive still references `https://www.ipaenglish.com/wp-sitemap.xml`.
- `deployment-verification.txt`: backup, deployed-file hashes, PHP lint, cache purge, and runtime verification summary.
- `gsc-submission-2026-10-07.md`: owner-provided GSC evidence confirming `Đã gửi sơ đồ trang web thành công`, plus the distinction between successful submission and the still-pending refreshed Google fetch/processing state.

The owner's browser screenshot displayed seven child sitemap rows while the anonymous public re-check returned four. The exact session/cache cause was not established; crawler-facing closure verification uses the anonymous public response and records the browser observation separately rather than silently reconciling them.

SEO-W2-03 is closed as **DONE** because implementation, public runtime verification, evidence, documentation, and GSC submission are complete. Final Google fetch/processing/indexing status remains a Week 3 verification item and is not claimed complete here.

No credentials, cookies, verification tokens, or private authentication material are stored here.
