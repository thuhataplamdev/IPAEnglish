# SEO-W2-08 — GA4 Production Setup / Verification

**Timing:** Week 1 access check + Week 2 implementation  
**Owner:** SEO Exec + Dev / Tech Exec  
**Priority:** High  
**Audit mapping:** TECH-004  
**Dependency:** SEO-W1-01

## Objective

Đảm bảo production site gửi page_view vào **business-owned GA4 property** bằng một implementation path duy nhất.

## Known baseline

Audit chưa xác nhận executable GA4/gtag tag trong sampled live HTML.

## Steps

1. Xác định production đang dùng:
   - direct Google tag;
   - GTM;
   - WordPress integration/plugin;
   - theme integration;
   - hay chưa có.
2. Chọn một owner phù hợp với operations hiện tại.
3. Không hardcode thêm tag thứ hai nếu GTM/plugin đã active.
4. Cấu hình production measurement ID qua đúng owner.
5. Purge cache nếu markup thay đổi.
6. Verify:
   - browser Network requests;
   - Tag Assistant/DebugView nếu available;
   - GA4 Realtime;
   - page_location/page_title;
   - four target landing pages.
7. Kiểm tra login/LMS/private flows không gửi sensitive payload.

## Privacy guard

Không gửi:
- credentials;
- learner answers;
- private order notes;
- payment secrets;
- unnecessary personal data.

## Acceptance

- Production page_view visible.
- Target URLs identifiable in GA4.
- No duplicate page_view from two tags.
- Business owner controls property.

## Definition of Done

- [ ] TECH-004 Fixed/Accepted.
- [ ] Production traffic verified.
- [ ] Duplicate tag check passed.
- [ ] Evidence documented without exposing credentials.
