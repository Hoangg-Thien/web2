document.getElementById("saveBtn").addEventListener("click", function () {
    const formData = new FormData();

    formData.append("product_id", document.getElementById("product-code").value);
    formData.append("product_name", document.getElementById("product-name").value);
    formData.append("product_price", document.getElementById("product-price").value);
    formData.append("product_status", document.getElementById("product-status").value);
    formData.append("product_type", document.getElementById("product-type").value);

    const imageInput = document.getElementById("image-upload");
    if (imageInput.files.length > 0) {
        formData.append("product_image", imageInput.files[0]);
    }

    fetch("update_product.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Cập nhật thành công!");
            location.reload(); // Tải lại trang nếu cần hiển thị lại dữ liệu mới
        } else {
            alert("Lỗi: " + data.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert("Lỗi kết nối server!");
    });
});
