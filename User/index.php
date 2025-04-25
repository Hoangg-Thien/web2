<!DOCTYPE html>  
<html lang="vi">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="shortcut icon" href="./img/favicon.png" type="image/x-icon">
    <title>Tiệm trái cây</title>  
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

        /* Nút đóng popup */
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
            color: #555;
        }

        .close:hover {
            color: red;
        }

        /* Tùy chỉnh select */
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Nút lọc */
        button {
            background: green;
            color: white;
            border: none;
            padding: 8px 12px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #0056b3;
        }

        .autocomplete-suggestions {
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
            background-color: white;
            position: absolute;
            z-index: 1000;
            width: 250px;
        }
    
        .autocomplete-suggestions div {
            padding: 8px;
            cursor: pointer;
        }
    
        .autocomplete-suggestions div:hover {
            background-color: #f0f0f0;
        }
    
        .result-card {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>  
<body>  
    <header>  
        <a href="#" class="fruit">  
            <img src="./img/carrotheader.png" alt="Cà rốt" />  
            Cà rốt  
        </a>  
        <a href="#" class="fruit">  
            <img src="./img/potatoheader.png" alt="Khoai tây" />  
            Khoai tây  
        </a>  
        <a href="#" class="fruit">  
            <img src="./img/watermelonheader.png" alt="Dưa hấu" />  
            Dưa hấu  
        </a>  
        <a href="#" class="fruit">  
            <img src="./img/orangeheader.png" alt="Trái cam" />  
            Cam  
        </a>  
        <a href="#" class="fruit">  
            <img src="./img/duagangheader.png" alt="Đu đủ" />  
            Đu đủ  
        </a>  
        <a href="#" class="fruit">  
            <img src="./img/tomatoheader.png" alt="Cà chua" />  
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
                    <li><a href="./user/declious-fruits.php">Trái cây ngon </a></li>
                    <li><a href="./user/Vietnamese-fruits.php">Trái cây Việt  </a></li>
                    <li><a href="./user/Imported-fruits.php">Trái cây Nhập Khẩu </a></li>
                    <li><a href="./user/vegetables.php">Rau củ  </a></li>
                    <li><a href="./user/Imported-fruits.php">Trái cây Khô</a></li>
                    <li><a href="./user/Imported-fruits.php">Các loại hạt  </a></li>
                </ul>
            </div>  
            
            <div class="menu">  
                <a href="index.php" class="active">Trang chủ</a>  
                <a href="./user/introducelogin.php">Giới thiệu</a>  
                <a href="./user/newslogin.php">Tin tức</a>  
                <a href="./user/contactlogin.php">Liên hệ</a> 
                <a href="./user/cart-user.php" target="_blank" class="cart-icon" title="Go to Cart">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-count" style="margin-left: 5px; font-weight: bold;">0</span>
                </a>
            </div>  
            <div class="search-container">
                <form action="./user/searchProducts.php" method="GET">
                <!-- Tìm kiếm đơn giản -->
                <div>
                    <input type="text" name="search" id="searchInput" placeholder="Nhập tên sản phẩm..." autocomplete="off" required>
                    <div id="suggestBox" class="autocomplete-suggestions"></div>
                    <button type="submit">Tìm kiếm</button>
                    <button type="button" id="toggleSearch">Tìm kiếm nâng cao</button>
                </div>
            
                <!-- Kết quả -->
                <div id="searchResults"></div>
            
                <div id="priorityFruits" class="hidden">
                    <ul>
                    </ul>
                </div>   
                <div id="searchModal" class="modal" style="display:none;">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Tìm kiếm nâng cao</h2>
                        
                        <label>Khoảng giá:</label>
                        <select id="priceRange">
                            <option>Tất cả</option>
                            <option>30k-70k</option>
                            <option>Trên 70k</option>
                        </select>
                
                        <label>Danh mục:</label>
                        <select id="sortedList">
                            <option>A->Z</option>
                            <option>Z->A</option>
                        </select>
                
                        <button onclick="smartSearchProducts()">Lọc</button>
                    </div>
                </div>  
                </form>
            </div>
        
            
            <div class="dropdown">
                <button class="dropdown-button">
                    <i class="fa-solid fa-user" style="margin-right: 10px;"></i> 
                    <span>Hi,User!</span>
                </button>
                <div class="dropdown-menu">
                  <a href="./user/userinfo.php">Tài khoản</a>
                  <a href="./user/history-user.php">Lịch sử</a>
                  <a href="./user/invoice-summary.php">Tóm tắt hóa đơn</a>
                  <a href="./user/usernologin.php">Đăng xuất</a>
                </div>
              </div>
        </div>  
    </div> 

    <div style="max-width: 100%; overflow: hidden; margin: auto;  margin-top: -190px;">  
        <img src="./img/salefruit.jpg" alt="salefruit" style="width: 100% ; height: 600px; display: block;">  
    </div>  
    
    <div >    
            <div class="list-product">  
                <h1>DANH MỤC SẢN PHẨM </h1>  
            </div>
            <style>
    .pagination {
        margin-top: 20px;
        text-align: center;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 5px;
    }

    .page-link {
        display: inline-block;
        padding: 8px 14px;
        background-color: #f1f1f1;
        border-radius: 6px;
        text-decoration: none;
        color: #000;
        transition: 0.2s;
    }

    .page-link:hover {
        background-color: #aaa;
        color: #fff;
    }

    .page-link.active {
        background-color: #4CAF50;
        color: white;
        font-weight: bold;
    }

    .page-link.disabled {
        background-color: #e0e0e0;
        color: #999;
        pointer-events: none;
    }
    </style>  
            <?php
            include("./user/connect.php");
            
             // Số sản phẩm mỗi trang
    $limit = 6;

    // Lấy trang hiện tại từ URL, nếu không có thì mặc định là trang 1
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;

    // Tính offset
    $start = ($page - 1) * $limit;

    // Lấy tổng số sản phẩm
    $totalQuery = "SELECT COUNT(*) as total FROM sanpham";
    $totalResult = $conn->query($totalQuery);
    $totalRow = $totalResult->fetch_assoc();
    $totalProducts = $totalRow['total'];
    $totalPages = ceil($totalProducts / $limit);

            $sql = "SELECT * FROM sanpham ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<div class="row image-container">';
                while ($row = $result->fetch_assoc()) {
                   
                    $productNameSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $row['product_name'])));

                    echo '
        <div class="col l-4 m-6 c-6">
            <div class="fruit-background" style="padding: 10px; border-radius: 12px; box-shadow: 0 0 8px rgba(0,0,0,0.1);">
                <img src="./img/' . $row['product_image'] . '" alt="' . htmlspecialchars($row['product_name']) . '" width="100%" style="border-radius: 12px;">

                <div class="caption" style="margin-top: 10px; font-weight: bold;">
                    ' . htmlspecialchars($row['product_name']) . '<br>
                    ' . number_format($row['product_price'], 0, ',', '.') . ' VND
                </div>

                <div class="icons" style="margin-top: 10px; display: flex; gap: 10px;">
                    <a href="./itemInfo/' . $row['product_link'] . '" class="info-icon" title="Xem thông tin chi tiết">
                        <i class="fa-solid fa-circle-info fa-lg"></i>
                    </a>
                    <button class="add-to-cart"
                data-id="' . $row['product_id'] . '"
                data-name="' . htmlspecialchars($row['product_name']) . '"
                data-price="' . $row['product_price'] . '">
                <i class="fas fa-cart-plus fa-lg"></i>
            </button>
                </div>
            </div>
        </div>';
    }
    echo '</div>';
} else {
    echo "<p>Không có sản phẩm nào.</p>";
}

