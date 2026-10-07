# SEO-W2-05 — Image Compression / WebP

**Timing:** Week 2  
**Owner:** Dev / Tech Exec  
**Priority:** Medium  
**Audit mapping:** TECH-005  
**Dependency:** SEO-W1-03
**Status:** DONE — single controlled WebP/compression path deployed and runtime-verified on 2026-10-07.

## Objective

Thiết lập **một** controlled image-optimization path để giảm image weight và hỗ trợ WebP/modern delivery mà không làm giảm chất lượng hoặc tạo nhiều pipeline chồng chéo.

## Known baseline

Sample JPG vẫn trả `image/jpeg` với WebP-capable request; audit chưa xác nhận active WebP delivery.

## Implementation steps

1. Inventory plugin/CDN/server image optimization đang thực sự active ở production.
2. Chọn **một owner**:
   - existing trusted image plugin; hoặc
   - server/CDN conversion path;
   - không enable hai hệ thống rewrite/convert đồng thời.
3. Backup/original retention policy.
4. Enable compression mức bảo toàn chất lượng.
5. Generate/serve WebP cho image phù hợp.
6. Không convert SVG/logo theo cách làm hỏng fidelity.
7. Purge page/image cache.
8. Kiểm tra 4 target pages:
   - hero;
   - course images;
   - system illustrations;
   - form/page assets.

## Implementation checkpoint — 2026-10-07

- Production inventory found no dedicated active WebP/image optimizer and no existing Caddy/Nginx WebP rewrite owner. W3 Total Cache and Autoptimize remain in their existing cache/CSS-JS roles.
- Chosen owner: one controlled server-side path. `wp-content/mu-plugins/ipa-image-webp.php` generates `.webp` siblings for JPEG/PNG WordPress media and keeps the original file untouched; Caddy serves the sibling only to clients advertising `image/webp` support and otherwise serves the original.
- No second image optimizer/CDN conversion pipeline was enabled. SVG assets are not converted.
- WebP quality is set to 82 and a generated sibling is kept only when it is smaller than its source.
- Dedicated pre-deploy rollback copies were captured for the Caddy site config and MU-plugin state; the existing database backup job was also run.
- Target-page backfill was intentionally bounded to eligible JPEG/PNG assets referenced by the four priority URLs: 56 files found, 56 generated, 0 skipped; aggregate bytes reduced from 3,382,026 to 1,081,000 (-68.0%). Full historical media-library migration remains out of scope.
- Same-URL negotiation check on `IPA-English-1024x536.jpg`: WebP-capable client received `image/webp` at 34,172 B; fallback client received the original `image/jpeg` at 89,034 B; both returned HTTP 200 with `Vary: Accept`.
- Four-page regression: all target pages returned HTTP 200; 54 unique image URLs produced 0 broken responses; all 51 unique currently referenced upload JPEG/PNG URLs passed modern-WebP and original-fallback checks.
- Dimensions were preserved for generated assets. Six priority-image PSNR samples ranged from 30.40 dB to 42.30 dB. This is an automated fidelity check; no separate human visual sign-off is claimed.
- WordPress object cache and W3 Total Cache were flushed successfully after deployment.
- Existing `WP_DEBUG already defined` warning in `wp-config.php` was observed again and is not introduced by this task.

Evidence: `docs/seo/evidence/w2-05/`.

## Validation

- Modern browser/request nhận WebP khi configured.
- Fallback vẫn hoạt động.
- No broken images.
- No layout shift regression rõ ràng do dimensions bị mất.
- Quality acceptable.
- File weight giảm trên sampled priority images.

## Scope boundary

Không biến task này thành full image-library migration nếu vượt effort; ảnh ngoài target/high-impact có thể Deferred. W2-05 closed with the four target pages plus future-upload generation covered; a historical full-library backfill was not required.

## Definition of Done

- [x] TECH-005 Fixed/Accepted.
- [x] One optimization owner documented.
- [x] WebP/compression verified.
- [x] Target pages functionally regression-tested; automated fidelity/dimension checks recorded.
