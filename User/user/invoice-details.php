<?php
session_start();
require_once('connect.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: usernologin.php");
    exit();
}

// Get invoice ID from URL
$invoice_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Function to get invoice details
function getInvoiceDetails($conn, $invoice_id, $user_id) {
    $query = "SELECT o.*, 
              GROUP_CONCAT(oi.product_name, '|', oi.quantity, '|', oi.price SEPARATOR '||') as order_items
              FROM orders o
              LEFT JOIN order_items oi ON o.id = oi.order_id
              WHERE o.id = ? AND o.user_id = ?
              GROUP BY o.id";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $invoice_id, $user_id);
    $stmt->execute();
    return $stmt->get_result();
}

// Get invoice details
$invoice = getInvoiceDetails($conn, $invoice_id, $_SESSION['user_id'])->fetch_assoc();

// If invoice not found or doesn't belong to user
if (!$invoice) {
    header("Location: invoice-summary.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Hóa Đơn - SEA FRUITS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../styles/news.css">
    <link rel="stylesheet" href="../styles/grid.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <style>
        .invoice-details-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border-color);
        }

        .invoice-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .invoice-title h1 {
            margin: 0;
            color: var(--primary-color);
            font-size: 2rem;
        }

        .invoice-status {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .invoice-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
        }

        .info-section h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .info-label {
            color: var(--light-text);
        }

        .info-value {
            font-weight: 500;
        }

        .invoice-items {
            margin-bottom: 2rem;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th,
        .items-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .items-table th {
            background: #f8f9fa;
            font-weight: 600;
        }

        .item-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        .invoice-summary {
            display: flex;
            justify-content: flex-end;
            gap: 2rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid var(--border-color);
        }

        .summary-item {
            text-align: right;
        }

        .summary-label {
            color: var(--light-text);
            margin-bottom: 0.5rem;
        }

        .summary-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .invoice-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .action-btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .back-btn {
            background: #f8f9fa;
            color: var(--text-color);
        }

        .download-btn {
            background: var(--primary-color);
            color: white;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .invoice-details-container {
                margin: 1rem;
                padding: 1rem;
            }

            .invoice-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .invoice-info {
                grid-template-columns: 1fr;
            }

            .invoice-summary {
                flex-direction: column;
                gap: 1rem;
            }

            .invoice-actions {
                flex-direction: column;
            }

            .action-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <!-- ... Giữ nguyên header từ file invoice-summary.php ... -->
    </header>

    <div class="invoice-details-container">
        <div class="invoice-header">
            <div class="invoice-title">
                <h1>Chi Tiết Hóa Đơn #<?php echo $invoice['id']; ?></h1>
            </div>
            <span class="invoice-status status-<?php echo strtolower($invoice['status']); ?>">
                <?php 
                switch($invoice['status']) {
                    case 'completed':
                        echo 'Hoàn thành';
                        break;
                    case 'pending':
                        echo 'Đang xử lý';
                        break;
                    case 'cancelled':
                        echo 'Đã hủy';
                        break;
                }
                ?>
            </span>
        </div>

        <div class="invoice-info">
            <div class="info-section">
                <h3>Thông Tin Đơn Hàng</h3>
                <div class="info-item">
                    <span class="info-label">Mã đơn hàng:</span>
                    <span class="info-value">#<?php echo $invoice['id']; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Ngày đặt:</span>
                    <span class="info-value"><?php echo date('d/m/Y H:i', strtotime($invoice['created_at'])); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Trạng thái:</span>
                    <span class="info-value">
                        <?php 
                        switch($invoice['status']) {
                            case 'completed':
                                echo 'Hoàn thành';
                                break;
                            case 'pending':
                                echo 'Đang xử lý';
                                break;
                            case 'cancelled':
                                echo 'Đã hủy';
                                break;
                        }
                        ?>
                    </span>
                </div>
            </div>

            <div class="info-section">
                <h3>Thông Tin Thanh Toán</h3>
                <div class="info-item">
                    <span class="info-label">Phương thức thanh toán:</span>
                    <span class="info-value"><?php echo $invoice['payment_method']; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Địa chỉ giao hàng:</span>
                    <span class="info-value"><?php echo $invoice['shipping_address']; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Số điện thoại:</span>
                    <span class="info-value"><?php echo $invoice['phone']; ?></span>
                </div>
            </div>
        </div>

        <div class="invoice-items">
            <h3>Chi Tiết Sản Phẩm</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $order_items = explode('||', $invoice['order_items']);
                    $total = 0;
                    foreach ($order_items as $item) {
                        list($name, $quantity, $price) = explode('|', $item);
                        $subtotal = $price * $quantity;
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <img src="../img/<?php echo strtolower(str_replace(' ', '-', $name)); ?>.jpg" 
                                         alt="<?php echo $name; ?>" class="item-image">
                                    <span><?php echo $name; ?></span>
                                </div>
                            </td>
                            <td><?php echo $quantity; ?></td>
                            <td><?php echo number_format($price); ?>đ</td>
                            <td><?php echo number_format($subtotal); ?>đ</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="invoice-summary">
            <div class="summary-item">
                <div class="summary-label">Tổng cộng:</div>
                <div class="summary-value"><?php echo number_format($total); ?>đ</div>
            </div>
        </div>

        <div class="invoice-actions">
            <button class="action-btn back-btn" onclick="window.location.href='invoice-summary.php'">
                <i class="fas fa-arrow-left"></i>
                Quay lại
            </button>
            <button class="action-btn download-btn" onclick="window.location.href='download-invoice.php?id=<?php echo $invoice['id']; ?>'">
                <i class="fas fa-download"></i>
                Tải xuống
            </button>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <!-- ... Giữ nguyên footer từ file invoice-summary.php ... -->
    </footer>
</body>
</html> 