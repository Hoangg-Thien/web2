<?php
require_once('c07db.php');

// Get invoice ID from URL parameter
$invoice_id = isset($_GET['id']) ? $_GET['id'] : '002';

try {
    // Prepare and execute query to get invoice details
    $stmt = $db->prepare("
        SELECT 
            i.invoice_id,
            i.order_date,
            i.payment_method,
            i.shipping_address,
            i.phone_number,
            i.status,
            i.subtotal,
            i.shipping_fee,
            i.discount,
            i.total_amount,
            c.customer_name,
            c.email
        FROM invoices i
        JOIN customers c ON i.customer_id = c.customer_id
        WHERE i.invoice_id = ?
    ");
    $stmt->execute([$invoice_id]);
    $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get invoice items
    $stmt = $db->prepare("
        SELECT 
            p.product_name,
            p.image_url,
            ii.unit_price,
            ii.quantity,
            (ii.unit_price * ii.quantity) as item_total
        FROM invoice_items ii
        JOIN products p ON ii.product_id = p.product_id
        WHERE ii.invoice_id = ?
    ");
    $stmt->execute([$invoice_id]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

// Helper function to format currency
function formatCurrency($amount) {
    return number_format($amount, 0, ',', '.') . 'đ';
}

// Helper function to get status class
function getStatusClass($status) {
    switch(strtolower($status)) {
        case 'completed':
            return 'status-completed';
        case 'pending':
            return 'status-pending';
        case 'cancelled':
            return 'status-cancelled';
        default:
            return 'status-pending';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <!-- [Previous head content remains the same] -->
    <title>Chi Tiết Hóa Đơn #<?php echo htmlspecialchars($invoice_id); ?> - SEA FRUITS</title>
</head>
<body>
    <!-- [Previous header and navigation content remains the same] -->

    <div class="invoice-detail-container">
        <a href="./invoice-summary.html" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Quay lại danh sách hóa đơn</span>
        </a>
        
        <div class="invoice-header">
            <div class="invoice-title">
                <h1>Hóa Đơn #<?php echo htmlspecialchars($invoice_id); ?></h1>
                <span class="invoice-status <?php echo getStatusClass($invoice['status']); ?>">
                    <?php echo htmlspecialchars($invoice['status']); ?>
                </span>
            </div>
            <div class="invoice-info">
                <div class="info-group">
                    <span class="info-label">Ngày đặt hàng</span>
                    <span class="info-value"><?php echo date('d/m/Y', strtotime($invoice['order_date'])); ?></span>
                </div>
                <div class="info-group">
                    <span class="info-label">Phương thức thanh toán</span>
                    <span class="info-value"><?php echo htmlspecialchars($invoice['payment_method']); ?></span>
                </div>
                <div class="info-group">
                    <span class="info-label">Địa chỉ giao hàng</span>
                    <span class="info-value"><?php echo htmlspecialchars($invoice['shipping_address']); ?></span>
                </div>
                <div class="info-group">
                    <span class="info-label">Số điện thoại</span>
                    <span class="info-value"><?php echo htmlspecialchars($invoice['phone_number']); ?></span>
                </div>
            </div>
        </div>

        <div class="invoice-items">
            <h2>Chi tiết sản phẩm</h2>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <div class="item-details">
                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['product_name']); ?>" 
                                     class="item-image">
                                <span class="item-name"><?php echo htmlspecialchars($item['product_name']); ?></span>
                            </div>
                        </td>
                        <td class="item-price"><?php echo formatCurrency($item['unit_price']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td class="item-price"><?php echo formatCurrency($item['item_total']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="invoice-summary">
            <h2>Tổng kết</h2>
            <div class="summary-row">
                <span>Tạm tính</span>
                <span><?php echo formatCurrency($invoice['subtotal']); ?></span>
            </div>
            <div class="summary-row">
                <span>Phí vận chuyển</span>
                <span><?php echo $invoice['shipping_fee'] > 0 ? formatCurrency($invoice['shipping_fee']) : 'Miễn phí'; ?></span>
            </div>
            <div class="summary-row">
                <span>Giảm giá</span>
                <span><?php echo formatCurrency($invoice['discount']); ?></span>
            </div>
            <div class="summary-row total">
                <span>Tổng cộng</span>
                <span><?php echo formatCurrency($invoice['total_amount']); ?></span>
            </div>
            <div class="invoice-actions">
                <button class="action-btn print-btn" onclick="window.print()">
                    <i class="fas fa-print"></i>
                    In hóa đơn
                </button>
                <button class="action-btn download-btn" onclick="generatePDF()">
                    <i class="fas fa-download"></i>
                    Tải PDF
                </button>
            </div>
        </div>
    </div>

    <!-- [Previous footer content remains the same] -->

    <script>
    function generatePDF() {
        // Add PDF generation logic here
        window.print(); // Temporary fallback to print
    }
    </script>
</body>
</html> 