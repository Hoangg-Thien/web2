<?php
require_once('../data/c07db.php');

// Fetch all tips from database
$sql = "SELECT * FROM tomato_tips ORDER BY tip_id";
$result = $conn->query($sql);

// Function to format content into list items
function formatContent($content) {
    $items = explode(',', $content);
    $formatted = '<ul class="tip-list">';
    foreach ($items as $item) {
        $formatted .= '<li>' . trim($item) . '</li>';
    }
    $formatted .= '</ul>';
    return $formatted;
}

// Function to get icon based on category
function getCategoryIcon($category) {
    switch ($category) {
        case 'intro':
            return 'fas fa-leaf';
        case 'selection':
            return 'fas fa-search';
        case 'storage':
            return 'fas fa-temperature-low';
        case 'methods':
            return 'fas fa-box-open';
        case 'avoid':
            return 'fas fa-exclamation-triangle';
        case 'duration':
            return 'fas fa-clock';
        default:
            return 'fas fa-info-circle';
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
    <link rel="stylesheet" href="../styles/grid.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <title>Mẹo Bảo Quản Cà Chua Tươi Lâu</title>
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

        .tips-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
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

        .article-meta {
            display: flex;
            gap: 20px;
            margin-top: 15px;
            color: #666;
            font-size: 0.9em;
        }

        .article-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .article-section {
            margin: 30px 0;
        }

        .article-section h2 {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #4CAF50;
            margin-bottom: 20px;
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
            <?php while($tip = $result->fetch_assoc()): ?>
                <?php if ($tip['category'] == 'intro'): ?>
                    <div class="article-header">
                        <div class="article-category">
                            <i class="<?php echo getCategoryIcon($tip['category']); ?>"></i>
                            Rau củ
                        </div>
                        <h1><?php echo htmlspecialchars($tip['title']); ?></h1>
                        <div class="article-meta">
                            <span><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($tip['created_at'])); ?></span>
                            <span><i class="far fa-eye"></i> <?php echo number_format($tip['views']); ?> lượt xem</span>
                            <span><i class="far fa-comment"></i> <?php echo $tip['comments']; ?> bình luận</span>
                        </div>
                    </div>

                    <div class="article-content">
                        <div class="article-intro">
                            <?php if ($tip['image_url']): ?>
                                <img src="<?php echo htmlspecialchars($tip['image_url']); ?>" alt="<?php echo htmlspecialchars($tip['title']); ?>">
                            <?php endif; ?>
                            <p><?php echo nl2br(htmlspecialchars($tip['content'])); ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="article-section">
                        <h2><i class="<?php echo getCategoryIcon($tip['category']); ?>"></i> <?php echo htmlspecialchars($tip['title']); ?></h2>
                        <div class="tips-grid">
                            <?php echo formatContent($tip['content']); ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="article-content">
                <p>Không tìm thấy thông tin về mẹo bảo quản cà chua.</p>
            </div>
        <?php endif; ?>

        <div class="article-footer">
            <div class="article-tags">
                <span>Tags:</span>
                <a href="#">#cachua</a>
                <a href="#">#baoquan</a>
                <a href="#">#meovatchu</a>
                <a href="#">#raucu</a>
            </div>
            <div class="article-share">
                <span>Chia sẻ bài viết:</span>
                <a href="#" class="share-btn facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="share-btn twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" class="share-btn pinterest"><i class="fab fa-pinterest-p"></i></a>
            </div>
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
        function updateViewCount(tipId) {
            fetch('update_views.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'tip_id=' + tipId
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