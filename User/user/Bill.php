<?php
require_once('../data/c07db.php');

// Get order ID from URL
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch order details
$sql = "SELECT o.*, u.fullname, u.phone, u.address, u.email 
        FROM orders o 
        JOIN users u ON o.user_id = u.user_id 
        WHERE o.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

// Fetch order items
$sql_items = "SELECT c.*, p.product_name, p.price 
              FROM chitiethoadon c 
              JOIN products p ON c.product_id = p.product_id 
              WHERE c.order_id = ?";
$stmt_items = $conn->prepare($sql_items);
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$items = $stmt_items->get_result();

// Function to format currency
function formatCurrency($amount) {
    return number_format($amount, 0, ',', '.') . 'đ';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn - FreshFood</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }

        /* Header Styles */
        .header {
            background-color: #2ecc71;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links a:hover {
            color: #f1c40f;
        }

        .nav-links i {
            font-size: 1.2rem;
        }

        .cart-count {
            background-color: #e74c3c;
            color: white;
            border-radius: 50%;
            padding: 0.2rem 0.5rem;
            font-size: 0.8rem;
            position: absolute;
            top: -8px;
            right: -8px;
        }

        .cart-link {
            position: relative;
        }

        .user-menu {
            position: relative;
        }

        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            min-width: 200px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 5px;
            display: none;
            z-index: 1000;
        }

        .user-menu:hover .user-dropdown {
            display: block;
        }

        .user-dropdown a {
            color: #333;
            padding: 0.8rem 1rem;
            display: block;
            transition: background-color 0.3s;
        }

        .user-dropdown a:hover {
            background-color: #f8f9fa;
            color: #2ecc71;
        }

        /* Bill Styles */
        .bill-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .bill-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #2ecc71;
        }

        .bill-title {
            color: #2ecc71;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .bill-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .info-group {
            margin-bottom: 1rem;
        }

        .info-group h3 {
            color: #2ecc71;
            margin-bottom: 0.5rem;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        .items-table th,
        .items-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .items-table th {
            background-color: #f8f9fa;
            color: #2ecc71;
        }

        .total-section {
            text-align: right;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 2px solid #2ecc71;
        }

        .total-amount {
            font-size: 1.5rem;
            color: #2ecc71;
            font-weight: bold;
        }

        .bill-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-print {
            background-color: #3498db;
            color: white;
        }

        .btn-print:hover {
            background-color: #2980b9;
        }

        .btn-download {
            background-color: #2ecc71;
            color: white;
        }

        .btn-download:hover {
            background-color: #27ae60;
        }

        /* Footer Styles */
        .footer {
            background-color: #2ecc71;
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .footer-section h3 {
            margin-bottom: 1rem;
            color: #f1c40f;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: #f1c40f;
        }

        .copyright {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        @media print {
            .header, .footer, .bill-actions {
                display: none;
            }
            .bill-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <a href="index.php" class="logo">FreshFood</a>
            <nav class="nav-links">
                <a href="index.php">
                    <i class="fas fa-home"></i>
                    Trang chủ
                </a>
                <a href="products.php">
                    <i class="fas fa-shopping-bag"></i>
                    Sản phẩm
                </a>
                <a href="about.php">
                    <i class="fas fa-info-circle"></i>
                    Giới thiệu
                </a>
                <a href="contact.php">
                    <i class="fas fa-envelope"></i>
                    Liên hệ
                </a>
                <a href="cart.php" class="cart-link">
                    <i class="fas fa-shopping-cart"></i>
                    Giỏ hàng
                    <span class="cart-count">0</span>
                </a>
                <div class="user-menu">
                    <a href="#">
                        <i class="fas fa-user"></i>
                        Tài khoản
                    </a>
                    <div class="user-dropdown">
                        <a href="profile.php">
                            <i class="fas fa-user-circle"></i>
                            Thông tin cá nhân
                        </a>
                        <a href="orders.php">
                            <i class="fas fa-clipboard-list"></i>
                            Đơn hàng
                        </a>
                        <a href="logout.php">
                            <i class="fas fa-sign-out-alt"></i>
                            Đăng xuất
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div class="bill-container">
        <?php if ($order): ?>
            <div class="bill-header">
                <h1 class="bill-title">Hóa đơn mua hàng</h1>
                <p>Mã đơn hàng: #<?php echo $order['order_id']; ?></p>
                <p>Ngày đặt: <?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></p>
            </div>

            <div class="bill-info">
                <div class="info-group">
                    <h3>Thông tin khách hàng</h3>
                    <p><?php echo htmlspecialchars($order['fullname']); ?></p>
                    <p><?php echo htmlspecialchars($order['phone']); ?></p>
                    <p><?php echo htmlspecialchars($order['email']); ?></p>
                    <p><?php echo htmlspecialchars($order['address']); ?></p>
                </div>
                <div class="info-group">
                    <h3>Thông tin đơn hàng</h3>
                    <p>Phương thức thanh toán: <?php echo htmlspecialchars($order['payment_method']); ?></p>
                    <p>Trạng thái: 
                        <span style="color: <?php 
                            echo $order['status'] == 'completed' ? '#2ecc71' : 
                                ($order['status'] == 'pending' ? '#f1c40f' : '#e74c3c'); 
                        ?>">
                        <?php 
                            echo $order['status'] == 'completed' ? 'Đã hoàn thành' : 
                                ($order['status'] == 'pending' ? 'Đang xử lý' : 'Đã hủy'); 
                        ?>
                        </span>
                    </p>
                </div>
            </div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    while ($item = $items->fetch_assoc()): 
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td><?php echo formatCurrency($item['price']); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo formatCurrency($subtotal); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="total-section">
                <p class="total-amount">Tổng cộng: <?php echo formatCurrency($total); ?></p>
            </div>

            <div class="bill-actions">
                <button class="btn btn-print" onclick="window.print()">
                    <i class="fas fa-print"></i> In hóa đơn
                </button>
                <button class="btn btn-download" onclick="downloadPDF()">
                    <i class="fas fa-download"></i> Tải PDF
                </button>
            </div>
        <?php else: ?>
            <div class="error-message">
                <p>Không tìm thấy thông tin đơn hàng.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>Về chúng tôi</h3>
                <p>FreshFood - Mang đến những sản phẩm tươi ngon nhất cho gia đình bạn.</p>
            </div>
            <div class="footer-section">
                <h3>Liên kết nhanh</h3>
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="products.php">Sản phẩm</a></li>
                    <li><a href="about.php">Giới thiệu</a></li>
                    <li><a href="contact.php">Liên hệ</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Liên hệ</h3>
                <ul>
                    <li><i class="fas fa-phone"></i> 0123 456 789</li>
                    <li><i class="fas fa-envelope"></i> info@freshfood.com</li>
                    <li><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận 1, TP.HCM</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2024 FreshFood. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function downloadPDF() {
            // Implement PDF download functionality
            alert('Tính năng tải PDF sẽ được cập nhật sau!');
        }
    </script>
</body>
</html> 