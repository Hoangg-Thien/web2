<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>
<!DOCTYPE html>  
<html lang="vi">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../styles/index.css">  
    <link rel="stylesheet" href="../styles/grid.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon"> 
    <title>Trái cây ngon </title>  
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
            <div class="product-category">DANH MỤC SẢN PHẨM
                <ul>
                    <li><a href="./declious-fruits-nologin.php">Trái cây ngon </a></li>
                    <li><a href="./VietNamese-fruits-nolog.php">Trái cây Việt  </a></li>
                    <li><a href="./Imported-fruits-nologin.php">Trái cây Nhập Khẩu </a></li>
                    <li><a href="./vegetables-nologin.php">Rau củ  </a></li>
                    <li><a href="./dried-fruits-nologin.php">Trái cây Khô</a></li>
                    <li><a href="./nut-fruits-nologin.php">Các loại hạt  </a></li>
                </ul>
            </div>  
            <div class="menu">  
                <a href="./usernologin.php" >Trang chủ</a>  
                <a href="./introduce.php">Giới thiệu</a>  
                <a href="./news.php">Tin tức</a>  
                <a href="./contact.php">Liên hệ</a>   
                <a href="./cart-user-nologin.php" target="_blank" class="cart-icon" title="Go to Cart">  
                    <i class="fas fa-shopping-cart"></i>  
                    <span id="cart-count" style="margin-left: 5px; font-weight: bold;">0</span>  
                </a>  
            </div>    
            <div class="search-container">
    <form action="searchProducts.php" method="GET">
        <input type="text" name="search" id="searchInput" placeholder="Nhập tên sản phẩm..." autocomplete="off" required>
        <div id="suggestBox" class="autocomplete-suggestions"></div>

        <div style="display: flex; gap: 10px; margin-top: 10px;">
            <button type="submit">Tìm kiếm</button>
            <button type="button" id="toggleSearch">Tìm kiếm nâng cao</button>
        </div>

        <!-- Modal nâng cao -->
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
            <div class="auth-buttons">  
                <a href="../user/regis.php" title="Đăng ký" target="_blank">Đăng ký</a>  
                <span>|</span>  
                <a href="../user/login-user.php" title="Đăng nhập" target="_blank">Đăng nhập</a>  
            </div> 
        </div>  
    </div> 

    <div class="grid wide">
        <div class="image-container Delicous row" id="imageContainer">  
        <div class="cart-container" style="padding: 30px;min-height: 500; width: 900px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
    <h2 style="text-align: center; margin-bottom: 30px; font-size: 26px; color: #333;">Giỏ hàng của bạn</h2>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f7f7f7;">
                <th style="padding: 12px; border: 1px solid #ddd; font-weight: 600;">Sản phẩm</th>
                <th style="padding: 12px; border: 1px solid #ddd; font-weight: 600;">Đơn giá</th>
                <th style="padding: 12px; border: 1px solid #ddd; font-weight: 600;">Số lượng</th>
                <th style="padding: 12px; border: 1px solid #ddd; font-weight: 600;">Thành tiền</th>
                <th style="padding: 12px; border: 1px solid #ddd; font-weight: 600;">Xoá</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($cart)): ?>
                <?php foreach ($cart as $id => $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td style="padding: 12px; border: 1px solid #ddd; text-align: center;"> <?= htmlspecialchars($item['name']) ?> </td>
                        <td style="padding: 12px; border: 1px solid #ddd; text-align: center;"> <?= number_format($item['price']) ?>₫ </td>
                        <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">
                            <button onclick="updateCart('decrease', '<?= $id ?>')" style="padding: 4px 10px;">-</button>
                            <?= $item['quantity'] ?>
                            <button onclick="updateCart('increase', '<?= $id ?>')" style="padding: 4px 10px;">+</button>
                        </td>
                        <td style="padding: 12px; border: 1px solid #ddd; text-align: center;"> <?= number_format($subtotal) ?>₫ </td>
                        <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">
                            <button onclick="updateCart('remove', '<?= $id ?>')" style="color: red; border: none; background: transparent; cursor: pointer;">X</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr style="background-color: #f9f9f9;">
                    <td colspan="3" style="text-align: right; font-weight: bold; padding: 12px; font-size: 16px;">Tổng cộng:</td>
                    <td colspan="2" style="padding: 12px; font-weight: bold; color: #2e7d32; font-size: 16px;"> <?= number_format($total) ?>₫ </td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 50px; color: gray;">
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <img src="../img/shopping-cart.jpg" alt="Giỏ hàng trống" style="width: 100px; height: auto; margin-bottom: 15px; opacity: 0.5;">
                            <div style="font-size: 18px;">Hiện không có sản phẩm nào</div>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if (!empty($cart)): ?>
    <div style="text-align: center; margin-top: 30px;">
        <button onclick="alert('Bạn cần đăng nhập để thanh toán!'); window.location.href='../user/login-user.php';" style="padding: 12px 24px; background-color: #f44336; color: white; font-size: 16px; border: none; border-radius: 6px; cursor: pointer;">
            Đăng nhập để thanh toán
        </button>
    </div>
<?php endif; ?>

</div>
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
            <img src="../img/policy3.jpg" alt="policy3">
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
                        
                        <li class="li_menu"><a href="./introduce.php"style="text-decoration: none;color: #333;">Giới thiệu</a></li>
                        
                        <li class="li_menu"><a href="./contact.php"style="text-decoration: none;color: #333;">Tin tức</a></li>
                        
                        <li class="li_menu"><a href="./news.php"style="text-decoration: none;color: #333;">Liên hệ</a></li>
                        
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
                        
                        <li class="li_menu"><a href="./introduce.php"style="text-decoration: none;color: #333;">Giới thiệu</a></li>
                        
                        <li class="li_menu"><a href="./contact.php"style="text-decoration: none;color: #333;">Tin tức</a></li>
                        
                        <li class="li_menu"><a href="./news.php"style="text-decoration: none;color: #333;">Liên hệ</a></li>
                        
                        
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
                        
                        <li class="li_menu"><a href="./introduce.php"style="text-decoration: none;color: #333;">Giới thiệu</a></li>
                        
                        <li class="li_menu"><a href="./contact.php"style="text-decoration: none;color: #333;">Tin tức</a></li>
                        
                        <li class="li_menu"><a href="./news.php"style="text-decoration: none;color: #333;">Liên hệ</a></li>
                        
                        
                    </ul>
                </div>
            </div>

            <div class="col l-3 m-6 c-12">
                <div >
                    <div class="social_footer row">
                        <div>Kết nối với chúng tôi</div>
                        <ul class="follow_option col l-12 " style="margin-left: -30px;">	
                            
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

    <script>
    let debounceTimeout;
    function searchProducts() 
    {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
    const searchBox = document.getElementById("searchBox");
    const searchQuery = searchBox.value.toLowerCase();
    const searchResults = document.getElementById("searchResults");
    const priorityFruits = document.getElementById("priorityFruits");
    priorityFruits.style.display = "none";
    searchResults.innerHTML = "";
    const filteredProducts = fruits.filter(product =>
        product.name.toLowerCase().includes(searchQuery)
    );
    filteredProducts.sort((a, b) => b.priority - a.priority);

    if (filteredProducts.length > 0) {
        filteredProducts.forEach(product => {
            const productLink = document.createElement("a");
            productLink.href = product.link;
            productLink.innerText = product.name;
            productLink.classList.add("search-result"); 
            searchResults.appendChild(productLink);
        });

        searchResults.style.display = "block";
    } else {
        searchResults.innerHTML = "<span class='empty'>Không tìm thấy sản phẩm nào</span>";
        searchResults.style.display = "block";
    }

 
    setTimeout(() => {
        searchBox.value = ""; 
        searchResults.style.display = "none"; 
        searchResults.innerHTML = "";
        priorityFruits.style.display = "block"; 
    }, 5000); 
}, 500); 
}

document.addEventListener("DOMContentLoaded", function () {
        let addToCartButtons = document.querySelectorAll(".add-to-cart-btn");

        addToCartButtons.forEach(button => {
            button.addEventListener("click", function () {
                alert("Bạn cần phải đăng nhập để thêm vào giỏ hàng!");
            });
        });
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

<footer>  
    <div>
        Copyright by us<b>&#8482</b>
    </div>
</footer>  
    </body>
</html>
<script src="../js/cart.js"></script>
<script>
function updateCart(action, productId) {
    fetch('/web2/User/user/cart-handle.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({action, product_id: productId})
    }).then(() => location.reload());
}
</script>

