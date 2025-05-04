<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');


$conn = new mysqli("localhost", "root", "", "c07db");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Kết nối database thất bại"]);
    exit;
}

$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$product_status = $_POST['product_status'];
$product_type = $_POST['product_type'];
$delete_image = isset($_POST['delete_image']) && $_POST['delete_image'] === 'true';
$imagePath = "";

// Nếu xóa ảnh
if ($delete_image) {
    // Lấy đường dẫn ảnh hiện tại từ cơ sở dữ liệu
    $sql = "SELECT product_image FROM sanpham WHERE product_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $currentImagePath = $row['product_image'];

    // Xóa file ảnh khỏi máy chủ
    if (file_exists($currentImagePath)) {
        unlink($currentImagePath);
    }

    // Cập nhật cơ sở dữ liệu để xóa đường dẫn ảnh
    $sql = "UPDATE sanpham SET product_name=?, product_price=?, product_status=?, product_type=?, product_image='' WHERE product_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsss", $product_name, $product_price, $product_status, $product_type, $product_id);
}
// Nếu có ảnh mới upload
else if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
    $imgName = time() . "_" . basename($_FILES['product_image']['name']);
    $targetDir = "../img/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $targetPath = $targetDir . $imgName;
    move_uploaded_file($_FILES['product_image']['tmp_name'], $targetPath);
    $imagePath = $targetPath;

    $sql = "UPDATE sanpham SET product_name=?, product_price=?, product_status=?, product_type=?, product_image=? WHERE product_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdssss", $product_name, $product_price, $product_status, $product_type, $imagePath, $product_id);
}
// Không đổi ảnh
else {
    $sql = "UPDATE sanpham SET product_name=?, product_price=?, product_status=?, product_type=? WHERE product_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsss", $product_name, $product_price, $product_status, $product_type, $product_id);
}

// Thực thi và trả kết quả JSON
if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi SQL: " . $stmt->error]);
}

$conn->close();
?>