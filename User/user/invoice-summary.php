<?php
require_once('c07db.php');

// Initialize database connection
$db = new Database();

// Get invoice statistics
function getInvoiceStats($db) {
    $stats = [
        'total' => 0,
        'completed' => 0,
        'pending' => 0,
        'cancelled' => 0
    ];
    
    $query = "SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
        SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
        FROM invoices WHERE user_id = ?";
    
    $user_id = $_SESSION['user_id']; // Assuming you have user session
    $result = $db->query($query, [$user_id]);
    if ($result && $row = $result->fetch()) {
        $stats = [
            'total' => $row['total'],
            'completed' => $row['completed'],
            'pending' => $row['pending'],
            'cancelled' => $row['cancelled']
        ];
    }
    return $stats;
}

// Get recent invoices
function getRecentInvoices($db, $limit = 10) {
    $query = "SELECT 
        i.invoice_id,
        i.order_date,
        i.total_amount,
        i.status,
        GROUP_CONCAT(p.product_name SEPARATOR ', ') as products
        FROM invoices i
        LEFT JOIN invoice_items ii ON i.invoice_id = ii.invoice_id
        LEFT JOIN products p ON ii.product_id = p.product_id
        WHERE i.user_id = ?
        GROUP BY i.invoice_id
        ORDER BY i.order_date DESC
        LIMIT ?";
    
    $user_id = $_SESSION['user_id']; // Assuming you have user session
    return $db->query($query, [$user_id, $limit]);
}

// Get invoice statistics
$stats = getInvoiceStats($db);

// Get recent invoices
$recent_invoices = getRecentInvoices($db);

// Handle filtering
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <!-- Keep your existing head content -->
    <title>Tóm Tắt Hóa Đơn - SEA FRUITS</title>
    <!-- Keep your existing styles -->
</head>
<body>
    <!-- Keep your existing header and navigation -->

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1><i class="fas fa-file-invoice"></i> Tóm Tắt Hóa Đơn</h1>
        </div>

        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-icon" style="background: #4CAF50;">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['total']; ?></h3>
                    <p>Tổng số đơn hàng</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #2196F3;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['completed']; ?></h3>
                    <p>Đơn hoàn thành</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #FFC107;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['pending']; ?></h3>
                    <p>Đang xử lý</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #F44336;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['cancelled']; ?></h3>
                    <p>Đã hủy</p>
                </div>
            </div>
        </div>

        <div class="recent-invoices">
            <div class="section-header">
                <h2><i class="fas fa-list"></i> Hóa Đơn Gần Đây</h2>
                <div class="invoice-filters">
                    <a href="?filter=all" class="filter-btn <?php echo $filter === 'all' ? 'active' : ''; ?>">Tất cả</a>
                    <a href="?filter=completed" class="filter-btn <?php echo $filter === 'completed' ? 'active' : ''; ?>">Hoàn thành</a>
                    <a href="?filter=pending" class="filter-btn <?php echo $filter === 'pending' ? 'active' : ''; ?>">Đang xử lý</a>
                    <a href="?filter=cancelled" class="filter-btn <?php echo $filter === 'cancelled' ? 'active' : ''; ?>">Đã hủy</a>
                </div>
            </div>

            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Sản phẩm</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($recent_invoices && $recent_invoices->rowCount() > 0): ?>
                        <?php while ($invoice = $recent_invoices->fetch()): ?>
                            <tr>
                                <td>#<?php echo htmlspecialchars($invoice['invoice_id']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($invoice['order_date'])); ?></td>
                                <td><?php echo htmlspecialchars($invoice['products']); ?></td>
                                <td><?php echo number_format($invoice['total_amount'], 0, ',', '.'); ?>đ</td>
                                <td>
                                    <span class="status-badge status-<?php echo $invoice['status']; ?>">
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
                                </td>
                                <td>
                                    <a href="invoice-detail.php?id=<?php echo $invoice['invoice_id']; ?>" class="action-btn view-btn">
                                        <i class="fas fa-eye"></i> Xem
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Không có hóa đơn nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Keep your existing footer -->
</body>
</html> 