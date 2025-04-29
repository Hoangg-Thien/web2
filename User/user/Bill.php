<?php
session_start();
require_once('connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_name'])) {
    echo '<script>
        alert("Vui lòng đăng nhập để xem hóa đơn!");
        window.location.href = "login-user.php";
    </script>';
    exit();
}

$user_name = $_SESSION['user_name'];

// Lấy thông tin hóa đơn của người dùng
$sql = "SELECT h.*, GROUP_CONCAT(CONCAT(s.product_name, '|', c.quantity, '|', s.product_price, '|', s.product_image) SEPARATOR '||') as order_items
        FROM hoadon h
        JOIN chitiethoadon c ON h.order_id = c.order_id
        JOIN sanpham s ON c.product_id = s.product_id
        WHERE h.user_name = ?
        GROUP BY h.order_id
        ORDER BY h.order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn - SEA FRUITS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../styles/contact.css">
    <link rel="stylesheet" href="../styles/grid.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* Variables */
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #45a049;
            --text-color: #333;
            --light-text: #666;
            --border-color: #eee;
            --background-color: #f8f9fa;
            --shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        /* Base styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }
        /* Container */
        .invoice-container {
            max-width: 700px;
            margin: 20px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }
        /* Header */
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border-color);
        }
        .invoice-logo {
            margin-bottom: 15px;
        }
        .invoice-logo img {
            max-width: 120px;
            height: auto;
            display: inline-block;
        }
        .invoice-title {
            font-size: 22px;
            color: var(--primary-color);
            margin-bottom: 8px;
            font-weight: 600;
        }
        .invoice-number {
            color: var(--light-text);
            font-size: 14px;
            margin-bottom: 8px;
        }
        .invoice-status {
            display: inline-block;
            padding: 6px 12px;
            background-color: #d4edda;
            color: #155724;
            border-radius: 15px;
            font-size: 14px;
            font-weight: 500;
        }
        /* Info Grid */
        .invoice-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .info-group h3 {
            color: var(--primary-color);
            font-size: 16px;
            margin-bottom: 12px;
            font-weight: 600;
        }
        .info-group p {
            font-size: 14px;
            margin: 4px 0;
            color: var(--text-color);
        }
        .info-label {
            color: var(--light-text);
            font-size: 13px;
        }
        /* Items Table */
        .invoice-items {
            margin-bottom: 30px;
            overflow-x: auto;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 500px; 
        }
        .items-table th {
            background-color: var(--background-color);
            padding: 10px;
            text-align: left;
            font-weight: 500;
            color: var(--light-text);
            border-bottom: 2px solid var(--border-color);
        }
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }
        .item-name {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .item-image {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
        }
        /* Summary Section */
        .invoice-summary {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }
        .summary-details {
            width: 250px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
            color: var(--light-text);
        }
        .summary-row.total {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-color);
            border-top: 2px solid var(--border-color);
            padding-top: 8px;
            margin-top: 8px;
        }
        /* Footer */
        .invoice-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid var(--border-color);
        }
        .invoice-footer p {
            color: var(--light-text);
            font-size: 14px;
            margin-bottom: 5px;
        }
        /* Action Buttons */
        .invoice-actions {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 15px;
        }
        .action-button {
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            border: none;
        }
        .print-button {
            background-color: var(--primary-color);
            color: white;
        }
        .download-button {
            background-color: white;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }
        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .invoice-container {
                margin: 15px;
                padding: 20px;
            }
            .invoice-info {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            .summary-details {
                width: 100%;
            }
            .invoice-actions {
                flex-direction: column;
            }
            .action-button {
                width: 100%;
                justify-content: center;
            }
        }
        @media screen and (max-width: 480px) {
            .invoice-container {
                margin: 10px;
                padding: 15px;
            }
            .invoice-title {
                font-size: 20px;
            }
            .invoice-number {
                font-size: 13px;
            }
            .item-image {
                width: 35px;
                height: 35px;
            }
            .items-table {
                font-size: 13px;
            }
            .info-group h3 {
                font-size: 15px;
            }
            .info-group p {
                font-size: 13px;
            }
        }
        /* Print Styles */
        @media print {
            body {
                background: white;
            }
            .invoice-container {
                margin: 0;
                padding: 15px;
                box-shadow: none;
            }
            .invoice-actions {
                display: none;
            }
            .items-table {
                page-break-inside: avoid;
            }
            .invoice-info,
            .invoice-items,
            .invoice-summary {
                page-break-inside: avoid;
            }
        }
    </style>
    <style>
        .search-container {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }
        #searchBox {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 80%;
            margin-right: 10px;
        }
        button {
            padding: 10px 20px;
            border: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }
        .dropdown-menu a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: black;
        }
        .dropdown-menu a:hover {
            background-color: #f1f1f1;
        }
        .dropdown.active .dropdown-menu {
            display: block;
        }
        .dropdown-button i{
            color: #333;
        }
        .dropdown-button span{
            color: #333;
        }
        button:hover {
            background-color: #45a049 !important;
        }
    </style>
