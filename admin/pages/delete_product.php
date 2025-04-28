<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "c07db");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Kết nối thất bại"]);
    exit;
}

$product_id = $_POST['product_id'] ?? null;
$status = $_POST['status'] ?? null;

if ($product_id === null || $status === null) {
    echo json_encode(["success" => false, "message" => "Thiếu thông tin sản phẩm"]);
    exit;
}

if ($status === 'Hết hàng') {
    // Ẩn sản phẩm thay vì xóa
    $stmt = $conn->prepare("UPDATE sanpham SET hidden = 1 WHERE product_id = ?");
    $stmt->bind_param("s", $product_id);
} else {
    // Xóa sản phẩm
    $stmt = $conn->prepare("DELETE FROM sanpham WHERE product_id = ?");
    $stmt->bind_param("s", $product_id);
}

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Không thể xử lý sản phẩm"]);
}

$stmt->close();
$conn->close();
?>
