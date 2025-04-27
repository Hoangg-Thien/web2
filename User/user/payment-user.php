<?php
session_start(); // luôn có dòng này để đọc session

$user = [];
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
?>



<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thanh toán</title>
  <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="../styles/payment.css">
  
</head>
<body>

<div class="container">
  <h1>THANH TOÁN</h1>

  <form action="process_payment.php" method="post">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
  <a href="../index.php" style="text-decoration: none; background: #28a745; color: white; padding: 10px 20px; border-radius: 5px;">
    🏠 Về Trang chủ
  </a>

  <a href="./cart-user.php" style="text-decoration: none; background: #007bff; color: white; padding: 10px 20px; border-radius: 5px;">
    🛒 Về Giỏ hàng
  </a>
</div>
    
    <!-- 1. Thông tin người nhận -->
    <div class="section">
      <h3>Thông tin người nhận</h3>
      <div class="checkbox-group">
  <label>
    <input type="checkbox" id="useDefaultInfo" onclick="fillDefaultInfo()">
    Sử dụng thông tin mặc định
  </label>
</div>


<div class="input-group">
  <label>Họ và tên</label>
  <input type="text" id="name" name="name" placeholder="Nhập họ tên">
</div>

<div class="input-group">
  <label>Địa chỉ</label>
  <input type="text" id="address" name="address" placeholder="Nhập địa chỉ">
</div>

<div class="input-group">
  <label>Số điện thoại</label>
  <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại">
</div>

<div class="input-group">
  <label>Email</label>
  <input type="email" id="email" name="email" placeholder="Nhập email">
</div>


<hr style="border: none; border-top: 2px solid #eee; margin: 30px 0;">




    <!-- 2. Phương thức thanh toán -->
    <div class="section">
      <h3>Chọn phương thức thanh toán</h3>

      <!-- Thẻ tín dụng -->
      <label class="payment-option">
        <input type="radio" name="payment_method" value="credit_card" checked onchange="togglePaymentMethod()">
        Thẻ tín dụng
      </label>
      <div class="credit-card-info">
        <div class="input-group">
          <label>Tên chủ thẻ</label>
          <input type="text" name="card_name" placeholder="Nhập tên chủ thẻ">
        </div>
        <div class="input-group">
          <label>Số thẻ tín dụng</label>
          <input type="text" name="card_number" placeholder="Nhập số thẻ">
        </div>
        <div class="input-group">
          <label>Ngày hết hạn (DD/MM/YY)</label>
          <input type="text" name="card_expiry" placeholder="DD/MM/YY">
        </div>
        <div class="input-group">
          <label>CVV</label>
          <input type="text" name="card_cvv" placeholder="CVV">
        </div>
      </div>

     <!-- Chuyển khoản ngân hàng -->
<label class="payment-option">
  <input type="radio" name="payment_method" value="bank_transfer" onchange="togglePaymentMethod()">
  Chuyển khoản ngân hàng
