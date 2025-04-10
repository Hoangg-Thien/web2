<?php
require 'connect.php';

$where_clause = "";

// Lọc theo ngày
if (isset($_GET['datein']) && !empty($_GET['datein'])) {
    $date_in = mysqli_real_escape_string($conn, $_GET['datein']);
    $where_clause .= " AND DATE(hd.order_date) >= '$date_in'";
}

if (isset($_GET['dateout']) && !empty($_GET['dateout'])) {
    $date_out = mysqli_real_escape_string($conn, $_GET['dateout']);
    $where_clause .= " AND DATE(hd.order_date) <= '$date_out'";
}

$order_sql = "SELECT hd.*, nd.fullname, nd.district, nd.city, nd.user_address,
              (SELECT SUM(cthd.quantity * sp.product_price) 
               FROM chitiethoadon cthd 
               JOIN sanpham sp ON cthd.product_id = sp.product_id 
               WHERE cthd.order_id = hd.order_id) as total_amount
              FROM hoadon hd 
              LEFT JOIN nguoidung nd ON hd.user_name = nd.user_name
              WHERE 1=1 $where_clause
              ORDER BY total_amount DESC";

$order_result = mysqli_query($conn, $order_sql);

$top_customers_sql = "SELECT nd.fullname, SUM(cthd.quantity * sp.product_price) as total_spent
                    FROM hoadon hd
                    JOIN nguoidung nd ON hd.user_name = nd.user_name
                    JOIN chitiethoadon cthd ON hd.order_id = cthd.order_id
                    JOIN sanpham sp ON cthd.product_id = sp.product_id
                    WHERE 1=1 $where_clause
                    GROUP BY nd.user_name, nd.fullname
                    ORDER BY total_spent DESC
                    LIMIT 5";

