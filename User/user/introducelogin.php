<!DOCTYPE html>  
<html lang="vi">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">  
    <link rel="stylesheet" href="../styles/introduce.css">  
    <link rel="stylesheet" href="../styles/grid.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon"> 
    <title>Trang Giới Thiệu</title>  
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
                    <li><a href="./declious-fruits.html">Trái cây ngon </a></li>
                    <li><a href="./Vietnamese-fruits.html">Trái cây Việt  </a></li>
                    <li><a href="./Imported-fruits.html">Trái cây Nhập Khẩu </a></li>
                    <li><a href="./vegetables.html">Rau củ  </a></li>
                    <li><a href="./Imported-fruits.html">Trái cây Khô</a></li>
                    <li><a href="./Imported-fruits.html">Các loại hạt  </a></li>
                </ul>
            </div>  
            <div class="menu">  
                <a href="../index.html" >Trang chủ</a>  
                <a href="../user/introducelogin.html" class="active">Giới thiệu</a>  
                <a href="../user/newslogin.html">Tin tức</a>  
                <a href="../user/contactlogin.html">Liên hệ</a>   
                <a href="../user/cart-user.html" target="_blank" class="cart-icon" title="Go to Cart">  
                    <i class="fas fa-shopping-cart"></i>  
                    <span id="cart-count" style="margin-left: 5px; font-weight: bold;">0</span>  
                </a>  
            </div>  
            <div class="search-container">   
                
                <div >
                    <input type="text" id="searchBox" placeholder="Tìm kiếm sản phẩm..." onkeyup="searchProducts()">
                    <button onclick="searchProducts()">Tìm kiếm</button>
                    <button id="toggleSearch">Tìm kiếm nâng cao</button>
                </div>  
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
                </div>
                
            <div class="dropdown">
                <button class="dropdown-button">
                    <i class="fa-solid fa-user" style="margin-right: 10px;"></i> 
                    <span>Hi,User!</span>
                </button>
                <div class="dropdown-menu">
                  <a href="../user/userinfo.html">Tài khoản</a>
                  <a href="../user/history-user.html">Lịch sử</a>
                  <a href="../user/invoice-summary.html">Tóm tắt hóa đơn</a>
                  <a href="../user/usernologin.html">Đăng xuất</a>
                </div>
            </div>
        </div>  
    </div> 
    <div class="update-system-container">
        <div >
            <h1 >Giới thiệu</h1>
            <p>Sea Fruit là công ty thương mại điện tử chuyên cung cấp các thực phẩm hữu cơ và tự nhiên với chuỗi cửa hàng thực phẩm hữu cơ với mục tiêu giúp người tiêu dùng Việt Nam có một cuộc sống khỏe mạnh hơn thông qua những loại thực phẩm hữu cơ có chứng nhận, thực phẩm tự nhiên và không có nguồn gốc biến đổi gene (GMO). Chúng tôi lựa chọn các loại thực phẩm hữu cơ, thực phẩm tự nhiên từ các nhà sản xuất, các công ty trong và ngoài nước thông qua quá trình lựa chọn kỹ càng về khả năng cung ứng, các giấy chứng nhận tiêu chuẩn do các tổ chức uy tín thế giới cấp. Chúng tôi yêu thích những gì chúng tôi làm và chúng tôi đam mê những lợi ích của một lối sống lành mạnh, tìm nguồn cung cấp sản phẩm hữu cơ chất lượng cao nhất cho khách hàng và cung cấp dịch vụ giao hàng tận nhà tốt nhất. Chúng tôi hoàn toàn tin tưởng rằng những sản phẩm tạo ra từ quá trình canh tác và sản xuất theo phương thức hữu cơ và tự nhiên tốt cho cơ thể mọi người, tốt hơn cho cộng đồng và tốt hơn cho hành tinh mà chúng ta đang sống. Một lần nữa, Sea Fruit được sáng lập bởi các nhà sáng lập muốn tạo dựng một cộng đồng thực phẩm sạch, dựa trên nền tảng hữu cơ (organic) và thuần từ thiên nhiên, nhằm mang lại sức khoẻ tốt nhất cho cộng đồng.</p>  
            <div>
                <img src="../img/logofood-safety.png" style="width: 180px; height: auto;">
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
    <div class="grid wide" style="justify-content: space-evenly;">
        <div class="row">
            <div class="col l-3 m-6 c-12">
                <a role="button" class="collapsed" data-toggle="collapse" aria-expanded="false" data-target="#collapseListMenu01" aria-controls="collapseListMenu01">
                    Về chúng tôi 
                </a>
                <div>
                    <ul >
                        
                        <li class="li_menu"><a href="../index.html"style="text-decoration: none; color: #333; ">Trang chủ</a></li>
                        
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
                        
                        <li class="li_menu"><a href="../index.html"style="text-decoration: none; color: #333; ">Trang chủ</a></li>
                        
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
                        
                        <li class="li_menu"><a href="../index.html"style="text-decoration: none; color: #333; ">Trang chủ</a></li>
                        
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
    <script>
         const fruits = [
{ name: "Nho Mỹ", link: "../itemInfo/grapes.html", priority: 1 },
{ name: "Bòn Bon", link: "../itemInfo/langsat.html", priority: 2 },
{ name: "Kiwi", link: "../itemInfo/kiwi.html", priority: 3 },
{ name: "Mãng cầu xiêm", link: "../itemInfo/custard-apple.html", priority: 4 },
{ name: "Thanh long ruột đỏ", link: "../itemInfo/dragon-fruit.html", priority: 5 },
{ name: "Xoài cát", link: "../itemInfo/mango.html", priority: 6 },
{ name: "Dưa hấu Long An", link: "../itemInfo/watermelon.html", priority: 7 },
{ name: "Chôm chôm", link: "../itemInfo/rambutant.html", priority: 8 },
{ name: "Ổi xá lị", link: "../itemInfo/guava.html", priority: 9 },
{ name: "Dâu tây Đà Lạt", link: "../itemInfo/strawberry.html", priority: 10 },
{ name: "Mận đỏ An Phước", link: "../itemInfo/water-apple.html", priority: 11 },
{ name: "Mận Hà Nội", link: "../itemInfo/plum.html", priority: 12 },
{ name: "Quýt đường", link: "../itemInfo/tangerine.html", priority: 13 },
{ name: "Bưởi da xanh", link: "../itemInfo/pomelo.html", priority: 14 },
{ name: "Cherry Úc", link: "../itemInfo/cherry.html", priority: 15 },
{ name: "Chuối chín Nam Mỹ", link: "../itemInfo/banana.html", priority: 16 },
{ name: "Lựu Ai Cập", link: "../itemInfo/pomegranite.html", priority: 17 },
{ name: "Táo Envy", link: "../itemInfo/apple.html", priority: 18 }
];

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
    <footer>  
        <div>
            Copyright by us<b>&#8482</b>
        </div>
    </footer>  
</body>  
</html>