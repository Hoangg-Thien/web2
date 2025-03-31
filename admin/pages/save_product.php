<?php
    require_once 'connect.php';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $product_code = $_POST['product-code'];
        $product_name = $_POST['product-name'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $status = $_POST['status'];
        $description = $_POST['description'];

        $image_path = '';
        if(isset($_FILES['product-image']) && $_FILES['product-image']['error'] == 0){
            $upload_dir = '../img/';

            $file_name = time() . '_' . $_FILES['product-image']['name'];
            $target_file = $upload_dir . $file_name;
            
            if(move_uploaded_file($_FILES['product-image']['tmp_name'], $target_file)) {
                $image_path = '..img/' . $file_name;
            }
        }
        $sql = "INSERT INTO sanpham(product_id, product_name, product_type, product_price, product_status, product_image, product_description)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn ->prepare($sql);
        $stmt->bind_param("sssssss", $product_code, $product_name, $category, $price, $status, $image_path, $description);

        if($stmt->execute()){
            header("Location: addpro.html?success");
            exit();
        }else{
            header("Location: addpro.html?error");
            exit();
        }
        $stmt->close();
        $conn->close();
    }
?>