$top_customers_result = mysqli_query($conn, $top_customers_sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê tình hình kinh doanh </title>
    <link rel="stylesheet" href="./stylescss/satistics.css">
    <link rel="stylesheet" href="./stylescss/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <button class="toggle-sidebar" id="toggleSidebar"><i class="fas fa-bars"></i></button>
    <div class="sidebar" id="sidebar">
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

        <ul class="sidebar-menu">
            <a class="icon-denim" href="./usermanage.php" target="_self"><i class="fa-solid fa-user-shield"></i> Quản
                lí người dùng</a>
            <a class="icon-denim" href="./order.php" target="_self"><i class="fa-solid fa-cart-shopping"></i> Quản lý
                đơn hàng</a>
            <a class="icon-denim" href="./prolist.html" target="_self"><i class="fa-solid fa-box-archive"></i> Tất cả
                sản phẩm</a>
            <a class="icon-denim" href="./addpro.html" target="_self"><i class="fa-solid fa-cart-plus"></i> Thêm sản
                phẩm</a>
            <a class="icon-denim icon-denim-active" href="./satistics.php" target="_self"><i
                    class="fa-solid fa-chart-column"></i> Thống kê tình hình</a>
            <a class="icon-denim" href="../index.html" target="_self"><i class="fa-solid fa-user-xmark"></i> Đăng
                xuất</a>
        </ul>
    </div>

    <header>
        <div class="web-header">
            <a href=""> <img src="../img/mau-thiet-ke-logo-trai-cay-SPencil-Agency-7.png"
                    alt="mau-thiet-ke-logo-trai-cay-SPencil-Agency-7"></a>
        </div>
    </header>

    <main class="main" id="main">
        <div class="order-management">
            <h1 style="font-weight: bold;">Thống Kê Tình Hình Kinh Doanh</h1>
        </div>

        <form action="" id="dateFilterForm">
                    <label for="datein">Từ ngày: </label>
                    <input type="date" name="datein" id="datein" value="<?php echo isset($_GET['datein']) ? htmlspecialchars($_GET['datein']) : ''; ?>">
                    <label for="dateout">đến ngày: </label>
                    <input type="date" name="dateout" id="dateout" value="<?php echo isset($_GET['dateout']) ? htmlspecialchars($_GET['dateout']) : ''; ?>">
                </form>
        <button style="outline: none; margin-top: 10px;" id="applyLocationFilter" class="btn btn-filter">Lọc</button>
        <button style="outline: none; margin-top: 10px;" id="resetLocationFilter" class="btn btn-reset">Đặt lại</button>

        <div>
            <h3 class="tile-title">5 KHÁCH HÀNG CÓ MỨC MUA CAO NHẤT</h3>
        </div>
        <div class="tile-body">
            <table class="table table-hover table-bordered" id="sampleTable">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn</th>
                        <th>Tên Khách hàng</th>
                        <th>Đơn hàng</th>
                        <th>Tổng tiền</th>
                        <th>Ngày</th>
                        <th>Hóa đơn</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if ($top_customers_result) {
                        mysqli_data_seek($top_customers_result, 0);
                    }

                    $rank = 1;
                    
                    if ($order_result && mysqli_num_rows($order_result) > 0) {
                        while ($order = mysqli_fetch_assoc($order_result)) {
                            $order_id = $order['order_id'];
                            
                            $date = date('d/m/Y', strtotime($order['order_date']));
                            $time = date('H:i', strtotime($order['order_date']));
                    ?>
                    <tr>
                        <td><?php echo $rank++; ?></td>
                        <td><?php echo $order['order_id']; ?></td>
                        <td><?php echo $order['fullname']; ?></td>
                        <td>
                            <?php
                            $order_detail_sql = "SELECT cthd.*, sp.product_name, sp.product_price
                                                FROM chitiethoadon cthd
                                                LEFT JOIN sanpham sp ON cthd.product_id = sp.product_id
                                                WHERE cthd.order_id = '$order_id'";
                            $order_detail_result = mysqli_query($conn, $order_detail_sql);
                            
                            if ($order_detail_result && mysqli_num_rows($order_detail_result) > 0) {
                                while ($detail = mysqli_fetch_assoc($order_detail_result)) {
                                    $quantity = isset($detail['quantity']) ? $detail['quantity'] : 1;
                                    echo $quantity . "kg x " . $detail['product_name'] . "<br>";
                                }
                            } else {
                                echo "Không có đơn";
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            if (isset($order['total_amount']) && $order['total_amount'] > 0) {
                                echo number_format($order['total_amount'], 0, ',', '.') . 'đ';
                            } else {
                                echo "N/A";
                            }
                            ?>
                        </td>
                        <td><?php echo $date; ?><br><?php echo $time; ?></td>
                    </tr>
                    <?php
                        }
                    } else {
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Không có đơn hàng nào</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <h3 class="tile-title">MẶT HÀNG</h3>
        <div class="tile-body">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng bán ra</th>
                        <th>Giá tiền</th>
                        <th>Hóa đơn</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>F010</td>
                        <td class="img-pro"><img src="../img/man-Ha-Noi.jpg" alt="man-Ha-Noi"></td>
                        <td>Mận Hà Nội</td>
                        <td>30kg</td>
                        <td>45.000đ/kg</td>
                        <td><a target="_blank" href="../billpro/probill.html"><i class="fa-solid fa-bars"></i></a></td>
                    </tr>

                    <tr>
                        <td>F005</td>
                        <td class="img-pro"><img src="../img/trai-chom-chom.jpg" alt="trai-chom-chom">
                        </td>
                        <td>Chôm chôm</td>
                        <td>25kg</td>
                        <td>45.000đ/kg</td>
                        <td><a target="_blank" href="../billpro/probill.html"><i class="fa-solid fa-bars"></i></a></td>
                    </tr>

                    <tr>
                        <td>F007</td>
                        <td class="img-pro"> <img src="../img/trai-oi.jpg" alt="trai-oi"></td>
                        <td>Ổi xá lị</td>
                        <td>19kg</td>
                        <td>45.000đ/kg</td>
                        <td><a target="_blank" href="../billpro/probill.html"><i class="fa-solid fa-bars"></i></a></td>
                    </tr>

                    <tr>
                        <td>F012</td>
                        <td class="img-pro"> <img src="../img/dau-tay.jpg" alt="dau-tay"></td>
                        <td>Dâu tây Đà Lạt</td>
                        <td>15kg</td>
                        <td>160.000đ/kg</td>
                        <td><a target="_blank" href="../billpro/probill.html"><i class="fa-solid fa-bars"></i></a></td>
                    </tr>

                    <tr>
                        <td>F002</td>
                        <td class="img-pro"> <img src="../img/trai-kiwi.jpg" alt="trai-kiwi"></td>
                        <td>Kiwi</td>
                        <td>10kg</td>
                        <td>160.000đ/kg</td>
                        <td><a target="_blank" href="../billpro/probill.html"><i class="fa-solid fa-bars"></i></a></td>
                    </tr>

                    <tr>
                        <th colspan="4">Tổng cộng:</th>
                        <td>7.330.000đ</td>
                    </tr>
                </tbody>
            </table>


            <h3 class="tile-title">SẢN PHẨM BÁN CHẠY</h3>
            <div class="tile-body">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Mã sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng bán ra</th>
                            <th>Giá tiền</th>
                            <th>Hóa đơn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>F010</td>
                            <td class="img-pro"> <img src="../img/man-Ha-Noi.jpg" alt="man-Ha-Noi"></td>
                            <td>Mận Hà Nội</td>
                            <td>30kg</td>
                            <td>45.000đ/kg</td>
                            <td><a target="_blank" href="../billpro/probill.html"><i class="fa-solid fa-bars"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td>F005</td>
                            <td class="img-pro"> <img src="../img/trai-chom-chom.jpg" alt="trai-chom-chom">
                            </td>
                            <td>Chôm chôm</td>
                            <td>25kg</td>
                            <td>45.000đ/kg</td>
                            <td><a target="_blank" href="../billpro/probill.html"><i class="fa-solid fa-bars"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td>F007</td>
                            <td class="img-pro"> <img src="../img/trai-oi.jpg" alt="trai-oi"></td>
                            <td>Ổi xá lị</td>
                            <td>19kg</td>
                            <td>45.000đ/kg</td>
                            <td><a target="_blank" href="../billpro/probill.html"><i class="fa-solid fa-bars"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="4">Tổng cộng:</th>
                            <td>3.330.000đ</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h3 class="tile-title">SẢN PHẨM BÁN Ế</h3>
            <div class="tile-body">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Mã sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng bán ra</th>
                            <th>Giá tiền</th>
                            <th>Hóa đơn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>F001</td>
                            <td class="img-pro"> <img src="../img/trai-chuoi.jpg" alt="trai-chuoi"></td>
                            <td>Chuối chín Nam Mỹ</td>
                            <td>0kg</td>
                            <td>45.000đ/kg</td>
                            <td><a target="_blank" href="../billpro/probill.html"><i class="fa-solid fa-bars"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td>F004</td>
                            <td class="img-pro"> <img src="../img/trai-man-do.jpg" alt="trai-man-do"></td>
                            <td>Mận đỏ An Phước</td>
                            <td>1kg</td>
                            <td>45.000đ/kg</td>
                            <td><a target="_blank" href="../billpro/probill.html"><i class="fa-solid fa-bars"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td>F003</td>
                            <td class="img-pro"> <img src="../img/hinh-trai-buoi.jpg" alt="hinh-trai-buoi">
                            </td>
                            <td>Bưởi da xanh</td>
                            <td>0kg</td>
                            <td>45.000đ/kg</td>
                            <td><a target="_blank" href="../billpro/probill.html"><i class="fa-solid fa-bars"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="4">Tổng cộng:</th>
                            <td>45.000đ</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">THỐNG KÊ DOANH SỐ</h3>
                    <div class="embed-responsive embed-responsive-16by9">
                        <canvas class="embed-responsive-item" id="barChartDemo"></canvas>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>

    <script src="../js/statistic.js"></script>
    <script>
        $(document).ready(function () {
            $("#toggleSidebar").click(function () {
                $("#sidebar").toggleClass("active");
            });

            $(document).click(function (event) {
                if (!$(event.target).closest('#sidebar, #toggleSidebar').length && $('#sidebar').hasClass('active')) {
                    $("#sidebar").removeClass("active");
                }
            });

            // lọc theo ngày
            $('#applyLocationFilter').on('click', function(e) {
                e.preventDefault();
                
                var datein = $('#datein').val();
                var dateout = $('#dateout').val();
                
                var url = 'satistics.php?';
                var params = [];
                
                if (datein) {
                    params.push('datein=' + datein);
                }
                
                if (dateout) {
                    params.push('dateout=' + dateout);
                }
                
                window.location.href = url + params.join('&');
            });
            
            $('#resetLocationFilter').on('click', function(e) {
                e.preventDefault();
                window.location.href = 'satistics.php';
            });
            
            $('#dateFilterForm').on('submit', function(e) {
                e.preventDefault();
                $('#applyLocationFilter').click();
            });
        });
    </script>

</body>
</html>