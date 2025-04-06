document.getElementById("saveBtn").addEventListener("click", function () {
    let productData = {
        product_id: document.getElementById("product-code").value,
        product_name: document.getElementById("product-name").value,
        product_price: document.getElementById("product-price").value,
        product_status: document.getElementById("product-status").value,
        product_type: document.getElementById("product-type").value,
        product_image: document.getElementById("product-image").src // Lấy URL ảnh nếu có
    };

    fetch("update_product.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams(productData).toString()
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Hiển thị thông báo cập nhật
        if (data.status === "success") {
            location.reload(); // Làm mới trang sau khi cập nhật thành công
        }
    })
    .catch(error => console.error("Lỗi:", error));
});
