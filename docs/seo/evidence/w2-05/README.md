# SEO-W2-05 image compression / WebP evidence

Captured on 2026-10-07 for the four priority Vietnamese target pages.

## Ownership and implementation

- One controlled server-owned optimization path is active.
- WordPress MU-plugin `wp-content/mu-plugins/ipa-image-webp.php` generates smaller `.webp` siblings for JPEG/PNG media and retains originals for fallback.
- Caddy content-negotiates the same original URL using the request `Accept` header and serves the sibling only when it exists.
- No additional image optimizer plugin/CDN conversion pipeline was enabled.
- SVG/logo assets are not converted.

## Bounded backfill result

- Scope: eligible JPEG/PNG files referenced by the four target pages, not the entire historical media library.
- Files found: 56.
- WebP siblings generated: 56.
- Skipped/failed: 0.
- Original aggregate size: 3,382,026 bytes.
- WebP aggregate size: 1,081,000 bytes.
- Aggregate reduction: 68.0%.
- All generated files retained source dimensions.

## Runtime acceptance

- Same-URL modern request example: `IPA-English-1024x536.jpg` returned HTTP 200, `image/webp`, `Vary: Accept`, 34,172 bytes.
- Fallback request to the same URL returned HTTP 200, `image/jpeg`, `Vary: Accept`, 89,034 bytes.
- Four target pages returned HTTP 200.
- 54 unique image URLs were checked with 0 broken responses.
- 51 unique currently referenced upload JPEG/PNG URLs passed both modern WebP negotiation and original-format fallback.
- Six priority-image PSNR checks ranged from 30.40 dB to 42.30 dB with dimensions preserved. This is an automated fidelity check; no separate human visual sign-off is claimed.
- WordPress object cache and W3 Total Cache flushes returned OK.

`backfill-results.tsv` contains the per-file conversion measurements. `runtime-verification.txt` contains the compact acceptance output. `caddy-webp-snippet.txt` records the non-secret delivery rule used for this task.

## Rollback

The pre-deploy Caddy config and MU-plugin state were copied to `/root/backups/ipaenglish/w2-05-20261007-152116/` on the VPS. Rollback is to restore the saved Caddy site config, remove the W2-05 MU-plugin, remove only the generated `*.jpg.webp` / `*.jpeg.webp` / `*.png.webp` siblings created for this bounded target set, validate/reload Caddy, and retain all originals. Do not delete standalone source `.webp` media.

No credentials, cookies, private keys, verification tokens, or authenticated session material are stored in this evidence package.
