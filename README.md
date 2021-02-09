## Đồ án PD03 - Xây dựng website quản lý nội dung từ các đám mây lưu trữ

### Thành viên

- Trương Thái Ngọc - Nhóm trưởng - <truongthaingoc.it@gmail.com>
- Nguyễn Trường An - <nt.an.hutech@gmail.com>
- Trần Duy Anh - <duyanh221299@gmail.com>
- Chu Cẩm Phong - <chucamphong1999@gmail.com>

### Giảng viên hướng dẫn

- Tên giảng viên: TS. Ngô Thanh Hùng
- Địa chỉ email: nt.hung@hutech.edu.vn

### Thời gian thực hiện

- Bắt đầu: 02/02/2021
- Kết thúc: ?

### Hướng dẫn cài đặt môi trường dự án

1. Công cụ cần thiết (Cài đặt theo thứ tự bên dưới)
    - [WSL 2](https://docs.microsoft.com/en-us/windows/wsl/install-win10)
    - [Docker](https://www.docker.com/)
    - [Windows Terminal](https://www.microsoft.com/vi-vn/p/windows-terminal/9n0dx20hk701)
    - [Ubuntu 20.04](https://www.microsoft.com/en-us/p/ubuntu-2004-lts/9n6svws3rx71?activetab=pivot:overviewtab)
        - Lưu ý: Sau khi hoàn tất cài Ubuntu 20.04 thì hãy vào Docker ở mục `WSL INTEGRATION` và chọn `Ubuntu-20.04` như
          hình bên dưới
          ![image](https://user-images.githubusercontent.com/58473133/107377080-29890000-6b1d-11eb-93ba-9055ea9afc76.png)
        - Cấu hình trên chỉ hiện khi đã chỉnh lên WSL 2
    - [Git: Đã được cài sẵn khi cài Ubuntu 20.04](https://github.com/project-design-03/cloud-storage-all-in-one)
    - [PhpStormProjects](https://www.jetbrains.com/toolbox-app/)
        - Nên sử dụng PhpStorm vì nó hỗ trợ rất tốt cho ngôn ngữ PHP, vì Laravel sử dụng Reflection rất nhiều nên nếu sử
          dụng những loại như Visual studio code thì khả năng hỗ trợ hoàn thành code không được tốt bằng PhpStorm
        - Sau khi cài PhpStorm thì hãy cài thêm một số plugin sau:
            - Laravel (Hỗ trợ Laravel)
            - Laravel Idea (Hỗ trợ Laravel)
            - Tailwind CSS Smart Completions (Hỗ trợ TailwindCSS)
            - Tailwind Formatter (Hỗ trợ TailwindCSS)
            - Material Theme UI (Nếu muốn giao diện PhpStorm đẹp thì cài không thì thôi)
    - [DataGrip](https://www.jetbrains.com/toolbox-app/)
        - Vì sẽ không dùng PhpMyAdmin nên sẽ dùng DataGrip thay thế, DataGrip có thể kết nối đến mọi cơ sở dữ liệu không
          riêng gì MySQL
2. Clone project về máy tính, lưu ý hiện tại đang làm việc trên môi trường Ubuntu nên hãy clone vào thư mục bất kỳ miễn
   thuộc về Ubuntu. Ví dụ ở đây sẽ clone vào thư mục `~/PhpStormProjects/cloud-storage-all-in-one` (Sử dụng Windows
   Terminal để chạy lệnh git
   ```bash
   # Tạo thư mục ~/PhpStormProjects
   mkdir ~/PhpStormProjects
   
   # Trỏ đến thư mục ~/PhpStormProjects
   cd ~/PhpStormProjects
   
   # Clone project về
   git clone https://github.com/project-design-03/cloud-storage-all-in-one.git
   ```
   ##### Không được phép clone vào các thư mục thuộc Windows vì sẽ làm giảm tốc độ xử lý do sự khác nhau giữa Linux và Windows

3. Sau khi đã clone về xong thì hãy trỏ vào thư mục project và chạy lệnh sau để bắt đầu cài đặt các thư viện của project

    ```bash
    docker run --rm \
        -v $(pwd):/opt \
        -w /opt \
        laravelsail/php80-composer:latest \
        bash -c "composer install"
    
    # Nếu có yêu cầu nhập mật khẩu thì hãy nhập mật khẩu mà đã đặt khi cài đặt Ubuntu
    sudo chown -R $USER: .
    ```

4. Sau khi đã chạy xong lệnh trên thì chạy tiếp lệnh dưới đây:

    ```bash
    # Bước 1: Khởi chạy các dịch vụ để hỗ trợ chạy dự án (Sẽ mất khá nhiều thời gian ở lần đầu tiên)
    ./vendor/bin/sail up -d
    
    # Bước 2: Tạo application key cho dự án
    ./vendor/bin/sail artisan key:generate --ansi
    
    # Bước 3: Cài đặt các thư viện hỗ trợ front-end
    ./vendor/bin/sail artisan yarn install
    
    # Bước 4: Build các file hỗ trợ front-end sang css, js,...
    ./vendor/bin/sail artisan yarn dev
    
    # Bước 5: Khởi tạo các bảng trong cơ sở dữ liệu
    # --seed: Có nghĩa sẽ khởi tạo luôn các tài khoản đã được cấu hình sẵn, nếu bỏ đi sẽ chỉ tạo các bảng mà không tạo dữ liệu
    ./vendor/bin/sail artisan migrate:fresh --seed
    ```

5. Mở project trên PhpStorm và bắt đầu lập trình 🙄
