<?php
session_start();
require_once('../data/c07db.php');

// Fetch carrot product details
$product_sql = "SELECT * FROM products WHERE product_id = 'F001'";
$product_result = $conn->query($product_sql);

if ($product_result->num_rows == 0) {
    header("Location: products.php");
    exit();
}

$product = $product_result->fetch_assoc();

// Update view count
$update_views = "UPDATE products SET views = views + 1 WHERE product_id = 'F001'";
$conn->query($update_views);

// Function to format currency
function formatCurrency($amount) {
    return number_format($amount, 0, ',', '.') . ' đ';
}

// Function to format JSON data
function formatJsonData($jsonString) {
    $data = json_decode($jsonString, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        return $data;
    }
    return [];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cà rốt - SEA FRUITS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../styles/grid.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <style>
        .product-detail {
            max-width: 1200px;
            margin: 30px auto;
            padding: 30px;
            background: #fff;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .product-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #4CAF50;
        }

        .product-title {
            color: #4CAF50;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .product-category {
            color: #666;
            font-size: 16px;
        }

        .product-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .product-image {
            text-align: center;
        }

        .product-image img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .product-info {
            padding: 20px;
        }

        .product-price {
            font-size: 24px;
            color: #4CAF50;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .product-description {
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .product-stock {
            margin-bottom: 20px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .product-stock i {
            color: #4CAF50;
            margin-right: 10px;
        }

        .product-features {
            margin-bottom: 20px;
        }

        .feature-item {
            margin-bottom: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .feature-title {
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .feature-content {
            line-height: 1.6;
        }

        .add-to-cart {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-top: 30px;
        }

        .quantity-input {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-input button {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .quantity-input input {
            width: 50px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
        }

        .add-to-cart-button {
            flex: 1;
            padding: 15px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .add-to-cart-button:hover {
            background: #45a049;
        }

        .product-tips {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .tips-title {
            color: #4CAF50;
            font-size: 20px;
            margin-bottom: 15px;
        }

        .tips-list {
            list-style-type: none;
            padding: 0;
        }

        .tips-list li {
            margin-bottom: 10px;
            padding-left: 25px;
            position: relative;
        }

        .tips-list li:before {
            content: "•";
            color: #4CAF50;
            position: absolute;
            left: 0;
        }

        @media (max-width: 768px) {
            .product-content {
                grid-template-columns: 1fr;
            }
            
            .product-detail {
                margin: 15px;
                padding: 15px;
            }
            
            .add-to-cart {
                flex-direction: column;
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

    <div class="product-detail">
        <div class="product-header">
            <h1 class="product-title"><?php echo htmlspecialchars($product['product_name']); ?></h1>
            <p class="product-category"><?php echo htmlspecialchars($product['category']); ?></p>
        </div>

        <div class="product-content">
            <div class="product-image">
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
            </div>

            <div class="product-info">
                <div class="product-price">
                    <?php echo formatCurrency($product['price']); ?>
                </div>

                <div class="product-description">
                    <?php echo htmlspecialchars($product['description']); ?>
                </div>

                <div class="product-stock">
                    <i class="fas fa-box"></i>
                    <?php if ($product['stock_quantity'] > 0): ?>
                        Còn hàng: <?php echo $product['stock_quantity']; ?> kg
                    <?php else: ?>
                        Hết hàng
                    <?php endif; ?>
                </div>

                <div class="product-features">
                    <?php
                    $nutritionInfo = formatJsonData($product['nutrition_info']);
                    if (!empty($nutritionInfo)): ?>
                        <div class="feature-item">
                            <div class="feature-title">Thông tin dinh dưỡng</div>
                            <div class="feature-content">
                                <ul>
                                    <?php foreach ($nutritionInfo as $key => $value): ?>
                                        <li><?php echo htmlspecialchars($key . ': ' . $value); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                    $benefits = formatJsonData($product['benefits']);
                    if (!empty($benefits)): ?>
                        <div class="feature-item">
                            <div class="feature-title">Lợi ích sức khỏe</div>
                            <div class="feature-content">
                                <ul>
                                    <?php foreach ($benefits as $benefit): ?>
                                        <li><?php echo htmlspecialchars($benefit); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="add-to-cart">
                    <div class="quantity-input">
                        <button type="button" onclick="decreaseQuantity()">-</button>
                        <input type="number" id="quantity" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>">
                        <button type="button" onclick="increaseQuantity()">+</button>
                    </div>
                    <button class="add-to-cart-button" onclick="addToCart()">
                        <i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng
                    </button>
                </div>
            </div>
        </div>

        <div class="product-tips">
            <h3 class="tips-title">Mẹo bảo quản cà rốt</h3>
            <ul class="tips-list">
                <?php
                $storageTips = formatJsonData($product['storage_tips']);
                if (!empty($storageTips)):
                    foreach ($storageTips as $tip):
                ?>
                    <li><?php echo htmlspecialchars($tip); ?></li>
                <?php
                    endforeach;
                endif;
                ?>
            </ul>
        </div>
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
                    <h3>Liên hệ</h3>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận XYZ, TP.HCM</li>
                        <li><i class="fas fa-phone"></i> 0123 456 789</li>
                        <li><i class="fas fa-envelope"></i> info@example.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> SEA FRUITS. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function decreaseQuantity() {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function increaseQuantity() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.getAttribute('max'));
            if (parseInt(input.value) < max) {
                input.value = parseInt(input.value) + 1;
            }
        }

        function addToCart() {
            const quantity = document.getElementById('quantity').value;
            // Add to cart logic here
            alert('Đã thêm ' + quantity + ' kg cà rốt vào giỏ hàng');
        }
    </script>
</body>
</html> 