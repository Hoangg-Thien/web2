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
                <a href="../index.php" >Trang chủ</a>  
                <a href="../user/introducelogin.php">Giới thiệu</a>  
                <a href="../user/newslogin.php">Tin tức</a>  
                <a href="../user/contactlogin.php">Liên hệ</a>   
                <a href="../user/cart-user.php" target="_blank" class="cart-icon" title="Go to Cart">  
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

            <div class="dropdown">
                <button class="dropdown-button">
                    <i class="fa-solid fa-user" style="margin-right: 10px;"></i>
                    <span>
                        <?php
                        if (isset($_SESSION['user_name'])) {
                            echo "Xin chào, <strong>" . htmlspecialchars($_SESSION['user_name']) . "</strong>!";
                        } else {
                            echo "Xin chào, khách!";
                        }
                        ?>
                    </span>
                </button>
                <div class="dropdown-menu">
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <a href="./userinfo.php">Tài khoản</a>
                        <a href="./history-user.php">Lịch sử</a>
                        <a href="./invoice-summary.php">Tóm tắt hóa đơn</a>
                        <a href="./usernologin.php">Đăng xuất</a> 
                    <?php else: ?>
                        <a href="./login-user.php">Đăng nhập</a>
                        <a href="./regis.php">Đăng ký</a>
                    <?php endif; ?>
                </div>
            </div>
        </div> 
    </div> 

    <main class="main-content">
    <div class="breadcrumb">
        <a class="black" href="../index.php">Trang chủ</a> >
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


    <section class="customer_service container">
        <div class="col-md-4">
            <h3>Dịch vụ khách hàng</h3>
            <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn.</p>
            <ul>
                <li><strong>Hotline:</strong> 0123 456 789</li>
                <li><strong>Email:</strong> AboutUs@shop.com</li>
                <li><strong>Thời gian làm việc:</strong> 8h - 20h hàng ngày</li>
            </ul>
        </div>
        <div class="col-md-4">
            <h3>Thông tin shop</h3>
            <p>Tên shop: SeaFruits</p>
            <p>Địa chỉ: 273, An Dương Vương, Quận 5, TPHCM</p>
            <p>Chúng tôi cung cấp trái cây tươi ngon nhất.</p>
        </div>
    </section>

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

    <footer>  
        <div>
            Copyright by us<b>&#8482</b>
        </div>
    </footer>  
</body>  
</html>
<script src="../User/js/cart.js"> </script>