<?php
header('Content-Type: application/json');
require 'connect.php';

$result = $conn->query("SELECT * FROM sanpham");

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);
$conn->close();
?>
