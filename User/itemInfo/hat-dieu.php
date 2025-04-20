<!DOCTYPE html>  
<html lang="vi">  
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Hạt điều</title>  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../styles/fruit-info.css">  
    <link rel="stylesheet" href="../styles/grid.css">
    <link rel="stylesheet" href="../styles/index.css">

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

    <div class="item-container">
    <?php
// Kết nối cơ sở dữ liệu
$host = 'localhost';
$user = 'root';
$pass = ''; // cập nhật nếu có mật khẩu
$db = 'c07db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Lỗi kết nối: " . $conn->connect_error);
}

// Lấy sản phẩm xoài sấy
$sql = "SELECT * FROM sanpham WHERE product_name = 'Hạt điều' LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ten = htmlspecialchars($row['product_name']);
    $gia = number_format($row['product_price'], 0, ',', '.') . 'đ/kg';
    $hinhanh = htmlspecialchars($row['product_image']);
    $product_id = $row['product_id'];
    ?>

    <div class="item-container">
        <img class="fruit-img" src="../img/<?php echo $hinhanh; ?>" alt="<?php echo $ten; ?>">
        <div class="item-info">
            <p>
                Tên: <?php echo $ten; ?><br>
                Xuất xứ: VIỆT NAM <br>
                Ngày nhập kho: 12/12/2025 <br>
                HSD: 3 TUẦN <br>
                Giá: <?php echo $gia; ?><br>
            </p>
            <div class="quantity-container">
                <button class="quantity-btn" id="decrease">-</button>
                <input type="text" id="quantity" value="1">
                <button class="quantity-btn" id="increase">+</button>
            </div>
            <form action="../user/cart-handle.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <input type="hidden" name="quantity" id="quantity-hidden" value="1">
                <button class="add-to-cart"
    data-id="<?php echo $product_id; ?>"
    data-name="<?php echo htmlspecialchars($ten); ?>"
    data-price="<?php echo $row['product_price']; ?>">
    <i class="fas fa-cart-plus fa-lg"></i> Thêm vào giỏ
</button>

            </form>
        </div>
        <div id="success-overlay"></div>
        <div id="success-message">
            <p>Đã thêm vào giỏ hàng thành công!</p>
            <a href="../user/cart-user.php">Xem giỏ hàng</a>
            <a href="../user/payment-user.php">Tiến tới thanh toán</a>
        </div>
    </div>

    <script>
        // Đồng bộ số lượng giữa input và form
        const quantityInput = document.getElementById('quantity');
        const quantityHidden = document.getElementById('quantity-hidden');
        const btnIncrease = document.getElementById('increase');
        const btnDecrease = document.getElementById('decrease');

        btnIncrease.addEventListener('click', () => {
            let val = parseInt(quantityInput.value) || 1;
            quantityInput.value = val + 1;
            quantityHidden.value = val + 1;
        });

        btnDecrease.addEventListener('click', () => {
            let val = parseInt(quantityInput.value) || 1;
            if (val > 1) {
                quantityInput.value = val - 1;
                quantityHidden.value = val - 1;
            }
        });

        quantityInput.addEventListener('input', () => {
            quantityHidden.value = quantityInput.value;
        });
    </script>

    <?php
} else {
    echo "<p>Không tìm thấy sản phẩm xoài sấy.</p>";
}

