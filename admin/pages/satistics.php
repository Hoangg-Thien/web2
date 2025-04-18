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

// Truy vấn để lấy tất cả đơn hàng
$orders_sql = "SELECT hd.order_id, hd.order_date, nd.fullname, 
              (SELECT SUM(cthd.quantity * sp.product_price) 
               FROM chitiethoadon cthd 
               JOIN sanpham sp ON cthd.product_id = sp.product_id 
               WHERE cthd.order_id = hd.order_id) as total_amount
              FROM hoadon hd 
              LEFT JOIN nguoidung nd ON hd.user_name = nd.user_name
              WHERE 1=1 $where_clause
              ORDER BY hd.order_date DESC";

$orders_result = mysqli_query($conn, $orders_sql);

// Mảng để lưu trữ khách hàng đã gộp
$merged_customers = [];

// Gộp khách hàng
if ($orders_result && mysqli_num_rows($orders_result) > 0) {
    while ($order = mysqli_fetch_assoc($orders_result)) {
        $fullname = $order['fullname'];

        // Nếu chưa có khách hàng này trong mảng gộp
        if (!isset($merged_customers[$fullname])) {
            $merged_customers[$fullname] = [
                'fullname' => $fullname,
                'orders' => [],
                'total_amount' => 0,
                'date_range' => []
            ];
        }

        // Thêm đơn hàng vào khách hàng
        $merged_customers[$fullname]['orders'][] = [
            'order_id' => $order['order_id'],
            'order_date' => $order['order_date'],
            'total_amount' => $order['total_amount']
        ];

        // Cộng dồn tổng tiền
        $merged_customers[$fullname]['total_amount'] += $order['total_amount'];
    }
}

// Sắp xếp khách hàng theo tổng tiền giảm dần
uasort($merged_customers, function($a, $b) {
    return $b['total_amount'] <=> $a['total_amount'];
});

// Lấy 5 khách hàng có mức mua cao nhất
$top_customers = array_slice($merged_customers, 0, 5);

// Sắp xếp khách hàng theo tổng tiền giảm dần
uasort($merged_customers, function($a, $b) {
    return $b['total_amount'] <=> $a['total_amount'];
});

// Lấy 5 khách hàng có mức mua cao nhất
$top_customers = array_slice($merged_customers, 0, 5);

session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: /web2/login.php");
    exit();
}

// Top 3 sản phẩm bán chạy
$best_sellers_sql = "SELECT sp.product_id, sp.product_name, sp.product_price, sp.product_image, 
                    SUM(cthd.quantity) as total_sold
                    FROM sanpham sp
                    JOIN chitiethoadon cthd ON sp.product_id = cthd.product_id
                    JOIN hoadon hd ON cthd.order_id = hd.order_id
                    WHERE 1=1 $where_clause
                    GROUP BY sp.product_id, sp.product_name, sp.product_price, sp.product_image
                    ORDER BY total_sold DESC
                    LIMIT 3";

$best_sellers_result = mysqli_query($conn, $best_sellers_sql);
$best_sellers = [];
$total_best_sellers = 0;

if ($best_sellers_result && mysqli_num_rows($best_sellers_result) > 0) {
    while ($product = mysqli_fetch_assoc($best_sellers_result)) {
        $best_sellers[] = $product;
        $total_best_sellers += ($product['total_sold'] * $product['product_price']);
    }
}

// Top 3 sản phẩm bán ế
$worst_sellers_sql = "SELECT sp.product_id, sp.product_name, sp.product_price, sp.product_image, 
                      COALESCE(SUM(cthd.quantity), 0) as total_sold
                      FROM sanpham sp
                      LEFT JOIN chitiethoadon cthd ON sp.product_id = cthd.product_id
                      LEFT JOIN hoadon hd ON cthd.order_id = hd.order_id AND (1=1 $where_clause)
                      GROUP BY sp.product_id, sp.product_name, sp.product_price, sp.product_image
                      ORDER BY total_sold ASC
                      LIMIT 3";

$worst_sellers_result = mysqli_query($conn, $worst_sellers_sql);
$worst_sellers = [];
$total_worst_sellers = 0;

if ($worst_sellers_result && mysqli_num_rows($worst_sellers_result) > 0) {
    while ($product = mysqli_fetch_assoc($worst_sellers_result)) {
        $worst_sellers[] = $product;
        $total_worst_sellers += ($product['total_sold'] * $product['product_price']);
    }
}

// truy vấn hóa đơn sp bán chạy/ ế
foreach ($best_sellers as &$product) {
    $product_orders_sql = "SELECT DISTINCT hd.order_id, hd.order_date, nd.fullname
                          FROM hoadon hd
                          JOIN chitiethoadon cthd ON hd.order_id = cthd.order_id
                          LEFT JOIN nguoidung nd ON hd.user_name = nd.user_name
                          WHERE cthd.product_id = '{$product['product_id']}'
                          $where_clause
                          ORDER BY hd.order_date DESC";
    
    $product_orders_result = mysqli_query($conn, $product_orders_sql);
    $product['orders'] = [];
    
    if ($product_orders_result && mysqli_num_rows($product_orders_result) > 0) {
        while ($order = mysqli_fetch_assoc($product_orders_result)) {
            $product['orders'][] = $order;
        }
    }
}

