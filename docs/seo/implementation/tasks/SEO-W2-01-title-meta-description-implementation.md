# SEO-W2-01 — Title + Meta Description Implementation

**Timing:** Week 2  
**Owner:** SEO Exec + Dev / Tech Exec  
**Priority:** Medium  
**Audit mapping:** TECH-002, TECH-003  
**Dependencies:** SEO-W1-04, SEO-W1-05

## Objective

Đảm bảo 4 target URLs có Title tiếng Việt phù hợp intent và đúng **một** Meta Description hữu ích, dùng WordPress-native data thay vì tạo SEO subsystem mới.

## Target URLs

- `https://www.ipaenglish.com/vi/`
- `https://www.ipaenglish.com/vi/global-english-for-teen-achievers/`
- `https://www.ipaenglish.com/vi/book-a-test/`
- `https://www.ipaenglish.com/vi/learning-system/`

## Design constraints

- Title: ưu tiên existing WordPress page/site title behavior.
- Meta Description source: WordPress-native Excerpt/summary.
- Meta Description renderer: minimal child-theme `wp_head` integration nếu production chưa có owner khác.
- Canonical vẫn do WordPress core sở hữu.
- Không thêm custom SEO settings screen hoặc `_ipa_seo_*` data model.

## Repository touchpoint

Primary code candidate:

`wp-content/themes/masterstudy-child/functions.php`

Hiện child theme đã có custom functions; mọi thay đổi phải nhỏ, namespaced/prefixed và không ảnh hưởng floating chat code.

## Implementation steps

1. Trước khi code, inspect rendered head của 4 target URLs:
   - đếm `<meta name="description">`;
   - xác định có SEO plugin/runtime owner ngoài repo hay không.
2. Kiểm tra Page post type có Excerpt UI/support không.
3. Nếu chưa:
   - enable native excerpt support cho `page` bằng child theme;
   - không tạo custom post meta.
4. SEO Exec điền approved description vào native Excerpt/summary.
5. Nếu site vẫn không render description:
   - thêm một callback `wp_head`;
   - lấy queried page ID;
   - lấy excerpt;
   - `trim`/sanitize;
   - `esc_attr` trước khi output;
   - nếu excerpt rỗng thì **không output generic description**.
6. Giới hạn behavior để không tạo duplicate nếu runtime owner khác xuất hiện.
7. Title:
   - thử cập nhật WordPress title/translation trong admin trước;
   - nếu visible navigation/template bị tác động không chấp nhận được, dùng smallest document-title filter cho đúng target page;
   - không build parallel title field.
8. Purge cache target URLs + language variants.
9. Recheck rendered HTML.

## Code-level checks

- Function names có prefix `ipaenglish_`.
- Không echo unescaped excerpt.
- Không output description ở admin/feed/private context.
- Không output duplicate description.
- Không add canonical code.

## Validation

For each target URL:

- HTTP 200.
- Exactly one effective `<title>`.
- Exactly one Meta Description.
- Description đúng tiếng Việt và đúng intent.
- Canonical count vẫn = 1.
- English counterpart không bị title override nhầm.
- Language switch vẫn hoạt động.

## Rollback

- Revert child-theme commit.
- Remove/restore affected page excerpt/title values if necessary.
- Purge W3TC/Autoptimize caches.

## Definition of Done

- [ ] TECH-002 Fixed/Accepted with evidence.
- [ ] TECH-003 Fixed/Accepted with evidence.
- [ ] 4 target pages verified in rendered head.
- [ ] No duplicate canonical/description.
- [ ] Audit + Keyword Map updated.
