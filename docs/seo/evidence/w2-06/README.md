# SEO-W2-06 evidence — Cache Ownership + Basic Performance

Date: 2026-10-07

## Production ownership after remediation

- W3 Total Cache: browser-cache module/config only; page cache and minify are OFF.
- Autoptimize: public HTML/CSS/JS optimization; logged-in editors/admins bypass optimization.
- Caddy: runtime zstd/gzip response compression.
- No second page-cache or minification/compression owner was enabled.

## Production changes

Only four ownership-sensitive values changed:

1. `autoptimize_optimize_logged`: `on` → unchecked/empty.
2. `browsercache.html.compression`: `true` → `false`.
3. `browsercache.cssjs.compression`: `true` → `false`.
4. `browsercache.other.compression`: `true` → `false`.

W3TC `pgcache.enabled=false` and `minify.enabled=false` were intentionally preserved. W3TC browser-cache module remains enabled. After the change, Autoptimize, W3TC and WordPress object caches were purged.

## Verification summary

- 4/4 target pages: HTTP 200 after purge.
- Login/account shells tested: `/wp-login.php`, `/user-account/`, `/membership-account/`, `/my-account/`, `/courses/` all remained reachable.
- Booking page `/vi/book-a-test/`: HTTP 200 and form markup still present.
- Language switching isolation: `/` emitted `lang="en-US"`; `/vi/` emitted `lang="vi"` after alternating requests.
- Public optimization stayed active: target HTML still references Autoptimize CSS/JS assets.
- Runtime compression stayed active after W3TC compression was disabled: sampled Autoptimize CSS returned HTTP 200, `Content-Encoding: zstd`, `Vary: Accept-Encoding`, served by Caddy.
- W3TC footer comments can appear when page cache is OFF and therefore are not used as cache-hit evidence.

## Performance diagnostic

Three compressed curl requests were sampled per target before and after the ownership change. Overall median TTFB across all 12 requests was approximately 0.804s before and 0.813s after. The variation is treated as runtime noise; W2-06 makes no public-speed improvement claim.

See `perf-before-after.tsv` for raw timings, `settings-before-after.txt` for selected safe config values, and `runtime-regression.txt` for bounded runtime checks.

## Rollback

Pre-change production artifacts:

- DB backup: `/root/backups/ipaenglish/db/db-2026-10-07-1616.sql.gz`
- W3TC config backup: `/root/backups/ipaenglish/w2-06-20261007-161631/master.php.before`
- Selected settings backup: `/root/backups/ipaenglish/w2-06-20261007-161631/settings-before.json`

Rollback is limited to restoring the selected options/config and purging affected caches.

## Boundaries / deferred

- No real user session was impersonated. Personalized content safety is supported by page cache remaining globally OFF and Autoptimize bypassing logged-in editors/admins; an operator can repeat a real authenticated click-through during W3 QA.
- Sampled Caddy-served static asset had ETag/Last-Modified and compression but no explicit Cache-Control/Expires max-age. A broader Caddy static-cache policy and deeper JS/CSS/Elementor/Core Web Vitals tuning remain a separate performance-hardening scope.
