<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./stylescss/addpro.css">
    <link rel="stylesheet" href="./stylescss/responsive.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Thêm sản phẩm</title>
</head>
<body>

    <div class="sidebar">
        <nav>
            <ul style="margin-bottom: 10px;">
                <li class="user-info">
                    <div class="img-edit">
                        <img class="img-head" src="../img/admin.jpg" alt="User Image"> 
                    </div>

                    <div class="role">Chào mừng trở lại, Huy!</div>
                </li>
            </ul>
        </nav>

        <hr>

     
        <a class="icon-denim" href="./usermanage.html" target="_self"> <i class="fa-solid fa-user-shield"></i></i> Quản lí người dùng</a>
        <a class="icon-denim" href="./order.html" target="_self"> <i class="fa-solid fa-cart-shopping"></i> Quản lý đơn hàng</a>
        <a class="icon-denim" href="./prolist.html" target="_self"><i class="fa-solid fa-box-archive"></i> Tất cả sản phẩm</a>
        <a class="icon-denim icon-denim-active" href="./addpro.html" target="_self"> <i class="fa-solid fa-cart-plus"></i> Thêm sản phẩm</a>
        <a class="icon-denim" href="./satistics.html" target="_self"> <i class="fa-solid fa-chart-column"></i> Thống kê tình hình</a>
        <a class="icon-denim" href="../index.html" target="_self"><i class="fa-solid fa-user-xmark"></i> Đăng xuất</a>
    </div>

    <hr>

    <div class="main">
        <header>
            <div class="web-header">
               <a href=""> <img src="../img/mau-thiet-ke-logo-trai-cay-SPencil-Agency-7.png" alt="mau-thiet-ke-logo-trai-cay-SPencil-Agency-7"></a>
            </div>
        </header>

        <div class="order-management">
            <h1 class="header-h1">Thêm sản phẩm</h1>
        </div>

        <div class="container">
            <div class="button-group">
                <button><i class="fa-solid fa-square-plus" onclick=""></i> Thêm nhà cung cấp</button>
                <button><i class="fa-solid fa-square-plus" onclick=""></i> Thêm danh mục</button>
                <button><i class="fa-solid fa-square-plus" onclick=""></i> Thêm tình trạng</button>
            </div>
            
            <form>

                <div class="form-group-row">
                    <div class="form-group">
                        <label for="product-code">Mã sản phẩm</label>
                        <input type="text" id="product-code" name="product-code">
                    </div>
                    <div class="form-group">
                        <label for="product-name">Tên sản phẩm</label>
                        <input type="text" id="product-name" name="product-name">
                    </div>
                    <div class="form-group">
                        <label for="supplier">Nhà cung cấp</label>
                        <select id="supplier" name="supplier">
                            <option value="">-- Chọn nhà cung cấp --</option>
                            <option value="supplier1">Nhà cung cấp 1</option>
                            <option value="supplier2">Nhà cung cấp 2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category">Danh mục</label>
                            <select id="category" name="category">
                                <option value="">-- Chọn danh mục --</option>
                                <option value="">Trái cây ngon</option>
                                <option value="">Trái cây Việt</option>
                                <option value="">Trái cây Nhập Khẩu</option>
                            </select>
                    </div>
                </div>
                
            <div class="form-group-row">
                    <div class="form-group">
                        <label for="price">Giá bán</label>
                        <input type="text" id="price" name="price">
                    </div>
                    <div class="form-group">
                        <label for="status">Tình trạng</label>
                        <select id="status" name="status">
                            <option value="">-- Chọn tình trạng --</option>
                            <option value="status1">Còn hàng</option>
                            <option value="status2">Hết hàng</option>
                        </select>
                    </div>
                <form action="../pages/test.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="product-image">Ảnh sản phẩm</label>
                        <div class="image-upload-container">
                            <input type="file" id="product-image" name="product-image" accept="image/*" onchange="previewImage(this)">
                            <div id="image-preview" class="image-preview">
                                <p>Hình ảnh</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

                <div class="form-group">
                    <label for="description">Mô tả sản phẩm</label>
                    <textarea id="description" name="description" rows="4"></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="reset" class="btn-cancel" onclick=""><i class="fas fa-trash-alt"></i> Hủy bỏ</button>
                    <button type="submit" class="btn-save" onclick=""><i class="fa-solid fa-download"></i> Lưu lại</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../js/product.js"></script>
    
</body>
</html>

<?php

    require_once 'loadanh.php';

    $dbhost = "localhost";
    $dbuser = "";
    $dbpass = "";
    $dbname = "website";

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    if($conn -> connect_error){
        echo ("Ket noi that bai" . $conn->connect_error);
    }

    if($_SERVER["REQUEST_METHOD" == "POST"]){
        $product_id = $_POST["product_id"];
        $product_name = $_POST["product_name"];
        $product_price = $_POST["product_price"];
        $product_status = $_POST["product_status"];
        $product_type = $_POST["product_type"];
        $product_image = $_POST["product_image"];
    
    $stmt->close();
    }
?>