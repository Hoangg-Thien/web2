<?php
// Kết nối database
$conn = new mysqli("localhost", "root", "", "website");
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Kết nối thất bại: " . $conn->connect_error]));
}

// Kiểm tra dữ liệu gửi đến
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_status = $_POST['product_status'];
    $product_type = $_POST['product_type'];
    $product_image = $_POST['product_image']; // Ảnh có thể là URL hoặc tên file lưu trong server

    // Câu lệnh cập nhật database
    $sql = "UPDATE sanpham SET 
                product_name='$product_name', 
                product_price='$product_price', 
                product_status='$product_status', 
                product_type='$product_type', 
                product_image='$product_image' 
            WHERE product_id='$product_id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Cập nhật thành công!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi: " . $conn->error]);
    }
}

// Đóng kết nối
$conn->close();
?>
