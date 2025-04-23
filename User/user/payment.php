<?php
session_start();
require_once('../data/c07db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Get order ID from URL
if (!isset($_GET['order_id'])) {
    header("Location: orders.php");
    exit();
}

$order_id = $_GET['order_id'];

// Fetch order details
$order_sql = "SELECT o.*, u.user_name, u.user_email, u.user_phone, u.user_address 
              FROM orders o 
              JOIN nguoidung u ON o.user_id = u.user_id 
              WHERE o.order_id = ? AND o.user_id = ?";
$stmt = $conn->prepare($order_sql);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows == 0) {
    header("Location: orders.php");
    exit();
}

$order = $order_result->fetch_assoc();

// Check if order is already paid
if ($order['payment_status'] == 'completed') {
    header("Location: order-confirmation.php?order_id=" . $order_id);
    exit();
}

// Fetch payment methods
$methods_sql = "SELECT * FROM payment_methods WHERE is_active = 1";
$methods_result = $conn->query($methods_sql);
$payment_methods = $methods_result->fetch_all(MYSQLI_ASSOC);

// Handle payment submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cancel_payment'])) {
        // Update order status to cancelled
        $update_order = "UPDATE orders SET payment_status = 'cancelled' WHERE order_id = ?";
        $stmt = $conn->prepare($update_order);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        
        header("Location: orders.php");
        exit();
    }
    
    $payment_method_id = $_POST['payment_method'];
    $transaction_id = $_POST['transaction_id'] ?? null;
    
    // Validate payment method
    $valid_method = false;
    foreach ($payment_methods as $method) {
        if ($method['payment_method_id'] == $payment_method_id) {
            $valid_method = true;
            break;
        }
    }
    
    if (!$valid_method) {
        $error = "Phương thức thanh toán không hợp lệ";
    } else {
        // Start transaction
        $conn->begin_transaction();
        
        try {
            // Update order payment status
            $update_order = "UPDATE orders 
                            SET payment_status = 'completed',
                                payment_method_id = ?,
                                payment_date = NOW(),
                                transaction_id = ?
                            WHERE order_id = ?";
            $stmt = $conn->prepare($update_order);
            $stmt->bind_param("isi", $payment_method_id, $transaction_id, $order_id);
            $stmt->execute();
            
            // Record payment history
            $insert_payment = "INSERT INTO payment_history 
                             (order_id, amount, payment_method_id, transaction_id, status)
                             VALUES (?, ?, ?, ?, 'completed')";
            $stmt = $conn->prepare($insert_payment);
            $stmt->bind_param("idis", $order_id, $order['total_amount'], $payment_method_id, $transaction_id);
            $stmt->execute();
            
            $conn->commit();
            $success = "Thanh toán thành công!";
            
            // Redirect to order confirmation page
            header("Location: order-confirmation.php?order_id=" . $order_id);
            exit();
            
        } catch (Exception $e) {
            $conn->rollback();
            $error = "Có lỗi xảy ra khi xử lý thanh toán. Vui lòng thử lại.";
        }
    }
}

// Function to format currency
function formatCurrency($amount) {
    return number_format($amount, 0, ',', '.') . ' đ';
}

