<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);
$product_id = $data['product_id'];
$action = $data['action'];

$pdo = new PDO("mysql:host=localhost;dbname=c07db", "root", "");

// Tạo session nếu chưa có
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

switch ($action) {
    case 'add':
        $stmt = $pdo->prepare("SELECT * FROM sanpham WHERE product_id = ? AND product_status = 'Còn hàng'");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();

        if ($product) {
            // Đường dẫn ảnh trên trình duyệt
            $imageFile = $product['product_image'];
            $imagePath = '/web2/User/user/img/mit-say.jpg'; // đảm bảo file sample.jpg tồn tại


            // Kiểm tra file ảnh có tồn tại thật không (trên server)
            $serverPath = $_SERVER['DOCUMENT_ROOT'] . '/web2/User/user/img/' . $imageFile;
            if (!file_exists($serverPath)) {
                $imagePath = '/web2/User/user/img/no-image.jpg'; // fallback
            }

            // Lưu vào session
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += 1;
            } else {
                $_SESSION['cart'][$product_id] = [
                    'name' => $product['product_name'],
                    'price' => $product['product_price'],
                    'image' => $imagePath,
                    'quantity' => 1
                ];
            }

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'cart_count' => count($_SESSION['cart']),
                'product' => [
                    'name' => $product['product_name'],
                    'image' => $imagePath
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm hết hàng']);
        }
        break;

    case 'increase':
        $_SESSION['cart'][$product_id]['quantity']++;
        break;

    case 'decrease':
        if ($_SESSION['cart'][$product_id]['quantity'] > 1) {
            $_SESSION['cart'][$product_id]['quantity']--;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
        break;

    case 'remove':
        unset($_SESSION['cart'][$product_id]);
        break;
}

exit;