</label>
<div class="bank-transfer-info">
  <div style="display: flex; gap: 20px; align-items: flex-start;">
    <!-- QR code bên trái -->
    <div class="qr-code">
      <img src="../img/qr-code.jpg" alt="QR chuyển khoản">
    </div>

    <!-- Thông tin tài khoản bên phải -->
    <div class="bank-info">
      <h4>Thông tin nạp tiền</h4>
      <table>
        <tr>
          <td><strong>Nội dung chuyển khoản:</strong></td>
          <td><span id="copy-content">CK <?php echo htmlspecialchars($user['username'] ?? 'username'); ?></span>
          <button type="button" onclick="copyToClipboard('copy-content')">📋</button></td>
        </tr>
        <tr>
          <td><strong>Tên ngân hàng:</strong></td>
          <td><span id="copy-bank">MB Bank</span> <button type="button" onclick="copyToClipboard('copy-bank')">📋</button></td>
        </tr>
        <tr>
          <td><strong>Số tài khoản:</strong></td>
          <td><span id="copy-account">002471993</span> <button type="button" onclick="copyToClipboard('copy-account')">📋</button></td>
        </tr>
        <tr>
          <td><strong>Tên tài khoản:</strong></td>
          <td><span id="copy-name">Ngô Nguyễn Thành Nhân</span> <button type="button" onclick="copyToClipboard('copy-name')">📋</button></td>
        </tr>
        <tr>
          <td><strong>Chi nhánh:</strong></td>
          <td><span id="copy-branch">Hồ Chí Minh</span> <button type="button" onclick="copyToClipboard('copy-branch')">📋</button></td>
        </tr>
      </table>
    </div>
  </div>

  <!-- Nội dung lưu ý -->
  <div style="margin-top: 20px;color: #555;">
  <span style="color: #d9534f; font-weight: bold;">LƯU Ý:</span><br>
    Hệ thống sẽ xử lý tự động cộng số dư sau khi chuyển khoản 1-3 phút nếu bạn:
    <ul style="margin-top: 10px;">
    <li>Ghi nội dung chuyển khoản <span style="color: #28a745; font-weight: bold;">ĐÚNG</span> như bên trên. 
        <small>(*Trong trường hợp ghi nhầm Username người khác, chúng tôi sẽ không chịu trách nhiệm!)</small>
    </li>
    <li>Sử dụng hình thức chuyển tiền nhanh 24/7.</li>
  </ul>
  <p style="margin-top: 10px;">
    -Bạn có thể thao tác nhanh bằng cách mở ứng dụng ngân hàng và quét mã QR bên trên để tự động điền đúng số tiền và nội dung cần chuyển.<br>
    -Trong trường hợp sau 5 phút không được xử lý tự động, vui lòng liên hệ bộ phận CSKH để được hỗ trợ.
  </p>
  </div>
</div>


      <!-- Thanh toán khi nhận hàng -->
      <label class="payment-option">
        <input type="radio" name="payment_method" value="cod" onchange="togglePaymentMethod()">
        Thanh toán khi nhận hàng
      </label>
      <!--Lưu ý khi thanh toán nhận hàng-->
      <div class="cod-info" style="display: none; margin-top: 20px; color: #555;"> <!-- set luôn màu toàn bộ div -->
  <span style="color: #d9534f; font-weight: bold;">LƯU Ý:</span><br>
  Khi chọn hình thức <strong>Thanh toán khi nhận hàng (COD)</strong>, bạn cần lưu ý:
  <ul style="margin-top: 10px;">
    <li>Chuẩn bị sẵn số tiền thanh toán khi giao hàng để thuận tiện cho quá trình giao nhận.</li>
    <li>Kiểm tra kỹ tình trạng sản phẩm trước khi thanh toán cho nhân viên giao hàng.</li>
    <li>Chỉ thanh toán đúng số tiền ghi trên hóa đơn, <span style="color: red; font-weight: bold;">KHÔNG thanh toán thêm phí nào khác</span>.</li>
    <li>Trong trường hợp sản phẩm có vấn đề hoặc sai sót, vui lòng liên hệ ngay với bộ phận chăm sóc khách hàng.</li>
  </ul>
  <p style="margin-top: 10px;">Xin chân thành cảm ơn quý khách đã tin tưởng và sử dụng dịch vụ của chúng tôi!</p>
</div>
<div style="margin-top: 20px; color: #555;">
  <strong>HỖ TRỢ KHÁCH HÀNG:</strong><br>
  Nếu bạn gặp bất kỳ vấn đề nào về thanh toán hoặc đơn hàng, xin vui lòng liên hệ bộ phận CSKH:
  <ul style="margin-top: 10px;">
    <li>📞 Hotline: <a href="tel:0123456789" style="color: #28a745;">012 345 6789</a></li>
    <li>📧 Email: <a href="mailto:aboutus@gmail.com" style="color: #28a745;">AboutUs@gmail.com</a></li>
  </ul>
