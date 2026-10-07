# SEO-W2-07 evidence — Robots / HTTPS / Canonical Regression

Date: 2026-10-07

## Result

W2-07 passed after one bounded infrastructure correction. Robots and canonical output did not regress. A pre-check exposed an avoidable two-hop redirect only when both scheme and host were noncanonical (`http://ipaenglish.com/...`). Caddy ownership was confirmed and corrected so the tested HTTP/HTTPS apex and HTTP `www` variants now reach the selected `https://www.ipaenglish.com` host in one redirect.

## Robots

- `https://www.ipaenglish.com/robots.txt` → HTTP 200.
- Sitemap directive: `https://www.ipaenglish.com/wp-sitemap.xml`.
- `Disallow: /wp-admin/`; `Allow: /wp-admin/admin-ajax.php`.
- No public CSS/JS/image path is disallowed by the current robots file.
- Sample public CSS, JavaScript and image assets each returned HTTP 200 after the Caddy reload.

## Canonical

Each target returned HTTP 200 and exactly one self-canonical:

- `/vi/` → `https://www.ipaenglish.com/vi/`
- `/vi/global-english-for-teen-achievers/` → `https://www.ipaenglish.com/vi/global-english-for-teen-achievers/`
- `/vi/book-a-test/` → `https://www.ipaenglish.com/vi/book-a-test/`
- `/vi/learning-system/` → `https://www.ipaenglish.com/vi/learning-system/`

All four canonical targets returned HTTP 200. No custom canonical renderer was added.

## Redirect ownership and change

Before remediation:

- `http://ipaenglish.com/...` → Caddy `308` to `https://ipaenglish.com/...` → WordPress `301` to `https://www.ipaenglish.com/...` (2 redirects).
- `https://ipaenglish.com/...` → WordPress `301` to HTTPS `www` (1 redirect).
- `http://www.ipaenglish.com/...` → Caddy `308` to HTTPS `www` (1 redirect).

Runtime owner was `/etc/caddy/conf.d/ipaenglish.caddy`; tracked `.htaccess` was not modified. The Caddy site definition was split so HTTP apex and HTTPS apex redirect directly to HTTPS `www`, while the existing `www` application block retains PHP, WebP negotiation, file serving and zstd/gzip behavior.

After remediation, `/` and all four target paths were tested across HTTP `www`, HTTP apex, HTTPS apex and canonical HTTPS `www`: every noncanonical variant required exactly one redirect and every canonical URL required zero.

## Safety / rollback

- Proposed Caddy config: validated before install.
- Full `/etc/caddy/Caddyfile`: validated after install.
- Caddy reload: successful; service remained active.
- Rollback copy: `/root/backups/ipaenglish/w2-07-20261007-165540/ipaenglish.caddy.before`.
