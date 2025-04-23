<?php
require_once('../data/c07db.php');

// Fetch watermelon details from database
$sql = "SELECT * FROM product_details WHERE product_id = 'F009'";
$result = $conn->query($sql);

// Function to format JSON data
function formatJSON($jsonString) {
    return json_decode($jsonString, true);
}

// Update view count
if ($result->num_rows > 0) {
    $updateViews = "UPDATE product_details SET views = views + 1 WHERE product_id = 'F009'";
    $conn->query($updateViews);
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
    <title>Chi Tiết Dưa Hấu - SEA FRUITS</title>
    <style>
        .article-detail-container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .article-header {
            padding: 30px;
            background: #f8f9fa;
            border-bottom: 1px solid #eee;
        }

        .article-category {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #4CAF50;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9em;
            margin-bottom: 15px;
        }

        .article-content {
            padding: 30px;
        }

        .article-intro img {
            width: 60%;
            border-radius: 10px;
            margin-bottom: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .nutrition-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .nutrition-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .nutrition-item {
            text-align: center;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .nutrition-item i {
            font-size: 24px;
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .nutrition-item .number {
            display: block;
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .nutrition-item .label {
            display: block;
            color: #666;
            font-size: 14px;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 20px 0;
        }

        .benefit-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .benefit-card i {
            font-size: 2em;
            color: #4CAF50;
            margin-bottom: 15px;
        }

        .tips-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .tip-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .tip-card i {
            font-size: 2em;
            color: #4CAF50;
            margin-bottom: 15px;
        }

        .tip-list {
            list-style: none;
            padding: 0;
            text-align: left;
            margin-top: 10px;
        }

        .tip-list li {
            margin: 8px 0;
            font-size: 0.9em;
            color: #666;
        }

        .article-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .article-tags {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .article-tags a {
            color: #4CAF50;
            text-decoration: none;
        }

        .article-share {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .share-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
        }

        .share-btn.facebook {
            background: #3b5998;
        }

        .share-btn.twitter {
            background: #1da1f2;
        }

        .share-btn.pinterest {
            background: #e60023;
        }

        @media (max-width: 768px) {
            .nutrition-grid,
            .benefits-grid,
            .tips-grid {
                grid-template-columns: 1fr;
            }

            .article-footer {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }

            .article-intro img {
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

    <div class="article-detail-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while($product = $result->fetch_assoc()): ?>
                <?php
                    $nutrition = formatJSON($product['nutrition_info']);
                    $benefits = formatJSON($product['benefits']);
                    $tips = formatJSON($product['storage_tips']);
                ?>
                <div class="article-header">
                    <div class="article-category">
                        <i class="fas fa-leaf"></i>
                        <?php echo htmlspecialchars($product['category']); ?>
                    </div>
                    <h1><?php echo htmlspecialchars($product['title']); ?></h1>
                    <div class="article-meta">
                        <span><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($product['created_at'])); ?></span>
                        <span><i class="far fa-eye"></i> <?php echo number_format($product['views']); ?> lượt xem</span>
                        <span><i class="far fa-comment"></i> <?php echo $product['comments']; ?> bình luận</span>
                    </div>
                </div>

                <div class="article-content">
                    <div class="article-intro">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
                        <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                    </div>

                    <div class="nutrition-info">
                        <h2><i class="fas fa-star"></i> Giá Trị Dinh Dưỡng</h2>
                        <div class="nutrition-grid">
                            <div class="nutrition-item">
                                <i class="fas fa-tint"></i>
                                <span class="number"><?php echo $nutrition['water']; ?></span>
                                <span class="label">Nước</span>
                            </div>
                            <div class="nutrition-item">
                                <i class="fas fa-fire"></i>
                                <span class="number"><?php echo $nutrition['calories']; ?></span>
                                <span class="label">Calories</span>
                            </div>
                            <div class="nutrition-item">
                                <i class="fas fa-vitamin"></i>
                                <span class="number"><?php echo $nutrition['vitamin_c']; ?></span>
                                <span class="label">Vitamin C</span>
                            </div>
                        </div>
                    </div>

                    <div class="benefits-section">
                        <h2><i class="fas fa-heart"></i> Lợi Ích Sức Khỏe</h2>
                        <div class="benefits-grid">
                            <?php foreach ($benefits as $key => $value): ?>
                                <div class="benefit-card">
                                    <i class="fas fa-check-circle"></i>
                                    <h3><?php echo htmlspecialchars($value); ?></h3>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="tips-section">
                        <h2><i class="fas fa-lightbulb"></i> Mẹo Chọn Và Bảo Quản</h2>
                        <div class="tips-grid">
                            <div class="tip-card">
                                <i class="fas fa-search"></i>
                                <h3>Cách Chọn</h3>
                                <ul class="tip-list">
                                    <?php foreach ($tips['selection'] as $tip): ?>
                                        <li><?php echo htmlspecialchars($tip); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="tip-card">
                                <i class="fas fa-temperature-low"></i>
                                <h3>Bảo Quản</h3>
                                <ul class="tip-list">
                                    <?php foreach ($tips['storage'] as $tip): ?>
                                        <li><?php echo htmlspecialchars($tip); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="tip-card">
                                <i class="fas fa-utensils"></i>
                                <h3>Cách Dùng</h3>
                                <ul class="tip-list">
                                    <?php foreach ($tips['usage'] as $tip): ?>
                                        <li><?php echo htmlspecialchars($tip); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="article-footer">
                    <div class="article-tags">
                        <span>Tags:</span>
                        <a href="#">#duahau</a>
                        <a href="#">#gianihet</a>
                        <a href="#">#muabe</a>
                        <a href="#">#suckhoe</a>
                    </div>
                    <div class="article-share">
                        <span>Chia sẻ bài viết:</span>
                        <a href="#" class="share-btn facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="share-btn twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="share-btn pinterest"><i class="fab fa-pinterest-p"></i></a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="article-content">
                <p>Không tìm thấy thông tin về dưa hấu.</p>
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