#Tool tạo dự án PHP thuần cơ bản v1.4

- Truy cập .env để chỉnh sửa thông tin database

- Các lệnh script hiện có

* composer serve: chạy dự án trên local
* composer public: chạy dự án ở trạng thái public để cho người dùng khác truy cập
  (yêu cầu kết nối chung mạng)

- Làm những bước sau để chạy dự án ở public:

  1. Mở CMD hoặc Terminal -> nhập ipconfig -> Enter
  2. Tìm IPv4 Address -> copy
  3. Truy cập file composer.json và sửa script phần xxx.xx.xx.xxx thành địa chỉ IP của bạn<br>
     "public": "php -S xxx.xx.xx.xxx:8000 routes/web.php -t public"

- Lệnh public chỉ có thời gian chờ là 300s (5 phút), sau đó sẽ tự dừng lệnh
- Nhập php cli.php để xem tất cả các lệnh
