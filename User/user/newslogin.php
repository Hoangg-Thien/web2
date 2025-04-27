<?php
session_start();
require_once('connect.php');

// Function to get news articles
function getNewsArticles($conn, $limit = 10) {
    $query = "SELECT * FROM news ORDER BY created_at DESC LIMIT ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to search news
function searchNews($conn, $keyword) {
    $query = "SELECT * FROM news WHERE title LIKE ? OR content LIKE ? ORDER BY created_at DESC";
    $searchTerm = "%$keyword%";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
    return $stmt->get_result();
}

// Get news articles
$news_articles = getNewsArticles($conn);

// Handle search
$search_results = null;
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_results = searchNews($conn, $_GET['search']);
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
    <title>Tin tức - SEA FRUITS</title>  
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
        <style>
        
        .news-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .featured-news h2, .news-categories h2 {
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
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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
        }

        .article-content {
            padding: 25px;
            flex: 1;
            background: #fff;
            position: relative;
        }

        .article-tag {
            position: absolute;
            top: -15px;
            left: 25px;
            background: #ff6b6b;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .article-content h3 {
            color: #2d3436;
            font-size: 1.8em;
            margin: 15px 0;
            line-height: 1.3;
            font-weight: 700;
        }

        .article-meta {
            display: flex;
            gap: 20px;
            color: #636e72;
            font-size: 0.9em;
            margin-bottom: 20px;
        }

        .article-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .article-meta i {
            color: #4CAF50;
        }

        .article-highlights {
            list-style: none;
            padding: 0;
            margin: 15px 0;
        }

        .article-highlights li {
            margin: 10px 0;
            padding-left: 10px;
            border-left: 3px solid #4CAF50;
            font-size: 0.95em;
            color: #2d3436;
        }

        .article-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .read-more {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .read-more:hover {
            color: #45a049;
            transform: translateX(5px);
        }

        .article-share {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .article-share span {
            color: #636e72;
            font-size: 0.9em;
        }

        .share-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .share-btn:hover {
            transform: translateY(-3px);
        }

        .share-btn.facebook {
            background: #3b5998;
        }

        .share-btn.twitter {
            background: #1da1f2;
        }

        .share-btn.pinterest {
            background: #bd081c;
        }

        .excerpt {
            color: #636e72;
            line-height: 1.6;
            font-size: 1em;
            margin: 15px 0;
        }

        @media (max-width: 768px) {
            .article-meta {
                flex-wrap: wrap;
                gap: 10px;
            }

            .article-footer {
                flex-direction: column;
                gap: 15px;
            }

            .article-share {
            width: 100%;
                justify-content: center;
            }
        }

        /* Responsive Design */
        @media screen and (max-width: 1200px) {
            .news-container {
                padding: 0 15px;
            }

            .news-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
            }
        }

        @media screen and (max-width: 992px) {
            .news-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .featured-article {
                flex-direction: column;
            }

            .featured-article img {
                width: 100%;
                height: 300px;
            }

            .article-content {
                padding: 20px;
            }

            .category-buttons {
                justify-content: center;
                gap: 10px;
            }

            .category-btn {
                padding: 6px 15px;
                font-size: 0.9em;
            }
        }

        @media screen and (max-width: 768px) {
            .featured-news h2, .news-categories h2 {
                font-size: 20px;
            text-align: center;
        }

            .article-content h3 {
                font-size: 1.5em;
            }

            .article-meta {
                flex-direction: column;
                gap: 8px;
            }

            .article-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .article-share {
            width: 100%;
                justify-content: flex-start;
            }

            .news-item {
                margin-bottom: 20px;
            }
        }

        @media screen and (max-width: 576px) {
            .news-grid {
                grid-template-columns: 1fr;
            }

            .featured-article img {
                height: 200px;
            }

            .category-buttons {
                flex-wrap: wrap;
            }

            .category-btn {
                width: calc(50% - 10px);
            text-align: center;
                margin: 5px;
            }

            .article-highlights li {
                font-size: 0.9em;
                padding-left: 8px;
            }

            .news-tag {
                font-size: 0.75em;
            }

            .news-content h4 {
                font-size: 1.1em;
            }

            .news-content p {
                font-size: 0.9em;
            }
        }

        /* Cải thiện hiệu ứng hover cho mobile */
        @media (hover: hover) {
            .news-item:hover {
                transform: translateY(-5px);
            }

            .share-btn:hover {
                transform: translateY(-3px);
            }

            .read-more:hover {
                transform: translateX(5px);
            }
        }

        /* Tối ưu cho màn hình retina */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .news-item img,
            .featured-article img {
                image-rendering: -webkit-optimize-contrast;
            }
        }

        /* Cải thiện loading cho ảnh */
        .news-item img,
        .featured-article img {
            transition: opacity 0.3s ease;
            will-change: opacity;
            loading: lazy;
        }

        /* Cải thiện accessibility */
        .category-btn:focus,
        .read-more:focus,
        .share-btn:focus {
            outline: 2px solid #4CAF50;
            outline-offset: 2px;
        }

        /* Thêm animation mượt mà */
        .news-item {
            animation: fadeIn 0.5s ease-out;
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

        /* Cải thiện loading state */
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

        /* Tối ưu performance */
        .news-grid {
            contain: content;
            will-change: transform;
        }

        /* Cải thiện touch targets cho mobile */
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

        /* Add these styles to your existing CSS */
        .read-more-btn {
            display: inline-block;
            padding: 8px 16px;
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

    <div class="sea-fruit-container" >  
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
                <a href="../index.php" class="active">Trang chủ</a>  
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
                    <input type="text" id="searchBox" name="search" placeholder="Tìm kiếm tin tức..." 
                           value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit"><i class="fas fa-search"></i> Tìm kiếm</button>
                </form>
                </div>
        
            
            <div class="dropdown">
                <button class="dropdown-button">
                    <i class="fa-solid fa-user" style="margin-right: 10px;"></i> 
                    <span>Hi,User!</span>
                </button>
                <div class="dropdown-menu">
                  <a href="../user/userinfo.php">Tài khoản</a>
                  <a href="../user/history-user.php">Lịch sử</a>
                  <a href="../user/invoice-summary.php">Tóm tắt hóa đơn</a>
                  <a href="../user/usernologin.php">Đăng xuất</a>
                </div>
                </div>
            </div>
        </div>
    <div class="news-container">
        <!-- Featured News Section -->
        <div class="featured-news">
            <h2>Tin tức nổi bật</h2>
            <?php
            // Get featured news
            $featured_query = "SELECT * FROM news WHERE is_featured = 1 ORDER BY created_at DESC LIMIT 1";
            $featured_result = $conn->query($featured_query);
            if ($featured_result && $featured_result->num_rows > 0) {
                $featured_article = $featured_result->fetch_assoc();
            ?>
                <div class="featured-article">
                    <img src="<?php echo htmlspecialchars($featured_article['image_url']); ?>" alt="<?php echo htmlspecialchars($featured_article['title']); ?>">
                    <div class="article-content">
                        <h3><?php echo htmlspecialchars($featured_article['title']); ?></h3>
                        <div class="article-meta">
                            <span><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($featured_article['created_at'])); ?></span>
                            <span><i class="far fa-eye"></i> <?php echo number_format($featured_article['views']); ?> lượt xem</span>
                            <span><i class="far fa-comment"></i> <?php echo number_format($featured_article['comments']); ?> bình luận</span>
                        </div>
                        <p class="excerpt">
                            <?php echo htmlspecialchars($featured_article['excerpt']); ?>
                            <?php if(!empty($featured_article['highlights'])): ?>
                            <ul class="article-highlights">
                                <?php 
                                $highlights = explode("\n", $featured_article['highlights']);
                                foreach($highlights as $highlight):
                                ?>
                                    <li><?php echo htmlspecialchars($highlight); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </p>
                        <div class="article-footer">
                            <a href="news-detail.php?id=<?php echo $featured_article['id']; ?>" class="read-more">Đọc tiếp <i class="fas fa-arrow-right"></i></a>
                            <div class="article-share">
                                <span>Chia sẻ:</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class="share-btn facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($featured_article['title']); ?>" class="share-btn twitter" target="_blank"><i class="fab fa-twitter"></i></a>
                                <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>&description=<?php echo urlencode($featured_article['title']); ?>" class="share-btn pinterest" target="_blank"><i class="fab fa-pinterest-p"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div>

        <!-- News Categories -->
        <div class="news-categories">
            <h2>Danh mục tin tức</h2>
            <div class="category-buttons">
                <button class="category-btn active" data-category="all" onclick="filterNews('all')">Tất cả</button>
                <button class="category-btn" data-category="Trái cây" onclick="filterNews('Trái cây')">Trái cây</button>
                <button class="category-btn" data-category="Rau củ" onclick="filterNews('Rau củ')">Rau củ</button>
            </div>
            </div>
        <!-- News Grid -->
        <div class="news-grid">
            <?php
            // Fetch news from database
            $news_query = "SELECT * FROM news ORDER BY created_at DESC";
            $news_result = $conn->query($news_query);

            if ($news_result && $news_result->num_rows > 0) {
                while($news = $news_result->fetch_assoc()) {
            ?>
                <div class="news-item" data-category="<?php echo htmlspecialchars($news['category']); ?>">
                    <img src="<?php echo htmlspecialchars($news['image_url']); ?>" alt="<?php echo htmlspecialchars($news['title']); ?>">
                    <div class="news-content">
                        <span class="news-tag"><?php echo htmlspecialchars($news['category']); ?></span>
                        <h4><?php echo htmlspecialchars($news['title']); ?></h4>
                        <p class="date"><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($news['created_at'])); ?></p>
                        <p><?php echo htmlspecialchars($news['excerpt']); ?></p>
                        <a href="news-detail.php?id=<?php echo $news['id']; ?>" class="read-more">Xem thêm</a>
                    </div>
                </div>
            <?php
                }
            } else {
                echo '<p>Không có tin tức nào.</p>';
            }
            ?>
        </div>
    </div>
    <div class="logo" style="color:#444444;padding-bottom:30px ; height: 150px;">
        <img src="../img/seafruits-logo.png" alt="seafruits-logo">
        <div style="padding:10px;">
            <div>Hotline: 0123456789</div>
            <div>Email: AboutUs@gmail.com</div>
            </div>
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
    


    <script>
        
        function confirmAddToCart(productId) {
        if (confirm("Bạn có chắc muốn thêm sản phẩm này vào giỏ hàng không?")) {
            addToCart(productId);
        }
    }

    function addToCart(productId) {
        // Tạm thời dùng alert để test
        console.log("Thêm sản phẩm: " + productId);
        alert("Đã thêm sản phẩm vào giỏ hàng!");
        
        // TODO: Gửi AJAX hoặc xử lý thêm giỏ hàng thực tế tại đây
    }
        
const input = document.getElementById("searchInput");
    const suggestBox = document.getElementById("suggestBox");
    
    input.addEventListener("keyup", function () {
        const query = input.value.trim();
        if (query.length > 0) {
            fetch(`./user/suggest.php?term=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    suggestBox.innerHTML = "";
                    data.forEach(item => {
                        const div = document.createElement("div");
                        div.textContent = item;
                        div.onclick = () => {
                            input.value = item;
                            suggestBox.innerHTML = "";
                        };
                        suggestBox.appendChild(div);
                    });
                });
        } else {
            suggestBox.innerHTML = "";
        }
    });
    
    document.addEventListener("click", function (e) {
        if (e.target !== input) {
            suggestBox.innerHTML = "";
        }
    });


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

    document.getElementById("toggleSearch").addEventListener("click", function () {
        document.getElementById("searchModal").style.display = "flex";
    });

    document.querySelector(".close").addEventListener("click", function () {
        document.getElementById("searchModal").style.display = "none";
    });

    // Đóng khi nhấn ra ngoài modal
    window.onclick = function (event) {
        let modal = document.getElementById("searchModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
    </script>

     
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
<style>
        
        .news-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .featured-news h2, .news-categories h2 {
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
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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
        }

        .article-content {
            padding: 25px;
            flex: 1;
            background: #fff;
            position: relative;
        }

        .article-tag {
            position: absolute;
            top: -15px;
            left: 25px;
            background: #ff6b6b;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .article-content h3 {
            color: #2d3436;
            font-size: 1.8em;
            margin: 15px 0;
            line-height: 1.3;
            font-weight: 700;
        }

        .article-meta {
            display: flex;
            gap: 20px;
            color: #636e72;
            font-size: 0.9em;
            margin-bottom: 20px;
        }

        .article-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .article-meta i {
            color: #4CAF50;
        }

        .article-highlights {
            list-style: none;
            padding: 0;
            margin: 15px 0;
        }

        .article-highlights li {
            margin: 10px 0;
            padding-left: 10px;
            border-left: 3px solid #4CAF50;
            font-size: 0.95em;
            color: #2d3436;
        }

        .article-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .read-more {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .read-more:hover {
            color: #45a049;
            transform: translateX(5px);
        }

        .article-share {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .article-share span {
            color: #636e72;
            font-size: 0.9em;
        }

        .share-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .share-btn:hover {
            transform: translateY(-3px);
        }

        .share-btn.facebook {
            background: #3b5998;
        }

        .share-btn.twitter {
            background: #1da1f2;
        }

        .share-btn.pinterest {
            background: #bd081c;
        }

        .excerpt {
            color: #636e72;
            line-height: 1.6;
            font-size: 1em;
            margin: 15px 0;
        }

        @media (max-width: 768px) {
            .article-meta {
                flex-wrap: wrap;
                gap: 10px;
            }

            .article-footer {
                flex-direction: column;
                gap: 15px;
            }

            .article-share {
                width: 100%;
                justify-content: center;
            }
        }

        /* Responsive Design */
        @media screen and (max-width: 1200px) {
            .news-container {
                padding: 0 15px;
            }

            .news-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
            }
        }

        @media screen and (max-width: 992px) {
            .news-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .featured-article {
                flex-direction: column;
            }

            .featured-article img {
                width: 100%;
                height: 300px;
            }

            .article-content {
                padding: 20px;
            }

            .category-buttons {
                justify-content: center;
                gap: 10px;
            }

            .category-btn {
                padding: 6px 15px;
                font-size: 0.9em;
            }
        }

        @media screen and (max-width: 768px) {
            .featured-news h2, .news-categories h2 {
                font-size: 20px;
                text-align: center;
            }

            .article-content h3 {
                font-size: 1.5em;
            }

            .article-meta {
                flex-direction: column;
                gap: 8px;
            }

            .article-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .article-share {
                width: 100%;
                justify-content: flex-start;
            }

            .news-item {
                margin-bottom: 20px;
            }
        }

        @media screen and (max-width: 576px) {
            .news-grid {
                grid-template-columns: 1fr;
            }

            .featured-article img {
                height: 200px;
            }

            .category-buttons {
                flex-wrap: wrap;
            }

            .category-btn {
                width: calc(50% - 10px);
                text-align: center;
                margin: 5px;
            }

            .article-highlights li {
                font-size: 0.9em;
                padding-left: 8px;
            }

            .news-tag {
                font-size: 0.75em;
            }

            .news-content h4 {
                font-size: 1.1em;
            }

            .news-content p {
                font-size: 0.9em;
            }
        }

        /* Cải thiện hiệu ứng hover cho mobile */
        @media (hover: hover) {
            .news-item:hover {
                transform: translateY(-5px);
            }

            .share-btn:hover {
                transform: translateY(-3px);
            }

            .read-more:hover {
                transform: translateX(5px);
            }
        }

        /* Tối ưu cho màn hình retina */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .news-item img,
            .featured-article img {
                image-rendering: -webkit-optimize-contrast;
            }
        }

        /* Cải thiện loading cho ảnh */
        .news-item img,
        .featured-article img {
            transition: opacity 0.3s ease;
            will-change: opacity;
            loading: lazy;
        }

        /* Cải thiện accessibility */
        .category-btn:focus,
        .read-more:focus,
        .share-btn:focus {
            outline: 2px solid #4CAF50;
            outline-offset: 2px;
        }

        /* Thêm animation mượt mà */
        .news-item {
            animation: fadeIn 0.5s ease-out;
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

        /* Cải thiện loading state */
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

        /* Tối ưu performance */
        .news-grid {
            contain: content;
            will-change: transform;
        }

        /* Cải thiện touch targets cho mobile */
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
    </style>
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
    

<script>
    // JavaScript for product categories
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

    // JavaScript for news filtering
    function filterNews(category) {
        // Remove active class from all buttons
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        // Add active class to clicked button
        const clickedButton = document.querySelector(`[data-category="${category}"]`);
        if (clickedButton) {
            clickedButton.classList.add('active');
        }

        // Get all news items
        const newsItems = document.querySelectorAll('.news-item');

        // Show/hide news items based on category
        newsItems.forEach(item => {
            if (category === 'all') {
                item.style.display = 'block';
            } else {
                const itemCategory = item.getAttribute('data-category');
                // So sánh không phân biệt chữ hoa/thường
                if (itemCategory.toLowerCase() === category.toLowerCase()) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            }
        });

        // Add smooth animation
        newsItems.forEach(item => {
            if (item.style.display === 'block') {
                item.style.animation = 'fadeIn 0.5s ease-out';
            }
        });

        // Scroll to news grid
        document.querySelector('.news-grid').scrollIntoView({ behavior: 'smooth' });
    }

    // Add click event listeners to category buttons
    document.addEventListener('DOMContentLoaded', function() {
        const categoryButtons = document.querySelectorAll('.category-btn');
        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                filterNews(category);
            });
        });
    });
</script>


</body>
</html> 