<?php
include("connect.php");

echo '<style>
.result-card {
    border: 1px solid #ddd;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    background-color: #f9f9f9;
}
</style>';

// Kiểm tra tham số 'search'
if (isset($_GET['search'])) {
    $keyword = trim($_GET['search']);
    echo "Bạn đang tìm kiếm: " . htmlspecialchars($keyword) . "<br>";

    // Sử dụng prepared statement để tránh SQL Injection
    $sql = "SELECT * FROM sanpham WHERE product_name LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%" . $keyword . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    // Hiển thị kết quả
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='result-card'>";
            echo "<strong>" . htmlspecialchars($row['product_name']) . "</strong><br>";
            echo "Giá: " . htmlspecialchars($row['product_price']) . " VND";
            echo "</div>";
        }
    } else {
        echo "<p>Không tìm thấy sản phẩm nào.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Tham số tìm kiếm không hợp lệ.</p>";
}

// Đóng kết nối
$conn->close();
?>