// Function to get payment method icon
function getMethodIcon($methodName) {
    switch (strtolower($methodName)) {
        case 'momo':
            return '<i class="fas fa-mobile-alt"></i>';
        case 'banking':
            return '<i class="fas fa-university"></i>';
        case 'cod':
            return '<i class="fas fa-truck"></i>';
        default:
            return '<i class="fas fa-credit-card"></i>';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - SEA FRUITS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../styles/grid.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <style>
        .payment-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            background: #fff;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .payment-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #4CAF50;
        }

        .payment-title {
            color: #4CAF50;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .order-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 10px;
            background: #fff;
            border-radius: 5px;
        }

        .summary-item.total {
            font-size: 18px;
            font-weight: bold;
            color: #4CAF50;
            border-top: 2px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }

        .payment-methods {
            margin-bottom: 30px;
        }

        .method-option {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .method-option:hover {
            border-color: #4CAF50;
            background: #f8f9fa;
        }

        .method-option input[type="radio"] {
            margin-right: 15px;
        }

        .method-icon {
            font-size: 24px;
            margin-right: 15px;
            color: #4CAF50;
        }

        .method-details {
            flex-grow: 1;
        }

        .method-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .method-description {
            color: #666;
            font-size: 14px;
        }

        .transaction-input {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: none;
        }

        .transaction-input.active {
            display: block;
        }

        .payment-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .payment-button {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .payment-button.primary {
            background: #4CAF50;
            color: white;
        }

        .payment-button.secondary {
            background: #dc3545;
            color: white;
        }

        .payment-button:hover {
            opacity: 0.9;
        }

        .error-message {
            color: #dc3545;
            padding: 10px;
            margin-bottom: 20px;
            background: #f8d7da;
            border-radius: 5px;
        }

        .success-message {
            color: #28a745;
            padding: 10px;
            margin-bottom: 20px;
            background: #d4edda;
            border-radius: 5px;
        }

        .qr-code {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .qr-code img {
            max-width: 200px;
            margin: 10px 0;
        }

        @media (max-width: 768px) {
            .payment-container {
                margin: 15px;
                padding: 15px;
            }
            
            .payment-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-top">
            <div class="container">
                <div class="header-top-left">
                    <a href="tel:0123456789"><i class="fas fa-phone"></i> 0123 456 789</a>
                    <a href="mailto:info@example.com"><i class="fas fa-envelope"></i> info@example.com</a>
                </div>
                <div class="header-top-right">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="header-main">
            <div class="container">
                <div class="logo">
                    <a href="../index.php"><img src="../img/logo.png" alt="Logo"></a>
                </div>
                <nav class="main-menu">
                    <ul>
                        <li><a href="../index.php">Trang chủ</a></li>
                        <li><a href="products.php">Sản phẩm</a></li>
                        <li><a href="about.php">Giới thiệu</a></li>
                        <li><a href="contact.php">Liên hệ</a></li>
                    </ul>
                </nav>
                <div class="header-icons">
                    <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                    <a href="account.php"><i class="fas fa-user"></i></a>
                </div>
            </div>
        </div>
    </header>

    <div class="payment-container">
        <div class="payment-header">
            <h1 class="payment-title">THANH TOÁN ĐƠN HÀNG</h1>
            <p>Mã đơn hàng: #<?php echo $order_id; ?></p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <div class="order-summary">
            <h3>Thông tin đơn hàng</h3>
            <div class="summary-item">
                <span>Tên khách hàng:</span>
                <span><?php echo htmlspecialchars($order['user_name']); ?></span>
            </div>
            <div class="summary-item">
                <span>Địa chỉ giao hàng:</span>
                <span><?php echo htmlspecialchars($order['user_address']); ?></span>
            </div>
            <div class="summary-item">
                <span>Số điện thoại:</span>
                <span><?php echo htmlspecialchars($order['user_phone']); ?></span>
            </div>
            <div class="summary-item total">
                <span>Tổng tiền:</span>
                <span><?php echo formatCurrency($order['total_amount']); ?></span>
            </div>
        </div>

        <form method="POST" action="">
            <div class="payment-methods">
                <h3>Chọn phương thức thanh toán</h3>
                <?php foreach ($payment_methods as $method): ?>
                    <label class="method-option">
                        <input type="radio" name="payment_method" value="<?php echo $method['payment_method_id']; ?>" 
                               data-method="<?php echo strtolower($method['method_name']); ?>">
                        <span class="method-icon"><?php echo getMethodIcon($method['method_name']); ?></span>
                        <div class="method-details">
                            <div class="method-name"><?php echo htmlspecialchars($method['method_name']); ?></div>
                            <div class="method-description"><?php echo htmlspecialchars($method['description']); ?></div>
                        </div>
                    </label>
                <?php endforeach; ?>
            </div>

            <div class="payment-buttons">
                <button type="submit" name="submit_payment" class="payment-button primary">
                    <i class="fas fa-check"></i> Xác nhận thanh toán
                </button>
                <button type="submit" name="cancel_payment" class="payment-button secondary">
                    <i class="fas fa-times"></i> Hủy thanh toán
                </button>
            </div>
        </form>
    </div>

    <footer>
        <div class="container">
            <div class="footer-top">
                <div class="footer-column">
                    <h3>Về chúng tôi</h3>
                    <p>Chúng tôi cung cấp các sản phẩm rau củ quả tươi ngon, chất lượng cao với giá cả hợp lý.</p>
                </div>
                <div class="footer-column">
                    <h3>Liên kết nhanh</h3>
                    <ul>
                        <li><a href="../index.php">Trang chủ</a></li>
                        <li><a href="products.php">Sản phẩm</a></li>
                        <li><a href="about.php">Giới thiệu</a></li>
                        <li><a href="contact.php">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Liên hệ</h3>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận XYZ, TP.HCM</li>
                        <li><i class="fas fa-phone"></i> 0123 456 789</li>
                        <li><i class="fas fa-envelope"></i> info@example.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> SEA FRUITS. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const transactionInput = document.querySelector('.transaction-input');
            
            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    const selectedMethod = this.dataset.method;
                    
                    if (selectedMethod === 'momo' || selectedMethod === 'banking') {
                        if (!transactionInput) {
                            const input = document.createElement('div');
                            input.className = 'transaction-input active';
                            input.innerHTML = `
                                <label for="transaction_id">Mã giao dịch:</label>
                                <input type="text" id="transaction_id" name="transaction_id" required
                                       placeholder="Nhập mã giao dịch">
                            `;
                            this.closest('.method-option').appendChild(input);
                        } else {
                            transactionInput.classList.add('active');
                        }
                    } else if (transactionInput) {
                        transactionInput.classList.remove('active');
                    }
                });
            });
        });
    </script>
</body>
</html> 