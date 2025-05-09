<?php



session_start(); // luôn có dòng này để đọc session\




if (!isset($_SESSION['user_name'])) {
  echo "Bạn chưa đăng nhập.";
  exit();
}

// Kết nối database
$pdo = new PDO("mysql:host=localhost;dbname=c07db", "root", "");

// Lấy user_name từ session
$user_name = $_SESSION['user_name'];

// Truy vấn database lấy thông tin user
$stmt = $pdo->prepare("SELECT fullname, user_email, phone, user_address,district,city FROM nguoidung WHERE user_name = ?");
$stmt->execute([$user_name]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$user) {
  echo "Không tìm thấy thông tin người dùng.";
  exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 


  // Tạo lại session mới với thông tin thanh toán
  $_SESSION['payment_info'] = [
    'full_name' => $_POST['name'],
    'address' => $_POST['address'],
    'phone' => $_POST['phone'],
    'email' => $_POST['email'],
    'payment_method' => $_POST['payment_method'],
    'district' => $_POST['district'], // Thêm district
    'city' => $_POST['city'], // Thêm city
    'cart' => $_SESSION['cart'] ?? [],
    'total' => isset($_SESSION['cart']) ? array_sum(array_map(function($item) {
        return $item['price'] * $item['quantity'];
    }, $_SESSION['cart'])) : 0,
    'order_date' => date('Y-m-d H:i:s'),
    'order_status' => 'pending'
];



  // Điều hướng đến hóa đơn
  header('Location: bill-preview.php');
  exit();
}



$total = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
}

?>