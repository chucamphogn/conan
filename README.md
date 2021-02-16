# Đồ án PD03 - Xây dựng website quản lý nội dung từ các đám mây lưu trữ

## Thành viên

- Trương Thái Ngọc - Nhóm trưởng - <truongthaingoc.it@gmail.com>
- Nguyễn Trường An - <nt.an.hutech@gmail.com>
- Trần Duy Anh - <duyanh221299@gmail.com>
- Chu Cẩm Phong - <chucamphong1999@gmail.com>

## Giảng viên hướng dẫn

- Tên giảng viên: TS. Ngô Thanh Hùng
- Địa chỉ email: nt.hung@hutech.edu.vn

## Thời gian thực hiện

- Bắt đầu: 02/02/2021
- Kết thúc: ?

## Hướng dẫn cài đặt môi trường dự án

#### Lưu ý: Bắt buộc phải cài môi trường ảo để thống nhất môi trường lập trình giữa các thành viên.

#### Tuyệt đối không dùng XAMPP, Laragon,... vì những tool này không hỗ trợ đủ.

### 1. Cài đặt [Jetbrains Toolbox](https://www.jetbrains.com/toolbox-app/) (Hỗ trợ cài đặt IDE PHPStorm nhanh chóng)

### 2. Cài đặt [Docker](https://www.docker.com/)

- Sau khi khởi động lại máy sẽ hiện lên bảng "WSL 2 installation is incomplete" báo WSL 2 chưa được cài đặt
- Nhấp vào đường link "https://aka.ms/wsl2kernal" và làm theo bước 4 và 5 trên trang hướng dẫn
- Nhấp chọn Restart để khởi động lại Docker sau khi đã hoàn thành bước trên

### 3. Cài đặt [Windows Terminal](https://www.microsoft.com/en-us/p/windows-terminal/9n0dx20hk701?activetab=pivot:overviewtab)

### 4. Mở Windows Terminal đã cài đặt ở bước 2 và chạy lệnh sau:

```bash
wsl --set-default-version 2
```

### 5. Cài đặt [Ubuntu 20.04](https://www.microsoft.com/en-us/p/ubuntu-2004-lts/9n6svws3rx71?activetab=pivot:overviewtab)

- Ở lần mở đầu tiên Ubuntu sẽ yêu cầu điền username và password, password rất quan trọng nên hãy nhớ
- Sau khi đã thực hiện đầy đủ thì mở Windows Terminal và chạy lệnh sau:

    ```bash
    wsl -l -v
    ```
    
    Nếu kết quả trả về như bên dưới là thành công:
    
    ```bash
      NAME                   STATE           VERSION
    * docker-desktop         Running         2
      docker-desktop-data    Running         2
      Ubuntu-20.04           Stopped         2
    ```
    
    Nếu ở mục Ubuntu-20.04 hiển thị VERSION là 1 thì chạy lệnh sau để chuyển phiên bản sang WSL 2:
    
    ```bash
    wsl --set-version Ubuntu-20.04 2
    ```

### 6. Mở bảng Settings của Docker và tích chọn như bên dưới và nhấn `Apply & Restart`

