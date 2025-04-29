<?php
$host = 'localhost';
$username = 'root';
$password = '';

// Tạo kết nối MySQL
$conn = new mysqli($host, $username, $password);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Tạo database nếu chưa tồn tại
$sql = "CREATE DATABASE IF NOT EXISTS c07";
if ($conn->query($sql) === TRUE) {
    echo "Database c07 đã được tạo hoặc đã tồn tại<br>";
} else {
    echo "Lỗi tạo database: " . $conn->error . "<br>";
}

// Chọn database
$conn->select_db("c07");

// Xóa bảng cũ nếu tồn tại
$sql = "DROP TABLE IF EXISTS news";
$conn->query($sql);

// Tạo bảng news
$sql = "CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image_url VARCHAR(255),
    category VARCHAR(50),
    is_featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    views INT DEFAULT 0,
    comments INT DEFAULT 0,
    excerpt TEXT,
    highlights TEXT
)";

if ($conn->query($sql) === TRUE) {
    echo "Bảng news đã được tạo<br>";
} else {
    echo "Lỗi tạo bảng news: " . $conn->error . "<br>";
}

// Xóa bảng cũ nếu tồn tại
$sql = "DROP TABLE IF EXISTS sanpham";
$conn->query($sql);

// Tạo bảng sanpham
$sql = "CREATE TABLE sanpham (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    product_price DECIMAL(10,2) NOT NULL,
    product_image VARCHAR(255),
    product_description TEXT,
    category VARCHAR(50),
    link VARCHAR(255)
)";

if ($conn->query($sql) === TRUE) {
    echo "Bảng sanpham đã được tạo<br>";
} else {
    echo "Lỗi tạo bảng sanpham: " . $conn->error . "<br>";
}

// Xóa bảng cũ nếu tồn tại
$sql = "DROP TABLE IF EXISTS users";
$conn->query($sql);

// Tạo bảng users
$sql = "CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    full_name VARCHAR(100),
    address TEXT,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Bảng users đã được tạo<br>";
} else {
    echo "Lỗi tạo bảng users: " . $conn->error . "<br>";
}

// Xóa bảng cũ nếu tồn tại
$sql = "DROP TABLE IF EXISTS cart";
$conn->query($sql);

// Tạo bảng cart
$sql = "CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES sanpham(product_id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Bảng cart đã được tạo<br>";
} else {
    echo "Lỗi tạo bảng cart: " . $conn->error . "<br>";
}

// Thêm dữ liệu mẫu cho bảng news
$sql = "INSERT INTO news (title, content, image_url, category, is_featured, excerpt, highlights) 
VALUES 
('Mùa dâu tây Đà Lạt bắt đầu', 'Mùa dâu tây Đà Lạt năm nay đã bắt đầu với những trái dâu tươi ngon, đỏ mọng. Nông dân đang thu hoạch những lứa dâu đầu tiên với chất lượng tốt.', 'dau-tay-dalat.jpg', 'Trái cây', 1, 'Mùa dâu tây Đà Lạt năm nay đã bắt đầu với những trái dâu tươi ngon, đỏ mọng.', '1. Dâu tây Đà Lạt đang vào mùa\n2. Chất lượng dâu năm nay rất tốt\n3. Giá dâu ổn định'),
('Xoài cát Hòa Lộc chính vụ', 'Xoài cát Hòa Lộc đang vào mùa chính vụ với hương vị thơm ngon đặc trưng. Nông dân đang thu hoạch những trái xoài chất lượng cao.', 'xoai-cat-hoa-loc.jpg', 'Trái cây', 0, 'Xoài cát Hòa Lộc đang vào mùa chính vụ với hương vị thơm ngon đặc trưng.', '1. Xoài cát Hòa Lộc chính vụ\n2. Hương vị thơm ngon đặc trưng\n3. Chất lượng cao')
ON DUPLICATE KEY UPDATE id=id";

if ($conn->query($sql) === TRUE) {
    echo "Dữ liệu mẫu cho bảng news đã được thêm vào<br>";
} else {
    echo "Lỗi thêm dữ liệu vào bảng news: " . $conn->error . "<br>";
}

// Thêm dữ liệu mẫu cho bảng sanpham
$sql = "INSERT INTO sanpham (product_name, product_price, product_image, category, link) 
VALUES 
('Dâu tây', 150000, 'dautay.jpg', 'Trái cây', 'dau-tay'),
('Xoài cát', 80000, 'xoai-cat.jpg', 'Trái cây', 'xoai-cat'),
('Dưa hấu', 50000, 'dua-hau.jpg', 'Trái cây', 'dua-hau')
ON DUPLICATE KEY UPDATE product_id=product_id";

if ($conn->query($sql) === TRUE) {
    echo "Dữ liệu mẫu cho bảng sanpham đã được thêm vào<br>";
} else {
    echo "Lỗi thêm dữ liệu vào bảng sanpham: " . $conn->error . "<br>";
}

$conn->close();
echo "Cài đặt database hoàn tất!";
?> 