// Hiển thị phân trang
echo '<div class="pagination">';

// Nút "Trang trước"
if ($page > 1) {
    echo '<a href="?page=' . ($page - 1) . '" class="page-link">&laquo; Trước</a>';
}

// Hiển thị tất cả số trang (kể cả chỉ có 1 trang)
for ($i = 1; $i <= $totalPages; $i++) {
    echo '<a href="?page=' . $i . '" class="page-link ' . ($i == $page ? 'active' : '') . '">' . $i . '</a>';
}

// Nút "Trang sau"
if ($page < $totalPages) {
    echo '<a href="?page=' . ($page + 1) . '" class="page-link">Sau &raquo;</a>';
}

echo '</div>';

            $conn->close();
            ?>
        
        
    </div>
    

    <div style="max-width: 100%; overflow: hidden; margin: auto;  margin-top: 100px;">  
        <img src="./img/banner-quang-cao.jpg" alt="banner-quang-cao" style="width: 100%; display: block;">  
    </div>
    
    <div class="policy-container" >
        <div >
            <img src="./img/policy1.png" alt="policy1">
            <div style="margin-left: -30px;padding: 10px;font-weight: 700;font-size: 20px;">Giao hàng miễn phí</div>
            <div style="margin-left:-20px;color:#444444;font-size: 14px;">Với đơn hàng hơn 300.000đ</div>
        </div>
        <div>
            <img src="./img/policy2.png" alt="policy2">
            <div style="margin-left: -20px;padding: 10px;font-weight: 700;font-size: 20px;">Hỗ trợ 24/7</div>
            <div style="margin-left:-20px;color:#444444;font-size: 14px;">Nhanh chóng thuận tiện</div>
        </div>
        <div>
            <img src="./img/policy3.jpg" alt="policy3">
            <div style="margin-left: -10px;padding: 10px;font-weight: 700;font-size: 20px;">Đổi trả trong 3 ngày</div>
            <div style="margin-left:-20px;color:#444444;font-size: 14px;">Hấp dẫn chưa từng có</div>
        </div>
        <div >
            <img src="./img/policy4.png" alt="policy2">
            <div style="margin-left: -10px;padding: 10px;font-weight: 700;font-size: 20px;">Giá tiêu chuẩn</div>
            <div style="margin-left:-10px;color:#444444;font-size: 14px;">Tiết kiệm 10% giá thị trường</div>
        </div>
    </div>

    <div class="logo" style="color:#444444;padding-bottom:30px ; height: 150px;">
        <img src="./img/seafruits-logo.png" alt="seafruits-logo">
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
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="./user/introducelogin.php">Giới thiệu</a></li>
                    <li><a href="./user/newslogin.php">Tin tức</a></li>
                    <li><a href="./user/contactlogin.html">Liên hệ</a></li>
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
    


    <script> 
        
