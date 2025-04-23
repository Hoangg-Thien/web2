<?php
require_once('../data/c07db.php');

// Fetch promotion details from database
$sql = "SELECT p.*, s.product_name, s.product_price, s.image_url as product_image 
        FROM promotions p 
        JOIN sanpham s ON p.product_id = s.product_id 
        WHERE p.product_id = 'F008' 
        AND CURDATE() BETWEEN p.start_date AND p.end_date";
$result = $conn->query($sql);

// Function to format currency
function formatCurrency($amount) {
    return number_format($amount, 0, ',', '.') . 'đ';
}

// Function to calculate discount price
function calculateDiscountPrice($originalPrice, $discountPercent) {
    return $originalPrice * (1 - $discountPercent/100);
}
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
    <title>Khuyến Mãi Đu Đủ - SEA FRUITS</title>
    <style>
        .promotion-container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .promotion-header {
            padding: 30px;
            background: #f8f9fa;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        .promotion-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ff6b6b;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9em;
            margin-bottom: 15px;
        }

        .promotion-title {
            color: #333;
            margin-bottom: 20px;
        }

        .promotion-meta {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 15px;
            color: #666;
            font-size: 0.9em;
        }

        .promotion-content {
            padding: 30px;
        }

        .product-image {
            width: 60%;
            border-radius: 10px;
            margin: 0 auto 20px;
            display: block;
        }

        .price-section {
            background: #fff3f3;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }

        .original-price {
            text-decoration: line-through;
            color: #999;
            font-size: 1.2em;
        }

        .discount-price {
            color: #ff6b6b;
            font-size: 1.8em;
            font-weight: bold;
            margin: 10px 0;
        }

        .discount-badge {
            background: #ff6b6b;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
            display: inline-block;
            margin-left: 10px;
        }

        .promotion-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .detail-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .detail-card i {
            font-size: 2em;
            color: #ff6b6b;
            margin-bottom: 15px;
        }

        .detail-list {
            list-style: none;
            padding: 0;
            text-align: left;
            margin-top: 10px;
        }

        .detail-list li {
            margin: 8px 0;
            font-size: 0.9em;
            color: #666;
        }

        .cta-button {
            display: inline-block;
            background: #ff6b6b;
            color: white;
            padding: 15px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
            transition: background 0.3s;
        }

        .cta-button:hover {
            background: #ff5252;
        }

        @media (max-width: 768px) {
            .promotion-details {
                grid-template-columns: 1fr;
            }

            .product-image {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-top">
            <div class="container">
                <div class="header-top-left">
                    <a href="tel:0123456789"><i class="fas fa-phone"></i> 0123 456 789</a>
                    <a href="mailto:info@example.com"><i class="fas fa-envelope"></i> info@example.com</a>
                </div>
                <div class="header-top-right">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="header-main">
            <div class="container">
                <div class="logo">
                    <a href="../index.php"><img src="../img/logo.png" alt="Logo"></a>
                </div>
                <nav class="main-menu">
                    <ul>
                        <li><a href="../index.php">Trang chủ</a></li>
                        <li><a href="products.php">Sản phẩm</a></li>
                        <li><a href="about.php">Giới thiệu</a></li>
                        <li><a href="contact.php">Liên hệ</a></li>
                    </ul>
                </nav>
                <div class="header-icons">
                    <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                    <a href="account.php"><i class="fas fa-user"></i></a>
                </div>
            </div>
        </div>
    </header>

    <div class="promotion-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while($promotion = $result->fetch_assoc()): ?>
                <div class="promotion-header">
                    <div class="promotion-badge">
                        <i class="fas fa-gift"></i>
                        Khuyến mãi
                    </div>
                    <h1 class="promotion-title"><?php echo htmlspecialchars($promotion['title']); ?></h1>
                    <div class="promotion-meta">
                        <span><i class="far fa-calendar-alt"></i> Từ <?php echo date('d/m/Y', strtotime($promotion['start_date'])); ?> đến <?php echo date('d/m/Y', strtotime($promotion['end_date'])); ?></span>
                        <span><i class="far fa-eye"></i> <?php echo number_format($promotion['views']); ?> lượt xem</span>
                    </div>
                </div>

                <div class="promotion-content">
                    <img src="<?php echo htmlspecialchars($promotion['product_image']); ?>" alt="<?php echo htmlspecialchars($promotion['product_name']); ?>" class="product-image">
                    
                    <div class="price-section">
                        <div class="original-price"><?php echo formatCurrency($promotion['product_price']); ?></div>
                        <div class="discount-price">
                            <?php echo formatCurrency(calculateDiscountPrice($promotion['product_price'], $promotion['discount_percent'])); ?>
                            <span class="discount-badge">-<?php echo $promotion['discount_percent']; ?>%</span>
                        </div>
                    </div>

                    <div class="promotion-details">
                        <div class="detail-card">
                            <i class="fas fa-calendar-check"></i>
                            <h3>Thời gian áp dụng</h3>
                            <ul class="detail-list">
                                <li>Từ <?php echo date('d/m/Y', strtotime($promotion['start_date'])); ?></li>
                                <li>Đến <?php echo date('d/m/Y', strtotime($promotion['end_date'])); ?></li>
                                <li>Áp dụng tất cả các ngày trong tuần</li>
                            </ul>
                        </div>
                        <div class="detail-card">
                            <i class="fas fa-tags"></i>
                            <h3>Điều kiện áp dụng</h3>
                            <ul class="detail-list">
                                <li>Áp dụng cho đu đủ loại 1</li>
                                <li>Mua tối thiểu 1kg</li>
                                <li>Không áp dụng cùng các chương trình khác</li>
                            </ul>
                        </div>
                    </div>

                    <div style="text-align: center;">
                        <a href="products.php" class="cta-button">Mua ngay</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="promotion-content">
                <p>Hiện tại không có chương trình khuyến mãi nào cho đu đủ.</p>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <div class="container">
            <div class="footer-top">
                <div class="footer-column">
                    <h3>Về chúng tôi</h3>
                    <p>Chúng tôi cung cấp các sản phẩm rau củ quả tươi ngon, chất lượng cao với giá cả hợp lý.</p>
                </div>
                <div class="footer-column">
                    <h3>Liên kết nhanh</h3>
                    <ul>
                        <li><a href="../index.php">Trang chủ</a></li>
                        <li><a href="products.php">Sản phẩm</a></li>
                        <li><a href="about.php">Giới thiệu</a></li>
                        <li><a href="contact.php">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Thông tin liên hệ</h3>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận XYZ</li>
                        <li><i class="fas fa-phone"></i> 0123 456 789</li>
                        <li><i class="fas fa-envelope"></i> info@example.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Fresh Food. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Update view count
        function updateViewCount(promotionId) {
            fetch('update_views.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'promotion_id=' + promotionId
            });
        }

        // Share buttons
        document.querySelectorAll('.share-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const url = window.location.href;
                const title = document.querySelector('h1').textContent;
                
                if (this.classList.contains('facebook')) {
                    window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url), '_blank');
                } else if (this.classList.contains('twitter')) {
                    window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(title), '_blank');
                } else if (this.classList.contains('pinterest')) {
                    window.open('https://pinterest.com/pin/create/button/?url=' + encodeURIComponent(url) + '&description=' + encodeURIComponent(title), '_blank');
                }
            });
        });
    </script>
</body>
</html>