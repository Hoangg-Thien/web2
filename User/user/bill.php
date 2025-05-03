<?php
session_start();
include 'connect.php';

// Kiểm tra nếu giỏ hàng rỗng
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Giỏ hàng trống. Không thể tạo hóa đơn.");
}

// Lấy thông tin khách hàng từ form hoặc session
$customerName = isset($_POST['customerName']) ? htmlspecialchars($_POST['customerName']) : "Khách vãng lai";
$paymentMethod = isset($_POST['PaymentMethod']) ? htmlspecialchars($_POST['PaymentMethod']) : "Không xác định";
$district = isset($_POST['district']) ? htmlspecialchars($_POST['district']) : "Không có";
$phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : "Không có";
$totalAmount = 0;

// Tính tổng tiền
foreach ($_SESSION['cart'] as $item) {
    $totalAmount += $item['quantity'] * $item['price'];
}

// Bắt đầu giao dịch để đảm bảo toàn vẹn dữ liệu
$conn->begin_transaction();

try {
    // 1. Thêm vào bảng hóa đơn
    $sql = "INSERT INTO hoadon (customerName, PaymentMethod, district, phone, total_amount) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssd", $customerName, $paymentMethod, $district, $phone, $totalAmount);
    $stmt->execute();
    $orderId = $conn->insert_id;

    // 2. Thêm chi tiết sản phẩm vào bảng chitiethoadon
    $sql = "INSERT INTO chitiethoadon (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    foreach ($_SESSION['cart'] as $productId => $item) {
        $stmt->bind_param("iiid", $orderId, $productId, $item['quantity'], $item['price']);
        $stmt->execute();
    }

    // 3. Xóa giỏ hàng khỏi session
    unset($_SESSION['cart']);

    // 4. Commit giao dịch
    $conn->commit();

    // Chuyển hướng đến trang hiển thị hóa đơn
    header("Location: bill_view.php?order_id=$orderId");
    exit();
} catch (Exception $e) {
    $conn->rollback();
    die("Lỗi xảy ra: " . $e->getMessage());
}
?>