![image](https://user-images.githubusercontent.com/58473133/108045336-ee835100-7075-11eb-89cd-d3b19688f74a.png)
![image](https://user-images.githubusercontent.com/58473133/108045446-0c50b600-7076-11eb-8bba-9b94dc1adc96.png)

### 7. Tắt toàn bộ những ứng dụng liên quan như Windows Terminal,... và khởi động lại Windows Terminal để cập nhật cấu hình mới

### 8. Sau khi đã khởi động lại Windows Terminal, chuyển sang tab Ubuntu 20.04 như hình

![image](https://user-images.githubusercontent.com/58473133/108045756-68b3d580-7076-11eb-9b73-e9f2c98ca078.png)

### 9. Chạy các lệnh sau để kiểm tra việc cài đặt đã thành công hay chưa

```bash
docker -v
docker-compose -v
```
Nếu kết quả như bên dưới là thành công
```bash
# ...
Docker version 20.10.2, build 2291f61
docker-compose version 1.27.4, build 40524192
# ...
```

### 10. Clone đồ án từ Github

```bash
mkdir ~/PhpStormProjects
cd ~/PhpStormProjects
# Lưu ý: Git được cài đặt sẵn trong Ubuntu 20.04
git clone https://github.com/project-design-03/cloud-storage-all-in-one.git
```
Trong quá trình clone sẽ hỏi tài khoản và mật khẩu thì hãy nhập thông tin tài khoản của Github là được

### 11. Cài đặt thư viện trong đồ án

```bash
cd cloud-storage-all-in-one

# Sẽ mất vài phút tuỳ thuộc vào tốc độ mạng
docker run --rm -v $(pwd):/opt -w /opt laravelsail/php80-composer:latest composer install
```

Sau khi cài xong chạy tiếp lệnh dưới để kiểm tra

```bash
./vendor/bin/sail -v
```

Nếu kết quả trả về như bên dưới là thành công

```bash
docker-compose version 1.27.4, build 40524192
```

### 12. Cài đặt môi trường lập trình

Ở lần đầu tiên thì nó sẽ tự động setup môi trường lập trình cho mình, sẽ mất vài phút tuỳ thuộc vào tốc độ mạng

```bash
./vendor/bin/sail up -d
```

Nếu quá trình diễn ra hoàn tất và trên Windows Terminal hiển thị như bên dưới là thành công
Nếu Docker bị Windows Firewall chặn thì cứ `Allow access`

```bash
# ...
Creating cloud-storage-all-in-one_mysql_1   ... done
Creating cloud-storage-all-in-one_mailhog_1      ... done
Creating cloud-storage-all-in-one_pgsql_1   ... done
Creating cloud-storage-all-in-one_redis_1   ... done
Creating cloud-storage-all-in-one_laravel.test_1 ... done
```

### 13. Cấu hình dự án (Nếu bước này hoàn thành thì có thể truy cập localhost để xem thành quả)

```bash
cp .env.example .env
./vendor/bin/sail artisan key:generate --ansi

# Khởi tạo các tệp tin hỗ trợ PHPStorm
./vendor/bin/sail artisan ide-helper:eloquent
./vendor/bin/sail artisan ide-helper:models -N

# Cài đặt thư viện hỗ trợ front-end
./vendor/bin/sail yarn install
# Build các file cho front-end
./vendor/bin/sail yarn dev

# Migration database và seed data
./vendor/bin/sail artisan migrate:fresh --seed

# Nếu báo lỗi `password authentication failed for user "root"` thì hãy chạy lệnh sau, không thì hãy bỏ qua
./vendor/bin/sail down
docker rm -f $(docker ps -a -q)
docker volume rm $(docker volume ls -q)
# Sau khi chạy xong 3 lệnh trên thì quay lại chạy lại bước `Migration database và seed data`
```

### 14. Mở PHPStorm và open project với đường dẫn từ bước 10

![image](https://user-images.githubusercontent.com/58473133/108048874-24c2cf80-707a-11eb-9986-0bf1ec33dc3d.png)

Để PHPStorm hỗ trợ tốt hơn hãy cài thêm một số plugin sau:
- Laravel (Hỗ trợ Laravel)
- Laravel Idea (Hỗ trợ Laravel)
- Tailwind CSS Smart Completions (Hỗ trợ TailwindCSS)
- Tailwind Formatter (Hỗ trợ TailwindCSS)
- Material Theme UI (Nếu muốn giao diện đẹp)

### 15. Kết nối PHPStorm với cơ sở dữ liệu, PHPStorm đã hỗ trợ kết nối csdl đầy đủ nên không cần cài thêm bất kỳ tool nào như phpmyadmin, sql management,...

![image](https://user-images.githubusercontent.com/58473133/108054206-f268a080-7080-11eb-872a-7de54c2c89f2.png)
![image](https://user-images.githubusercontent.com/58473133/108054321-15935000-7081-11eb-897d-dcc59ed708fb.png)

Ở bước này PHPStorm sẽ yêu cầu tải driver thì cứ bấm tải để PHPStorm tự động tải và nhập đầy đủ thông tin như bên dưới,
sau khi nhập xong nhấn `Test connection` để kiểm tra để xem kết nối được csdl hay chưa, nếu thành công rồi thì bấm `OK`

![image](https://user-images.githubusercontent.com/58473133/108054438-3b205980-7081-11eb-9c4b-598060a72ef6.png)

Sau khi kết nối thành công, PHPStorm sẽ hiện bảng bên dưới để có thể thao tác với csdl

![image](https://user-images.githubusercontent.com/58473133/108054671-889cc680-7081-11eb-922d-1c01eb424d82.png)
![image](https://user-images.githubusercontent.com/58473133/108054830-be41af80-7081-11eb-9124-25778c6f7677.png)

### 16. PHPStorm đã tích hợp sẵn Git nên có thể thao tác trên giao diện thay vì sử dụng lệnh và không cần cài thêm Git lên Windows
