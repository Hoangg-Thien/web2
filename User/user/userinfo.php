<?php
session_start();
?>
<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">  
    <link rel="stylesheet" href="../styles/userinfo.css">  
    <link rel="stylesheet" href="../styles/grid.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon"> 
    <title>Trang Tài Khoản</title>  
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
        <a href="#" class="fruit"><img src="../img/carrotheader.png" alt="Cà rốt" /> Cà rốt</a>  
        <a href="#" class="fruit"><img src="../img/potatoheader.png" alt="Khoai tây" /> Khoai tây</a>  
        <a href="#" class="fruit"><img src="../img/watermelonheader.png" alt="Dưa hấu" /> Dưa hấu</a>  
        <a href="#" class="fruit"><img src="../img/orangeheader.png" alt="Trái cam" /> Cam</a>  
        <a href="#" class="fruit"><img src="../img/duagangheader.png" alt="Đu đủ" /> Đu đủ</a>  
        <a href="#" class="fruit"><img src="../img/tomatoheader.png" alt="Cà chua" /> Cà chua</a>  
    </header>  

    <div class="sea-fruit-container">  
        <div><div class="sea-fruit">SEA FRUITS</div></div>  

        <div style="display: flex; align-items: center; padding: 10px 20px;">  
            <div class="product-category">DANH MỤC SẢN PHẨM</div>  
            <div class="menu">  
                <a href="./userlogin.php" >Trang chủ</a>  
                <a href="../user/introducelogin.php">Giới thiệu</a>  
                <a href="../user/newslogin.php">Tin tức</a>  
                <a href="../user/contactlogin.php">Liên hệ</a>   
                <a href="../user/cart-user.php" target="_blank" class="cart-icon" title="Go to Cart">  
                    <i class="fas fa-shopping-cart"></i>  
                    <span id="cart-count" style="margin-left: 5px; font-weight: bold;">
    <?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>
</span>
                </a>  
            </div>  

            <div class="search-container">  
                <div>  
                    <input type="text" id="searchBox" placeholder="Tìm kiếm sản phẩm..." onkeyup="searchProducts()">  
                    <button onclick="searchProducts()">Tìm kiếm</button>  
                </div>  
            </div>  
            
            <?php if (isset($_SESSION['user_name'])): ?>
    <div class="dropdown">
        <button class="dropdown-button">
            <i class="fa-solid fa-user" style="margin-right: 10px;"></i>
            <span>Xin chào, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>!</span>
        </button>
        <div class="dropdown-menu">
            <a href="./userinfo.php">Tài khoản</a>
            <a href="./history-user.php">Lịch sử</a>
            <a href="./bill-summary.php">Tóm tắt hóa đơn</a>
            <a href="../index.php">Đăng xuất</a> 
        </div>
    </div>
<?php endif; ?>

        </div> 
    </div> 

    <main class="main-content">
    <div class="breadcrumb">
        <a class="black" href="./userlogin.php">Trang chủ</a> >
        <a href="./userinfo.php">Trang khách hàng</a>
    </div>

    <div class="account-info">
        <div class="account-left">
            <h2>TRANG TÀI KHOẢN</h2>
            <p>
                Xin chào,
                <span class="user-name">
                    <?php
                        echo isset($_SESSION['user_name'])
                            ? htmlspecialchars($_SESSION['user_name'])
                            : 'khách';
                    ?>
                </span>!
            </p>

            <ul>
                <li><a class="green" href="./userinfo.php">Thông tin tài khoản</a></li>
                <li><a href="./cart-user.php">Đơn hàng của bạn</a></li>
                <li><a href="#">Đổi mật khẩu</a></li>
            </ul>
        </div>

        <div class="account-right">
            <h2>THÔNG TIN TÀI KHOẢN</h2>

            <?php if (isset($_SESSION['user_name'])): ?>
                <p>
                    <strong>Họ tên:</strong>
                    <?php
                        echo isset($_SESSION['fullname'])
                            ? htmlspecialchars($_SESSION['fullname'])
                            : 'Không có thông tin';
                    ?>
                </p>
                <p>
                    <strong>Email:</strong>
                    <?php
                        echo isset($_SESSION['user_email'])
                            ? htmlspecialchars($_SESSION['user_email'])
                            : 'Không có thông tin';
                    ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</main>



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
                <li><a href="./userlogin.php">Trang chủ</a></li>
                    <li><a href="./introducelogin.php">Giới thiệu</a></li>
                    <li><a href="./newslogin.php">Tin tức</a></li>
                    <li><a href="./contactlogin.php">Liên hệ</a></li>
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
<script>
function updateCart(action, productId) {
    fetch('/web-final/User/user/cart-handle.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({action, product_id: productId})
    }).then(() => location.reload());
}
</script>