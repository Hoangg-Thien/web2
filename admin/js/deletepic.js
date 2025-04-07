document.getElementById("delete-image").addEventListener("click", function () {
    const imageElement = document.getElementById("product-image");
    const imageInput = document.getElementById("image-upload");

    // Xóa ảnh trên giao diện
    imageElement.src = "";
    imageElement.alt = "Chưa có ảnh";
    imageElement.style.display = "none"; // Ẩn ảnh
    imageInput.value = "";
    imageElement.setAttribute("data-deleted", "true"); // Đánh dấu ảnh đã xóa
});

document.getElementById("image-upload").addEventListener("change", function (e) {
    const file = e.target.files[0];
    const imageElement = document.getElementById("product-image");

    if (file && (file.type === "image/png" || file.type === "image/jpeg")) { // Kiểm tra file hợp lệ
        const reader = new FileReader();
        reader.onload = function (e) {
            imageElement.src = e.target.result;
            imageElement.style.display = "block"; // Hiển thị lại ảnh
            imageElement.removeAttribute("data-deleted"); // Đánh dấu không xóa
        };
        reader.readAsDataURL(file);
    } else {
        alert("Vui lòng tải lên ảnh hợp lệ (PNG hoặc JPEG).");
    }
});

// Chuẩn bị FormData gửi đến server
const formData = new FormData();
const isImageDeleted = document.getElementById("product-image").getAttribute("data-deleted");
if (isImageDeleted === "true") {
    formData.append("delete_image", "true");
}
const imageFile = document.getElementById("image-upload").files[0];
if (imageFile) {
    formData.append("product_image", imageFile);
}

// Gửi yêu cầu đến server
fetch('/api/update-product', {
    method: 'POST',
    body: formData
})
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Cập nhật thành công!");
        } else {
            console.error("Lỗi:", data.message);
        }
    })
    .catch(error => console.error("Lỗi mạng:", error));
