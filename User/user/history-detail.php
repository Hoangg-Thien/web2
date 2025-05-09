<?php
session_start();
require_once('connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_name'])) {
    header("Location: login-user.php");
    exit();
}

// Kiểm tra ID đơn hàng
if (!isset($_GET['id'])) {
    header("Location: history-user.php");
    exit();
}

$order_id = $_GET['id'];
$user_name = $_SESSION['user_name'];

// Lấy thông tin chi tiết đơn hàng
$sql = "SELECT h.order_id, h.order_status, h.order_date, h.PaymentMethod, 
        CONCAT(h.address, ', ', h.district, ', ', h.city) as shipping_address, 
        h.phone, h.customerName, h.receipter,
        GROUP_CONCAT(CONCAT(s.product_name, '|', c.quantity, '|', s.product_price, '|', s.product_image) SEPARATOR '||') as order_items
        FROM hoadon h
        JOIN chitiethoadon c ON h.order_id = c.order_id
        JOIN sanpham s ON c.product_id = s.product_id
        WHERE h.order_id = ? AND h.user_name = ?
        GROUP BY h.order_id";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $order_id, $user_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: history-user.php");
    exit();
}

$order = $result->fetch_assoc();
$order_items = explode('||', $order['order_items']);
$total = 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../styles/grid.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <title>Chi Tiết Đơn Hàng - SEA FRUITS</title>
    <style>
        .order-detail-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .order-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #4CAF50;
        }

        .order-title {
            color: #4CAF50;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .order-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .info-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .info-label {
            color: #666;
            font-size: 0.9rem;
        }

        .info-value {
            font-weight: 500;
        }

        .order-items {
            margin-bottom: 2rem;
        }

        .item-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .item-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }

        .item-name {
            font-weight: 500;
        }

        .item-quantity {
            color: #666;
        }

        .item-price {
            color: #4CAF50;
            font-weight: 500;
        }

        .order-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: #f8f8f8;
            border-radius: 5px;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .back-btn {
            display: inline-block;
            padding: 0.8rem 2rem;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 2rem;
            transition: background 0.3s ease;
        }

        .back-btn:hover {
            background: #45a049;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
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
        button:hover {
            background-color: #45a049;
        }
        #searchResults {
            border: 1px solid #ccc;
            max-height: 300px;
            overflow-y: auto;
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
            display: none;
        }
        #searchResults a {
            display: block;
            padding: 5px;
            color: #333;
            text-decoration: none;
            margin-bottom: 5px;
        }
        #searchResults a:hover {
            text-decoration: underline;
        }
        #priorityFruits {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f0f0f0;
            display: none;
            border-radius: 5px;
        }
        #priorityFruits ul {
            list-style-type: none;
            padding: 0;
        }
        #priorityFruits li {
            margin-bottom: 8px;
        }
        #priorityFruits a {
            color: blue;
            text-decoration: none;
        }
        #priorityFruits a:hover {
            text-decoration: underline;
        }
        .search-result {
            display: block;
            margin: 5px 0;
            color: #0066cc;
            text-decoration: none;
        }
        .search-result:hover {
            text-decoration: underline;
        }
        .empty {
            color: red;
            font-weight: bold;
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
            padding: 10px;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1;
            border-radius: 5px;
        }
        .dropdown-menu a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: black;
            transition: background-color 0.3s;
        }
        .dropdown-menu a:hover {
            background-color: #f1f1f1;
        }
        .dropdown.active .dropdown-menu {
            display: block;
        }
        .dropdown-button i {
            color: #333;
            margin-right: 5px;
        }
        .dropdown-button span {
            color: #333;
        }
        /* News container styles */
        .news-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .featured-news h2, .news-category h2 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .featured-article {
            display: flex;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 40px;
        }
        .featured-article img {
            width: 45%;
            object-fit: cover;
        }
        .category-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .category-btn {
            padding: 8px 20px;
            border: 2px solid #4CAF50;
            background: white;
            color: #4CAF50;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .category-btn.active, .category-btn:hover {
            background: #4CAF50;
            color: white;
        }
        .news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px;
}
        .news-item {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .news-item:hover {
            transform: translateY(-5px);
        }
        .news-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .news-content {
            padding: 20px;
        }
        .news-tag {
            background: #4CAF50;
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8em;
            display: inline-block;
            margin-bottom: 10px;
        }
        .news-content h4 {
            color: #333;
            margin: 10px 0;
            font-size: 1.2em;
        }
        .date {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
        .date i {
            margin-right: 5px;
        }
        .read-more {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
        }
        .read-more:hover {
            text-decoration: underline;
        }
        /* Responsive styles */
        @media (max-width: 768px) {
            .featured-article {
                flex-direction: column;
            }
            .featured-article img {
                width: 100%;
                height: 200px;
            }
            .category-buttons {
                justify-content: center;
            }
            .news-grid {
                grid-template-columns: 1fr;
            }
        }
        /* Animation and performance optimizations */
        .news-item {
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        /* Loading state */
        .news-container {
            min-height: 400px;
            position: relative;
        }
        .loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        /* Performance optimization */
        .news-grid {
            contain: content;
            will-change: transform;
        }
        /* Touch targets optimization */
        @media (pointer: coarse) {
            .category-btn,
            .read-more,
            .share-btn {
                min-height: 44px;
                min-width: 44px;
                padding: 12px 20px;
            }
            .article-meta span {
                padding: 8px 0;
            }
        }
        /* Read more button */
        .read-more-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .read-more-btn:hover {
            background-color: #45a049;
        }
        .modal {
            display: none; /* Ban đầu ẩn */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* Nội dung popup */
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: fadeIn 0.3s ease-in-out;
        }
        /* Hiệu ứng mở popup */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        <div style="display: flex; align-items: center; padding: 10px;">  
            <div class="product-category">DANH MỤC SẢN PHẨM 
                <ul>
                    <li><a href="declious-fruits.php">Trái cây ngon</a></li>
                    <li><a href="Vietnamese-fruits.php">Trái cây Việt</a></li>
                    <li><a href="Imported-fruits.php">Trái cây nhập khẩu</a></li>
                    <li><a href="vegetables.php">Rau củ</a></li>
                    <li><a href="Imported-fruits.php">Trái cây nhập khẩu</a></li>
                    <li><a href="Imported-fruits.php">Các loại khác</a></li>
                </ul>
            </div>  
            
            <div class="menu">  
                <a href="../index.php" class="active">Trang chủ</a>  
                <a href="introducelogin.php">Giới thiệu</a>  
                <a href="newslogin.php">Tin tức</a>  
                <a href="contactlogin.php">Liên hệ</a> 
                <a href="cart-user.php" target="_blank" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-count" style="margin-left: 5px; font-size: 14px;">0</span>
                </a>
            </div>  
            <div class="search-container">
                <form action="searchProducts.php" method="GET">
                    <div>
                        <input type="text" name="search" id="searchInput" placeholder="Tìm kiếm sản phẩm...">
                        <div id="suggestBox" class="autocomplete-suggestions"></div>
                        <button type="submit">Tìm kiếm</button>
                        <button type="button" id="toggleSearch">Tìm kiếm nâng cao</button>
                    </div>
                
                    <div id="searchResults"></div>
                
                    <div id="priorityFruits" class="hidden">
                        <ul>
                        </ul>
                    </div>   
                    <div id="searchModal" class="modal" style="display:none">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Tìm kiếm nâng cao</h2>
                            
                            <label>Khoảng giá:</label>
                            <select id="priceRange">
                                <option>Tất cả</option>
                                <option>30k-70k</option>
                                <option>Trên 70k</option>
                            </select>
                    
                            <label>Danh mục:</label>
                            <select id="sortedList">
                                <option>A->Z</option>
                                <option>Z->A</option>
                            </select>
                    
                            <button onclick="smartSearchProducts()">Lọc</button>
                        </div>
                    </div>  
                </form>
            </div>
        
            
            <div class="dropdown">
                <button class="dropdown-button">
                    <i class="fa-solid fa-user"></i>
                    <span>
                        <?php
                        if (isset($_SESSION['user_name'])) {
                            echo "Xin chào, <strong>" . htmlspecialchars($_SESSION['user_name']) . "</strong>";
                        } else {
                            echo "Xin chào, khách!";
                        }
                        ?>
                    </span>
                </button>
                <div class="dropdown-menu">
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <a href="userinfo.php">Tài khoản</a>
                        <a href="history-user.php">Lịch sử</a>
                        <a href="invoice-summary.php">Tóm tắt hóa đơn</a>
                        <a href="usernologin.php">Đăng xuất</a>
                    <?php else: ?>
                        <a href="login-user.php">Đăng nhập</a>
                        <a href="regis.php">Đăng ký</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>  
    </div>
    <div class="order-detail-container">
        <div class="order-header">
            <h1 class="order-title">Chi Tiết Đơn Hàng #<?php echo $order['order_id']; ?></h1>
            <span class="status-badge status-<?php echo strtolower($order['order_status']); ?>">
                <?php 
                switch($order['order_status']) {
                    case 'Giao thành công':
                        echo 'Hoàn thành';
                        break;
                    case 'Đã xác nhận':
                        echo 'Đang xử lý';
                        break;
                    case 'Chưa xác nhận':
                        echo 'Đang chờ xác nhận';
                        break;
                    case 'Đã hủy':
                        echo 'Đã hủy';
                        break;
                    default:
                        echo $order['order_status'];
                }
                ?>
            </span>
        </div>

        <div class="order-info">
            <div class="info-group">
                <span class="info-label">Ngày đặt hàng</span>
                <span class="info-value"><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></span>
            </div>
            <div class="info-group">
                <span class="info-label">Phương thức thanh toán</span>
                <span class="info-value"><?php echo $order['PaymentMethod']; ?></span>
            </div>
            <div class="info-group">
                <span class="info-label">Tên khách hàng</span>
                <span class="info-value"><?php echo $order['customerName']; ?></span>
            </div>
            <div class="info-group">
                <span class="info-label">Người nhận</span>
                <span class="info-value"><?php echo $order['receipter']; ?></span>
            </div>
            <div class="info-group">
                <span class="info-label">Địa chỉ giao hàng</span>
                <span class="info-value"><?php echo $order['shipping_address']; ?></span>
            </div>
            <div class="info-group">
                <span class="info-label">Số điện thoại</span>
                <span class="info-value"><?php echo $order['phone']; ?></span>
            </div>
        </div>

        <div class="order-items">
            <h2>Sản phẩm đã đặt</h2>
            <div class="item-list">
                <?php
                foreach ($order_items as $item) {
                    list($name, $quantity, $price, $image) = explode('|', $item);
                    $subtotal = $price * $quantity;
                    $total += $subtotal;
                ?>
                    <div class="item">
                        <div class="item-info">
                            <img src="../img/<?php echo $image; ?>" alt="<?php echo $name; ?>" class="item-image">
                            <div>
                                <div class="item-name"><?php echo $name; ?></div>
                                <div class="item-quantity">Số lượng: <?php echo $quantity; ?></div>
                            </div>
                        </div>
                        <div class="item-price"><?php echo number_format($subtotal); ?>đ</div>
                    </div>
                <?php } ?>
            </div>
            <div class="order-total">
                <span>Tổng cộng</span>
                <span><?php echo number_format($total); ?>đ</span>
            </div>
        </div>

        <a href="history-user.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="footer">
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
    </div>
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
    function showFruits(category) {
        let fruitList = document.getElementById("fruitList");
        let categoryTitle = document.getElementById("categoryTitle");
        let fruitItems = document.getElementById("fruitItems");
        
        categoryTitle.textContent = category;
        fruitItems.innerHTML = "";
        
        const fruits = {
            "Trái cây ngon": [
                { name: "Dâu tây", link: "product-detail.php?name=dautay" },
                { name: "Mận hậu", link: "product-detail.php?name=manhau" },
                { name: "Xoài cát", link: "product-detail.php?name=xoaicat" },
                { name: "Dưa hấu", link: "product-detail.php?name=duahau" },
                { name: "Chôm chôm", link: "product-detail.php?name=chomchom" },
                { name: "Ổi xá lị", link: "product-detail.php?name=oilaxi" }
            ],
            "Trái cây Việt": [
                { name: "Mít Thái", link: "product-detail.php?name=mitthai" },
                { name: "Sầu riêng Ri6", link: "product-detail.php?name=saurieng" },
                { name: "Bưởi da xanh", link: "product-detail.php?name=buoidx" },
                { name: "Bòn Bon", link: "product-detail.php?name=bonbon" },
                { name: "Quýt đường", link: "product-detail.php?name=quytduong" },
                { name: "Mận Hà Nội", link: "product-detail.php?name=manhn" }
            ],
            "Trái cây nhập khẩu": [
                { name: "Nho Mỹ", link: "product-detail.php?name=nhomy" },
                { name: "Táo Nhật", link: "product-detail.php?name=taonhat" },
                { name: "Lê Hàn Quốc", link: "product-detail.php?name=lehan" },
                { name: "Cherry Úc", link: "product-detail.php?name=cherryuc" },
                { name: "Kiwi", link: "product-detail.php?name=kiwi" },
                { name: "Lựu Ai Cập", link: "product-detail.php?name=luuaicap" }
            ]
        };
        if (fruits[category]) {
            fruits[category].forEach(fruit => {
                let li = document.createElement("li");
                let a = document.createElement("a");
                a.textContent = fruit.name;
                a.href = fruit.link;
                li.appendChild(a);
                fruitItems.appendChild(li);
            });
            fruitList.style.display = "block";
        }
    }
    function hideFruits() {
        let fruitList = document.getElementById("fruitList");
        fruitList.style.display = "none";
    }
</script>
         
</body>
</html> 