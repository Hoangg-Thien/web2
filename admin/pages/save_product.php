
<?php
    require_once 'connect.php';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $product_code = $_POST['product-code'];
        $product_name = $_POST['product-name'];
        $category_id = isset($_POST['category-id']) ? $_POST['category-id'] : 0; // Gán giá trị mặc định là 0 nếu không có
        $type = $_POST['type'];
        $price = $_POST['price'];
        $status = $_POST['status'];
        $description = $_POST['description'];

        $image_path = '';
        if(isset($_FILES['product-image']) && $_FILES['product-image']['error'] == 0){
            $upload_dir = '../img/';
            $file_name = time() . '_' . $_FILES['product-image']['name'];
            $target_file = $upload_dir . $file_name;

            if (!is_writable($upload_dir)) {
                die("Thư mục $upload_dir không có quyền ghi.");
            }

            if(move_uploaded_file($_FILES['product-image']['tmp_name'], $target_file)) {
                $image_path = '../img/' . $file_name;
            } else {
                die("Không thể tải lên file.");
            }
        }

        $sql = "INSERT INTO sanpham(product_id, product_name, category_id, product_type, product_price, product_status, product_image, product_description)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị SQL: " . $conn->error);
        }

        $stmt->bind_param("ssssssss", $product_code, $product_name, $category_id, $type, $price, $status, $image_path, $description);

        if($stmt->execute()){
            header("Location: addpro.php?success");
        } else {
            die("Lỗi SQL: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();
    }
?>