</head>
<body>
<header>
    <a href="#" class="fruit">  
        <img src="../img/carrotheader.png" alt="Cà rốt" />  
        Cà rốt  
    </a>  
    <a href="#" class="fruit">  
        <img src="../img/potatoheader.png" alt="Khoai tây" />  
        Khoai tây  
    </a>  
    <a href="#" class="fruit">  
        <img src="../img/watermelonheader.png" alt="Dưa hấu" />  
        Dưa hấu  
    </a>  
    <a href="#" class="fruit">  
        <img src="../img/orangeheader.png" alt="Trái cam" />  
        Cam  
    </a>  
    <a href="#" class="fruit">  
        <img src="../img/duagangheader.png" alt="Đu đủ" />  
        Đu đủ  
    </a>  
    <a href="#" class="fruit">  
        <img src="../img/tomatoheader.png" alt="Cà chua" />  
        Cà chua  
    </a>  
</header>  
<div class="sea-fruit-container">  
    <div>  
        <div class="sea-fruit">SEA FRUITS</div>  
    </div>
    <div style="display: flex; align-items: center; padding: 10px 20px;">  
        <div class="product-category">DANH MỤC SẢN PHẨM 
            <ul>
                <li onmouseover="showFruits('Trái cây ngon')" onmouseout="hideFruits()">Trái cây ngon</li>
                <li onmouseover="showFruits('Trái cây Việt')" onmouseout="hideFruits()">Trái cây Việt</li>
                <li onmouseover="showFruits('Trái cây nhập khẩu')" onmouseout="hideFruits()">Trái cây nhập khẩu</li>
            </ul>
        </div>
        
        <div class="fruit-list" id="fruitList" style="display: none;">
            <h4 id="categoryTitle"></h4>
            <ul id="fruitItems">
                <!-- Trái cây sẽ được thêm bằng JavaScript -->
            </ul>
        </div>
        <div class="menu">  
            <a href="../index.php">Trang chủ</a>  
            <a href="./introducelogin.php">Giới thiệu</a>  
            <a href="./newslogin.php">Tin tức</a>  
            <a href="./contactlogin.php">Liên hệ</a> 
            <a href="./cart-user.php" target="_blank" class="cart-icon" title="Go to Cart">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count" style="margin-left: 5px; font-weight: bold;">0</span>
            </a>
        </div>
        <div class="search-container">
            <form method="GET" action="">
                <input type="text" id="searchBox" name="search" placeholder="Tìm kiếm tin tức..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit"><i class="fas fa-search"></i> Tìm kiếm</button>
            </form>
        </div>
    
        <div class="dropdown">
            <button class="dropdown-button">
                <i class="fa-solid fa-user" style="margin-right: 10px;"></i> 
                <span>Hi, <?php echo isset($user['fullname']) ? htmlspecialchars($user['fullname']) : ''; ?></span>
            </button>
            <div class="dropdown-menu">
                <?php if ($user): ?>
                <a href="../user/userinfo.php">Tài khoản</a>
                <a href="../user/history-user.php">Lịch sử</a>
                <a href="../user/invoice-summary.php">Tóm tắt hóa đơn</a>
                <a href="../user/usernologin.php">Đăng xuất</a>
                <?php else: ?>
                    <a href="../user/login.php">Đăng nhập</a>
                    <a href="../user/register.php">Đăng ký</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
    
    <div class="container">
        <div class="invoice-container">
            <div class="invoice-header">
                <h2>HÓA ĐƠN MUA HÀNG</h2>
                <div class="invoice-info">
                    <p><strong>Mã đơn hàng:</strong> #<?php echo $order['order_id']; ?></p>
                    <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></p>
                    <p><strong>Trạng thái:</strong> <?php echo $order['order_status']; ?></p>
                </div>
            </div>

            <div class="invoice-content">
                <div class="customer-info">
                    <h3>Thông tin khách hàng</h3>
                    <p><strong>Tên khách hàng:</strong> <?php echo htmlspecialchars($order['customerName']); ?></p>
                    <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
                    <p><strong>Quận/Huyện:</strong> <?php echo htmlspecialchars($order['district']); ?></p>
                    <p><strong>Thành phố:</strong> <?php echo htmlspecialchars($order['city']); ?></p>
                    <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
                </div>

                <div class="order-items">
                    <h3>Chi tiết đơn hàng</h3>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->prepare("
                                SELECT c.*, s.product_name, s.product_image
                                FROM chitiethoadon c
                                JOIN sanpham s ON c.product_id = s.product_id
                                WHERE c.order_id = ?
                            ");
                            $stmt->bind_param("i", $order_id);
                            $stmt->execute();
                            $items = $stmt->get_result();
                            $total = 0;
                            while ($item = $items->fetch_assoc()) {
                                $subtotal = $item['quantity'] * $item['unit_price'];
                                $total += $subtotal;
                                ?>
                                <tr>
                                    <td class="item-name">
                                        <img src="../img/<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="item-image">
                                        <?php echo htmlspecialchars($item['product_name']); ?>
                                    </td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo number_format($item['unit_price']); ?>đ</td>
                                    <td><?php echo number_format($subtotal); ?>đ</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Tổng cộng:</strong></td>
                                <td><strong><?php echo number_format($total); ?>đ</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="payment-info">
                    <h3>Thông tin thanh toán</h3>
                    <p><strong>Phương thức thanh toán:</strong> <?php echo htmlspecialchars($order['PaymentMethod']); ?></p>
                </div>
            </div>

            <div class="invoice-actions">
                <button onclick="window.print()" class="action-button print-button">
                    <i class="fas fa-print"></i> In hóa đơn
                </button>
                <a href="history-user.php" class="action-button back-button">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Về chúng tôi</h3>
                <p>Sea Fruits - Nơi cung cấp trái cây tươi ngon, chất lượng cao với giá cả hợp lý.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Liên kết nhanh</h3>
                <ul>
                    <li><a href="../index.php">Trang chủ</a></li>
                    <li><a href="introducelogin.php">Giới thiệu</a></li>
                    <li><a href="newslogin.php">Tin tức</a></li>
                    <li><a href="contactlogin.php">Liên hệ</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Dịch vụ</h3>
                <ul>
                    <li><a href="#">Giao hàng nhanh</a></li>
                    <li><a href="#">Đổi trả dễ dàng</a></li>
                    <li><a href="#">Thanh toán an toàn</a></li>
                    <li><a href="#">Bảo hành chất lượng</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Liên hệ</h3>
                <ul class="contact-info">
                    <li><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận 1, TP.HCM</li>
                    <li><i class="fas fa-phone"></i> Hotline: 0123456789</li>
                    <li><i class="fas fa-envelope"></i> Email: AboutUs@gmail.com</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Sea Fruits. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.querySelector('.dropdown-button').addEventListener('click', function() {
            const dropdown = this.parentElement;
            dropdown.classList.toggle('active');
        });

        window.addEventListener('click', function(e) {
            const dropdown = document.querySelector('.dropdown');
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
    </script>
</body>
</html> 