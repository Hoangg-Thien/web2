<?php
include 'connect.php';

// Lấy order_id từ URL
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id > 0) {
    // Lấy thông tin hóa đơn
    $sql = "SELECT customerName, PaymentMethod, district, phone, total_amount FROM hoadon WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $invoice = $result->fetch_assoc();

    // Kiểm tra nếu không tìm thấy hóa đơn
    if (!$invoice) {
        die("Không tìm thấy hóa đơn.");
    }

    // Lấy danh sách sản phẩm trong hóa đơn
    $sql = "SELECT p.product_name, c.quantity, c.unit_price 
            FROM chitiethoadon c 
            JOIN sanpham p ON c.product_id = p.product_id
            WHERE c.order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $products = $stmt->get_result();
} else {
    die("Không tìm thấy hóa đơn.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chi tiết hóa đơn</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Thông tin khách hàng</h2>
    <p><strong>Tên khách hàng:</strong> <?php echo htmlspecialchars($invoice['customerName']); ?></p>
    <p><strong>Phương thức thanh toán:</strong> <?php echo htmlspecialchars($invoice['PaymentMethod']); ?></p>
    <p><strong>Quận:</strong> <?php echo htmlspecialchars($invoice['district']); ?></p>
    <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($invoice['phone']); ?></p>
    <p><strong>Tổng tiền:</strong> <?php echo number_format($invoice['total_amount'], 0, ',', '.'); ?> VND</p>

    <h2>Danh sách sản phẩm đã mua</h2>
    <table>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
        </tr>
        <?php while ($product = $products->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($product['product_name']); ?></td>
            <td><?php echo $product['quantity']; ?></td>
            <td><?php echo number_format($product['unit_price'], 0, ',', '.'); ?> VND</td>
            <td><?php echo number_format($product['quantity'] * $product['unit_price'], 0, ',', '.'); ?> VND</td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
