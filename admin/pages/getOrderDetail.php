<?php
require 'connect.php';
header('Content-Type: application/json');

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $sql = "SELECT d.*, nd.fullname, nd.user_name, nd.user_address, sp.product_name, sp.product_price 
            FROM dathang d
            LEFT JOIN nguoidung nd ON d.user_name = nd.user_name
            LEFT JOIN sanpham sp ON d.product_id = sp.product_id
            WHERE d.order_id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $order_id);
        
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $order = mysqli_fetch_assoc($result);
            
            if (isset($order['product_price'])) {
                $quantity = isset($order['quantity']) && !empty($order['quantity']) ? $order['quantity'] : 1;
                $order['total_amount'] = $order['product_price'] * $quantity;
            }
            
            if (empty($order['address']) && !empty($order['user_address'])) {
                $order['address'] = $order['user_address'];
            }
            
            echo json_encode([
                'success' => true,
                'data' => $order
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy thông tin đơn hàng'
            ]);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Lỗi truy vấn: ' . mysqli_error($conn)
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Không có mã đơn hàng được cung cấp'
    ]);
} 