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

2.  Supervisor:
    Cài đặt và cấu hình theo docs: https://laravel.com/docs/7.x/cache
3. Khởi chạy ứng dụng:
    4.1 composer install
    4.2 php artisan migrate --seed
    4.3 Cấp quyền execute "chmod +x /yourfiles.sh"
    và chạy 2 file cấu hình "/yourfiles.sh"
    
    *File cấu hình supervisor trong folder supervisor


-----
Update 08/04/2021
1. /Jobs/CheckNetJob.php
    => Xây dựng tính năng kiểm tra internet access của IP sống (các IP có status == true).
2. Quy trình chạy:
    => /Jobs/CheckHealthJob sẽ chạy đầu tiên nếu IP sống sẽ dispatch job CheckNet => CheckNetJob chạy, kiểm tra và update trạng thái vào cột isInternetConnect = 0(Ko kết nối được) hoặc = 1 (nết kết nối đến internet thành công).
3. CheckNetJob sẽ được chạy tự động khi CheckHealthJob chạy thành công và current_status = 1.