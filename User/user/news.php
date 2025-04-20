<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">  
    <link rel="stylesheet" href="../styles/news.css">  
    <link rel="stylesheet" href="../styles/grid.css">
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
                <a href="../user/usernologin.html" >Trang chủ</a>  
                <a href="../user/introduce.html">Giới thiệu</a>  
                <a href="../user/news.html" class="active">Tin tức</a>  
                <a href="../user/contact.html">Liên hệ</a>   
                <a href="../user/cartusernologin.html" target="_blank" class="cart-icon" title="Go to Cart">  
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
                <a href="../user/regis.html" title="Đăng ký" target="_blank">Đăng ký</a>  
                <span>|</span>  
                <a href="../user/login-user.html" title="Đăng nhập" target="_blank">Đăng nhập</a>  
            </div> 
        </div>  
    </div> 
    <div class="update-system-container">
        <div class="update-message">
            <i class="fas fa-tools"></i>
            <h2>Hệ thống đang cập nhật</h2>
            <p>Vui lòng quay lại sau!</p>
            <a href="../user/usernologin.html" class="back-button">Quay về trang chủ</a>
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
                        
                        <li class="li_menu"><a href="../user/usernologin.html"style="text-decoration: none; color: #333; ">Trang chủ</a></li>
                        
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
                        
                        <li class="li_menu"><a href="../user/usernologin.html"style="text-decoration: none; color: #333; ">Trang chủ</a></li>
                        
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
                        
                        <li class="li_menu"><a href="../user/usernologin.html"style="text-decoration: none; color: #333; ">Trang chủ</a></li>
                        
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
    
    <footer>  
        <div>
            Copyright by us<b>&#8482</b>
        </div>
    </footer>  
</body>  
</html>