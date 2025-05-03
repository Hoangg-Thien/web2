<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">  
    <link rel="stylesheet" href="../styles/news.css">  
    <link rel="stylesheet" href="../styles/grid.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon"> 
    <title>Trang Tin Tức</title>  
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
            <div class="product-category">DANH MỤC SẢN PHẨM</div>  
            <div class="menu">  
                <a href="../user/usernologin.php" >Trang chủ</a>  
                <a href="../user/introduce.php">Giới thiệu</a>  
                <a href="../user/news.php" class="active">Tin tức</a>  
                <a href="../user/contact.php">Liên hệ</a>   
                <a href="../user/cartusernologin.php" target="_blank" class="cart-icon" title="Go to Cart">  
                    <i class="fas fa-shopping-cart"></i>  
                    <span id="cart-count" style="margin-left: 5px; font-weight: bold;">0</span>  
                </a>  
            </div>  
            <div class="search-container">  
                <div>  
                    <input type="text" id="searchBox" placeholder="Tìm kiếm sản phẩm..." onkeyup="searchProducts()">  
                    <button onclick="searchProducts()">Tìm kiếm</button>  
                </div>  
            </div>  
            <div class="auth-buttons">  
                <a href="../user/regis.php" title="Đăng ký" target="_blank">Đăng ký</a>  
                <span>|</span>  
                <a href="../user/login-user.php" title="Đăng nhập" target="_blank">Đăng nhập</a>  
            </div> 
        </div>  
    </div>
    
    <div class="login-prompt" style="text-align: center; padding: 50px 20px; background: #f9f9f9; margin: 20px auto; max-width: 600px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <i class="fas fa-lock" style="font-size: 48px; color: #4CAF50; margin-bottom: 20px;"></i>
        <h2 style="color: #333; margin-bottom: 15px;">Vui lòng đăng nhập</h2>
        <p style="color: #666; margin-bottom: 25px;">Để xem tin tức mới nhất từ SEA FRUITS, quý khách vui lòng đăng nhập tài khoản.</p>
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
    </div>

</body>
</html>
</body>  
</html>