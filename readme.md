## Mutiple-choice Questions Management

### Description

Ứng dụng quản lý đề thi chắc nghiệm online gồm những chức năng:
* Quản lý sinh viên.
* Quản lý đề thi trắc nghiệm online.
* Chấm điểm bài thi.
* Phân quyền người dùng tương ứng vơi từng vai trò.
* ...................................

### Components
* Ứng dụng xây dựng dựa trên framework [laravel 5.6](https://laravel.com/) và các package hỗ trợ khác
* Sử dụng hệ quản trị cơ sở dữ liệu mariaDB

### Slack Channel

Please join us in our Slack channel to get faster responses to your questions. Get your invite here: https://laravel-5-boilerplate.herokuapp.com

### Prerequisite
Để chạy được ứng dụng trước tiên cần cài đặt những thành phần sau:
* PHP, Mysql, Webserver (Xampp, Lampp, ...).
* [Composer](https://getcomposer.org/)
* [Node](https://getcomposer.org/)
### Install
Sau đây là các bước cài đặt ứng dụng trên local:
* Bước 1: Clone (download) project về máy và lưu trong websever.
* Bước 2: Tạo file .env, sau đó copy toàn bộ file .env.example vào file .env vừa tạo.
* Bước 3: Từ command line, gõ lệnh: **php artisan key:generate**
* Bước 4: Từ command line, gõ lệnh **composer install**
* Bước 5: Từ command line, gõ lệnh **composer dump-autoload**
* Bước 6: Cài đặt thư viện node bằng command: **npm install**
* Bước 7: Chạy commond: **npm run dev**
* Bước 8: Sau khi khởi tạo database, tiến hành cấu hình database trong file .env như sau:
    * DB_CONNECTION=mysql
    * DB_HOST=YOUR_IP (127.0.0.1 nếu local)
    * DB_PORT=PORT_DATABASE (Mặc định 3306)
    * DB_DATABASE=DATABASE_NAME
    * DB_USERNAME=USERNAME
    * DB_PASSWORD=PASSWORD
* Bước 9: Thực hiện lệnh: **php artisan migrate** để tạo các bảng trong database.
* Bước 10: Gõ lần lượt các lệnh sau 
    * **php artisan db:seed --class=PermisionRoleTableSeeder**
    * **php artisan db:seed --class=UserRoleTable**
    * **php artisan db:seed --class=UsersTableSeeder**
* Bước 11: Đăng nhập thử tài khoản vừa tạo trong database (các tài khoản đều có mật khẩu là **secret**)
### License
