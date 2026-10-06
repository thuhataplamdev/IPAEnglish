# IPAEnglish SEO Implementation Task Pack

Bộ tài liệu này được tách từ baseline đã merge vào `main` của repository:

- `docs/seo/SEO-SRS.md`
- `docs/seo/SEO-TSD.md`
- `docs/seo/SEO-ESTIMATE.md`
- `docs/seo/TECHNICAL-SEO-AUDIT.md`
- `docs/seo/KEYWORD-MAP.md`

Repository: https://github.com/thuhataplamdev/IPAEnglish

## Kết luận khi rà soát repo

Các tài liệu hiện tại **đã có plan/timeline, responsibility split, audit backlog, keyword map và acceptance criteria**. Vì vậy bộ này **không tạo lại SRS/TSD/Estimate**.

Phần còn thiếu để bắt đầu execution là:

1. một dashboard/index theo task;
2. một file hướng dẫn triển khai chi tiết cho từng task;
3. dependency, evidence, rollback và Definition of Done rõ ràng cho từng task.

## Cấu trúc

- `00-DASHBOARD.md` — dashboard điều phối 3 tuần.
- `SOURCE-MAPPING.md` — liên kết task pack với các tài liệu authority hiện có.
- `tasks/` — 16 task chi tiết, mỗi task là một file độc lập.
- `test_task_pack.py` — focused validation bảo đảm dashboard và task files không bị lệch khi tài liệu được cập nhật.

## Quy ước trạng thái

- `READY` — có thể bắt đầu khi access cần thiết đã sẵn sàng.
- `BASELINE_RESOLVED` — baseline trong tài liệu đã chốt, vẫn cần runtime validation.
- `OPEN` — source audit đang ghi nhận là chưa xử lý.
- `IN_PROGRESS_SOURCE` — source audit đang ghi nhận In Progress.
- `ACCEPTED_BASELINE` — source audit đã Accepted nhưng vẫn phải regression test sau thay đổi.
- `BLOCKED` — phụ thuộc task trước.

## Quy tắc thực thi

- Không xem dashboard này là nguồn thay thế SRS/TSD. Khi xung đột, SRS/TSD trên `main` là authority.
- Mỗi task phải cập nhật evidence vào `TECHNICAL-SEO-AUDIT.md` hoặc `KEYWORD-MAP.md` phù hợp.
- Không commit secret, GSC/GA4 account data, token, measurement credential hoặc thông tin người học vào repository.

## Validation

Sau khi thay đổi dashboard hoặc task files, chạy:

```bash
python3 -m unittest discover -s docs/seo/implementation -p 'test_task_pack.py' -v
```

Validation kiểm tra:

- dashboard có đúng 16 task ID duy nhất;
- mỗi task ID có đúng một file triển khai;
- W1-03 vẫn bao phủ TECH-001 đến TECH-010;
- repository delta của task-pack workflow không vượt ra ngoài `docs/seo/implementation/`.
