# SEO-W2-05 — Image Compression / WebP

**Timing:** Week 2  
**Owner:** Dev / Tech Exec  
**Priority:** Medium  
**Audit mapping:** TECH-005  
**Dependency:** SEO-W1-03

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

## Validation

- Modern browser/request nhận WebP khi configured.
- Fallback vẫn hoạt động.
- No broken images.
- No layout shift regression rõ ràng do dimensions bị mất.
- Quality acceptable.
- File weight giảm trên sampled priority images.

## Scope boundary

Không biến task này thành full image-library migration nếu vượt effort; ảnh ngoài target/high-impact có thể Deferred.

## Definition of Done

- [ ] TECH-005 Fixed/Accepted.
- [ ] One optimization owner documented.
- [ ] WebP/compression verified.
- [ ] Target pages visually/functionally regression-tested.