foreach ($worst_sellers as &$product) {
    $product_orders_sql = "SELECT DISTINCT hd.order_id, hd.order_date, nd.fullname
                          FROM hoadon hd
                          JOIN chitiethoadon cthd ON hd.order_id = cthd.order_id
                          LEFT JOIN nguoidung nd ON hd.user_name = nd.user_name
                          WHERE cthd.product_id = '{$product['product_id']}'
                          $where_clause
                          ORDER BY hd.order_date DESC";
    
    $product_orders_result = mysqli_query($conn, $product_orders_sql);
    $product['orders'] = [];
    
    if ($product_orders_result && mysqli_num_rows($product_orders_result) > 0) {
        while ($order = mysqli_fetch_assoc($product_orders_result)) {
            $product['orders'][] = $order;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê tình hình kinh doanh </title>
    <link rel="stylesheet" href="./stylescss/satistics.css">
    <link rel="stylesheet" href="./stylescss/responsivestatistics.css">
    <link rel="stylesheet" href="./stylescss/turnover.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 250px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 4px;
            right: 0;
            max-height: 200px;
            overflow-y: auto; 
        }
        
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            white-space: nowrap;
        }
        
        .dropdown-content a:hover {background-color: #f1f1f1}
        
        .btn-info1.dropdown-toggle {
            background-color: #17ab1d; 
            color: white; 
            border: none; 
            padding: 6px 12px; 
            border-radius: 4px; 
            text-decoration: none;
        }
        .btn-info1.dropdown-toggle:active {
           outline: none;
        }
        .multi-orders {
            font-size: 0.8em;
            color: #666;
            margin-top: 3px;
        }
        .dropdown-menu{
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 250px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 4px;
            right: 0;
            top: auto;
            margin-bottom: 5px;
            bottom: 100%;
            max-height: 200px;
            overflow-y: auto; 
        }
        .dropdown-menu a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            white-space: nowrap;
        }
        
        .dropdown-menu a:hover {background-color: #f1f1f1}
    </style>
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
                    <?php if (isset($_SESSION['fullname'])): ?>
                        <div> Chào mừng trở lại, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>! </div>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>

        <hr>

        <ul class="sidebar-menu">
            <a class="icon-denim" href="./usermanage.php" target="_self"><i class="fa-solid fa-user-shield"></i> Quản
                lí người dùng</a>
            <a class="icon-denim" href="./order.php" target="_self"><i class="fa-solid fa-cart-shopping"></i> Quản lý
                đơn hàng</a>
            <a class="icon-denim" href="./prolist.php" target="_self"><i class="fa-solid fa-box-archive"></i> Tất cả
                sản phẩm</a>
            <a class="icon-denim" href="./addpro.php" target="_self"><i class="fa-solid fa-cart-plus"></i> Thêm sản
                phẩm</a>
            <a class="icon-denim icon-denim-active" href="./satistics.php" target="_self"><i
                    class="fa-solid fa-chart-column"></i> Thống kê tình hình</a>
            <a class="icon-denim" href="../index.php" target="_self"><i class="fa-solid fa-user-xmark"></i> Đăng
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
                        <th>Tên Khách hàng</th>
                        <th>Đơn hàng</th>
                        <th>Tổng tiền</th>
                        <th>Hóa đơn</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $rank = 1;
                    
                    if (!empty($top_customers)) {
                        foreach ($top_customers as $customer) {
                            // Hiển thị thông tin đơn hàng
                            $order_display = count($customer['orders']) > 1 ? 
                                            count($customer['orders']) . " đơn hàng" : 
                                            "1 đơn hàng";
                            
                            // Tạo button xem chi tiết
                            if (count($customer['orders']) == 1) {
                                // Nếu chỉ có 1 đơn hàng thì tạo button đơn giản
                                $order = reset($customer['orders']);
                                $button = '<a href="satictics_detail.php?id=' . $order['order_id'] . '" class="btn btn-info btn-sm" style="background-color: #17ab1d; color: white; border: none; padding: 6px 12px; border-radius: 4px; text-decoration: none;">
                                            <i class="fa fa-eye"></i> Xem đơn hàng
                                           </a>';
                            } else {
                                // Nếu có nhiều đơn hàng thì tạo dropdown
                                $button = '<div class="dropdown">
                                            <button class="btn btn-info1 dropdown-toggle" type="button" id="dropdownContentButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i></i>▼ Xem đơn hàng
                                            </button>
                                            <div class="dropdown-content">';

                                            usort($customer['orders'], function($a, $b) {
                                                return strtotime($a['order_date']) - strtotime($b['order_date']);
                                            });
                                
                                // Thêm link cho từng đơn hàng
                                foreach ($customer['orders'] as $index => $order) {
                                    $order_date = date('d/m/Y', strtotime($order['order_date']));
                                    $order_time = date('H:i', strtotime($order['order_date']));
                                    $button .= '<a href="satictics_detail.php?id=' . $order['order_id'] . '">
                                                Đơn ' . ($index + 1) . ': '  . '  ' . $order_date . '
                                               </a>';
                                }
                                
                                $button .= '</div></div>';
                            }
                    ?>
                    <tr>
                        <td><?php echo $rank++; ?></td>
                        <td><?php echo $customer['fullname']; ?></td>
                        <td><?php echo $order_display; ?></td>
                        <td><?php echo number_format($customer['total_amount'], 0, ',', '.') . 'đ'; ?></td>
                        <td><?php echo $button; ?></td>
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

              <!-- SẢN PHẨM BÁN CHẠY -->
              <div class="product-section best-sellers">
                    <h3 class="tile-title">SẢN PHẨM BÁN CHẠY</h3>
                    <div class="tile-body">
                        <div class="row">
                            <?php if (!empty($best_sellers)): ?>
                                <?php foreach ($best_sellers as $product): ?>
                                    <div class="col-md-4">
                                        <div class="product-card">
                                            <div class="product-image">
                                                <img src="../img/<?php echo htmlspecialchars($product['product_image']); ?>" 
                                                    alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                            </div>
                                            <div class="product-info">
                                                <h4><?php echo htmlspecialchars($product['product_name']); ?></h4>
                                                <p><strong>Số lượng đã bán:</strong> <?php echo $product['total_sold']; ?>kg</p>
                                                <p><strong>Tổng doanh thu:</strong> <?php echo number_format($product['total_sold'] * $product['product_price'], 0, ',', '.'); ?>đ</p>
                                                <div class="dropdown">
                                                    <button class="btn btn-info1 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa-solid fa-circle-info"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <?php if (!empty($product['orders'])): ?>
                                                            <?php foreach ($product['orders'] as $index => $order): ?>
                                                                <?php 
                                                                    $order_date = date('d/m/Y', strtotime($order['order_date'])); 
                                                                ?>
                                                                <a href="satictics_detail.php?id=<?php echo $order['order_id']; ?>">
                                                                    Đơn <?php echo ($index + 1); ?>: <?php echo $order_date; ?>
                                                                </a>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <a href="javascript:void(0)" style="cursor: default; background-color: #f9f9f9;">Không có dữ liệu đơn hàng</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-md-12">
                                    <div class="no-data">Không có dữ liệu sản phẩm bán chạy</div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            <!-- SẢN PHẨM BÁN Ế -->
            <div class="product-section worst-sellers">
                        <h3 class="tile-title">SẢN PHẨM BÁN Ế</h3>
                        <div class="tile-body">
                            <div class="row">
                                <?php if (!empty($worst_sellers)): ?>
                                    <?php foreach ($worst_sellers as $product): ?>
                                        <div class="col-md-4">
                                            <div class="product-card slow-seller">
                                                <div class="product-image">
                                                    <img src="../img/<?php echo htmlspecialchars($product['product_image']); ?>" 
                                                        alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                                </div>
                                                <div class="product-info">
                                                    <h4><?php echo htmlspecialchars($product['product_name']); ?></h4>
                                                    <p><strong>Số lượng đã bán:</strong> <?php echo $product['total_sold']; ?>kg</p>
                                                    <p><strong>Tổng doanh thu:</strong> <?php echo number_format($product['total_sold'] * $product['product_price'], 0, ',', '.'); ?>đ</p>
                                                    <div class="dropdown">
                                                        <button class="btn btn-info1 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa-solid fa-circle-info"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <?php if (!empty($product['orders'])): ?>
                                                                <?php foreach ($product['orders'] as $index => $order): ?>
                                                                    <?php 
                                                                        $order_date = date('d/m/Y', strtotime($order['order_date'])); 
                                                                    ?>
                                                                    <a href="satictics_detail.php?id=<?php echo $order['order_id']; ?>">
                                                                        Đơn <?php echo ($index + 1); ?>: <?php echo $order_date; ?>
                                                                    </a>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <a href="javascript:void(0)" style="cursor: default; background-color: #f9f9f9;">Không có dữ liệu đơn hàng</a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-md-12">
                                        <div class="no-data">Không có dữ liệu sản phẩm bán ế trong khoảng thời gian này</div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
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
                if (!$(event.target).closest('#sidebar, #toggleSidebar, .dropdown').length && $('#sidebar').hasClass('active')) {
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
            $(document).on('click', '.dropdown-toggle', function() {
                var $dropdownMenu = $(this).next('.dropdown-content');
                $dropdownMenu.toggle(); 
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('.dropdown').length) {
                    $('.dropdown-content').hide(); 
                }
            });
            
            $(document).ready(function () {
                $(document).on('click', '.dropdown-toggle', function() {
                    var $dropdownContent = $(this).next('.dropdown-menu');
                    $dropdownContent.toggle();
                });

                $(document).on('click', function(event) {
                    if (!$(event.target).closest('.dropdown').length) {
                        $('.dropdown-menu').hide();
                    }
                });
            });
    </script>
</body>
</html>