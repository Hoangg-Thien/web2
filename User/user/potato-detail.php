<?php
require_once('../data/c07db.php');

// Fetch potato details
$sql = "SELECT * FROM products WHERE product_id = 'F002'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $potato = $result->fetch_assoc();
    
    // Update view count
    $update_views = "UPDATE products SET views = views + 1 WHERE product_id = 'F002'";
    $conn->query($update_views);
    
    // Decode JSON data
    $nutrition_info = json_decode($potato['nutrition_info'], true);
    $benefits = json_decode($potato['benefits'], true);
    $storage_tips = json_decode($potato['storage_tips'], true);
} else {
    $potato = null;
}

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
    <title>Khoai tây - FreshFood</title>
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

        /* Product Detail Styles */
        .product-detail {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 20px;
        }

        .product-header {
            text-align: center;
            margin-bottom: 40px;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .product-title {
            font-size: 2.5em;
            color: #2ecc71;
            margin-bottom: 10px;
        }

        .product-category {
            color: #666;
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .product-image {
            max-width: 100%;
            height: auto;
            margin: 20px 0;
            border-radius: 10px;
        }

        .product-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .info-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .info-section h3 {
            color: #2ecc71;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f1c40f;
        }

        .nutrition-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .nutrition-item {
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            transition: transform 0.3s;
        }

        .nutrition-item:hover {
            transform: translateY(-5px);
        }

        .nutrition-item strong {
            display: block;
            color: #2ecc71;
            margin-bottom: 5px;
        }

        .benefits-list, .storage-tips {
            list-style-type: none;
            padding: 0;
        }

        .benefits-list li, .storage-tips li {
            margin-bottom: 10px;
            padding-left: 25px;
            position: relative;
        }

        .benefits-list li:before, .storage-tips li:before {
            content: "✓";
            color: #2ecc71;
            position: absolute;
            left: 0;
        }

        .social-share {
            margin-top: 40px;
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .social-share h3 {
            color: #2ecc71;
            margin-bottom: 20px;
        }

        .social-share a {
            display: inline-block;
            margin: 0 10px;
            color: #333;
            font-size: 1.5em;
            transition: color 0.3s;
        }

        .social-share a:hover {
            color: #2ecc71;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 1rem;
            }

            .nav-links {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .product-title {
                font-size: 2em;
            }

            .product-info {
                grid-template-columns: 1fr;
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

    <div class="product-detail">
        <?php if ($potato): ?>
            <div class="product-header">
                <h1 class="product-title"><?php echo htmlspecialchars($potato['product_name']); ?></h1>
                <p class="product-category"><?php echo htmlspecialchars($potato['category']); ?></p>
                <img src="<?php echo htmlspecialchars($potato['image_url']); ?>" alt="Khoai tây" class="product-image">
            </div>

            <div class="product-info">
                <div class="info-section">
                    <h3>Thông tin dinh dưỡng</h3>
                    <div class="nutrition-grid">
                        <?php foreach ($nutrition_info as $key => $value): ?>
                            <div class="nutrition-item">
                                <strong><?php echo htmlspecialchars($key); ?></strong>
                                <p><?php echo htmlspecialchars($value); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="info-section">
                    <h3>Lợi ích sức khỏe</h3>
                    <ul class="benefits-list">
                        <?php foreach ($benefits as $benefit): ?>
                            <li><?php echo htmlspecialchars($benefit); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="info-section">
                    <h3>Hướng dẫn bảo quản</h3>
                    <ul class="storage-tips">
                        <?php foreach ($storage_tips as $tip): ?>
                            <li><?php echo htmlspecialchars($tip); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="social-share">
                <h3>Chia sẻ</h3>
                <a href="#" onclick="shareOnFacebook()"><i class="fab fa-facebook"></i></a>
                <a href="#" onclick="shareOnTwitter()"><i class="fab fa-twitter"></i></a>
                <a href="#" onclick="shareOnPinterest()"><i class="fab fa-pinterest"></i></a>
            </div>
        <?php else: ?>
            <div class="error-message">
                <p>Không tìm thấy thông tin sản phẩm.</p>
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
        function shareOnFacebook() {
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href));
        }

        function shareOnTwitter() {
            window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(window.location.href));
        }

        function shareOnPinterest() {
            window.open('https://pinterest.com/pin/create/button/?url=' + encodeURIComponent(window.location.href));
        }
    </script>
</body>
</html> 