//Thêm giỏ hàng
document.querySelectorAll('.add-to-cart').forEach(button => {
     button.addEventListener('click', function() {
         const productId = this.dataset.id;
         const productName = this.dataset.name;
         const productPrice = this.dataset.price;
 
         fetch('/web2/User/user/cart-handle.php', {
             method: 'POST',
             headers: {'Content-Type': 'application/json'},
             body: JSON.stringify({
                 action: 'add',
                 product_id: productId,
                 product_name: productName,
                 product_price: productPrice
             })
         }).then(res => res.json())
           .then(data => {
               if (data.success) {
                   // Update cart icon badge
                   document.querySelector('#cart-count').innerText = data.cart_count;
 
                   // Hiển thị thông báo popup giữa màn hình
                   const notification = document.createElement('div');
                   notification.textContent = 'Đã thêm vào giỏ hàng';
                   notification.style.position = 'fixed';
                   notification.style.top = '50%';
                   notification.style.left = '50%';
                   notification.style.transform = 'translate(-50%, -50%)';
                   notification.style.backgroundColor = '#4CAF50';
                   notification.style.color = '#fff';
                   notification.style.padding = '16px 28px';
                   notification.style.borderRadius = '10px';
                   notification.style.boxShadow = '0 4px 12px rgba(0,0,0,0.3)';
                   notification.style.zIndex = 9999;
                   notification.style.fontSize = '16px';
                   notification.style.fontWeight = '500';
                   document.body.appendChild(notification);
 
                   setTimeout(() => {
                       document.body.removeChild(notification);
                   }, 2000);
               } else {
                   alert(data.message);
               }
           });
     });
 });        





        
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

     
</body>  
</html>

<script src="../User/js/cart.js"> </script>