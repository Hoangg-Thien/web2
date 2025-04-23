<?php
require_once('../data/c07db.php');

try {
    // Get all orders for the current user (assuming user_id is stored in session)
    // For now, we'll get all orders. In a real application, you'd filter by user_id
    $stmt = $db->prepare("
        SELECT 
            o.order_id,
            o.order_date,
            o.payment_method,
            o.shipping_address,
            o.phone_number,
            o.status,
            o.total_amount,
            u.full_name,
            u.email
        FROM orders o
        JOIN users u ON o.user_id = u.user_id
        ORDER BY o.order_date DESC
    ");
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get order items for each order
    foreach ($orders as &$order) {
        $stmt = $db->prepare("
            SELECT 
                p.product_name,
                p.image_url,
                c.unit_price,
                c.quantity,
                c.total_amount as total_price
            FROM chitiethoadon c
            JOIN products p ON c.product_id = p.product_id
            WHERE c.order_id = ?
        ");
        $stmt->execute([$order['order_id']]);
        $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    error_log($e->getMessage());
    $error = "Đã có lỗi xảy ra khi tải lịch sử đơn hàng.";
}

// Helper function to format currency
function formatCurrency($amount) {
    return number_format($amount, 0, ',', '.') . 'đ';
}

// Helper function to format date
function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}

// Helper function to get status class
function getStatusClass($status) {
    switch (strtolower($status)) {
        case 'completed':
        case 'hoàn thành':
            return 'status-completed';
        case 'pending':
        case 'chờ xử lý':
            return 'status-pending';
        case 'cancelled':
        case 'đã hủy':
            return 'status-cancelled';
        default:
            return 'status-pending';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../styles/news.css">
    <link rel="stylesheet" href="../styles/grid.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <title>Lịch Sử Mua Hàng - SEA FRUITS</title>
    <style>
        /* Keep all the existing CSS styles from history-user.html */
        /* ... existing code ... */
    </style>
</head>
<body>
    <!-- Keep the existing header and navigation -->
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
            <div class="product-category">DANH MỤC SẢN PHẨM</div>
            <div class="menu">
                <a href="../index.html" class="active">Trang chủ</a>
                <a href="./introducelogin.html">Giới thiệu</a>
                <a href="./newslogin.html">Tin tức</a>
                <a href="./contactlogin.html">Liên hệ</a>
                <a href="./cart-user.html" target="_blank" class="cart-icon" title="Go to Cart">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-count" style="margin-left: 5px; font-weight: bold;">0</span>
                </a>
            </div>
            <div class="search-container">
                <div>
                    <input type="text" id="searchBox" placeholder="Tìm kiếm sản phẩm..." onkeyup="searchProducts()">
                    <button onclick="searchProducts()">Tìm kiếm</button>
                </div>
                <div id="searchResults"></div>
                <div id="priorityFruits" class="hidden">
                    <ul>
                    </ul>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropdown-button">
                    <i class="fa-solid fa-user" style="margin-right: 10px;"></i>
                    <span>Hi,User!</span>
                </button>
                <div class="dropdown-menu">
                    <a href="./userinfo.html">Tài khoản</a>
                    <a href="./history-user.php">Lịch sử</a>
                    <a href="./invoice-summary.html">Tóm tắt hóa đơn</a>
                    <a href="./usernologin.html">Đăng xuất</a>
                </div>
            </div>
        </div>
    </div>

    <div class="history-container">
        <div class="history-header">
            <div class="history-title">
                <h1>Lịch Sử Mua Hàng</h1>
            </div>
            <div class="history-filters">
                <button class="filter-btn active" onclick="filterOrders('all')">Tất cả</button>
                <button class="filter-btn" onclick="filterOrders('completed')">Hoàn thành</button>
                <button class="filter-btn" onclick="filterOrders('pending')">Đang xử lý</button>
                <button class="filter-btn" onclick="filterOrders('cancelled')">Đã hủy</button>
            </div>
        </div>

        <div class="history-list">
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php elseif (empty($orders)): ?>
                <div class="empty-message">Bạn chưa có đơn hàng nào.</div>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                <div class="history-item" data-status="<?php echo strtolower($order['status']); ?>">
                    <div class="order-header">
                        <div class="order-info">
                            <span class="order-number">Đơn hàng #<?php echo htmlspecialchars($order['order_id']); ?></span>
                            <span class="order-date">Ngày đặt: <?php echo formatDate($order['order_date']); ?></span>
                        </div>
                        <span class="order-status <?php echo getStatusClass($order['status']); ?>">
                            <?php echo htmlspecialchars($order['status']); ?>
                        </span>
                    </div>
                    <div class="order-details">
                        <div class="detail-group">
                            <span class="detail-label">Phương thức thanh toán</span>
                            <span class="detail-value"><?php echo htmlspecialchars($order['payment_method']); ?></span>
                        </div>
                        <div class="detail-group">
                            <span class="detail-label">Địa chỉ giao hàng</span>
                            <span class="detail-value"><?php echo htmlspecialchars($order['shipping_address']); ?></span>
                        </div>
                        <div class="detail-group">
                            <span class="detail-label">Số điện thoại</span>
                            <span class="detail-value"><?php echo htmlspecialchars($order['phone_number']); ?></span>
                        </div>
                    </div>
                    <div class="order-items">
                        <div class="item-list">
                            <?php foreach ($order['items'] as $item): ?>
                            <div class="item">
                                <div class="item-info">
                                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['product_name']); ?>" 
                                         class="item-image">
                                    <span class="item-name"><?php echo htmlspecialchars($item['product_name']); ?></span>
                                </div>
                                <span class="item-price"><?php echo formatCurrency($item['total_price']); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="order-total">
                            <span>Tổng cộng</span>
                            <span><?php echo formatCurrency($order['total_amount']); ?></span>
                        </div>
                    </div>
                    <div class="order-actions">
                        <a href="Bill.php?id=<?php echo $order['order_id']; ?>" class="action-btn view-btn">
                            <i class="fas fa-eye"></i>
                            Xem chi tiết
                        </a>
                        <button class="action-btn reorder-btn" onclick="reorder(<?php echo $order['order_id']; ?>)">
                            <i class="fas fa-redo"></i>
                            Đặt lại
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="pagination">
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn">4</button>
            <button class="page-btn">5</button>
            <button class="page-btn">></button>
        </div>
    </div>

    <!-- Keep the existing footer -->
    <div class="footer">
        <!-- ... existing footer content ... -->
    </div>

    <script>
        // Filter orders function
        function filterOrders(status) {
            // Remove active class from all buttons
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Add active class to clicked button
            event.target.classList.add('active');

            // Get all order items
            const orders = document.querySelectorAll('.history-item');
            
            orders.forEach(order => {
                const orderStatus = order.getAttribute('data-status');
                
                if (status === 'all') {
                    order.style.display = 'block';
                } else if (status === 'completed' && orderStatus.includes('hoàn thành')) {
                    order.style.display = 'block';
                } else if (status === 'pending' && orderStatus.includes('chờ xử lý')) {
                    order.style.display = 'block';
                } else if (status === 'cancelled' && orderStatus.includes('hủy')) {
                    order.style.display = 'block';
                } else {
                    order.style.display = 'none';
                }
            });
        }

        // Reorder function
        function reorder(orderId) {
            // Add reorder logic here
            alert('Chức năng đặt lại đang được phát triển');
        }

        // Dropdown menu
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

        // Cart count
        localStorage.setItem('cartCount', 0);
        let cartCount = 0;
        document.getElementById('cart-count').textContent = cartCount;
    </script>
</body>
</html> 