</div>


    </div>

    <!-- 3. Nút Thanh toán -->
    <button type="submit" class="submit-btn">Thanh toán</button>

  </form>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
  function togglePaymentMethod() {
    const method = document.querySelector('input[name="payment_method"]:checked').value;

document.querySelector('.credit-card-info').style.display = 'none';
document.querySelector('.bank-transfer-info').style.display = 'none';
document.querySelector('.cod-info').style.display = 'none'; // Ẩn COD trước

if (method === 'credit_card') {
  document.querySelector('.credit-card-info').style.display = 'block';
} else if (method === 'bank_transfer') {
  document.querySelector('.bank-transfer-info').style.display = 'block';
} else if (method === 'cod') {
  document.querySelector('.cod-info').style.display = 'block'; // Khi chọn COD thì hiện lưu ý COD
}
  }

  function fillDefaultInfo() {
  const isChecked = document.getElementById('useDefaultInfo').checked;

  if (isChecked) {
    // Khi tích chọn ô, tự động điền thông tin
    document.getElementById('name').value = '<?php echo addslashes($user['fullname'] ?? ''); ?>';
    document.getElementById('address').value = '<?php echo addslashes(($user['address'] ?? '') . ', ' . ($user['district'] ?? '') . ', ' . ($user['city'] ?? '')); ?>';

    document.getElementById('phone').value = '<?php echo addslashes($user['phone'] ?? ''); ?>';
    document.getElementById('email').value = '<?php echo addslashes($user['email'] ?? ''); ?>';
  } else {
    // Khi bỏ tick, xóa dữ liệu
    document.getElementById('name').value = '';
    document.getElementById('address').value = '';
    document.getElementById('phone').value = '';
    document.getElementById('email').value = '';
  }
}

function copyToClipboard(elementId) {
  const text = document.getElementById(elementId).innerText;
  navigator.clipboard.writeText(text).then(function() {
    alert("Đã sao chép: " + text);
  }, function(err) {
    alert("Lỗi khi sao chép!");
  });
}

  window.onload = togglePaymentMethod;

  //Điền form đầy đủ 
  function validateFormAndSubmit(event) {
  event.preventDefault();

  // Lấy giá trị thông tin người nhận
  const name = document.getElementById('name').value.trim();
  const address = document.getElementById('address').value.trim();
  const phone = document.getElementById('phone').value.trim();
  const email = document.getElementById('email').value.trim();

  if (!name || !address || !phone || !email) {
    Swal.fire({
      icon: 'warning',
      title: 'Thiếu thông tin!',
      text: 'Vui lòng điền đầy đủ thông tin người nhận trước khi thanh toán!'
    });
    return false;
  }

  // Lấy phương thức thanh toán
  const method = document.querySelector('input[name="payment_method"]:checked').value;
  if (method === "credit_card") {
    // Lấy giá trị các ô thẻ
    const cardName = document.querySelector('input[name="card_name"]').value.trim();
    const cardNumber = document.querySelector('input[name="card_number"]').value.trim();
    const cardExpiry = document.querySelector('input[name="card_expiry"]').value.trim();
    const cardCvv = document.querySelector('input[name="card_cvv"]').value.trim();

    // Bắt đầu validate từng ô:

    // Tên chủ thẻ
    if (!cardName) {
      Swal.fire({
        icon: 'warning',
        title: 'Thiếu tên chủ thẻ!',
        text: 'Vui lòng nhập tên chủ thẻ.'
      });
      return false;
    }

    // Số thẻ: phải đúng 16 số
    const cardNumberRegex = /^\d{16}$/;
    if (!cardNumberRegex.test(cardNumber)) {
      Swal.fire({
        icon: 'warning',
        title: 'Sai số thẻ!',
        text: 'Số thẻ tín dụng phải có đúng 16 chữ số.'
      });
      return false;
    }

    // Ngày hết hạn: đúng định dạng DD/MM/YY
    const expiryRegex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{2}$/;
if (!expiryRegex.test(cardExpiry)) {
  Swal.fire({
    icon: 'warning',
    title: 'Sai ngày hết hạn!',
    text: 'Ngày hết hạn phải đúng định dạng DD/MM/YY (ví dụ: 15/08/26) và năm hết hạn phải trên 26.'
  });
  return false;
}

    // CVV: phải 3 hoặc 4 chữ số
    const cvvRegex = /^\d{3,4}$/;
    if (!cvvRegex.test(cardCvv)) {
      Swal.fire({
        icon: 'warning',
        title: 'Sai mã CVV!',
        text: 'Mã CVV phải có 3 hoặc 4 chữ số.'
      });
      return false;
    }
  }

  // Nếu đầy đủ và đúng hết:
  Swal.fire({
    icon: 'success',
    title: 'Thanh toán thành công!',
    text: 'Cảm ơn bạn đã mua hàng!',
    confirmButtonText: 'Xem đơn hàng'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "invoice.php";
    }
  });
}

// Gắn validate vào form
document.querySelector('form').addEventListener('submit', validateFormAndSubmit);
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



</body>


</html>
