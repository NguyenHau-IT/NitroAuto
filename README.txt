B1: copy file php lưu vào ổ đĩa bất kì(nên chọn ổ C:)
B2: Win + r nhập: sysdm.cpl
B3: chọn Advanced
B4: chọn Environment Variables...
B5: tìm Path trong khung System variables
B6: chọn Browse...
B7: chọn file php đã lưu và thêm dấu \(ví dụ: C:\php\)
B8: chọn ok liên tục
lệnh chạy code nếu file php lưu ổ C
C:\php\php.exe -S localhost:8000
<ổ đĩa lưu file php>:\php\php.exe -S localhost:8000

nếu lỗi quay lại B7 chọn Path lúc nãy chọn Move Up lên tầm giữa cách path khác rồi làm B8