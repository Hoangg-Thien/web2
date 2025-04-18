<?php
header('Content-Type: application/json');

// Kết nối CSDL
$conn = new mysqli("localhost", "root", "", "website");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Kết nối thất bại"]);
    exit;
}

// Lấy ID từ POST
$product_id = $_POST['product_id'] ?? null;

if ($product_id === null) {
    echo json_encode(["success" => false, "message" => "Không có ID sản phẩm"]);
    exit;
}

// Truy vấn xóa
$stmt = $conn->prepare("DELETE FROM sanpham WHERE product_id = ?");
$stmt->bind_param("s", $product_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Không thể xóa sản phẩm"]);
}

$stmt->close();
$conn->close();
?>
