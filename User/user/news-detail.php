<?php
session_start();
require_once('connect.php');

// Get news ID from URL
$news_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get news details
$sql = "SELECT * FROM news WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $news_id);
$stmt->execute();
$result = $stmt->get_result();
$news = $result->fetch_assoc();

// If news not found, redirect to news page
if (!$news) {
    header("Location: newslogin.php");
    exit();
}

// Update view count
$update_sql = "UPDATE news SET views = views + 1 WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("i", $news_id);
$update_stmt->execute();

// Get related news
$related_sql = "SELECT * FROM news WHERE category = ? AND id != ? ORDER BY created_at DESC LIMIT 3";
$related_stmt = $conn->prepare($related_sql);
$related_stmt->bind_param("si", $news['category'], $news_id);
$related_stmt->execute();
$related_result = $related_stmt->get_result();
$related_news = $related_result->fetch_all(MYSQLI_ASSOC);
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
    <title>Chi Tiết Tin Tức - SEA FRUITS</title>
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
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
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
        .dropdown-button i {
            color: #333;
        }
        .dropdown-button span {
            color: #333;
        }
        .article-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
        }

        .article-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #4CAF50, #8BC34A);
        }

        .article-header {
            text-align: center;
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 1px solid #eee;
            position: relative;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .article-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, #4CAF50, #8BC34A);
        }

        .article-title {
            font-size: 2.2em;
            color: #333;
            margin-bottom: 15px;
            line-height: 1.3;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
            padding: 0 15px;
            position: relative;
            display: inline-block;
        }

        .article-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, #4CAF50, #8BC34A);
            border-radius: 3px;
        }

        .article-meta {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .article-meta span {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            background: #f8f9fa;
            border-radius: 15px;
            transition: all 0.3s ease;
            font-size: 0.9em;
        }

        .article-meta span:hover {
            background: #e9f5ea;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(76, 175, 80, 0.1);
        }

        .article-meta i {
            margin-right: 6px;
            color: #4CAF50;
            font-size: 1em;
        }

        .article-image {
            width: 65%;
            max-height: 380px;
            object-fit: cover;
            border-radius: 12px;
            margin: 0 auto 35px;
            display: block;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .article-image:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        .article-content {
            font-size: 1.15em;
            line-height: 1.9;
            color: #444;
            margin-bottom: 50px;
            padding: 0 35px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
        }

        .read-more-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            position: relative;
        }

        .read-more-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #4CAF50, #8BC34A);
            border-radius: 3px;
        }

        .read-more-title {
            font-size: 1.1em;
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            position: relative;
            padding: 0 15px;
        }

        .read-more-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 2px;
            background: linear-gradient(90deg, #4CAF50, #8BC34A);
            border-radius: 2px;
        }

        .read-more-title i {
            color: #4CAF50;
            font-size: 1em;
            transition: transform 0.3s ease;
        }

        .read-more-title:hover i {
            transform: rotate(15deg);
        }

        .read-more-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }

        .read-more-card {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: block;
            position: relative;
            border: 1px solid rgba(76, 175, 80, 0.1);
        }

        .read-more-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(76, 175, 80, 0.05), rgba(139, 195, 74, 0.05));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .read-more-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-color: rgba(76, 175, 80, 0.2);
        }

        .read-more-card:hover::before {
            opacity: 1;
        }

        .read-more-image {
            width: 100%;
            height: 130px;
            overflow: hidden;
            position: relative;
        }

        .read-more-image::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 30%;
            background: linear-gradient(to top, rgba(0,0,0,0.1), transparent);
        }

        .read-more-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .read-more-card:hover .read-more-image img {
            transform: scale(1.05);
        }

        .read-more-content {
            padding: 12px;
            position: relative;
        }

        .read-more-heading {
            font-size: 0.9em;
            color: #333;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.3;
            font-weight: 500;
            position: relative;
            padding-left: 10px;
        }

        .read-more-heading::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: linear-gradient(to bottom, #4CAF50, #8BC34A);
            border-radius: 3px;
        }

        .read-more-excerpt {
            color: #666;
            font-size: 0.8em;
            line-height: 1.4;
            margin-bottom: 8px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            padding-left: 10px;
        }

        .read-more-meta {
            display: flex;
            gap: 10px;
            color: #888;
            font-size: 0.75em;
            padding-left: 10px;
        }

        .read-more-meta span {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 3px 8px;
            background: rgba(76, 175, 80, 0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .read-more-meta span:hover {
            background: rgba(76, 175, 80, 0.15);
            transform: translateY(-1px);
        }

        .read-more-meta i {
            color: #4CAF50;
            font-size: 0.8em;
        }

        @media (max-width: 768px) {
            .read-more-section {
                margin-top: 25px;
                padding-top: 15px;
            }

            .read-more-title {
                font-size: 1em;
                margin-bottom: 12px;
            }

            .read-more-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .read-more-image {
                height: 120px;
            }

            .read-more-content {
                padding: 10px;
            }

            .read-more-heading {
                font-size: 0.85em;
            }
        }

        .article-footer {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .share-buttons {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .share-buttons span {
            color: #666;
            font-weight: 500;
            font-size: 1.1em;
        }

        .share-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #f5f5f5;
            color: #666;
            transition: all 0.3s ease;
            font-size: 1.2em;
        }

        .share-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .share-btn.facebook:hover { background: #1877f2; color: white; }
        .share-btn.twitter:hover { background: #1da1f2; color: white; }
        .share-btn.linkedin:hover { background: #0a66c2; color: white; }

        .related-news {
            margin-top: 60px;
            padding-top: 40px;
            border-top: 1px solid #eee;
        }

        .related-news-title {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 35px;
            padding-bottom: 15px;
            border-bottom: 2px solid #4CAF50;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .related-news-title i {
            color: #4CAF50;
            font-size: 1.2em;
        }

        .related-news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }

        .related-news-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position: relative;
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .related-news-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .related-news-image {
            width: 100%;
            height: 220px;
            overflow: hidden;
        }

        .related-news-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .related-news-card:hover .related-news-image img {
            transform: scale(1.05);
        }

        .related-news-content {
            padding: 25px;
        }

        .related-news-heading {
            margin-bottom: 15px;
            font-size: 1.2em;
        }

        .related-news-heading a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-news-heading a:hover {
            color: #4CAF50;
        }

        .related-news-excerpt {
            color: #666;
            font-size: 0.95em;
            margin-bottom: 20px;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-news-meta {
            display: flex;
            gap: 20px;
            color: #888;
            font-size: 0.9em;
        }

        .meta-item {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .meta-item i {
            color: #4CAF50;
            font-size: 1.1em;
        }

        @media (max-width: 768px) {
            .related-news {
                margin-top: 40px;
                padding-top: 30px;
            }

            .related-news-title {
                font-size: 1.5em;
                margin-bottom: 25px;
            }

            .related-news-grid {
                grid-template-columns: 1fr;
            }

            .related-news-image {
                height: 200px;
            }

            .related-news-content {
                padding: 20px;
            }

            .related-news-heading {
                font-size: 1.1em;
            }

            .related-news-meta {
                gap: 15px;
            }
        }

        .back-to-news-btn {
            display: inline-flex;
            align-items: center;
            padding: 12px 25px;
            background: linear-gradient(45deg, #4CAF50, #8BC34A);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.2);
        }

        .back-to-news-btn i {
            margin-right: 12px;
            transition: transform 0.3s ease;
        }

        .back-to-news-btn:hover {
            transform: translateX(-5px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.3);
        }

        .back-to-news-btn:hover i {
            transform: translateX(-5px);
        }

        @media (max-width: 768px) {
            .article-container {
                padding: 20px;
            }

            .article-header {
                margin-bottom: 25px;
                padding-bottom: 20px;
            }

            .article-title {
                font-size: 1.7em;
                padding: 0 10px;
            }
            
            .article-content {
                font-size: 1em;
                padding: 0 20px;
            }

            .article-meta {
                gap: 8px;
            }
            
            .article-meta span {
                padding: 4px 8px;
                font-size: 0.85em;
            }

            .article-image {
                width: 90%;
                max-height: 300px;
            }

            .article-content h2,
            .article-content h3 {
                font-size: 1.4em;
            }
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
                    <span><?php if(isset($_SESSION['user_name'])) { echo "Xin chào, <strong>" . htmlspecialchars($_SESSION['user_name']) . "</strong>!"; } else { echo "Xin chào, <strong>User</strong>!"; } ?></span>
                </button>
                <div class="dropdown-menu">
                    <?php if(isset($_SESSION['user_name'])): ?>
                        <a href="../user/userinfo.php">Tài khoản</a>
                        <a href="../user/history-user.php">Lịch sử</a>
                        <a href="../user/invoice-summary.php">Tóm tắt hóa đơn</a>
                        <a href="../user/logout.php">Đăng xuất</a>
                    <?php else: ?>
                        <a href="../user/login-user.php">Đăng nhập</a>
                        <a href="../user/regis.php">Đăng ký</a>
                    <?php endif; ?>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="article-container">
        <a href="newslogin.php" class="back-to-news-btn">
            <i class="fas fa-arrow-left"></i>
            Quay lại trang tin tức
        </a>

        <div class="article-header">
            <h1 class="article-title"><?php echo htmlspecialchars($news['title']); ?></h1>
            <div class="article-meta">
                <span><i class="far fa-calendar"></i> <?php echo date('d/m/Y', strtotime($news['created_at'])); ?></span>
                <span style="margin-left: 20px;"><i class="far fa-eye"></i> <?php echo $news['views']; ?> lượt xem</span>
                <span style="margin-left: 20px;"><i class="far fa-comment"></i> <?php echo $news['comments']; ?> bình luận</span>
            </div>
        </div>

        <?php if ($news['image_url']): ?>
            <img src="<?php echo htmlspecialchars($news['image_url']); ?>" alt="<?php echo htmlspecialchars($news['title']); ?>" class="article-image">
        <?php endif; ?>

        <div class="article-content">
            <?php echo nl2br(htmlspecialchars($news['content'])); ?>
        </div>

        <div class="read-more-section">
            <h3 class="read-more-title">
                <i class="fas fa-book-reader"></i>
                Đọc thêm tin tức khác
            </h3>
            <div class="read-more-grid">
                <?php
                // Lấy 3 bài viết ngẫu nhiên khác
                $random_sql = "SELECT * FROM news WHERE id != ? ORDER BY RAND() LIMIT 3";
                $random_stmt = $conn->prepare($random_sql);
                $random_stmt->bind_param("i", $news_id);
                $random_stmt->execute();
                $random_result = $random_stmt->get_result();
                $random_news = $random_result->fetch_all(MYSQLI_ASSOC);

                foreach ($random_news as $random): ?>
                <a href="news-detail.php?id=<?php echo $random['id']; ?>" class="read-more-card">
                    <div class="read-more-image">
                        <?php if ($random['image_url']): ?>
                            <img src="<?php echo htmlspecialchars($random['image_url']); ?>" alt="<?php echo htmlspecialchars($random['title']); ?>">
                        <?php endif; ?>
                    </div>
                    <div class="read-more-content">
                        <h4 class="read-more-heading"><?php echo htmlspecialchars($random['title']); ?></h4>
                        <p class="read-more-excerpt"><?php echo htmlspecialchars($random['excerpt']); ?></p>
                        <div class="read-more-meta">
                            <span>
                                <i class="far fa-calendar"></i>
                                <?php echo date('d/m/Y', strtotime($random['created_at'])); ?>
                            </span>
                            <span>
                                <i class="far fa-eye"></i>
                                <?php echo number_format($random['views']); ?> lượt xem
                            </span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="article-footer">
            <div class="share-buttons">
                <span>Chia sẻ:</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" target="_blank" class="share-btn">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($news['title']); ?>" target="_blank" class="share-btn">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>&title=<?php echo urlencode($news['title']); ?>" target="_blank" class="share-btn">
                    <i class="fab fa-linkedin"></i>
                </a>
            </div>
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
    
            .news-grid {
                contain: content;
                will-change: transform;
            }
    
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
     
         <style>
            /* Style cho trang chi tiết ở đây */
            .article-detail-container {
                max-width: 1000px;
                margin: 30px auto;
                padding: 0 20px;
            }
    
            .breadcrumb {
            display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 20px;
                color: #666;
            }
    
            .breadcrumb a {
                color: #4CAF50;
                text-decoration: none;
            }
    
            .article-main {
                background: white;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                overflow: hidden;
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
    
            .intro-text {
                font-size: 1.2em;
                line-height: 1.8;
                color: #666;
                margin-bottom: 30px;
            }
    
            .nutrition-info {
                background: #f8f9fa;
                border-radius: 10px;
                padding: 20px;
                margin: 20px 0;
            }
    
            .nutrition-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
                margin-bottom: 30px;
            }
    
            .nutrition-item {
                text-align: center;
                padding: 15px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                transition: transform 0.3s ease;
            }
    
            .nutrition-item:hover {
                transform: translateY(-5px);
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
    
            .benefit-list {
                background: white;
                padding: 20px;
                border-radius: 8px;
                margin: 20px 0;
            }
    
            .benefit-list h3 {
                color: #333;
                margin-bottom: 15px;
            }
    
            .benefit-list ul {
                list-style: none;
                padding: 0;
            }
    
            .benefit-list li {
                margin: 10px 0;
                color: #666;
                display: flex;
                align-items: center;
            }
    
            .benefit-list li i {
                color: #4CAF50;
                margin-right: 10px;
            }
    
            .did-you-know {
                background: #e8f5e9;
                padding: 20px;
                border-radius: 8px;
                margin-top: 20px;
                display: flex;
                align-items: center;
                gap: 15px;
            }
    
            .did-you-know i {
                font-size: 24px;
                color: #4CAF50;
            }
    
            .did-you-know p {
                margin: 0;
                color: #333;
                font-style: italic;
            }
    
            .tips-grid {
            display: grid;
                grid-template-columns: repeat(3, 1fr);
            gap: 20px;
                margin-top: 20px;
        }
    
            .tip-item {
                text-align: center;
                padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            }
    
            .tip-item i {
                font-size: 2em;
                color: #4CAF50;
                margin-bottom: 15px;
            }
    
            .article-footer {
                padding: 20px 30px;
                border-top: 1px solid #eee;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
    
            .tags a {
                color: #4CAF50;
                text-decoration: none;
                margin-right: 10px;
            }
    
            @media (max-width: 768px) {
                .tips-grid {
                    grid-template-columns: 1fr;
                }
    
                .article-footer {
                    flex-direction: column;
                    gap: 20px;
                }
    
                .nutrition-info {
                    flex-direction: column;
                    gap: 15px;
                }
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
                transition: transform 0.3s ease;
            }
    
            .benefit-card:hover {
                transform: translateY(-5px);
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
    
        @media (max-width: 768px) {
                .benefits-grid {
                grid-template-columns: 1fr;
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
        function showFruits(category) {
            let fruitList = document.getElementById("fruitList");
            let categoryTitle = document.getElementById("categoryTitle");
            let fruitItems = document.getElementById("fruitItems");
            
            categoryTitle.textContent = category;
            fruitItems.innerHTML = "";
            
            // Thêm các loại trái cây tương ứng với danh mục
            if (category === "Trái cây ngon") {
                addFruitItem("Dưa hấu", "../img/watermelonheader.png");
                addFruitItem("Cam", "../img/orangeheader.png");
                addFruitItem("Quýt", "../img/tangerineheader.png");
            } else if (category === "Trái cây Việt") {
                addFruitItem("Đu đủ", "../img/duagangheader.png");
                addFruitItem("Xoài", "../img/mangoheader.png");
                addFruitItem("Chuối", "../img/bananaheader.png");
            } else if (category === "Trái cây nhập khẩu") {
                addFruitItem("Táo", "../img/appleheader.png");
                addFruitItem("Lê", "../img/pearheader.png");
                addFruitItem("Nho", "../img/grapeheader.png");
            }
            
            fruitList.style.display = "block";
        }
        
        function addFruitItem(name, imageUrl) {
            let fruitItems = document.getElementById("fruitItems");
            let li = document.createElement("li");
            let img = document.createElement("img");
            img.src = imageUrl;
            img.alt = name;
            li.appendChild(img);
            li.appendChild(document.createTextNode(name));
            fruitItems.appendChild(li);
        }
        
        function hideFruits() {
            let fruitList = document.getElementById("fruitList");
            fruitList.style.display = "none";
        }
    </script>

</body>
</html> 