$conn->close();
?>

    </div>
    
    <div style="max-width: 1500px; overflow: hidden; margin: auto;  margin-top: 100px;">  
        <img src="../img/banner-quang-cao.jpg" alt="banner-quang-cao" style="width: 100%; height: 400px; display: block;">  
    </div>
    
    <div class="policy-container" >
        <div >
            <img src="../img/policy1.png" alt="policy1">
            <div style="margin-left: -30px;padding: 10px;font-weight: 700;font-size: 20px;">Giao hàng miễn phí</div>
            <div style="margin-left:-20px;color:#444444;font-size: 14px;">Với đơn hàng hơn 300.000đ</div>
        </div>
        <div>
            <img src="../img/policy2.png" alt="policy2">
            <div style="margin-left: -20px;padding: 10px;font-weight: 700;font-size: 20px;">Hỗ trợ 24/7</div>
            <div style="margin-left:-20px;color:#444444;font-size: 14px;">Nhanh chóng thuận tiện</div>
        </div>
        <div>
            <img src="../img/policy3.webp" alt="policy3">
            <div style="margin-left: -10px;padding: 10px;font-weight: 700;font-size: 20px;">Đổi trả trong 3 ngày</div>
            <div style="margin-left:-20px;color:#444444;font-size: 14px;">Hấp dẫn chưa từng có</div>
        </div>
        <div >
            <img src="../img/policy4.png" alt="policy2">
            <div style="margin-left: -10px;padding: 10px;font-weight: 700;font-size: 20px;">Giá tiêu chuẩn</div>
            <div style="margin-left:-10px;color:#444444;font-size: 14px;">Tiết kiệm 10% giá thị trường</div>
        </div>
    </div>

    <div class="logo" style="color:#444444;padding-bottom:30px ; height: 150px;">
        <img src="../img/seafruits-logo.png" alt="seafruits-logo">
        <div style="padding:10px;">
            <div>Hotline: 0123456789</div>
            <div>Email: AboutUs@gmail.com</div>
        </div>
    </div>

    <div class="grid wide" style="justify-content: space-evenly;">
        <div class="row">
            <div class="col l-3 m-6 c-12">
                <a role="button" class="collapsed" data-toggle="collapse" aria-expanded="false" data-target="#collapseListMenu01" aria-controls="collapseListMenu01">
                    Về chúng tôi 
                </a>
                <div>
                    <ul >
                        
                        <li class="li_menu"><a href="../index.php"style="text-decoration: none; color: #333; ">Trang chủ</a></li>
                        
                        <li class="li_menu"><a href="#"style="text-decoration: none;color: #333;">Giới thiệu</a></li>
                        
                        <li class="li_menu"><a href="#"style="text-decoration: none;color: #333;">Sản phẩm</a></li>
                        
                        <li class="li_menu"><a href="#"style="text-decoration: none;color: #333;">Tin tức</a></li>
                        
                        <li class="li_menu"><a href="#"style="text-decoration: none;color: #333;">Liên hệ</a></li>
                        
                    </ul>
                </div>
            </div>
            
            <div class="col l-3 m-6 c-12">
                <a role="button" class="collapsed" data-toggle="collapse" aria-expanded="false" data-target="#collapseListMenu01" aria-controls="collapseListMenu01">
                    Tin khuyến mãi
                </a>
                <div >
                    <ul >
                        
                        <li class="li_menu"><a href="../index.php"style="text-decoration: none; color: #333; ">Trang chủ</a></li>
                        
                        <li class="li_menu"><a href="#"style="text-decoration: none;color: #333;">Giới thiệu</a></li>
                        
                        <li class="li_menu"><a href="#"style="text-decoration: none;color: #333;">Sản phẩm</a></li>
                        
                        <li class="li_menu"><a href="#"style="text-decoration: none;color: #333;">Tin tức</a></li>
                        
                        <li class="li_menu"><a href="#"style="text-decoration: none;color: #333;">Liên hệ</a></li>
                        
                    </ul>
                </div>
            </div>

            <div class="col l-3 m-6 c-12">
                <a role="button" class="collapsed" data-toggle="collapse" aria-expanded="false" data-target="#collapseListMenu01" aria-controls="collapseListMenu01">
                    Dịch vụ
                </a>
                <div >
                    <ul >
                        
                        <li class="li_menu"><a href="../index.php"style="text-decoration: none; color: #333; ">Trang chủ</a></li>
                        
                        <li class="li_menu"><a href="#"style="text-decoration: none;color: #333;">Giới thiệu</a></li>
                        
                        <li class="li_menu"><a href="#"style="text-decoration: none;color: #333;">Sản phẩm</a></li>
                        
                        <li class="li_menu"><a href="#"style="text-decoration: none;color: #333;">Tin tức</a></li>
                        
                        <li class="li_menu"><a href="#"style="text-decoration: none;color: #333;">Liên hệ</a></li>
                        
                    </ul>
                </div>
            </div>

            <div class="col l-3 m-6 c-12">
                <div >
    
                    <div class="social_footer row">
                        <div>Kết nối với chúng tôi</div>
                        <ul class="follow_option col l-12 " style="margin-left: -50px;">	
                            
                            <li>
                                <a href="#" title="Theo dõi Facebook Sea Fruits"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            
                            <li>
                                <a href="#" title="Theo dõi Google Sea Fruits"><i class="fab fa-google"></i></a>
                            </li>
                            
                            
                            <li>
                                <a href="#" title="Theo dõi Instagam Sea Fruits"><i class="fab fa-instagram"></i></a>
                            </li>
                            
                            
                            <li>
                                <a href="#" title="Theo dõi Youtube Sea Fruits"><i class="fab fa-youtube"></i></a>
                            </li>
                            
                        </ul>
                    </div>
    

        </div>
            </div>
    </div>
    </div>
</body>
<footer style="width: 100% ;">
    <div>
        Copyright by us<b>&#8482</b>
    </div>
</footer>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const addBtn = document.querySelector('.add-to-cart');
    const quantityInput = document.getElementById('quantity');

    if (addBtn) {
        addBtn.addEventListener('click', function(e) {
            e.preventDefault();

            const productId = this.dataset.id;
            const productName = this.dataset.name;
            const productPrice = this.dataset.price;
            const quantity = parseInt(quantityInput?.value) || 1;

            fetch('../user/cart-handle.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'add',
                    product_id: productId,
                    product_name: productName,
                    product_price: productPrice,
                    quantity: quantity
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // ✅ Tự động chuyển đến trang giỏ hàng
                    window.location.href = '../user/cart-user.php';
                } else {
                    alert(data.message || 'Đã có lỗi xảy ra');
                }
            })
            .catch(err => {
                console.error('Lỗi khi thêm vào giỏ hàng:', err);
                alert('Không thể thêm vào giỏ hàng. Vui lòng thử lại!');
            });
        });
    }
});
</script>

