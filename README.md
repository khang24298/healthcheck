#IP SERVER, PORT CHECKING MODULE#

I. **Mô tả tính năng**
    
1. Thêm IP info cần kiểm tra:
    Thông qua HTTP POST <yourhost>/api/add-ip
    - Request data:
    {
        'ip': ip address //ex: 127.0.0.1  -> required
        'port': ip port //ex: 0->65353    -> optional
    }
    - Response trả về ip đã thêm nếu thành công hoặc thông báo lỗi nếu thất bại

2. Kiểm tra thông tin ip:
   Thêm IP info cần kiểm tra thông qua: 
   HTTP GET <yourhost>/api/ip-info/<check-ip>
    
3. Chạy tính năng kiểm tra IP trong background:
    Truy cập HTTP GET <yourhost>/api/check-ip-manual

4. Lấy kết quả Server IP:
    - Lấy IP Server sống: HTTP GET <yourhost>/api/ip-success
    - Lấy IP Server chết: HTTP GET <yourhost>/api/ip-fail
    - Lấy tất cả IP Server : HTTP GET <yourhost>/api/all

5. Cronjob tự động kiểm tra IP mỗi 5 phút.

II.  **Các service cần thiết**

1. Redis:
    Cài đặt và cấu hình theo docs: https://laravel.com/docs/7.x/cache
2. Cronjob:
    Trong thư mục root của ứng dụng:
    - Chạy crontab -e để tạo cronjob
    - Thêm nội dung:
    "5 * * * * cd /your-project-path && php artisan cronip:update >> /dev/null 2>&1"
3.  Supervisor:
    Cài đặt và cấu hình theo docs: https://laravel.com/docs/7.x/cache
4. Khởi chạy ứng dụng:
    4.1 composer install
    4.2 php artisan migrate --seed
    4.3 Cấp quyền execute "chmod +x /yourfiles.sh"
    và chạy 2 file cấu hình "/yourfiles.sh"
    
    *File cấu hình supervisor trong folder supervisor


----
Update 31/03/2021
1. Thiết kế giao diện show kết quả, upload và supervisor
2. Có thể chỉnh sửa supervisor config
3. Thêm cronjob cho double check 
"5 * * * * cd /your-project-path && php artisan cronip:update >> /dev/null 2>&1"
